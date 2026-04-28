<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TrashController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminNoteController;

// ══════════════════════════════════════════════════════════════
// PUBLIC ROUTES (Guests only)
// ══════════════════════════════════════════════════════════════

Route::middleware('guest')->group(function () {
    
    // Register
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    
    // Login
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    
});

// ══════════════════════════════════════════════════════════════
// AUTHENTICATED USER ROUTES
// ══════════════════════════════════════════════════════════════

Route::middleware('auth')->group(function () {
    
    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // ─────────────────────────────────────────────────────────
    // NOTES CRUD + ACTIONS
    // ─────────────────────────────────────────────────────────
    
    Route::resource('notes', NoteController::class);
    
    // Pin / Unpin a note
    Route::patch('/notes/{note}/pin', [NoteController::class, 'togglePin'])->name('notes.pin');
    
    // Favorite / Unfavorite a note
    Route::patch('/notes/{note}/favorite', [NoteController::class, 'toggleFavorite'])->name('notes.favorite');
    
    // ─────────────────────────────────────────────────────────
    // TRASH (Soft Deletes)
    // ─────────────────────────────────────────────────────────
    
    Route::get('/trash', [TrashController::class, 'index'])->name('trash.index');
    Route::patch('/trash/{id}/restore', [TrashController::class, 'restore'])->name('trash.restore');
    Route::delete('/trash/{id}', [TrashController::class, 'forceDelete'])->name('trash.destroy');
    Route::delete('/trash', [TrashController::class, 'emptyTrash'])->name('trash.empty');
    
    // ─────────────────────────────────────────────────────────
    // CATEGORIES
    // ─────────────────────────────────────────────────────────
    
    Route::resource('categories', CategoryController::class)->except(['show']);
    
    // ─────────────────────────────────────────────────────────
    // TAGS
    // ─────────────────────────────────────────────────────────
    
    Route::get('/tags', [TagController::class, 'index'])->name('tags.index');
    Route::post('/tags', [TagController::class, 'store'])->name('tags.store');
    Route::delete('/tags/{tag}', [TagController::class, 'destroy'])->name('tags.destroy');
    
    // ─────────────────────────────────────────────────────────
    // EXPORT
    // ─────────────────────────────────────────────────────────
    
    Route::get('/export/{note}/pdf', [ExportController::class, 'exportPdf'])->name('export.pdf');
    Route::get('/export/{note}/txt', [ExportController::class, 'exportTxt'])->name('export.txt');
    
    // ─────────────────────────────────────────────────────────
    // PROFILE & SETTINGS
    // ─────────────────────────────────────────────────────────
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'changePassword'])->name('profile.password');
    Route::post('/profile/theme', [ProfileController::class, 'toggleTheme'])->name('profile.theme');
//     Route::post('/profile/theme', function () {
//     session(['dark_mode' => !session('dark_mode', false)]);
//     return back();
// })->name('profile.theme');
    
});

// ══════════════════════════════════════════════════════════════
// ADMIN ROUTES (Admin only)
// ══════════════════════════════════════════════════════════════
// Admin-Login

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // User Management
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}/block', [AdminUserController::class, 'toggleBlock'])->name('users.block');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    
    // All Notes Management
    Route::get('/notes', [AdminNoteController::class, 'index'])->name('notes.index');
    Route::delete('/notes/{note}', [AdminNoteController::class, 'destroy'])->name('notes.destroy');

    // Categories (Admin)
    Route::resource('categories', CategoryController::class);

    // Tags (Admin)
    Route::get('/tags', [TagController::class, 'index'])->name('tags.index');

    
});

// ══════════════════════════════════════════════════════════════
// HOME REDIRECT
// ══════════════════════════════════════════════════════════════

Route::get('/', function () {
    return Auth::check() 
        ? redirect()->route('notes.index') 
        : redirect()->route('login');
})->name('home');