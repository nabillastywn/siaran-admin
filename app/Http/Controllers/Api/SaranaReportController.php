<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\SaranaReport;
use App\Models\User;
use Carbon\Carbon;

class SaranaReportController extends Controller
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
            'sarpras_id' => 'required|integer|exists:sarpras,id',
            'location' => 'required|string|max:255',
            'date' => 'required|date_format:Y-m-d',
            'report' => 'required|string',
            'attachment' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $userL = auth()->guard('api')->user();

            $user = User::findOrFail($userL->id);

            // Ensure only MAHASISWA_ROLE (role = 2) can create Sarana report
            if (!$user->isUserMhs()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized to create a Sarana Report.',
                ], 403);
            }

            $data = [
                'sarpras_id' => $request->sarpras_id,
                'user_id' => $user->id,
                'location' => $request->location,
                'date' => $request->date,
                'report' => $request->report,
                'slug' => Str::slug($request->report . '-' . Carbon::now()->timestamp),
                'status_id' => 1, // Assuming status_id 1 represents 'pending' status
            ];

            // Handle attachment upload if provided
            if ($request->hasFile('attachment')) {
                $image = $request->file('attachment');
                $imageName = $image->hashName();
                $image->storeAs('public/report/sarpras', $imageName);
                $data['attachment'] = $imageName;
            }

            // Create the sarana report
            $saranaReport = SaranaReport::create($data);

            // Transform the response data
            $responseData = [
                'id' => $saranaReport->id,
                'sarpras_id' => $saranaReport->sarpras_id,
                'user_id' => $saranaReport->user_id,
                'location' => $saranaReport->location,
                'date' => $saranaReport->date,
                'description' => $saranaReport->report,
                'attachment' => $saranaReport->attachment ? asset('storage/report/sarpras/' . $saranaReport->attachment) : null,
                'slug' => $saranaReport->slug,
                'status_id' => $saranaReport->status_id,
                'created_at' => Carbon::parse($saranaReport->created_at)->format('d-M-Y H:i'),
                'updated_at' => Carbon::parse($saranaReport->updated_at)->format('d-M-Y H:i'),
            ];

            return response()->json([
                'success' => true,
                'message' => 'Sarana Report successfully created.',
                'data' => $responseData,
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create Sarana Report.',
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
        
        // Define array of sarpras_id based on nim condition
        $allowedSarprasIds = [];
        
        if ($user->isUserPic()) {
            switch ($user->nim) {
                case 'pic-bem':
                    $allowedSarprasIds = [1];
                    break;
                case 'pic-hme':
                    $allowedSarprasIds = [2];
                    break;
                case 'pic-hms':
                    $allowedSarprasIds = [3];
                    break;
                case 'pic-hmm':
                    $allowedSarprasIds = [4];
                    break;
                case 'pic-hima':
                    $allowedSarprasIds = [5];
                    break;
                case 'pic-hmab':
                    $allowedSarprasIds = [6];
                    break;
                default:
                    return response()->json([
                        'success' => false,
                        'message' => 'Unauthorized to access Sarana Reports.',
                    ], 403);
            }
            
            // Fetch sarana reports based on allowed sarpras_ids
            $saranaReports = SaranaReport::whereIn('sarpras_id', $allowedSarprasIds)
                ->orderBy('created_at', 'desc')
                ->get();
        } elseif ($user->isUserMhs()) {
            // Fetch only user's own sarana reports
            $saranaReports = SaranaReport::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            // Unauthorized access for other roles
            return response()->json([
                'success' => false,
                'message' => 'You Are Unauthorized to access Sarana Reports.',
            ], 403);
        }

        return response()->json([
            'success' => true,
            'message' => 'List Sarana Reports',
            'data' => $saranaReports->map(function ($report) {
                return [
                    'id' => $report->id,
                    'sarpras' => [
                        'id' => $report->sarpras->id,
                        'name' => $report->sarpras->name,
                    ],
                    'user' => [
                            'id' => $report->user->id,
                            'name' => $report->user->name,
                            'email' =>$report->user->email,
                            'address' => $report->user->address,
                            'phone_number' => $report->user->phone_number,
                            'class' => $report->user->class,
                            'major' =>$report->user->major,
                            'study_program' => $report->user->study_program,
                        ],
                    'location' => $report->location,
                    'date' => $report->date,
                    'description' => $report->report,
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
            'message' => 'Failed to fetch Sarana Reports.',
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

        // Ensure only PIC_ROLE (role = 1) with specific nim can update status
        if (!($user->isUserPic() && in_array($user->nim, ['pic-bem', 'pic-hme', 'pic-hms', 'pic-hmm', 'pic-hima', 'pic-hmab']))) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to update the Sarana Report status.',
            ], 403);
        }

        // Fetch sarana report based on allowed sarpras_ids
        $saranaReport = SaranaReport::findOrFail($id);

        // Check if the user is authorized to update based on sarpras_id
        switch ($user->nim) {
            case 'pic-bem':
                if ($saranaReport->sarpras_id !== 1) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Unauthorized to update Sarana Report status for this sarpras_id.',
                    ], 403);
                }
                break;
            case 'pic-hme':
                if ($saranaReport->sarpras_id !== 2) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Unauthorized to update Sarana Report status for this sarpras_id.',
                    ], 403);
                }
                break;
            case 'pic-hms':
                if ($saranaReport->sarpras_id !== 3) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Unauthorized to update Sarana Report status for this sarpras_id.',
                    ], 403);
                }
                break;
            case 'pic-hmm':
                if ($saranaReport->sarpras_id !== 4) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Unauthorized to update Sarana Report status for this sarpras_id.',
                    ], 403);
                }
                break;
            case 'pic-hima':
                if ($saranaReport->sarpras_id !== 5) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Unauthorized to update Sarana Report status for this sarpras_id.',
                    ], 403);
                }
                break;
            case 'pic-hmab':
                if ($saranaReport->sarpras_id !== 6) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Unauthorized to update Sarana Report status for this sarpras_id.',
                    ], 403);
                }
                break;
            default:
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized to update the Sarana Report status.',
                ], 403);
        }

        // Update status
        $saranaReport->status_id = $request->status_id;
        $saranaReport->save();

        return response()->json([
            'success' => true,
            'message' => 'Sarana Report status successfully updated.',
            'data' => $saranaReport,
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to update Sarana Report status.',
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
        // Retrieve authenticated user
        $userL = auth()->guard('api')->user();
        $user = User::findOrFail($userL->id);

        // Find the SaranaReport by ID
        $saranaReport = SaranaReport::findOrFail($id);

        // Check authorization:
        // Allow access if the user is a 'pic-bem', 'pic-hme', etc., based on sarpras_id
        // Or allow access if the user is a student (role = 2) and owns the report
        if ($user->isUserMhs() && $saranaReport->user_id === $user->id) {
            // If user is a student and owns the report, allow access
        } else {
            switch ($user->nim) {
                case 'pic-bem':
                    if ($saranaReport->sarpras_id !== 1) {
                        return response()->json([
                            'success' => false,
                            'message' => 'You are unauthorized to view this Sarana Report.',
                        ], 403);
                    }
                    break;
                case 'pic-hme':
                    if ($saranaReport->sarpras_id !== 2) {
                        return response()->json([
                            'success' => false,
                            'message' => 'You are unauthorized to view this Sarana Report.',
                        ], 403);
                    }
                    break;
                case 'pic-hms':
                    if ($saranaReport->sarpras_id !== 3) {
                        return response()->json([
                            'success' => false,
                            'message' => 'You are unauthorized to view this Sarana Report.',
                        ], 403);
                    }
                    break;
                case 'pic-hmm':
                    if ($saranaReport->sarpras_id !== 4) {
                        return response()->json([
                            'success' => false,
                            'message' => 'You are unauthorized to view this Sarana Report.',
                        ], 403);
                    }
                    break;
                case 'pic-hima':
                    if ($saranaReport->sarpras_id !== 5) {
                        return response()->json([
                            'success' => false,
                            'message' => 'You are unauthorized to view this Sarana Report.',
                        ], 403);
                    }
                    break;
                case 'pic-hmab':
                    if ($saranaReport->sarpras_id !== 6) {
                        return response()->json([
                            'success' => false,
                            'message' => 'You are unauthorized to view this Sarana Report.',
                        ], 403);
                    }
                    break;
                default:
                    return response()->json([
                        'success' => false,
                        'message' => 'You are unauthorized to view this Sarana Report.',
                    ], 403);
            }
        }

        // If authorized, construct and return the response with Sarana Report details
        return response()->json([
            'success' => true,
            'message' => 'Sarana Report Details',
            'data' => [
                'id' => $saranaReport->id,
                'user' => [
                    'id' => $saranaReport->user->id,
                    'name' => $saranaReport->user->name,
                    'email' => $saranaReport->user->email,
                    'address' => $saranaReport->user->address,
                    'phone_number' => $saranaReport->user->phone_number,
                    'class' => $saranaReport->user->class,
                    'major' => $saranaReport->user->major,
                    'study_program' => $saranaReport->user->study_program,
                ],
                'sarpras' => [
                    'id' => $saranaReport->sarpras->id,
                    'name' => $saranaReport->sarpras->name,
                ],
                'location' => $saranaReport->location,
                'date' => $saranaReport->date,
                'description' => $saranaReport->report,
                'attachment' => $saranaReport->attachment,
                'slug' => $saranaReport->slug,
                'status' => [
                    'id' => $saranaReport->status->id,
                    'name' => $saranaReport->status->name,
                ],
                'created_at' => $saranaReport->created_at,
                'updated_at' => $saranaReport->updated_at,
            ],
        ], 200);

    } catch (\Exception $e) {
        // Handle exceptions
        return response()->json([
            'success' => false,
            'message' => 'Failed to fetch Sarana Report details.',
            'error' => $e->getMessage(),
        ], 500);
    }
}

public function destroy($id)
{
    try {
        $userL = auth()->guard('api')->user();
        $user = User::findOrFail($userL->id);

        // Find the Sarana Report by ID
        $saranaReport = SaranaReport::findOrFail($id);

        // Check if the report belongs to the authenticated user and if its status is '1' (pending)
        if ($saranaReport->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to delete this Sarana Report.',
            ], 403);
        }

        if ($saranaReport->status_id !== 1) {
            return response()->json([
                'success' => false,
                'message' => 'Sarana Report cannot be deleted as it is already being processed.',
            ], 403);
        }

        // Delete the report
        $saranaReport->delete();

        return response()->json([
            'success' => true,
            'message' => 'Sarana Report successfully deleted.',
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to delete Sarana Report.',
            'error' => $e->getMessage(),
        ], 500);
    }
}
}