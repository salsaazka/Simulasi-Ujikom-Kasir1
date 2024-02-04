<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Buyer;
use Illuminate\Http\Request;
use App\Models\DetailSale;
use App\Models\Product;

use DB;
class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $dataSale = Sale::with('buyer', 'details')->get();
        $dataProduct = Product::all(); 
        $detailSales = DetailSale::with(['products', 'sales'])->get();
        // dd($dataSale);
        // dd($details);
        
        return view('sale.index', compact('dataSale', 'dataProduct', 'detailSales'));
    }
    public function showModal($id)
    {
        $details = DetailSale::with('products', 'sales')
                     ->where('sale_id', $id)
                     ->first();
    
        return view('sale.index', compact('details'));
    }

    public function create()
    { 
        $dataBuyer = Buyer::all();
        $dataProduct = Product::all(); 
        return view('sale.create', compact('dataBuyer', 'dataProduct'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'product_id' => 'required',
            'total_produk' => 'required|integer|min:1',
        ]);

        $product = Product::find($request->product_id);

        if (!$product) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan');
        }

        $newStok = $product->stok - $request->total_produk;

        if ($newStok < 0) {
            return redirect()->back()->with('error', 'Stok produk ' . $product->name . ' tidak mencukupi');
        }

        $product->update(['stok' => $newStok]);

        // Create a new sale record
        $sale = Sale::create([
            'buyer_id' => $request->buyer_id,
            'total_price' => $product->price * $request->total_produk,
        ]);

        // Create a new detail sale record
        $detail = DetailSale::create([
            'sale_id' => $sale->id,
            'product_id' => $request->product_id,
            'total_produk' => $request->total_produk,
            'subtotal' => $product->price * $request->total_produk,
        ]);

        return redirect()->route('sale.index')->with('success', 'Anda berhasil menambah data');
    }


    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $dataBuyer = Buyer::all();
        $dataProduct = Product::all(); 
        $dataSale = DetailSale::with(['sales', 'products'])->find($id);
        // echo json_encode($dataSale);exit();
        return view('sale.edit', compact(['dataBuyer', 'dataProduct', 'dataSale']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'product_id' => 'required',
            'buyer_id' => 'required',
            'total_produk' => 'required'
        ]);
    
        $product = Product::find($request->product_id);
    
        if (!$product) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan');
        }
    
        $newStok = $product->stok - $request->total_produk;
    
        if ($newStok < 0) {
            return redirect()->back()->with('error', 'Stok produk tidak mencukupi');
        }
    
        $product->update(['stok' => $newStok]);
    
        $sale = Sale::find($id);
        $sale->update([
            'buyer_id' => $request->buyer_id,
        ]);
    
        // Hitung total harga dari subtotal semua item penjualan
        $totalPrice = DetailSale::where('sale_id', $id)->sum('subtotal');
    
        // Update kolom total_price pada model Sale
        $sale->update(['total_price' => $totalPrice]);
    
        $detailSale = DetailSale::where('sale_id', $id)->first();
        $detailSale->update([
            'product_id' => $request->product_id,
            'total_produk' => $request->total_produk,
            'subtotal' => $product->price * $request->total_produk,
        ]);
       
        return redirect()->route('sale.index')->with('success', 'Anda berhasil mengubah data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $dataSale= Sale::where('id', $id)->delete();
        return redirect()->route('sale.index');
    }
}
