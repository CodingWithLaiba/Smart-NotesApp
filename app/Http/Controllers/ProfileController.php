<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

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
        $user = Auth::user();

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name'      => $request->name,
            'email'     => $request->email,
            'theme'     => $request->boolean('dark_mode') ? 'dark' : 'light',
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

        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'confirmed', Password::min(8)],
        ]);

        $user->update([
            'password' => $validated['password'],
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

