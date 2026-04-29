<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;  // Handles login/logout

class LoginController extends Controller
{
    // -------------------------------------------------------
    // Show the login form
    // Route: GET /login
    // -------------------------------------------------------
    public function showLoginForm()
    {
        return view('auth.login');
    }
    // -------------------------------------------------------
    // Handle login form submission
    // Route: POST /login
    // -------------------------------------------------------
    public function login(Request $request)
    {
        // Step 1: Validate the input
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        // Step 2: Try to log the user in
        // Auth::attempt() checks email + password against the database
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            // Check if the user is blocked by admin
            if (Auth::user()->is_blocked) {
                Auth::logout(); // force logout immediately
                return back()->withErrors(['email' => 'Your account has been blocked. Please contact support.']);
            }

            // Step 3: Regenerate session to prevent session fixation attacks
            $request->session()->regenerate();

            // Step 4: Redirect to notes page
            return redirect()->route('notes.index')->with('success', 'Welcome back! 👋');
        }

        // Step 5: If credentials are wrong, go back with an error
        return back()->withErrors([
            'email' => 'The email or password you entered is incorrect.',
        ]);
    }

    // -------------------------------------------------------
    // Log the user out
    // Route: POST /logout
    // -------------------------------------------------------
    public function logout(Request $request)
    {
        Auth::logout(); // Clear the authentication

        // Invalidate the session and regenerate the token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out.');
    }
    /**
 * Show the admin login form.
 */
public function showAdminLoginForm()
{
    return view('auth.admin-login');
}

/**
 * Handle an admin login attempt.
 */
public function adminLogin(\Illuminate\Http\Request $request)
{
    $credentials = $request->validate([
        'email'    => 'required|email',
        'password' => 'required|string',
    ]);

    if (! Auth::attempt($credentials, $request->boolean('remember'))) {
        throw \Illuminate\Validation\ValidationException::withMessages([
            'email' => 'These credentials do not match our records.',
        ]);
    }

    // Must be an admin
    if (! Auth::user()->is_admin) {
        Auth::logout();
        throw \Illuminate\Validation\ValidationException::withMessages([
            'email' => 'This account does not have admin access.',
        ]);
    }

    // Block check
    if (Auth::user()->is_blocked) {
        Auth::logout();
        throw \Illuminate\Validation\ValidationException::withMessages([
            'email' => 'Your account has been blocked.',
        ]);
    }

    $request->session()->regenerate();

    return redirect()->route('admin.dashboard');
}
}