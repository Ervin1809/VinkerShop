@extends('buyerPage.dashboard')

@section('contentBuyer')
    <div class="max-w-4xl mx-auto px-4 py-8">  <!-- ganti container dengan max-w-4xl -->
        <div class="mb-4">
            <a href="{{ route('order.success') }}" class="flex items-center text-gray-600 hover:text-gray-800">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back
            </a>
        </div>
        <h1 class="text-2xl font-bold mb-6 opacity-0 transform translate-y-4 transition-all duration-500" id="pageTitle">
            My Orders
        </h1>

        @forelse ($orders as $order)
            <div class="bg-white rounded-lg shadow-md mb-4 p-4 opacity-0 transform translate-y-4 transition-all duration-500 order-card">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h2 class="text-lg font-semibold">Order #{{ $order->id }}</h2>
                        <p class="text-gray-500 text-sm">Invoice: {{ $order->invoice_number }}</p>
                        <p class="text-gray-600">{{ $order->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-lg">Total: Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                        <span class="inline-block px-4 py-2 rounded-3xl text-sm font-medium bg-green-100 text-green-700 border border-green-200">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                </div>

                <div class="mb-4">
                    <button onclick="toggleDetails({{ $order->id }})" class="w-full flex items-center justify-between p-2 hover:bg-gray-50 rounded-md border border-gray-200">
                        <h3 class="font-semibold">Order Details</h3>
                        <svg id="chevron-{{ $order->id }}" class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                </div>

                <div id="details-{{ $order->id }}"
                    class="overflow-hidden opacity-0"
                    style="height: 0; transition: none;">
                    <div class="border-t pt-4">
                        @foreach ($order->orderDetails as $detail)
                            <div class="flex items-center gap-4 mb-2 p-2 bg-gray-50 rounded">
                                <img src="{{ asset('storage/' . $detail->product->product_images->first()->image_path) }}" alt="{{ $detail->product->name }}"
                                    class="w-16 h-16 object-cover rounded">
                                <div class="flex-1">
                                    <h4 class="font-medium">{{ $detail->product->name }}</h4>
                                    <p class="text-gray-600">
                                        {{ $detail->quantityOrdered }} x Rp {{ number_format($detail->product->price, 0, ',', '.') }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold">
                                        Rp {{ number_format($detail->quantityOrdered * $detail->product->price, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-8">
                <p class="text-gray-500">No orders found</p>
            </div>
        @endforelse
    </div>

    <script>
        function toggleDetails(orderId) {
            const details = document.getElementById(`details-${orderId}`);
            const content = details.children[0];
            const chevron = document.getElementById(`chevron-${orderId}`);

            // Tambahkan transition setelah initial load
            details.style.transition = 'all 0.3s ease-in-out';

            if (details.classList.contains('opacity-0')) {
                details.classList.remove('opacity-0');
                details.style.height = content.offsetHeight + 'px';
                chevron.classList.add('rotate-180');
            } else {
                details.classList.add('opacity-0');
                details.style.height = '0';
                chevron.classList.remove('rotate-180');
            }
        }

        // Add page load animation
        document.addEventListener('DOMContentLoaded', function() {
            const title = document.getElementById('pageTitle');
            const cards = document.querySelectorAll('.order-card');

            // Animate title first
            setTimeout(() => {
                title.classList.remove('opacity-0', 'translate-y-4');
            }, 100);

            // Animate cards with delay
            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.classList.remove('opacity-0', 'translate-y-4');
                }, 300 + (index * 100)); // 300ms initial delay, then 100ms per card
            });
        });
    </script>
@endsection
