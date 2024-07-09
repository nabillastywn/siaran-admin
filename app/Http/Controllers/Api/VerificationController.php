<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class VerificationController extends Controller
{
    /**
     * Verify the user's email.
     *
     * @param  Request  $request
     * @return \Illuminate\View\View
     */
    public function verify(Request $request)
    {
        // Find user by ID
        $user = User::findOrFail($request->route('id'));

        // Verify user's email
        if (! hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            return view('auth.result', ['status' => 'error', 'message' => 'Invalid verification link']);
        }

        // Check if email is already verified
        if ($user->hasVerifiedEmail()) {
            return view('auth.result', ['status' => 'info', 'message' => 'Email already verified']);
        }

        // Mark the user's email as verified
        $user->markEmailAsVerified();

        return view('auth.result', ['status' => 'success', 'message' => 'Email successfully verified']);
    }
}