@extends('layouts.index')

@section('content')
    <div class="card">
        <div class="card-body">
            
        <form action="{{ route('detailsale.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="" class="form-label">Sale</label>
                <select name="sale_id" id="sale_id" class="form-control" placeholder="Input Sale">
                    <option value="" disabled selected>Select Sale</option>
                    @foreach($dataSale as $sale)
                        <option value="{{ $sale->id }}">{{ $sale->total_price }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Product</label>
                <select name="product_id" id="product_id" class="form-control" placeholder="Input Product">
                    <option value="" disabled selected>Select Product</option>
                    @foreach($dataProduct as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Total Product</label>
                <input type="number" name="total_produk" id="" class="form-control" placeholder="Input Total Product">
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Subtotal</label>
                <input type="number" name="subtotal" id="" class="form-control" placeholder="Input Subtotal">
            </div>
            
            <button
                type="submit"
                class="btn text-white mb-5"
                style="background-color: #55D090"
            >
                Submit
            </button>
        </form>
        </div>
    </div>
@endsection