<?php
// ══════════════════════════════════════════════════════════════
//  AdminUserController.php
//  app/Http/Controllers/Admin/AdminUserController.php
// ══════════════════════════════════════════════════════════════
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
 
class AdminUserController extends Controller
{
    /**
     * List all registered users.
     * Route: GET /admin/users
     */
    public function index(Request $request)
    {
        // Search by name or email if the admin typed in the search box
        $query = User::where('is_admin', false); // Don't show admin accounts in the list
 
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
 
        // Show 20 users per page, with their note count
        $users = $query->withCount('notes')->latest()->paginate(20);
 
        return view('admin.users.index', compact('users'));
    }
 
    /**
     * View all notes belonging to a specific user.
     * Route: GET /admin/users/{user}/notes
     */
    public function userNotes(User $user)
    {
        $notes = $user->notes()->latest()->paginate(15);
 
        return view('admin.notes.index', compact('notes', 'user'));
    }
 
    /**
     * Block or unblock a user account.
     * Blocked users cannot log in.
     * Route: POST /admin/users/{user}/block
     */
    public function toggleBlock(User $user)
    {
        // Prevent the admin from blocking themselves
        if ($user->id === Auth::id()) {
            return back()->with('error', 'You cannot block your own account.');
        }
 
        // Flip the is_blocked status
        $user->update(['is_blocked' => !$user->is_blocked]);
 
        $msg = $user->is_blocked ? 'User blocked.' : 'User unblocked.';
        return back()->with('success', $msg);
    }
 
    /**
     * Permanently delete a user and all their notes.
     * Route: DELETE /admin/users/{user}
     */
    public function destroy(User $user)
    {
        // Prevent deleting yourself
        if ($user->id === Auth::id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }
 
        // Delete the user (their notes will also be deleted if you set onDelete cascade in migration)
        $user->delete();
 
        return redirect()->route('admin.users.index')->with('success', 'User account deleted.');
    }
}