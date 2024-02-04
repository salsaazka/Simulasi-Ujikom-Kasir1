<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use DB;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataProduct = Product::all();
        return view('product.index', compact('dataProduct'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      return view('product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);
        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'stok' => $request->stok,
        ]);
        return redirect()->route('product.index')->with('success', 'Anda berhasil menambah data');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $dataProduct = Product::where('id', $id)->first();
        return view('product.edit', compact('dataProduct'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        Product::where('id', $id)->update([
            'name' => $request->name,
            'price' => $request->price,
            'stok' => $request->stok,
        ]);
        return redirect()->route('product.index')->with('success', 'anda berhasil update data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $dataProduct = Product::where('id', $id)->delete();
        return redirect()->route('product.index');
    }
}
