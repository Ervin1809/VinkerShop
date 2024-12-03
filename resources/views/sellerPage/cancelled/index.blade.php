@extends('sellerPage.dashboard')

@section('contentSeller')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8 text-gray-800 animate-fade-slide">
            <i class="fas fa-times-circle mr-2 animate-bounce"></i>Cancelled Orders
        </h1>

        @if ($orders->isEmpty())
            <div class="bg-gray-50 rounded-xl p-8 text-center border-2 border-dashed border-gray-300 animate-fade-slide" style="animation-delay: 0.15s">
                <i class="fas fa-ban text-4xl text-gray-400 mb-3"></i>
                <p class="text-gray-600">No cancelled orders found at the moment.</p>
            </div>
        @else
            <div class="grid gap-6">
                @foreach ($orders as $order)
                    <div class="order-card bg-white rounded-xl shadow-sm p-6 border border-gray-100 animate-fade-slide" style="animation-delay: {{ $loop->iteration * 0.15 }}s">
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
                            <div class="px-4 py-2 rounded-full text-sm font-semibold shadow-sm bg-red-100 text-red-800">
                                <i class="fas fa-times-circle text-xs mr-1"></i>
                                Cancelled
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
        @keyframes fadeSlideIn {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fade-slide {
            animation: fadeSlideIn 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
            opacity: 0;
        }
        .order-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            will-change: transform, opacity, box-shadow;
        }
        .order-card:hover {
            transform: translateY(-2px) scale(1.005);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
    </style>
@endsection
