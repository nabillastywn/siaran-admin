<?php

namespace App\Http\Controllers\Admin;

use App\Models\UserMhs;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class UserMhsController extends Controller
{
    public function index()
    {
        $userMhs = UserMhs::latest()->when(request()->q, function($query) {
            $query->where('name', 'like', '%' . request()->q . '%');
        })->paginate(10);

        $title = 'UserMhs';

        return view('pages.usermhs.index', compact('userMhs', 'title'));
    }

    public function create()
    {
        return view('pages.usermhs.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:user_mhs',
            'email' => 'required|email|unique:user_mhs',
            'nim' => 'required|unique:user_mhs',
            'class' => 'required',
            'major' => 'required',
            'study_program' => 'required',
            'phone_number' => 'required',
            'password' => 'required|string|confirmed|min:8',
            'password_confirmation' => 'required|same:password',
            'avatar' => 'nullable|image|mimes:jpeg,jpg,png|max:2000',
        ]);

        $avatarName = null;

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = basename($request->file('avatar')->hashName());
            $avatar->storeAs('public/user/mahasiswa', $avatarName);

        }

        $userMhs = UserMhs::create([
            'name' => $request->name,
            'email' => $request->email,
            'nim' => $request->nim,
            'class' => $request->class,
            'major' => $request->major,
            'study_program' => $request->study_program,
            'phone_number' => $request->phone_number,
            'password' => bcrypt($request->password),
            'avatar' => $avatarName,
        ]);

        if ($userMhs) {
            return redirect()->route('admin.user-mhs.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            return redirect()->route('admin.user-mhs.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    public function edit(UserMhs $userMhs)
    {
        return view('pages.usermhs.edit', compact('userMhs'));
    }

    public function update(Request $request, UserMhs $userMhs)
    {
        $this->validate($request, [
            'name' => 'required|unique:user_mhs,name,' . $userMhs->id,
            'email' => 'required|email|unique:user_mhs,email,' . $userMhs->id,
            'nim' => 'required|unique:user_mhs,nim,' . $userMhs->id,
            'class' => 'required',
            'major' => 'required',
            'study_program' => 'required',
            'phone_number' => 'required',
            'password' => 'nullable|min:8',
            'avatar' => 'nullable|image|mimes:jpeg,jpg,png|max:2000',
        ]);

        $avatarName = $userMhs->avatar;

        if ($request->hasFile('avatar')) {
            Storage::delete('public/user/mahasiswa/' . $avatarName);
            $avatar = $request->file('avatar');
            $avatarName = $avatar->hashName();
            $avatar->storeAs('public/user/mahasiswa', $avatarName);
        }

        $userMhs->update([
            'name' => $request->name,
            'email' => $request->email,
            'nim' => $request->nim,
            'class' => $request->class,
            'major' => $request->major,
            'study_program' => $request->study_program,
            'phone_number' => $request->phone_number,
            'password' => $request->password ? bcrypt($request->password) : $userMhs->password,
            'avatar' => $avatarName,
        ]);

        if ($userMhs) {
            return redirect()->route('admin.user-mhs.index')->with(['success' => 'Data Berhasil Diupdate!']);
        } else {
            return redirect()->route('admin.user-mhs.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }

    public function destroy(UserMhs $userMhs)
    {
        Storage::delete('public/user/mahasiswa/' . $userMhs->avatar);
        $userMhs->delete();

        if ($userMhs) {
            return redirect()->route('admin.user-mhs.index')->with(['success' => 'Data Berhasil Dihapus!']);
        } else {
            return redirect()->route('admin.user-mhs.index')->with(['error' => 'Data Gagal Dihapus!']);
        }
    }

    public function show(UserMhs $userMhs)
    {
        $title = 'Detail UserMhs';
        return view('pages.usermhs.show', compact('userMhs', 'title'));
    }
}