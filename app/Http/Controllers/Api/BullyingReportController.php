<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\BullyingReport;
use App\Models\User;
use Carbon\Carbon;

class BullyingReportController extends Controller
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
            'attachment' => 'nullable|mimes:jpeg,png,jpg,gif,svg,doc,docx,mp4,mp3,wav,pdf|max:20480',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $userL = auth()->guard('api')->user();

            $user = User::findOrFail($userL->id);

            // Ensure only MAHASISWA_ROLE (role = 2) can create bullying report
            if (!$user->isUserMhs()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized to create a Bullying Report.',
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

            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $fileName = $file->hashName();
                $file->storeAs('public/report/bullying', $fileName);
                $data['attachment'] = $fileName;
            }

            // Create the bullying report
            $bullyingReport = BullyingReport::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Bullying Report successfully created.',
                'data' => $bullyingReport,
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create Bullying Report.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Other methods...
    
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
            
            if ($user->isUserPic() && $user->nim === 'pic-bem') {
                // Fetch all bullying reports for pic_bem
                $bullyingReports = BullyingReport::orderBy('created_at', 'desc')->get();
            } elseif ($user->isUserMhs()) {
                // Fetch only user's own bullying reports
                $bullyingReports = BullyingReport::where('user_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->get();
            } else {
                // Unauthorized access for other roles
                return response()->json([
                    'success' => false,
                    'message' => 'You Are Unauthorized to access Bullying Reports.',
                ], 403);
            }

            return response()->json([
                'success' => true,
                'message' => 'List Bullying Reports',
                'data' => $bullyingReports->map(function ($report) {
                    return [
                        'id' => $report->id,
                        'user' => [
                            'id' => $report->user->id,
                            'name' => $report->user->name,
                            'email' => $report->user->email,
                            'address' => $report->user->address,
                            'phone_number' => $report->user->phone_number,
                            'class' => $report->user->class,
                            'major' => $report->user->major,
                            'study_program' => $report->user->study_program,
                        ],
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
                'message' => 'Failed to fetch Bullying Reports.',
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
            if (!($user->isUserPic() && $user->nim === 'pic-bem')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized to update the Bullying Report status.',
                ], 403);
            }

            $bullyingReport = BullyingReport::findOrFail($id);
            $bullyingReport->status_id = $request->status_id;
            $bullyingReport->save();

            return response()->json([
                'success' => true,
                'message' => 'Bullying Report status successfully updated.',
                'data' => $bullyingReport,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update Bullying Report status.',
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

            $bullyingReport = BullyingReport::findOrFail($id);

            // Ensure only pic_bem or the user who created the report can view the details
            if (($user->isUserPic() && $user->nim === 'pic-bem') || $bullyingReport->user_id == $user->id) {
                return response()->json([
                    'success' => true,
                    'message' => 'Bullying Report Details',
                    'data' => [
                        'id' => $bullyingReport->id,
                        'user' => [
                            'id' => $bullyingReport->user->id,
                            'name' => $bullyingReport->user->name,
                            'email' => $bullyingReport->user->email,
                            'address' => $bullyingReport->user->address,
                            'phone_number' => $bullyingReport->user->phone_number,
                            'class' => $bullyingReport->user->class,
                            'major' => $bullyingReport->user->major,
                            'study_program' => $bullyingReport->user->study_program,
                        ],
                        'location' => $bullyingReport->location,
                        'date' => $bullyingReport->date,
                        'description' => $bullyingReport->description,
                        'attachment' => $bullyingReport->attachment,
                        'slug' => $bullyingReport->slug,
                        'status' => [
                            'id' => $bullyingReport->status->id,
                            'name' => $bullyingReport->status->name,
                        ],
                        'created_at' => $bullyingReport->created_at,
                        'updated_at' => $bullyingReport->updated_at,
                    ],
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized to view this Bullying Report.',
                ], 403);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch Bullying Report details.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}