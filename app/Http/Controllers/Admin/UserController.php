<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->when(request()->q, function ($query) {
            $query->where('name', 'like', '%' . request()->q . '%');
        })->paginate(10);

        $title = 'Users';

        return view('pages.users.index', compact('users', 'title'));
    }

    public function create()
    {
        return view('pages.users.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'password_confirmation' => 'required|same:password',
            'phone_number' => 'required',
            'nim' => 'required|unique:users',
            'role' => 'required|in:0,1,2',
            'avatar' => 'nullable|image|mimes:jpeg,jpg,png|max:2000',
        ]);

        $avatarName = null;

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = basename($request->file('avatar')->hashName());
            $avatar->storeAs('public/user', $avatarName);
        }

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'nim' => $request->nim,
            'role' => $request->role,
            'avatar' => $avatarName,
        ]);

        if ($user) {
            return redirect()->route('admin.users.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            return redirect()->route('admin.users.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    public function edit(User $user)
    {
        return view('pages.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'username' => 'required|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
            'phone_number' => 'required',
            'nim' => 'required|unique:users,nim,' . $user->id,
            'role' => 'required|in:0,1,2',
            'avatar' => 'nullable|image|mimes:jpeg,jpg,png|max:2000',
        ]);

        $avatarName = $user->avatar;

        if ($request->hasFile('avatar')) {
            Storage::delete('public/user/' . $avatarName);
            $avatar = $request->file('avatar');
            $avatarName = $avatar->hashName();
            $avatar->storeAs('public/user', $avatarName);
        }

        $user->update([
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'phone_number' => $request->phone_number,
            'nim' => $request->nim,
            'role' => $request->role,
            'avatar' => $avatarName,
        ]);

        if ($user) {
            return redirect()->route('admin.users.index')->with(['success' => 'Data Berhasil Diupdate!']);
        } else {
            return redirect()->route('admin.users.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }

    public function destroy(User $user)
    {
        Storage::delete('public/user/' . $user->avatar);
        $user->delete();

        if ($user) {
            return redirect()->route('admin.users.index')->with(['success' => 'Data Berhasil Dihapus!']);
        } else {
            return redirect()->route('admin.users.index')->with(['error' => 'Data Gagal Dihapus!']);
        }
    }

    public function show(User $user)
    {
        $title = 'Detail User';
        return view('pages.users.show', compact('user', 'title'));
    }
}