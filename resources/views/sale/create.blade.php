@extends('layouts.index')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('sale.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="" class="form-label">Buyer</label>
                    <select name="buyer_id" id="buyer_id" class="form-control" placeholder="Input Buyer">
                        <option value="" disabled selected>Select Buyer</option>
                        @foreach($dataBuyer as $buyer)
                            <option value="{{ $buyer->id }}">{{ $buyer->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="" class="form-label">Products</label>
                    @foreach($dataProduct as $product)
                        <div class="form-check">
                            <input type="checkbox" name="product_id" class="form-check-input product-checkbox" id="product_{{ $product->id }}" value="{{ $product->id }}" data-price="{{ $product->price }}" data-stock="{{ $product->stok }}" data-total-product="0">
                            <label class="form-check-label" for="product_{{ $product->id }}">{{ $product->name }} - Price: {{ $product->price }} - Stock: {{ $product->stok }}</label>
                            <i class="fa-solid fa-cart-plus add-to-cart mx-3" style="font-size: 25px; color:green"></i>
                            <i class="fa-solid fa-square-minus remove-from-cart" style="font-size: 25px; color:red"></i>
                        </div>
                    @endforeach
                </div>

                <div class="mb-3">
                    <label for="" class="form-label">Total Product</label>
                    <input type="number" name="total_produk" id="total_produk" class="form-control" placeholder="Total Product" readonly>
                </div>

                <div class="mb-3">
                    <label for="" class="form-label">Total Price</label>
                    <input type="number" name="total_price" id="total_price" class="form-control" placeholder="Total Price" readonly>
                </div>

                <button type="submit" class="btn text-white mb-5" style="background-color: #55D090">
                    Submit
                </button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var checkboxes = document.querySelectorAll('.product-checkbox');
            var addToCartButtons = document.querySelectorAll('.add-to-cart');
            var removeFromCartButtons = document.querySelectorAll('.remove-from-cart');
            var totalPriceInput = document.getElementById('total_price');
            var totalProdukInput = document.getElementById('total_produk');

            var selectedProducts = [];

            checkboxes.forEach(function (checkbox, index) {
                checkbox.addEventListener('change', function () {
                    updateSelectedProducts();
                });

                addToCartButtons[index].addEventListener('click', function () {
                    addToCart(index);
                });

                removeFromCartButtons[index].addEventListener('click', function () {
                    removeFromCart(index);
                });
            });

            function updateSelectedProducts() {
                selectedProducts = [];
                var totalProductCount = 0;

                checkboxes.forEach(function (checkbox, index) {
                    if (checkbox.checked) {
                        var stock = parseInt(checkbox.getAttribute('data-stock'));
                        var currentTotalProduct = parseInt(checkbox.getAttribute('data-total-product'));

                        // Ensure total_product does not exceed the available stock
                        var availableTotalProduct = Math.min(stock, currentTotalProduct);

                        selectedProducts.push({
                            id: checkbox.value,
                            price: parseFloat(checkbox.getAttribute('data-price')),
                            stock: stock,
                            totalProduct: availableTotalProduct
                        });

                        totalProductCount += availableTotalProduct;
                    }
                });

                calculateTotalPrice();
                totalProdukInput.value = totalProductCount;
            }

            function calculateTotalPrice() {
                var totalPrice = 0;

                selectedProducts.forEach(function (product) {
                    totalPrice += product.price * product.totalProduct;
                });

                totalPriceInput.value = totalPrice.toFixed(2);
            }

            function addToCart(index) {
                var product = selectedProducts[index];

                if (product.totalProduct < product.stock) {
                    checkboxes[index].checked = true;
                    checkboxes[index].setAttribute('data-total-product', product.totalProduct + 1);
                    updateSelectedProducts();
                } else {
                    alert("Cannot add more products than available stock.");
                }
            }

            function removeFromCart(index) {
                var product = selectedProducts[index];

                if (product.totalProduct > 0) {
                    checkboxes[index].checked = true;
                    checkboxes[index].setAttribute('data-total-product', product.totalProduct - 1);
                    updateSelectedProducts();
                } else {
                    alert("Cannot remove more products than in the cart.");
                }
            }
        });
    </script>
@endsection
