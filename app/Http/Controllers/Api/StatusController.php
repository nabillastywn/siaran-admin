<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Status;

class StatusController extends Controller
{
    /**
     * index
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Get all statuses
        $statuses = Status::all();

        // Return response in JSON format
        return response()->json([
            'success' => true,
            'message' => 'List of Statuses',
            'data'    => $statuses,
        ], 200);
    }

    /**
     * show
     *
     * @param string $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($slug)
    {
        // Get status detail by slug with related reports
        $status = Status::with(['itemsReport', 'bullyingReport', 'saranaReport', 'sexualReport'])->where('slug', $slug)->first();

        if ($status) {
            // Return response in JSON format
            return response()->json([
                'success' => true,
                'message' => 'Status Details',
                'data'    => $status,
            ], 200);
        }

        // Return response in JSON format if not found
        return response()->json([
            'success' => false,
            'message' => 'Status Not Found!',
        ], 404);
    }
}