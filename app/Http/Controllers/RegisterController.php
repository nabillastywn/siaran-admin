<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(function ($request, $next) {
    //         if (!auth()->check() || auth()->user()->role !== 0) {
    //             return redirect('/login')->withErrors(['You are not authorized to access this page.']);
    //         }
    //         return $next($request);
    //     });
    // }

    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'username' => 'required|max:255|min:2',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:5|max:255',
            'role' => 'required|in:1,2', // Hanya `user_pic` dan mahasiswa yang bisa didaftarkan
        ]);

        $attributes['password'] = Hash::make($attributes['password']);

        $user = User::create($attributes);

        Auth::login($user);

        return redirect('/dashboard')->with('success', 'User registered successfully.');
    }
}