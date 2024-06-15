<?php

namespace App\Http\Controllers\Admin;

use App\Models\SexualReport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        $sexualReports = SexualReport::with(['user', 'status'])->orderByDesc('created_at')->paginate(10);

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

        // Check if the user can view this report based on their role
        if (auth()->user()->role === 0 || auth()->user()->role === 1 || auth()->user()->id === $sexualReport->user_id) {
            return view('pages.sexualreport.show', compact('title', 'sexualReport'));
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Update the status of the specified sexual report.
     *
     * @param \Illuminate\Http\Request $request
     * @param SexualReport $sexualReport
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request, SexualReport $sexualReport)
    {
        // Check if the user can update status based on their role
        if (auth()->user()->role === 1) {
            $this->validate($request, [
                'status_id' => 'required|exists:statuses,id',
            ]);

            $sexualReport->status_id = $request->status_id;
            $sexualReport->save();

            return redirect()->route('sexual-reports.show', $sexualReport->id)
                             ->with('success', 'Status updated successfully.');
        } else {
            abort(403, 'Unauthorized action.');
        }
    }
}