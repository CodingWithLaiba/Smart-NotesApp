<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Show the profile edit page.
     * Route: GET /profile/edit
     */
    public function edit()
    {
        /** @var User $user */
        $user = Auth::user();

        return view('profile.edit', compact('user'));
    }

    /**
     * Update the user's name, email, and dark mode preference.
     * Route: PUT /profile
     */
    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user(); // Now Intelephense knows $user has update(), password, etc.

        $request->validate([
            'name'  => 'required|string|max:255',
            // 'unique:users,email,{id}' means: email must be unique BUT ignore this user's own email
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name'      => $request->name,
            'email'     => $request->email,
            'dark_mode' => $request->boolean('dark_mode'), // saves dark/light mode preference
        ]);

        return redirect()->route('profile.edit')->with('success', 'Profile updated!');
    }

    /**
     * Change the user's password.
     * Route: PUT /profile/password
     */
    public function changePassword(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required|string',
            'password'         => 'required|string|min:6|confirmed', // needs password_confirmation field
        ]);

        // Verify that the current password they typed is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Your current password is incorrect.',
            ]);
        }

        // Save the new hashed password
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profile.edit')->with('success', 'Password changed successfully!');
    }
    public function toggleTheme(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        // Toggle between light and dark
        $newTheme = $user->theme === 'dark' ? 'light' : 'dark';

        $user->update(['theme' => $newTheme]);

        return back();
    }
}

