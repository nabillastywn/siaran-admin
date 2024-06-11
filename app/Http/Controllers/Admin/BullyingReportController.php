<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\BullyingReport;
use App\Http\Controllers\Controller;

class BullyingReportController extends Controller
{
    /**
     * Display a listing of the bullying reports.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $title = 'Bullying Report';

        // Retrieve all bullying reports with related user information, ordered by the latest
        $bullyingReports = BullyingReport::with('userMhs')->orderByDesc('created_at')->paginate(10);

        // Pass the data to the view
        return view('pages.bullyingreport.index', compact('title', 'bullyingReports'));
    }

    public function show(BullyingReport $bullyingReport)
    {
        $title = 'Detail Bullying Report';

        return view('pages.bullyingreport.show', compact('title', 'bullyingReport'));
    }
}