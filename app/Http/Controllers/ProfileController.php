<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profile
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update profile (name, email, foto)
     */
    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        // Upload foto
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('profile', 'public');
            $user->profile_photo = $path;
        }

        $user->save();

        return back()->with('success', 'Profile berhasil diupdate!');
    }

    /**
     * Hapus akun
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}