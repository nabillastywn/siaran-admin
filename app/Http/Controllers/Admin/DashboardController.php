<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BullyingReport;
use App\Models\SaranaReport;
use App\Models\SexualReport;
use App\Models\ItemsReport;
use App\Charts\AllReportsChart;

class DashboardController extends Controller
{
    protected $allReportsChart;

    public function __construct(AllReportsChart $allReportsChart)
    {
        $this->allReportsChart = $allReportsChart;
    }

    public function index()
    {
        // Count reports
        $bullying = BullyingReport::count();
        $sarpras = SaranaReport::count();
        $sexual = SexualReport::count();
        $lostitem = ItemsReport::count();

        // Build AllReportsChart
        $chart = $this->allReportsChart->build();
        // dd($chart);

        // Total reports
        $totalReports = $bullying + $sarpras + $sexual + $lostitem;

        return view('pages.dashboard', compact('bullying', 'sarpras', 'sexual', 'lostitem', 'totalReports', 'chart'));
    }
}