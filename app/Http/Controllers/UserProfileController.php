<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Pastikan model User diimpor
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

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone_number' => 'required|string|max:20',
            'nim' => 'required|string|max:20|unique:users,nim,' . $user->id,
            'address' => 'nullable|string|max:255',
            'class' => 'nullable|string|max:50',
            'major' => 'nullable|string|max:50',
            'study_program' => 'nullable|string|max:50',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update data pengguna
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone_number = $request->input('phone_number');
        $user->nim = $request->input('nim');
        $user->address = $request->input('address');
        $user->class = $request->input('class');
        $user->major = $request->input('major');
        $user->study_program = $request->input('study_program');

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Hapus avatar lama jika ada
            if ($user->avatar) {
                Storage::delete('public/user/' . $user->avatar);
            }

            // Simpan avatar baru
            $avatar = $request->file('avatar');
            $avatarName = $avatar->hashName();
            $avatar->storeAs('public/user', $avatarName);
            $user->avatar = $avatarName;
        }

        $user->save();

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully.');
    }
}