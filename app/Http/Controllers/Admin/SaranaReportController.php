<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SaranaReport;

class SaranaReportController extends Controller
{
    /**
     * Display a listing of the sarana reports.
     *
     * @return \Illuminate\View\View
     */
    public function index()
{
    $title = 'Sarana Report';

    // Retrieve all sarana reports with related user and sarana information, ordered by the latest
    $saranaReports = SaranaReport::with(['userMhs', 'sarpras'])->orderByDesc('created_at')->paginate(10);

    // Pass the data to the view
    return view('pages.saranareport.index', compact('title', 'saranaReports'));
}

public function show(SaranaReport $saranaReport)
{
    $title = 'Detail Sarana Report';

    return view('pages.saranareport.show', compact('title', 'saranaReport'));
}
}