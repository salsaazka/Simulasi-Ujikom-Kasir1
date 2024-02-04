<?php

namespace App\Http\Controllers;

use App\Models\DetailSale;
use App\Models\Sale;
use App\Models\Product;
use Illuminate\Http\Request;
use DB;
class DetailSaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataDetail = DetailSale::all();
        return view('detailSale.index', compact('dataDetail'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dataSale = Sale::all(); 
        $dataProduct = Product::all(); 
        return view('detailSale.create', compact('dataSale', 'dataProduct'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'sale_id' => 'required',
            'product_id' => 'required',
            'total_produk' => 'required'
        ]);
        
        DetailSale::create([
            'sale_id' => $request->sale_id,
            'product_id' => $request->product_id,
            'total_produk' => $request->total_produk,
            'subtotal' => $request->subtotal,
        ]);

        return redirect()->route('detailsale.index')->with('success', 'Anda berhasil menambah data');
    }

    /**
     * Display the specified resource.
     */
    public function show(DetailSale $detailSale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $dataDetail = DetailSale::where('id', $id)->first();
        $dataSale = Sale::all();
        $dataProduct = Product::all();
        return view('detailSale.edit', compact('dataDetail', 'dataSale', 'dataProduct'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        DetailSale::where('id', $id)->update([
            'sale_id' => $request->sale_id,
            'product_id' => $request->product_id,
            'total_produk' => $request->total_produk,
            'subtotal' => $request->subtotal,
        ]);
        return redirect()->route('detailsale.index')->with('success', 'anda berhasil mengubah data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $dataDetail= DetailSale::where('id', $id)->delete();
        return redirect()->route('detailsale.index')->with('success', 'anda berhasil menghapus data');
    }
    public function showModal($id)
    {
        $details = DetailSale::with('products', 'sales')->where('id', $id)->get();
        return view('sale.index', compact('details'));
    }
}
