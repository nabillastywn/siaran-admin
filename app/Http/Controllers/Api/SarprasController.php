<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sarpras;

class SarprasController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get data sarpras
        $sarpras = Sarpras::all();

        //return with response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data Sarana Prasarana',
            'data'    => $sarpras,
        ], 200);
    }

    /**
     * show
     *
     * @param  mixed $slug
     * @return void
     */
    public function show($slug)
    {
        //get detail data sarpras with saranaReport and user
        $sarpras = Sarpras::with('saranaReport.user')->where('slug', $slug)->first();

        if($sarpras) {
            //return with response JSON
            return response()->json([
                'success' => true,
                'message' => 'List Data Sarana Report berdasarkan Sarpras: '. $sarpras->name,
                'data'    => $sarpras,
            ], 200);
        }

        //return with response JSON
        return response()->json([
            'success' => false,
            'message' => 'Data Sarpras Tidak Ditemukan!',
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
    //     $sarpras = Sarpras::all();

    //     // Return response in JSON format
    //     return response()->json([
    //         'success' => true,
    //         'message' => 'All Lost Items',
    //         'data' => $sarpras,
    //     ], 200);
    // }
}