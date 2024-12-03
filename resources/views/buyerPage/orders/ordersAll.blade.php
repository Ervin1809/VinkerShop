@extends('buyerPage.dashboard')

@section('contentBuyer')
<style>
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
    .animate-fade-in-up {
        animation: fadeInUp 0.6s ease-out forwards;
    }
</style>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 opacity-0 animate-fade-in-up">
    <h2 class="text-3xl font-bold text-gray-900 mb-8">My Orders</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Pending Orders -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition-all hover:scale-105 opacity-0 animate-fade-in-up" style="animation-delay: 0.1s">
            <div class="px-6 py-4 border-b">
                <h5 class="text-amber-500 font-semibold text-lg">Pending</h5>
            </div>
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-3xl font-bold text-gray-700">{{ $pendingCount ?? 0 }}</span>
                </div>
                <p class="text-gray-600 mb-4">Awaiting confirmation</p>
                <a href="{{ route('buyer.orders.pending') }}" class="block w-full text-center py-2 px-4 rounded-lg border-2 border-amber-500 text-amber-500 hover:bg-amber-500 hover:text-white transition-colors duration-300">View Orders</a>
            </div>
        </div>

        <!-- Shipped Orders -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition-all hover:scale-105 opacity-0 animate-fade-in-up" style="animation-delay: 0.2s">
            <div class="px-6 py-4 border-b">
                <h5 class="text-blue-500 font-semibold text-lg">Shipped</h5>
            </div>
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span class="text-3xl font-bold text-gray-700">{{ $shippedCount ?? 0 }}</span>
                </div>
                <p class="text-gray-600 mb-4">On the way</p>
                <a href="{{ route('buyer.orders.shipped') }}" class="block w-full text-center py-2 px-4 rounded-lg border-2 border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white transition-colors duration-300">View Orders</a>
            </div>
        </div>

        <!-- Completed Orders -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition-all hover:scale-105 opacity-0 animate-fade-in-up" style="animation-delay: 0.3s">
            <div class="px-6 py-4 border-b">
                <h5 class="text-green-500 font-semibold text-lg">Completed</h5>
            </div>
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-3xl font-bold text-gray-700">{{ $completedCount ?? 0 }}</span>
                </div>
                <p class="text-gray-600 mb-4">Successfully delivered</p>
                <a href="{{ route('buyer.orders.completed') }}" class="block w-full text-center py-2 px-4 rounded-lg border-2 border-green-500 text-green-500 hover:bg-green-500 hover:text-white transition-colors duration-300">View Orders</a>
            </div>
        </div>

        <!-- Cancelled Orders -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition-all hover:scale-105 opacity-0 animate-fade-in-up" style="animation-delay: 0.4s">
            <div class="px-6 py-4 border-b">
                <h5 class="text-red-500 font-semibold text-lg">Cancelled</h5>
            </div>
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <span class="text-3xl font-bold text-gray-700">{{ $cancelledCount ?? 0 }}</span>
                </div>
                <p class="text-gray-600 mb-4">Order cancelled</p>
                <a href="{{ route('buyer.orders.cancelled') }}" class="block w-full text-center py-2 px-4 rounded-lg border-2 border-red-500 text-red-500 hover:bg-red-500 hover:text-white transition-colors duration-300">View Orders</a>
            </div>
        </div>
    </div>
</div>
@endsection
