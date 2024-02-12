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
                            <option value="{{ $buyer->id }}" {{ $dataSale->buyer_id == $buyer->id ? 'selected' : '' }}>{{ $buyer->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="product_id" class="form-label">Products</label>
                    @foreach($dataProduct as $product)
                        <div class="form-check">
                            <input type="checkbox" name="product_id[]" class="form-check-input product-checkbox" id="product_{{ $product->id }}" value="{{ $product->id }}" data-price="{{ $product->price }}" data-stock="{{ $product->stok }}" data-total-product="{{ $dataSale->products->where('id', $product->id)->first()->pivot->quantity ?? 0 }}">
                            <label class="form-check-label" for="product_{{ $product->id }}">{{ $product->name }} - Price: {{ $product->price }} - Stock: {{ $product->stok }}</label>
                            <i class="fa-solid fa-cart-plus add-to-cart mx-3" style="font-size: 25px; color:green"></i>
                            <i class="fa-solid fa-square-minus remove-from-cart" style="font-size: 25px; color:red"></i>
                        </div>
                    @endforeach
                </div>

                <div class="mb-3">
                    <label for="total_produk" class="form-label">Total Product</label>
                    <input type="number" name="total_produk" id="total_produk" class="form-control" placeholder="Total Product" value="{{ $dataSale->total_produk }}" readonly>
                </div>

                <div class="mb-3">
                    <label for="total_price" class="form-label">Total Price</label>
                    <input type="number" name="total_price" id="total_price" class="form-control" placeholder="Total Price" value="{{ $dataSale->total_price }}" readonly>
                </div>

                <button type="submit" class="btn text-white mb-5" style="background-color: #55D090">
                    Update
                </button>
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