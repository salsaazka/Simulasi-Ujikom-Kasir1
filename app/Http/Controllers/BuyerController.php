<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use Illuminate\Http\Request;
use DB;
class BuyerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataBuyer = Buyer::all();
        return view('buyer.index', compact('dataBuyer'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('buyer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        Buyer::create([
            'name' => $request->name,
            'no_telp' => $request->no_telp,
            'address' => $request->address,
        ]);
        return redirect()->route('buyer.index')->with('success', 'Anda berhasil membuat data pembeli');
    }

    /**
     * Display the specified resource.
     */
    public function show(Buyer $buyer)
    {
        //
    }

    public function edit($id)
    {
        $dataBuyer = Buyer::where('id', $id)->first();
        // dd($dataBuyer);
        return view('buyer.edit', compact('dataBuyer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required'
        ]);
        
        Buyer::where('id', $id)->update([
            'name' => $request->name,
            'no_telp' => $request->no_telp,
            'address' => $request->address,
        ]);
        return redirect()->route('buyer.index')->with('success', 'Anda berhasil update data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $dataBuyer = Buyer::where('id', $id)->delete();
        return redirect()->route('buyer.index')->with('success', 'anda berhasil menghapus data buyer');
    }
}
