<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{    
    /**
     * register
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        // Set validasi
        $validator = Validator::make($request->all(), [
            'name'          => 'required|string|max:255',
            'email'         => 'required|string|email|max:255|unique:users',
            'password'      => 'required|string|min:8|confirmed',
            'address'       => 'nullable|string|max:255',
            'phone_number'  => 'required|string|max:20',
            'nim'           => 'required|string|max:20|unique:users',
            'class'         => 'nullable|string|max:50',
            'major'         => 'nullable|string|max:50',
            'study_program' => 'nullable|string|max:50',
            'avatar'        => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Create user
        $user = User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'address'       => $request->address,
            'phone_number'  => $request->phone_number,
            'nim'           => $request->nim,
            'class'         => $request->class,
            'major'         => $request->major,
            'study_program' => $request->study_program,
            'avatar'        => $request->avatar,
            'role'          => User::MAHASISWA_ROLE, // Set role to Mahasiswa
        ]);
        
        // Return JSON
        return response()->json([
            'success' => true,
            'message' => 'Register Berhasil!',
            'data'    => $user,
            'token'   => $user->createToken('authToken')->accessToken  
        ], 201);
    }
}