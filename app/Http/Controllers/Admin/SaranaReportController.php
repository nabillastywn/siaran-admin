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
        $saranaReports = SaranaReport::with(['user', 'sarpras', 'status'])->orderByDesc('created_at')->paginate(10);

        // Pass the data to the view
        return view('pages.saranareport.index', compact('title', 'saranaReports'));
    }

    /**
     * Display the specified sarana report.
     *
     * @param SaranaReport $saranaReport
     * @return \Illuminate\View\View
     */
    public function show(SaranaReport $saranaReport)
    {
        $title = 'Detail Sarana Report';

        // Check if the user can view this report based on their role
        if (auth()->user()->role === 0 || auth()->user()->role === 1 || auth()->user()->id === $saranaReport->user_id) {
            return view('pages.saranareport.show', compact('title', 'saranaReport'));
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Update the status of the specified sarana report.
     *
     * @param \Illuminate\Http\Request $request
     * @param SaranaReport $saranaReport
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request, SaranaReport $saranaReport)
    {
        // Check if the user can update status based on their role
        if (auth()->user()->role === 1) {
            $this->validate($request, [
                'status_id' => 'required|exists:statuses,id',
            ]);

            $saranaReport->status_id = $request->status_id;
            $saranaReport->save();

            return redirect()->route('sarana-reports.show', $saranaReport->id)
                             ->with('success', 'Status updated successfully.');
        } else {
            abort(403, 'Unauthorized action.');
        }
    }
}