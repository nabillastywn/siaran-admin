<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function create()
    {
        // Hanya admin yang bisa mengakses halaman ini
        if (!auth()->check() || auth()->user()->role !== 0) {
            return redirect('/login')->withErrors(['You are not authorized to access this page.']);
        }

        return view('auth.register');
    }

    public function store(Request $request)
    {
        // Hanya admin yang bisa mengakses metode ini
        if (!auth()->check() || auth()->user()->role !== 0) {
            return redirect('/login')->withErrors(['You are not authorized to access this page.']);
        }

        $attributes = $request->validate([
            'username' => 'required|max:255|min:2',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:5|max:255',
            'role' => 'required|in:1,2', // Hanya `user_pic` dan mahasiswa yang bisa didaftarkan
            'terms' => 'required'
        ]);

        $user = User::create($attributes);
        auth()->login($user);

        return redirect('/dashboard');
    }
}