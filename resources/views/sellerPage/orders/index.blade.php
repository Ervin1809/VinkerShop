{{-- filepath: /Users/ervinhsn/Documents/Semester 3/Pemrograman Web/ProjectVinker/VinkerShop/resources/views/sellerPage/orders/index.blade.php --}}
@extends('sellerPage.dashboard')

@section('contentSeller')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8 text-gray-800 animate-fade-in">
            <i class="fas fa-shopping-bag mr-2 animate-bounce"></i>Incoming Orders
        </h1>

        @if ($orders->isEmpty())
            <div class="bg-gray-50 rounded-xl p-8 text-center border-2 border-dashed border-gray-300 animate-fade-in-up">
                <i class="fas fa-box-open text-4xl text-gray-400 mb-3"></i>
                <p class="text-gray-600">No orders found at the moment.</p>
            </div>
        @else
            <div class="grid gap-6">
                @foreach ($orders as $order)
                    <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 p-6 border border-gray-100 animate-fade-in-up transform hover:scale-[1.01]"
                         style="animation-delay: {{ $loop->iteration * 100 }}ms">
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
                            <div class="px-4 py-2 rounded-full text-sm font-semibold shadow-sm"
                                style="
                                    @if ($order->status == 'completed') background-color: #DEF7EC; color: #03543F;
                                    @elseif($order->status == 'pending') background-color: #FEF3C7; color: #92400E;
                                    @elseif($order->status == 'shipped') background-color: #DBEAFE; color: #1E40AF;
                                    @elseif($order->status == 'cancelled') background-color: #FEE2E2; color: #991B1B;
                                    @else background-color: #F3F4F6; color: #1F2937; @endif
                                ">
                                <i class="fas fa-circle text-xs mr-1"></i>
                                {{-- ucfirst untuk mengubah huruf pertama kata menjadi uppercase --}}
                                {{ ucfirst($order->status) }}
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

                        @if($order->status == 'pending' || $order->status == 'processing')
                            <div class="border-t border-gray-100 mt-6 pt-4 flex justify-end space-x-4">
                                @php
                                    $hasInsufficientStock = false;
                                    $insufficientItems = [];
                                    foreach ($order->orderDetails as $detail) {
                                        if ($detail->quantityOrdered > $detail->product->stock) {
                                            $hasInsufficientStock = true;
                                            $insufficientItems[] = $detail->product->name;
                                        }
                                    }
                                @endphp

                                @if($hasInsufficientStock)
                                    <div class="text-red-500 text-sm mr-auto">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                        Insufficient stock for: {{ implode(', ', $insufficientItems) }}
                                    </div>
                                @endif

                                <form action="{{ route('seller.orders.update-status', $order->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="shipped">
                                    <button type="submit"
                                        {{ $hasInsufficientStock ? 'disabled' : '' }}
                                        class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition-all duration-200 flex items-center hover:transform hover:scale-105
                                        {{ $hasInsufficientStock ? 'opacity-50 cursor-not-allowed' : '' }}">
                                        <i class="fas fa-shipping-fast mr-2"></i>
                                        Ship Order
                                    </button>
                                </form>

                                <form action="{{ route('seller.orders.update-status', $order->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="cancelled">
                                    <button type="submit"
                                        onclick="return confirm('Are you sure you want to cancel this order?')"
                                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-all duration-200 flex items-center hover:transform hover:scale-105">
                                        <i class="fas fa-times mr-2"></i>
                                        Cancel Order
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes fadeInUp {
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
            animation: fadeIn 0.5s ease-in forwards;
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.5s ease-out forwards;
        }
    </style>
@endsection
