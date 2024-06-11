<?php

namespace App\Http\Controllers\Admin;

use App\Models\UserPic;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class UserPicController extends Controller
{
    public function index()
    {
        $userPics = UserPic::latest()->when(request()->q, function($query) {
            $query->where('username', 'like', '%' . request()->q . '%');
        })->paginate(10);

        $title = 'UserPic';

        return view('pages.userpic.index', compact('userPics', 'title'));
    }

    public function create()
    {
        return view('pages.userpic.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|unique:user_pics',
            'email' => 'required|email|unique:user_pics',
            'phone_number' => 'required',
            'password' => 'required|string|confirmed|min:8',
            'password_confirmation' => 'required|same:password',
            'avatar' => 'nullable|image|mimes:jpeg,jpg,png|max:2000',
        ]);

        $avatarName = null;

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = basename($request->file('avatar')->hashName());
            $avatar->storeAs('public/user/pic', $avatarName);
        }

        $userPic = UserPic::create([
            'username' => $request->username,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => $request->password,
            'avatar' => $avatarName,
        ]);

        if ($userPic) {
            return redirect()->route('admin.user-pic.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            return redirect()->route('admin.user-pic.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    public function edit(UserPic $userPic)
    {
        return view('pages.userpic.edit', compact('userPic'));
    }

    public function update(Request $request, UserPic $userPic)
    {
        $this->validate($request, [
            'username' => 'required|unique:user_pics,username,' . $userPic->id,
            'email' => 'required|email|unique:user_pics,email,' . $userPic->id,
            'phone_number' => 'required',
            'password' => 'nullable|min:8',
            'avatar' => 'nullable|image|mimes:jpeg,jpg,png|max:2000',
        ]);

        $avatarName = $userPic->avatar;

        if ($request->hasFile('avatar')) {
            Storage::delete('public/user/pic/' . $avatarName);
            $avatar = $request->file('avatar');
            $avatarName = $avatar->hashName();
            $avatar->storeAs('public/user/pic', $avatarName);
        }

        $userPic->update([
            'username' => $request->username,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => $request->password ? bcrypt($request->password) : $userPic->password,
            'avatar' => $avatarName,
        ]);

        if ($userPic) {
            return redirect()->route('admin.user-pic.index')->with(['success' => 'Data Berhasil Diupdate!']);
        } else {
            return redirect()->route('admin.user-pic.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }

    public function destroy(UserPic $userPic)
    {
        Storage::delete('public/user/pic/' . $userPic->avatar);
        $userPic->delete();

        if ($userPic) {
            return redirect()->route('admin.user-pic.index')->with(['success' => 'Data Berhasil Dihapus!']);
        } else {
            return redirect()->route('admin.user-pic.index')->with(['error' => 'Data Gagal Dihapus!']);
        }
    }

    public function show(UserPic $userPic)
    {
        $title = 'Detail UserPic';
        return view('pages.userpic.show', compact('userPic', 'title'));
    }
}