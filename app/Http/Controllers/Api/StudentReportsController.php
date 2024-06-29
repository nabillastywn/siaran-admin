<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SaranaReport;
use App\Models\SexualReport;
use App\Models\BullyingReport;
use App\Models\ItemsReport;

class StudentReportsController extends Controller
{
    /**
     * Get all reports (Sarana Prasarana, Sexual, Lost Item, Bullying) created by a student.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllReports(Request $request)
    {
        try {
            $user = auth()->guard('api')->user();

            // Fetch all Sarana Prasarana reports
            $saranaReports = SaranaReport::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();

            // Fetch all Sexual reports
            $sexualReports = SexualReport::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();

            // Fetch all Lost Item reports
            $lostItemReports = ItemsReport::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();

            // Fetch all Bullying reports
            $bullyingReports = BullyingReport::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'List of all reports created by the student.',
                'data' => [
                    'sarana_prasarana' => $saranaReports,
                    'sexual_reports' => $sexualReports,
                    'lost_item_reports' => $lostItemReports,
                    'bullying_reports' => $bullyingReports,
                ],
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch student reports.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}