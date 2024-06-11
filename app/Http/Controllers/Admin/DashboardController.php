<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BullyingReport;
use App\Models\SaranaReport;
use App\Models\SexualReport;
use App\Models\ItemsReport;

class DashboardController extends Controller
{    
    /**
     * index
     *
     * @return void
     */
    public function index()
    {

        //bullying
        $bullying = BullyingReport::count();

        //sarana prasarana
        $sarpras = SaranaReport::count();

        //sexual harrasment
        $sexual = SexualReport::count();

        // lost item
        $lostitem = ItemsReport::count();

        return view('pages.dashboard', compact('bullying', 'sarpras', 'sexual', 'lostitem'));
    }
}