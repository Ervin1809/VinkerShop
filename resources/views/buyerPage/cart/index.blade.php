@extends('buyerPage/dashboard')

@section('contentBuyer')
    <div class="container mx-auto p-2 opacity-0 animate-fadeIn">
        <h1 class="text-3xl font-bold mb-6 text-[#915cfc]">Shopping Cart</h1>

        @if ($groupedCartItems->isEmpty())
            <div class="bg-gray-100 p-8 rounded text-center opacity-0 animate-fadeIn" style="animation-delay: 0.2s">
                <h2 class="text-xl text-gray-700">Your cart is empty.</h2>
                <a href="{{ route('buyer.products.index') }}" class="text-blue-500 hover:underline">Start Shopping</a>
            </div>
        @else
            @foreach ($groupedCartItems as $shopId => $items)
                <div class="bg-white shadow-lg rounded-lg p-6 mb-6 opacity-0 animate-fadeIn" style="animation-delay: 0.2s">
                    <div class="border-b pb-4 mb-4">
                        <h2 class="text-xl font-bold text-[#915cfc]">{{ $items->first()->product->shop->shopName }}</h2>
                    </div>

                    <table class="w-full border-collapse">
                        <thead class="border-b bg-gray-100">
                            <tr>
                                <th class="text-center px-4 py-2">
                                    <input type="checkbox" class="select-shop w-4 h-4 accent-[#915cfc]" data-shop-id="{{ $shopId }}">
                                </th>
                                <th class="text-left px-4 py-2">Product</th>
                                <th class="text-center px-4 py-2">Price</th>
                                <th class="text-center px-4 py-2">Quantity</th>
                                <th class="text-center px-4 py-2">Total</th>
                                <th class="text-center px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr class="border-b product-item" data-product-id="{{ $item->product->id }}" data-shop-id="{{ $shopId }}">
                                    <td class="px-4 py-4 text-center">
                                        <input type="checkbox" class="product-checkbox w-4 h-4 accent-[#915cfc]"
                                            data-id="{{ $item->id }}" data-price="{{ $item->product->price }}">
                                    </td>
                                    <td class="px-4 py-4 flex items-center space-x-4">
                                        <a href="{{ route('products.detailBuyer', $item->product->id) }}" class="flex items-center space-x-4 hover:opacity-50 transition-opacity">
                                            <img src="{{ asset('storage/' . $item->product->product_images->first()->image_path) }}"
                                                alt="{{ $item->product->name }}" class="w-16 h-16 object-cover rounded-md">
                                            <div>
                                                <h3 class="text-lg font-semibold">{{ $item->product->name }}</h3>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="px-4 py-4 text-center" data-price="{{ $item->product->price }}">
                                        {{ $item->product->formatted_price }}
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <div class="flex items-center justify-center space-x-2">
                                            <button type="button"
                                                class="px-2 py-1 bg-[#915cfc] text-white border rounded hover:bg-[#6a4bff]"
                                                onclick="decreaseQuantity({{ $item->id }})">-</button>
                                            <input type="number" id="quantity-{{ $item->id }}"
                                                value="{{ $item->quantity }}" class="w-16 text-center border rounded"
                                                min="1">
                                            <button type="button"
                                                class="px-2 py-1 bg-[#915cfc] text-white border rounded hover:bg-[#6a4bff]"
                                                onclick="increaseQuantity({{ $item->id }})">+</button>
                                        </div>
                                    </td>
                                    <td id="total-{{ $item->id }}" class="px-4 py-4 text-center font-bold">
                                        Rp{{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach

            <div
                class="fixed bottom-0 left-0 right-0 bg-white border-t shadow-[0_-4px_12px_rgba(0,0,0,0.1)] transition-transform duration-300">
                <div class="container mx-auto p-4">
                    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                        <div class="flex items-center gap-6">
                            <div class="flex items-center gap-2">
                                <span
                                    class="w-5 h-5 flex items-center justify-center rounded-full bg-[#915cfc] text-white text-sm"
                                    id="selectedItemsCount">0</span>
                                <span class="text-gray-600">items selected</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-sm text-gray-500">Total Amount</span>
                                <span id="selectedTotal" class="text-2xl font-bold text-[#915cfc]">Rp0</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="flex flex-col items-end">
                                <span class="text-sm text-gray-500">Estimated Delivery</span>
                                <span class="text-gray-700 font-medium">2-3 Business Days</span>
                            </div>
                            <form action="{{ route('order.checkout') }}" method="POST" id="checkoutForm"
                                class="flex-shrink-0">
                                @csrf
                                <input type="hidden" name="selected_items" id="selectedItems">
                                <div class="mb-4 relative">
                                    <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">Payment Method</label>
                                    <div class="relative">
                                        <select name="payment_method" id="payment_method"
                                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-[#915cfc] focus:ring focus:ring-[#915cfc] focus:ring-opacity-20 bg-white text-gray-700 transition-colors duration-200 appearance-none cursor-pointer pr-10">
                                            <option value="credit_card">Credit Card</option>
                                            <option value="bank_transfer">Bank Transfer</option>
                                            <option value="paypal">PayPal</option>
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-[#915cfc]">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" id="checkoutButton"
                                    class="group relative inline-flex items-center gap-2 bg-[#915cfc] text-white px-6 py-3 rounded-lg hover:bg-[#6a4bff] disabled:bg-gray-400 transition-all duration-200 ease-in-out transform hover:scale-[1.02]"
                                    disabled>
                                    <span>Proceed to Checkout</span>
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 transition-transform duration-200 group-hover:translate-x-1"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="h-44"></div>
        @endif
    </div>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideUp {
            from {
                transform: translateY(100%);
            }

            to {
                transform: translateY(0);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.5s ease-out forwards;
        }

        .fixed {
            animation: slideUp 0.3s ease-out;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkoutButton = document.getElementById('checkoutButton');
            const selectedItemsInput = document.getElementById('selectedItems');
            const productCheckboxes = document.querySelectorAll('.product-checkbox');

            checkoutButton.addEventListener('click', function(event) {
                event.preventDefault();

                const selectedItems = [];
                productCheckboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        const productId = checkbox.closest('.product-item').getAttribute(
                            'data-product-id');
                        const quantity = document.getElementById(
                            `quantity-${checkbox.getAttribute('data-id')}`).value;
                        selectedItems.push({
                            product_id: productId,
                            quantity: quantity
                        });
                    }
                });

                selectedItemsInput.value = JSON.stringify(selectedItems);

                document.getElementById('checkoutForm').submit();
            });
        });

        function handleSelectAll() {
            const selectAllCheckbox = document.getElementById('select-all');
            const productCheckboxes = document.querySelectorAll('.product-checkbox');

            productCheckboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });

            updateSelectedTotal();
        }

        function updateTotal(id) {
            const quantityInput = document.getElementById(`quantity-${id}`);
            const totalElement = document.getElementById(`total-${id}`);
            const row = quantityInput.closest('tr');

            const price = parseInt(row.querySelector('[data-price]').getAttribute('data-price'));

            const newTotal = quantityInput.value * price;

            const formattedTotal = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(newTotal);

            totalElement.textContent = formattedTotal;
        }

        function decreaseQuantity(id) {
            const input = document.getElementById(`quantity-${id}`);
            if (input.value > 1) {
                input.value = parseInt(input.value) - 1;

                updateTotal(id);
            }
        }

        function increaseQuantity(id) {
            const input = document.getElementById(`quantity-${id}`);
            input.value = parseInt(input.value) + 1;

            updateTotal(id);
        }

        function updateSelectedTotal() {
            const checkboxes = document.querySelectorAll('.product-checkbox:checked');
            let total = 0;

            document.getElementById('selectedItemsCount').textContent = checkboxes.length;

            checkboxes.forEach(checkbox => {
                const row = checkbox.closest('tr');
                const price = parseInt(row.querySelector('[data-price]').getAttribute('data-price'));
                const quantity = parseInt(row.querySelector('input[id^="quantity-"]').value);
                total += price * quantity;
            });

            const totalElement = document.getElementById('selectedTotal');
            totalElement.style.transform = 'scale(1.1)';
            totalElement.style.transition = 'transform 0.2s ease';

            const formattedTotal = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(total);

            totalElement.textContent = formattedTotal;

            setTimeout(() => {
                totalElement.style.transform = 'scale(1)';
            }, 200);

            const checkoutButton = document.getElementById('checkoutButton');
            checkoutButton.disabled = checkboxes.length === 0;

            const selectedItems = Array.from(checkboxes).map(cb => {
                const row = cb.closest('tr');
                const id = cb.getAttribute('data-id');
                const quantity = row.querySelector('input[id^="quantity-"]').value;
                return {
                    id,
                    quantity
                };
            });
            document.getElementById('selectedItems').value = JSON.stringify(selectedItems);
        }

        document.addEventListener('DOMContentLoaded', function() {
            const selectAllCheckbox = document.getElementById('select-all');
            selectAllCheckbox.addEventListener('change', handleSelectAll);

            const productCheckboxes = document.querySelectorAll('.product-checkbox');
            productCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const allCheckboxes = document.querySelectorAll('.product-checkbox');
                    const allChecked = Array.from(allCheckboxes).every(cb => cb.checked);
                    document.getElementById('select-all').checked = allChecked;

                    updateSelectedTotal();
                });
            });
        });

        const originalDecreaseQuantity = decreaseQuantity;
        decreaseQuantity = function(id) {
            originalDecreaseQuantity(id);
            updateSelectedTotal();
        }

        const originalIncreaseQuantity = increaseQuantity;
        increaseQuantity = function(id) {
            originalIncreaseQuantity(id);
            updateSelectedTotal();
        }

        // Inisialisasi handler untuk checkbox toko
        const shopCheckboxes = document.querySelectorAll('.select-shop');
        shopCheckboxes.forEach(shopCheckbox => {
            shopCheckbox.addEventListener('change', function() {
                const shopId = this.getAttribute('data-shop-id');
                const productCheckboxes = document.querySelectorAll(`.product-item[data-shop-id="${shopId}"] .product-checkbox`);
                productCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                updateSelectedTotal();
                updateShopCheckboxes();
            });
        });

        // Handler untuk checkbox produk
        const productCheckboxes = document.querySelectorAll('.product-checkbox');
        productCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                updateSelectedTotal();
                updateShopCheckboxes();
            });
        });

        // Fungsi untuk update status checkbox toko
        function updateShopCheckboxes() {
            const shops = {};

            // Inisialisasi status untuk setiap toko
            document.querySelectorAll('.select-shop').forEach(shopCheckbox => {
                const shopId = shopCheckbox.getAttribute('data-shop-id');
                const productCheckboxes = document.querySelectorAll(`.product-item[data-shop-id="${shopId}"] .product-checkbox`);
                const checkedProducts = document.querySelectorAll(`.product-item[data-shop-id="${shopId}"] .product-checkbox:checked`);

                shopCheckbox.checked = productCheckboxes.length > 0 && productCheckboxes.length === checkedProducts.length;
                shopCheckbox.indeterminate = checkedProducts.length > 0 && checkedProducts.length < productCheckboxes.length;
            });
        }

        // Update fungsi updateSelectedTotal yang sudah ada
        function updateSelectedTotal() {
            const checkboxes = document.querySelectorAll('.product-checkbox:checked');
            let total = 0;

            document.getElementById('selectedItemsCount').textContent = checkboxes.length;

            checkboxes.forEach(checkbox => {
                const row = checkbox.closest('tr');
                const price = parseInt(row.querySelector('[data-price]').getAttribute('data-price'));
                const quantity = parseInt(row.querySelector('input[id^="quantity-"]').value);
                total += price * quantity;
            });

            const totalElement = document.getElementById('selectedTotal');
            totalElement.style.transform = 'scale(1.1)';
            totalElement.style.transition = 'transform 0.2s ease';

            const formattedTotal = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(total);

            totalElement.textContent = formattedTotal;

            setTimeout(() => {
                totalElement.style.transform = 'scale(1)';
            }, 200);

            const checkoutButton = document.getElementById('checkoutButton');
            checkoutButton.disabled = checkboxes.length === 0;

            const selectedItems = Array.from(checkboxes).map(cb => {
                const row = cb.closest('tr');
                const id = cb.getAttribute('data-id');
                const quantity = row.querySelector('input[id^="quantity-"]').value;
                return { id, quantity };
            });
            document.getElementById('selectedItems').value = JSON.stringify(selectedItems);
        }

        // Inisialisasi status checkbox saat halaman dimuat
        updateShopCheckboxes();
    </script>

@endsection
