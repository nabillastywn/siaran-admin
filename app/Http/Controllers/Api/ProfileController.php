<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    /**
     * Get the authenticated user's profile.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'Data Profile',
            'data'    => auth()->guard('api')->user(),
        ], 200);
    }

    /**
     * Update user profile.
     *
     * @param  Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
{
    Log::info('PATCH request data:', $request->all());

    $validator = Validator::make($request->all(), [
        'name' => 'nullable|string|max:255',
        'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'nim' => 'nullable|string|max:255',
        'class' => 'nullable|string|max:255',
        'major' => 'nullable|string|max:255',
        'study_program' => 'nullable|string|max:255',
        'phone_number' => 'nullable|string|max:255',
        'address' => 'nullable|string|max:255',
    ]);

    if ($validator->fails()) {
        Log::error('Validation failed:', $validator->errors()->toArray());
        return response()->json($validator->errors(), 400);
    }

    try {
        // Get authenticated user's profile
        $user = User::findOrFail(auth()->guard('api')->user()->id);

        // Prepare data to update
        $updateData = [];

        if ($request->has('name')) {
            $updateData['name'] = $request->name;
        }

        if ($request->has('nim')) {
            $updateData['nim'] = $request->nim;
        }

        if ($request->has('class')) {
            $updateData['class'] = $request->class;
        }

        if ($request->has('major')) {
            $updateData['major'] = $request->major;
        }

        if ($request->has('study_program')) {
            $updateData['study_program'] = $request->study_program;
        }

        if ($request->has('phone_number')) {
            $updateData['phone_number'] = $request->phone_number;
        }

        if ($request->has('address')) {
            $updateData['address'] = $request->address;
        }

        // Update with uploaded avatar
        if ($request->file('avatar')) {
            // Delete old avatar image
            if ($user->avatar) {
                Storage::disk('local')->delete('public/user/' . basename($user->avatar));
            }

            // Upload new avatar image
            $image = $request->file('avatar');
            $image->storeAs('public/user', $image->hashName());

            $updateData['avatar'] = $image->hashName();
        }

        Log::info('Update data:', $updateData);

        // Update user data
        $user->update($updateData);

        Log::info('Updated user data:', $user->toArray());

        // Return success response
        return response()->json([
            'success' => true,
            'message' => 'Data Profile Berhasil Diupdate!',
            'data' => $user,
        ], 200);

    } catch (\Exception $e) {
        Log::error('Failed to update profile:', ['exception' => $e]);

        // Return error response if any exception occurs
        return response()->json([
            'success' => false,
            'message' => 'Failed to update profile.',
            'error' => $e->getMessage(),
        ], 500);
    }
}


    /**
     * Update user password.
     *
     * @param  Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|confirmed|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            // Get authenticated user's profile
            $user = User::findOrFail(auth()->guard('api')->user()->id);

            // Check if current password matches
            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Current Password does not match!',
                ], 400);
            }

            // Update the new password
            $user->update([
                'password' => Hash::make($request->new_password),
            ]);

            // Return success response
            return response()->json([
                'success' => true,
                'message' => 'Password Berhasil Diupdate!',
                'data' => $user,
            ], 200);

        } catch (\Exception $e) {
            // Return error response if any exception occurs
            return response()->json([
                'success' => false,
                'message' => 'Failed to update password.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}