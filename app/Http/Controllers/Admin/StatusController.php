<?php

namespace App\Http\Controllers\Admin;

use App\Models\Status;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StatusController extends Controller
{
    /**
     * Display a listing of the status.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statuses = Status::latest()->when(request()->q, function($query) {
            $query->where('name', 'like', '%' . request()->q . '%');
        })->paginate(10);

        $title = 'Status';

        return view('pages.status.index', compact('statuses', 'title'));
    }

    /**
     * Show the form for creating a new status.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.status.create');
    }

    /**
     * Store a newly created status in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:statuses'
        ]);

        $status = Status::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-')
        ]);

        if ($status) {
            return redirect()->route('admin.status.index')->with('success', 'Data Berhasil Disimpan!');
        } else {
            return redirect()->route('admin.status.index')->with('error', 'Data Gagal Disimpan!');
        }
    }

    /**
     * Show the form for editing the specified status.
     *
     * @param  \App\Models\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function edit(Status $status)
    {
        return view('pages.status.edit', compact('status'));
    }

    /**
     * Update the specified status in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Status $status)
    {
        $this->validate($request, [
            'name' => 'required|unique:statuses,name,' . $status->id
        ]);

        $status->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-')
        ]);

        if ($status) {
            return redirect()->route('admin.status.index')->with('success', 'Data Berhasil Diupdate!');
        } else {
            return redirect()->route('admin.status.index')->with('error', 'Data Gagal Diupdate!');
        }
    }

    /**
     * Remove the specified status from storage.
     *
     * @param  \App\Models\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function destroy(Status $status)
    {
        if ($status->delete()) {
            return redirect()->route('admin.status.index')->with('success', 'Data Berhasil Dihapus!');
        } else {
            return redirect()->route('admin.status.index')->with('error', 'Data Gagal Dihapus!');
        }
    }
}