<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LostItem;

class LostItemController extends Controller
{
    /**
     * index
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Get the latest lost items with pagination
        $lostItems = LostItem::all();

        // Return response in JSON format
        return response()->json([
            'success' => true,
            'message' => 'List of Lost Items',
            'data' => $lostItems,
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
        // Get the lost item with related item reports and user details
        $lostItem = LostItem::with('itemsReport.user')->where('slug', $slug)->first();

        if ($lostItem) {
            // Return response in JSON format
            return response()->json([
                'success' => true,
                'message' => 'List of Item Reports for Lost Item: ' . $lostItem->name,
                'data' => $lostItem,
            ], 200);
        }

        // Return response in JSON format if not found
        return response()->json([
            'success' => false,
            'message' => 'Lost Item Not Found!',
        ], 404);
    }
    /**
     * all
     *
     * @return \Illuminate\Http\JsonResponse
     */
    // public function all()
    // {
    //     // Get all lost items
    //     $lostItems = LostItem::all();

    //     // Return response in JSON format
    //     return response()->json([
    //         'success' => true,
    //         'message' => 'All Lost Items',
    //         'data' => $lostItems,
    //     ], 200);
    // }
}