<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;  // For password hashing
use Illuminate\Support\Facades\Auth;  // For logging the user in

class RegisterController extends Controller
{
    private function adminRegisterTokenIsValid(?string $token): bool
    {
        $expected = (string) config('app.admin_register_token', '');
        $token = (string) ($token ?? '');

        if ($expected === '' || $token === '') {
            return false;
        }

        return hash_equals($expected, $token);
    }
    // -------------------------------------------------------
    // Show the registration form
    // Route: GET /register
    // -------------------------------------------------------
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // -------------------------------------------------------
    // Handle the registration form submission
    // Route: POST /register
    // -------------------------------------------------------
    public function register(Request $request)
    {
        // Step 1: Validate all incoming fields
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email', // email must be unique
            'password' => 'required|string|min:8|confirmed',   // confirmed = password_confirmation field must match
        ]);

        // Step 2: Create the new user in the database
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password), // never store plain text passwords!
        ]);

        // Step 3: Log the user in automatically after registering
        Auth::login($user);

        // Step 4: Redirect to notes page with a success message
        return redirect()->route('notes.index')->with('success', 'Account created! Welcome to Smart Notes 🎉');
    }

    // -------------------------------------------------------
    // Show the admin registration form
    // Route: GET /admin/register
    // -------------------------------------------------------
    public function showAdminRegistrationForm(Request $request)
    {
        $hasAnyAdmin = User::where('is_admin', true)->exists();

        $requiresToken = $hasAnyAdmin && !($request->user() && $request->user()->is_admin);

        return view('auth.admin-register', [
            'requiresToken' => $requiresToken,
        ]);
    }

    // -------------------------------------------------------
    // Handle admin registration form submission
    // Route: POST /admin/register
    // -------------------------------------------------------
    public function registerAdmin(Request $request)
    {
        $hasAnyAdmin = User::where('is_admin', true)->exists();

        $requiresToken = $hasAnyAdmin && !($request->user() && $request->user()->is_admin);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'admin_register_token' => $requiresToken ? 'required|string' : 'nullable|string',
        ]);

        if ($requiresToken && ! $this->adminRegisterTokenIsValid($request->input('admin_register_token'))) {
            return back()
                ->withInput($request->except(['password', 'password_confirmation', 'admin_register_token']))
                ->withErrors(['admin_register_token' => 'Invalid admin registration key.']);
        }

        $admin = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => true,
        ]);

        Auth::login($admin);

        return redirect()->route('admin.dashboard')->with('success', 'Admin account created.');
    }
}