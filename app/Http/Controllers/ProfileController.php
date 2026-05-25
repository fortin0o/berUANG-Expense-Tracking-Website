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
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Upload cropped foto
        if ($request->filled('photo_base64')) {
            $image_parts = explode(";base64,", $request->photo_base64);
            if (count($image_parts) >= 2) {
                $image_base64 = base64_decode($image_parts[1]);
                $fileName = 'profile/' . uniqid() . '.jpg';
                
                // Delete old photo to save space
                if ($user->profile_photo && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->profile_photo)) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($user->profile_photo);
                }
                
                \Illuminate\Support\Facades\Storage::disk('public')->put($fileName, $image_base64);
                $user->profile_photo = $fileName;
            }
        } elseif ($request->hasFile('photo')) {
            // Fallback
            $path = $request->file('photo')->store('profile', 'public');
            $user->profile_photo = $path;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Hapus akun
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
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