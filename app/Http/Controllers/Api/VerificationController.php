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
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify(Request $request)
    {
        // Find user by ID
        $user = User::findOrFail($request->route('id'));

        // Verify user's email
        if (! hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            return response()->json(['message' => 'Invalid verification link'], 400);
        }

        // Check if email is already verified
        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified'], 200);
        }

        // Mark the user's email as verified
        $user->markEmailAsVerified();

        return response()->json(['message' => 'Email successfully verified'], 200);
    }
}