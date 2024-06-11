<?php

namespace App\Http\Controllers\Admin;

use App\Models\LostItem;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LostItemController extends Controller
{
    /**
     * Display a listing of the lost items.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lostitems = LostItem::latest()->when(request()->q, function($query) {
            $query->where('name', 'like', '%' . request()->q . '%');
        })->paginate(10);

        return view('pages.lostitem.index', compact('lostitems'));
    }

    /**
     * Show the form for creating a new lost item.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.lostitem.create');
    }

    /**
     * Store a newly created lost item in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:lost_items'
        ]);

        $lostitem = LostItem::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-')
        ]);

        return redirect()->route('admin.lost-item.index')->with('success', 'Data Berhasil Disimpan!');
    }

    /**
     * Show the form for editing the specified lost item.
     *
     * @param  \App\Models\LostItem  $lostitem
     * @return \Illuminate\Http\Response
     */
    public function edit(LostItem $lostitem)
    {
        return view('pages.lostitem.edit', compact('lostitem'));
    }

    /**
     * Update the specified lost item in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LostItem  $lostitem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LostItem $lostitem)
    {
        $request->validate([
            'name' => 'required|unique:lost_items,name,' . $lostitem->id
        ]);

        $lostitem->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-')
        ]);

        return redirect()->route('admin.lost-item.index')->with('success', 'Data Berhasil Diupdate!');
    }

    /**
 * Remove the specified resource from storage.
 *
 * @param  \App\Models\LostItem  $lostitem
 * @return \Illuminate\Http\Response
 */
public function destroy(LostItem $lostitem)
{
    if ($lostitem->delete()) {
        return redirect()->route('admin.lost-item.index')->with(['success' => 'Data Berhasil Dihapus!']);
    } else {
        return redirect()->route('admin.lost-item.index')->with(['error' => 'Data Gagal Dihapus!']);
    }
}

}