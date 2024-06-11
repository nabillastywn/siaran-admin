<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SexualReport;

class SexualReportController extends Controller
{
    /**
     * Display a listing of the sexual reports.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $title = 'Sexual Report';

        // Retrieve all sexual reports with related user and status information, ordered by the latest
        $sexualReports = SexualReport::with(['userMhs', 'status'])->orderByDesc('created_at')->paginate(10);

        // Pass the data to the view
        return view('pages.sexualreport.index', compact('title', 'sexualReports'));
    }

    /**
     * Display the specified sexual report.
     *
     * @param SexualReport $sexualReport
     * @return \Illuminate\View\View
     */
    public function show(SexualReport $sexualReport)
    {
        $title = 'Detail Sexual Report';

        return view('pages.sexualreport.show', compact('title', 'sexualReport'));
    }
}