<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\VerifiesEmails;

class LoginController extends Controller
{
    /**
     * Login user and return token.
     *
     * @param  Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'     => 'required|email',
            'password'  => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            // Get user by email
            $user = User::where('email', $request->email)->firstOrFail();

            // Check if user has verified their email
            if (!$user->hasVerifiedEmail()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email belum terverifikasi. Silakan periksa email Anda untuk tautan verifikasi.',
                ], 401);
            }

            // Validate password
            if (!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid credentials!',
                ], 401);
            }

            // Generate token
            $token = $user->createToken('authToken')->accessToken;

            // Determine user role and return appropriate response
            $userData = [
                'success' => true,
                'message' => 'Login Successful!',
                'token'   => $token,
            ];

            // Set user role based on conditions
            if ($user->role == 1) { // Role 1 indicates PIC
                switch ($user->nim) {
                    case 'pic-hmab':
                        $userData['role'] = 'pic_hmab';
                        $userData['data'] = $user;
                        break;
                    case 'pic-hima':
                        $userData['role'] = 'pic_hima';
                        $userData['data'] = $user;
                        break;
                    case 'pic-hms':
                        $userData['role'] = 'pic_hms';
                        $userData['data'] = $user;
                        break;
                    case 'pic-hmm':
                        $userData['role'] = 'pic_hmm';
                        $userData['data'] = $user;
                        break;
                    case 'pic-hme':
                        $userData['role'] = 'pic_hme';
                        $userData['data'] = $user;
                        break;
                    case 'pic-satgas':
                        $userData['role'] = 'pic_satgas';
                        $userData['data'] = $user;
                        break;
                    case 'pic-bem':
                        $userData['role'] = 'pic_bem';
                        $userData['data'] = $user;
                        break;
                    default:
                        $userData['role'] = 'unknown_pic';
                        break;
                }
            } elseif ($user->role == 2) { // Role 2 indicates Mahasiswa
                $userData['role'] = 'mahasiswa';
                $userData['data'] = $user; // Return user data for Mahasiswa
            } else {
                // Default role if not matched
                $userData['role'] = 'unknown';
            }

            // Return success response
            return response()->json($userData, 200);

        } catch (\Exception $e) {
            // Return error response if user not found or other exception occurs
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials!',
                'error' => $e->getMessage(),
            ], 401);
        }
    }

    /**
     * Logout user and revoke token.
     *
     * @param  Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'success' => true,
            'message' => 'Logout Successful!',
        ], 200);
    }
}