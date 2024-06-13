<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function show()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $attributes = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $user = User::where('email', $request->email)->first();

        // dd($user->password);
        // try {
        //     dd($request->password);
        // } catch (Exception $e) {
        //     dd($e);
        // }
        
        // try {
        //     dd(Hash::make($request->password));
        //     dd($user->password);
        // } catch (Exception $e) {
        //     dd($e);
        // }
        
        // try {
        //     dd(Hash::check($user->password, $request->password));
        // } catch (Exception $e) {
        //     dd($e);
        // }
        

        if (Hash::check($request->password, $user->password)) {
            dd($user->role);
            if ($user->role == 0) {
            // $request->session()->regenerate();
            Auth::login($user);

            // dd($user);

            return redirect()->intended('dashboard');
            } else {
                return back()->withErrors(['role' => 'Access denied! Only admin can login.']);
            }
        } else {
            return back()->withErrors(['email' => 'Invalid credentials.']);
        };

        // if (Auth::attempt(['email' => 'siaran@gmail.com', 'password'=> 'siaran', 'role'=> 0])) {
        //     $request->session()->regenerate();

        //     return redirect()->intended('dashboard');
        // }
        // else {
        //     return back()->withErrors([
        //         'email' => 'The provided credentials do not match our records.',
        //     ]);
        // }

       
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}