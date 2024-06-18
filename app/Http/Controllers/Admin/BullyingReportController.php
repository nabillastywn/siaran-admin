<?php

namespace App\Http\Controllers\Admin;

use App\Models\BullyingReport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User; // Import User model

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
        $bullyingReports = BullyingReport::with('user')->orderByDesc('created_at')->paginate(10);

        // Pass the data to the view
        return view('pages.bullyingreport.index', compact('title', 'bullyingReports'));
    }

    /**
     * Display the specified bullying report.
     *
     * @param  \App\Models\BullyingReport  $bullyingReport
     * @return \Illuminate\View\View
     */
    public function show(BullyingReport $bullyingReport)
    {
        $title = 'Detail Bullying Report';
        $userL = auth()->user();

        $user = User::findOrFail($userL->id);
        // Check if the user can view this report based on their role
        if ($user->isAdmin() || $user->isUserPic() || $user->id === $bullyingReport->user_id) {
            return view('pages.bullyingreport.show', compact('title', 'bullyingReport'));
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Update the status of the specified bullying report.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BullyingReport  $bullyingReport
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request, BullyingReport $bullyingReport)
    {
        // Retrieve authenticated user
        $userL = auth()->user();

        $user = User::findOrFail($userL->id);
        // Check if the user can update status based on their role
        if ($user->isUserPic()) {
            $this->validate($request, [
                'status_id' => 'required|exists:statuses,id',
            ]);

            $bullyingReport->status_id = $request->status_id;
            $bullyingReport->save();

            return redirect()->route('bullying-reports.show', $bullyingReport->id)
                ->with('success', 'Status updated successfully.');
        } else {
            abort(403, 'Unauthorized action.');
        }
    }
}