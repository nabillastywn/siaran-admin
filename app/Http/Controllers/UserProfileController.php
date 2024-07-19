<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserProfileController extends Controller
{
    public function show()
    {
        return view('pages.user-profile');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone_number' => 'required|string|max:20',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Simpan nama avatar saat ini
        $avatarName = $user->avatar;

        // Jika ada file avatar yang diunggah
        if ($request->hasFile('avatar')) {
            // Hapus avatar lama dari storage
            if ($user->avatar) {
                Storage::delete('public/user/' . $avatarName);
            }

            // Simpan avatar baru
            $avatar = $request->file('avatar');
            $avatarName = $avatar->hashName();
            $avatar->storeAs('public/user', $avatarName);
        }

        // Update informasi pengguna
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'avatar' => $avatarName,
        ]);

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully.');
    }
}