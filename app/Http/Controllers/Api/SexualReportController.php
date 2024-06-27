<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\SexualReport;
use App\Models\User;
use Carbon\Carbon;

class SexualReportController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'location' => 'required|string|max:255',
            'date' => 'required|date_format:Y-m-d',
            'description' => 'required|string',
            'attachment' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $userL = auth()->guard('api')->user();

            $user = User::findOrFail($userL->id);

            // Ensure only MAHASISWA_ROLE (role = 2) can create sexual report
            if (!$user->isUserMhs()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized to create a Sexual Report.',
                ], 403);
            }

            $data = [
                'user_id' => $user->id,
                'location' => $request->location,
                'date' => $request->date,
                'description' => $request->description,
                'slug' => Str::slug($request->description . '-' . Carbon::now()->timestamp),
                'status_id' => 1, // Assuming status_id 1 represents 'pending' status
            ];

            // Handle attachment upload if provided
            if ($request->hasFile('attachment')) {
                $image = $request->file('attachment');
                $imageName = $image->hashName();
                $image->storeAs('public/report/sexual', $imageName);
                $data['attachment'] = $imageName;
            }

            // Create the sexual report
            $sexualReport = SexualReport::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Sexual Report successfully created.',
                'data' => $sexualReport,
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create Sexual Report.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display a listing of the resource for the authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $userL = auth()->guard('api')->user();

            $user = User::findOrFail($userL->id);

            // Check if user is admin or pic_bem
            if ($user->isUserPic() && $user->nim === 'pic-satgas') {
                // Fetch all sexual reports for pic_bem
                $sexualReports = SexualReport::orderBy('created_at', 'desc')->get();
            } elseif ($user->isUserMhs()) {
                // Fetch only user's own sexual reports
                $sexualReports = SexualReport::where('user_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->get();
            } else {
                // Unauthorized access for other roles
                return response()->json([
                    'success' => false,
                    'message' => 'You Are Unauthorized to access Sexual Reports.',
                ], 403);
            }

            return response()->json([
                'success' => true,
                'message' => 'List Sexual Reports',
                'data' => $sexualReports->map(function ($report) {
                    return [
                        'id' => $report->id,
                        'location' => $report->location,
                        'date' => $report->date,
                        'description' => $report->description,
                        'attachment' => $report->attachment,
                        'slug' => $report->slug,
                        'status' => [
                            'id' => $report->status->id,
                            'name' => $report->status->name,
                        ],
                        'created_at' => $report->created_at,
                        'updated_at' => $report->updated_at,
                    ];
                }),
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch Sexual Reports.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the status of the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status_id' => 'required|integer|exists:statuses,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $userL = auth()->guard('api')->user();

            $user = User::findOrFail($userL->id);

            // Ensure only PIC_ROLE (role = 1) with nim pic-bem can update status
            if (!($user->isUserPic() && $user->nim === 'pic-satgas')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized to update the Sexual Report status.',
                ], 403);
            }

            $sexualReport = SexualReport::findOrFail($id);
            $sexualReport->status_id = $request->status_id;
            $sexualReport->save();

            return response()->json([
                'success' => true,
                'message' => 'Sexual Report status successfully updated.',
                'data' => $sexualReport,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update Sexual Report status.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $userL = auth()->guard('api')->user();

            $user = User::findOrFail($userL->id);

            $sexualReport = SexualReport::findOrFail($id);

            // Ensure only pic_bem or the user who created the report can view the details
            if (($user->isUserPic() && $user->nim === 'pic-satgas') || $sexualReport->user_id == $user->id) {
                return response()->json([
                    'success' => true,
                    'message' => 'Sexual Report Details',
                    'data' => [
                        'id' => $sexualReport->id,
                        'user' => [
                            'id' => $sexualReport->user->id,
                            'name' => $sexualReport->user->name,
                            'email' => $sexualReport->user->email,
                            'address' => $sexualReport->user->address,
                            'phone_number' => $sexualReport->user->phone_number,
                            'class' => $sexualReport->user->class,
                            'major' => $sexualReport->user->major,
                            'study_program' => $sexualReport->user->study_program,
                        ],
                        'location' => $sexualReport->location,
                        'date' => $sexualReport->date,
                        'description' => $sexualReport->description,
                        'attachment' => $sexualReport->attachment,
                        'slug' => $sexualReport->slug,
                        'status' => [
                            'id' => $sexualReport->status->id,
                            'name' => $sexualReport->status->name,
                        ],
                        'created_at' => $sexualReport->created_at,
                        'updated_at' => $sexualReport->updated_at,
                    ],
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'You are unauthorized to view this Sexual Report.',
                ], 403);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch Sexual Report details.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $userL = auth()->guard('api')->user();
            $user = User::findOrFail($userL->id);

            // Find the Sexual Report by ID
            $sexualReport = SexualReport::findOrFail($id);

            // Check if the report belongs to the authenticated user and if its status is '1' (pending)
            if ($sexualReport->user_id !== $user->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized to delete this Sexual Report.',
                ], 403);
            }

            if ($sexualReport->status_id !== 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sexual Report cannot be deleted as it is already being processed.',
                ], 403);
            }

            // Delete the report
            $sexualReport->delete();

            return response()->json([
                'success' => true,
                'message' => 'Sexual Report successfully deleted.',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete Sexual Report.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}