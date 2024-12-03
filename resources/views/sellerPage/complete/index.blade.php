@extends('sellerPage.dashboard')

@section('contentSeller')
    <div class="container mx-auto px-4 py-8 animate-fade-in">
        <h1 class="text-3xl font-bold mb-8 text-gray-800 hover:text-gray-700 transition-colors duration-300">
            <i class="fas fa-check-circle mr-2 animate-bounce"></i>Completed Orders
        </h1>

        @if ($orders->isEmpty())
            <div class="bg-gray-50 rounded-xl p-8 text-center border-2 border-dashed border-gray-300 animate-fade-in">
                <i class="fas fa-clipboard-check text-4xl text-gray-400 mb-3 animate-pulse"></i>
                <p class="text-gray-600">No completed orders found at the moment.</p>
            </div>
        @else
            <div class="grid gap-6">
                @foreach ($orders as $order)
                    <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 p-6 border border-gray-100 animate-slide-in"
                         style="animation-delay: {{ $loop->iteration * 150 }}ms">
                        {{-- Header Section --}}
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-receipt text-gray-400"></i>
                                    <h2 class="text-xl font-semibold text-gray-800">Order #{{ $order->id }}</h2>
                                </div>
                                <p class="text-gray-500 mt-1">
                                    <i class="far fa-clock mr-2"></i>
                                    {{ $order->created_at->format('F j, Y g:i A') }}
                                </p>
                            </div>
                            <div class="px-4 py-2 rounded-full text-sm font-semibold shadow-sm bg-green-100 text-green-800">
                                <i class="fas fa-check-circle text-xs mr-1"></i>
                                Completed
                            </div>
                        </div>

                        <div class="border-t border-gray-100 pt-4">
                            <h3 class="font-semibold text-gray-700 mb-3">
                                <i class="fas fa-user mr-2"></i>Buyer Details
                            </h3>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-gray-700"><i class="fas fa-user-circle mr-2"></i>{{ $order->buyer->name }}</p>
                                <p class="text-gray-600 mt-1"><i class="fas fa-envelope mr-2"></i>{{ $order->buyer->email }}</p>
                            </div>
                        </div>

                        <div class="border-t border-gray-100 mt-6 pt-4">
                            <h3 class="font-semibold text-gray-700 mb-3">
                                <i class="fas fa-shopping-cart mr-2"></i>Order Items
                            </h3>
                            <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                                @foreach ($order->orderDetails as $detail)
                                    <div class="flex justify-between items-center hover:bg-gray-100 p-2 rounded-lg transition-colors duration-200">
                                        <span class="text-gray-800 font-medium">{{ $detail->product->name }}</span>
                                        <span class="text-gray-600">
                                            {{ $detail->quantityOrdered }} × Rp{{ number_format($detail->product->price, 0, ',', '.') }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="border-t border-gray-100 mt-6 pt-4 flex justify-between items-center">
                            <span class="font-semibold text-gray-700">Total Amount:</span>
                            <span class="text-xl font-bold text-green-600">
                                Rp{{ number_format($order->total_amount, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <style>
        @keyframes fade-in {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slide-in {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.5s ease-out forwards;
        }

        .animate-slide-in {
            opacity: 0;
            animation: slide-in 0.5s ease-out forwards;
        }
    </style>
@endsection
