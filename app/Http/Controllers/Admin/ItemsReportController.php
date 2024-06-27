<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ItemsReport;

class ItemsReportController extends Controller
{
    /**
     * Display a listing of the items reports.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $title = 'Items Report';

        // Retrieve all items reports with related user and lost item information, ordered by the latest
        $itemsReports = ItemsReport::with(['user', 'lostItem'])->orderByDesc('created_at')->paginate(10);

        // Pass the data to the view
        return view('pages.itemsreport.index', compact('title', 'itemsReports'));
    }

    public function show(ItemsReport $itemsReport)
    {
        $title = 'Detail Items Report';

        return view('pages.itemsreport.show', compact('title', 'itemsReport'));
    }
}