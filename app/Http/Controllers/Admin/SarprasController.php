<?php

namespace App\Http\Controllers\Admin;

use App\Models\Sarpras;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SarprasController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $sarpras = Sarpras::latest()->when(request()->q, function($sarpras) {
            $sarpras = $sarpras->where('name', 'like', '%' . request()->q . '%');
        })->paginate(10);

        $title = 'Sarpras';

        return view('pages.sarpras.index', compact('sarpras'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.sarpras.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:sarpras'
        ]);

        $sarprases = Sarpras::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-')
        ]);

        if ($sarprases) {
            return redirect()->route('admin.sarpras.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            return redirect()->route('admin.sarpras.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sarpras  $sarpras
     * @return \Illuminate\Http\Response
     */
    public function edit(Sarpras $sarpras)
    {
        return view('pages.sarpras.edit', compact('sarpras'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sarpras  $sarpras
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sarpras $sarpras)
    {
        $this->validate($request, [
            'name' => 'required|unique:sarpras,name,' . $sarpras->id
        ]);

        $sarpras->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-')
        ]);

        if ($sarpras) {
            return redirect()->route('admin.sarpras.index')->with(['success' => 'Data Berhasil Diupdate!']);
        } else {
            return redirect()->route('admin.sarpras.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sarpras  $sarpras
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sarpras $sarpras)
    {
        if ($sarpras->delete()) {
            return redirect()->route('admin.sarpras.index')->with(['success' => 'Data Berhasil Dihapus!']);
        } else {
            return redirect()->route('admin.sarpras.index')->with(['error' => 'Data Gagal Dihapus!']);
        }
    }
}