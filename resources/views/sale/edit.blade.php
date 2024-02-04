@extends('layouts.index')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('sale.update', $dataSale->id) }}" method="POST">
                @method('PATCH')
                @csrf
                <div class="mb-3">
                    <label for="buyer_id" class="form-label">Buyer</label>
                    <select name="buyer_id" id="buyer_id" class="form-control" placeholder="Input Buyer">
                        <option value="" disabled>Select Buyer</option>
                        @foreach($dataBuyer as $buyer)
                            <option value="{{ $buyer->id }}" {{ $dataSale->sales->buyer_id == $buyer->id ? 'selected' : '' }}>{{ $buyer->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="product_id" class="form-label">Product</label>
                    <select name="product_id" id="product_id" class="form-control" placeholder="Input Product">
                        <option value="" disabled>Select Product</option>
                        @foreach($dataProduct as $product)
                            <option value="{{ $product->id }}" price="{{ $product->price }}" {{ $dataSale->product_id == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="total_produk" class="form-label">Total Product</label>
                    <input type="number" name="total_produk" value="{{ $dataSale->total_produk }}" id="total_produk" class="form-control" placeholder="Input Total Product" min="0">
                </div>
                <div class="mb-3">
                    <label for="total_price" class="form-label">Total Price</label>
                    <input type="text" name="total_price" id="total_price" class="form-control" readonly value="{{ $dataSale->total_price }}">
                </div>
                <button type="submit" class="btn text-white mb-5" style="background-color: #55D090">Submit</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('total_produk').addEventListener('input', function() {
            var selectedProduct = document.getElementById('product_id');
            var productPrice = selectedProduct.options[selectedProduct.selectedIndex].getAttribute('price');
            var totalProduk = this.value;
            var hargaProduk = parseFloat(productPrice) || 0;
            var totalPrice = hargaProduk * totalProduk;
            document.getElementById('total_price').value = totalPrice;
        });
    </script>
@endsection