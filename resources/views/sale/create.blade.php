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
                        @foreach ($dataBuyer as $buyer)
                            <option value="{{ $buyer->id }}">{{ $buyer->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="" class="form-label">Products</label>
                    @foreach ($dataProduct as $product)
                        <div class="form-check">
                            <input type="checkbox" name="product_id[]" class="form-check-input product-checkbox"
                                id="product_{{ $product->id }}" value="{{ $product->id }}"
                                data-price="{{ $product->price }}" data-stock="{{ $product->stok }}" data-total-product="0">
                            <label class="form-check-label" for="product_{{ $product->id }}">{{ $product->name }} - Price:
                                {{ $product->price }} - Stock: {{ $product->stok }}</label>
                            <i class="fa-solid fa-cart-plus add-to-cart mx-2" style="font-size: 25px; color:green"></i>
                            <span class="mx-2" id="quantity_{{ $product->id }}">0</span>
                            <i class="fa-solid fa-square-minus remove-from-cart mx-2"
                                style="font-size: 25px; color:red"></i>
                        </div>
                    @endforeach
                </div>

                <input type="hidden" name="total_products" id="input_total_products">
                <input type="hidden" name="total_price" id="input_total_price">
                <input type="hidden" name="quantity" id="input_quantity">

                <div class="mb-3 d-flex align-items-center">
                    <label for="" class="form-label">Total Product : </label>
                    <label id="total_produk" class="ms-2">0</label>
                </div>

                <div class="mb-3 d-flex align-items-center">
                    <label for="" class="">Total Price : </label>
                    <label id="formatted_total_price" class="ms-2">0</label>
                </div>

                <button type="submit" class="btn text-white mb-5" style="background-color: #55D090">
                    Submit
                </button>
            </form>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var checkboxes = document.querySelectorAll('.product-checkbox');
            var addToCartButtons = document.querySelectorAll('.add-to-cart');
            var removeFromCartButtons = document.querySelectorAll('.remove-from-cart');
            var totalPriceInput = document.getElementById('total_price');
            var totalProdukInput = document.getElementById('total_produk');
            var quantityInput = document.getElementById('input_quantity');

            function updateQuantityDisplay(productId, quantity) {
                var quantityDisplay = document.getElementById('quantity_' + productId);
                if (quantityDisplay) {
                    quantityDisplay.textContent = quantity;
                }
                var array = [];

                checkboxes.forEach(function(checkbox) {
                    if (checkbox.checked) {
                        var quantity = parseInt(checkbox.getAttribute('data-total-product'));
                        array.push(quantity);
                    }
                });

                quantityInput.value = array;
            }

            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    updateSelectedProducts();
                });
            });

            addToCartButtons.forEach(function(button, index) {
                button.addEventListener('click', function() {
                    changeProductCount(index, 1);
                });
            });

            removeFromCartButtons.forEach(function(button, index) {
                button.addEventListener('click', function() {
                    changeProductCount(index, -1);
                });
            });

            function changeProductCount(index, countChange) {
                var checkbox = checkboxes[index];
                var currentCount = parseInt(checkbox.getAttribute('data-total-product'));
                var stock = parseInt(checkbox.getAttribute('data-stock'));
                var newCount = currentCount + countChange;

                if (newCount >= 0 && newCount <= stock) {
                    checkbox.setAttribute('data-total-product', newCount);
                    checkbox.checked = newCount > 0; // Check the box if at least one product is selected.
                    updateSelectedProducts();
                    updateQuantityDisplay(checkbox.value, newCount);
                } else {
                    alert(
                        "Cannot add more products than available stock or remove more products than in the cart."
                    );
                }
            }
        });

        function updateSelectedProducts() {
            var totalProductCount = 0;
            var totalPrice = 0;
            var checkboxes = document.querySelectorAll('.product-checkbox');

            checkboxes.forEach(function(checkbox) {
                if (checkbox.checked) {
                    var totalProduct = parseInt(checkbox.getAttribute('data-total-product'));
                    var price = parseFloat(checkbox.getAttribute('data-price'));
                    totalProductCount += totalProduct;
                    totalPrice += totalProduct * price;
                }
            });

            var totalProdukDisplay = document.getElementById('total_produk'); // Changed to match the span ID
            var formattedTotalPriceDisplay = document.getElementById('formatted_total_price');

            // Format total price with commas as thousands separators
            var formattedTotalPrice = new Intl.NumberFormat('en-US', {
                maximumFractionDigits: 2
            }).format(totalPrice);

            totalProdukDisplay.textContent = totalProductCount; // Changed to textContent for a span element
            formattedTotalPriceDisplay.textContent = formattedTotalPrice; // Display the formatted number
        }

        function updateTotals() {
            var totalProductCount = 0;
            var totalPrice = 0;
            var checkboxes = document.querySelectorAll('.product-checkbox');

            checkboxes.forEach(function(checkbox) {
                if (checkbox.checked) {
                    var quantity = parseInt(document.getElementById('quantity_' + checkbox.value).textContent);
                    var price = parseFloat(checkbox.getAttribute('data-price'));
                    totalProductCount += quantity;
                    totalPrice += quantity * price;
                }
            });

            document.getElementById('input_total_products').value = totalProductCount;
            document.getElementById('input_total_price').value = totalPrice.toFixed(2); // Format to 2 decimal places

            // Update display labels
            document.getElementById('total_produk').textContent = totalProductCount;
            document.getElementById('formatted_total_price').textContent = totalPrice.toFixed(2);
        }

        // Attach updateTotals to run whenever a product is added/removed
        document.querySelectorAll('.add-to-cart, .remove-from-cart').forEach(function(button) {
            button.addEventListener('click', function() {
                updateTotals();
            });
        });

        // Also update totals before form submission
        document.querySelector('form').addEventListener('submit', function(event) {
            updateTotals();
        });

    </script>
@endsection
