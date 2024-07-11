<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\ItemsReport;
use App\Models\User;
use Carbon\Carbon;

class ItemsReportController extends Controller
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
            'lost_item_id' => 'required|exists:lost_items,id',
            'location' => 'required|string|max:255',
            'date' => 'required|date_format:Y-m-d',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'attachment' => 'nullable|mimes:jpeg,png,jpg,gif,svg,doc,docx,mp4,mp3,wav,pdf|max:20480',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $userL = auth()->guard('api')->user();

            $user = User::findOrFail($userL->id);

            // Ensure only MAHASISWA_ROLE (role = 2) can create items report
            if (!$user->isUserMhs()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized to create an Items Report.',
                ], 403);
            }

            $data = [
                'user_id' => $user->id,
                'lost_item_id' => $request->lost_item_id,
                'location' => $request->location,
                'date' => $request->date,
                'name' => $request->name,
                'description' => $request->description,
                'slug' => Str::slug($request->name . '-' . Carbon::now()->timestamp),
                'status_id' => 1, // Assuming statuses_id 1 represents 'pending' status
            ];

            // Handle attachment upload if provided
            if ($request->hasFile('attachment')) {
                $image = $request->file('attachment');
                $imageName = $image->hashName();
                $image->storeAs('public/report/items', $imageName);
                $data['attachment'] = $imageName;
            }

            // Create the items report
            $itemsReport = ItemsReport::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Items Report successfully created.',
                'data' => $itemsReport,
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create Items Report.',
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

        // Ensure only MAHASISWA_ROLE (role = 2) can access this endpoint
        if (!$user->isUserMhs()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to access Items Reports.',
            ], 403);
        }

        // Fetch only user's own items reports with eager loading for relationships
        $itemsReports = ItemsReport::with(['user', 'lostItem', 'status'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'List Items Reports',
            'data' => $itemsReports->map(function ($report) {
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
                    'lost_item' => [
                        'id' => $report->lostItem->id,
                        'name' => $report->lostItem->name,
                    ],
                    'location' => $report->location,
                    'date' => $report->date,
                    'name' => $report->name,
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
            'message' => 'Failed to fetch Items Reports.',
            'error' => $e->getMessage(),
        ], 500);
    }
}

public function getAllReports()
{
    try {
        $itemsReports = ItemsReport::with(['user', 'lostItem', 'status'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'List of All Items Reports',
            'data' => $itemsReports->map(function ($report) {
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
                    'lost_item' => [
                        'id' => $report->lostItem->id,
                        'name' => $report->lostItem->name,
                    ],
                    'location' => $report->location,
                    'date' => $report->date,
                    'name' => $report->name,
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
            'message' => 'Failed to fetch Items Reports.',
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
            $itemsReport = ItemsReport::with(['user', 'lostItem', 'status'])->findOrFail($id);
    
            return response()->json([
                'success' => true,
                'message' => 'Items Report Details',
                'data' => [
                    'id' => $itemsReport->id,
                    'user' => [
                        'id' => $itemsReport->user->id,
                        'name' => $itemsReport->user->name,
                        'email' => $itemsReport->user->email,
                        'address' => $itemsReport->user->address,
                        'phone_number' => $itemsReport->user->phone_number,
                        'class' => $itemsReport->user->class,
                        'major' => $itemsReport->user->major,
                        'study_program' => $itemsReport->user->study_program,
                    ],
                    'lost_item' => [
                        'id' => $itemsReport->lostItem->id,
                        'name' => $itemsReport->lostItem->name,
                    ],
                    'location' => $itemsReport->location,
                    'date' => $itemsReport->date,
                    'name' => $itemsReport->name,
                    'description' => $itemsReport->description,
                    'attachment' => $itemsReport->attachment,
                    'slug' => $itemsReport->slug,
                    'status' => [
                        'id' => $itemsReport->status->id,
                        'name' => $itemsReport->status->name,
                    ],
                    'created_at' => $itemsReport->created_at,
                    'updated_at' => $itemsReport->updated_at,
                ],
            ], 200);
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch Items Report details.',
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
        $user = auth()->guard('api')->user();

        // Find the items report by ID
        $itemsReport = ItemsReport::findOrFail($id);

        // Check if the authenticated user is the creator of the report
        if ($itemsReport->user_id != $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to update the Items Report status.',
            ], 403);
        }

        // Check if the status ID is 3 (completed)
        if ($request->status_id == 3) {
            // Add any additional logic for when the status is set to completed
            // For example, you might want to send a notification or update other related records
        }

        // Update the status ID
        $itemsReport->status_id = $request->status_id;
        $itemsReport->save();

        return response()->json([
            'success' => true,
            'message' => 'Items Report status successfully updated.',
            'data' => $itemsReport,
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to update Items Report status.',
            'error' => $e->getMessage(),
        ], 500);
    }
}
public function destroy($id)
{
    try {
        $userL = auth()->guard('api')->user();
        $user = User::findOrFail($userL->id);

        // Find the Items Report by ID
        $itemsReport = ItemsReport::findOrFail($id);

        // Check if the report belongs to the authenticated user and if its status is '1' (pending)
        if ($itemsReport->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to delete this Items Report.',
            ], 403);
        }

        if ($itemsReport->status_id !== 1) {
            return response()->json([
                'success' => false,
                'message' => 'Items Report cannot be deleted as it is already being processed.',
            ], 403);
        }

        // Delete the report
        $itemsReport->delete();

        return response()->json([
            'success' => true,
            'message' => 'Items Report successfully deleted.',
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to delete Items Report.',
            'error' => $e->getMessage(),
        ], 500);
    }
}

}