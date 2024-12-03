@extends('buyerPage/dashboard')

@section('contentBuyer')
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4 p-4 mb-10">
        @foreach ($products as $product)
            <!-- Card Produk -->
            <a href="{{ route('products.detailBuyer', $product->id) }}"
                class="block transform transition-transform hover:scale-105 opacity-0 animate-fadeIn"
                style="animation-delay: {{ $loop->index * 0.1 }}s">
                <div class="bg-white shadow-md rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <!-- Gambar Produk -->
                    <img class="w-full h-36 object-cover"
                        src="{{ asset('storage/' . $product->product_images->first()->image_path) }}"
                        alt="{{ $product->name }}">

                    <!-- Informasi Produk -->
                    <div class="p-3">
                        <!-- Nama Produk -->
                        <h3 class="text-gray-900 font-semibold text-base truncate">{{ $product->name }}</h3>

                        <!-- Harga Produk -->
                        <p class="text-gray-700 mt-1 font-bold text-lg">{{ $product->formatted_price }}</p>

                        <!-- Rating Produk (Opsional) -->
                        <div class="flex items-center mt-1">
                            <span class="text-yellow-400 text-xs">★ ★ ★ ★ ☆</span>
                            <span class="text-gray-600 ml-1 text-xs">(4.5)</span>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="mt-3 flex justify-end items-center">
                            <button
                                class="px-3 py-1 bg-[#915cfc] text-white text-xs font-semibold rounded-lg hover:bg-purple-400 transition-colors duration-200 flex items-center">
                                <!-- Ikon Keranjang dari Heroicons -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.6 8.4a1 1 0 001 .6h12.2a1 1 0 001-.6L17 13m-10 0h10m-6 5a1 1 0 110 2m4-2a1 1 0 110 2" />
                                </svg>
                                <span class="ml-1">Add to Cart</span>
                            </button>
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
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

        .animate-fadeIn {
            animation: fadeIn 0.5s ease-out forwards;
        }
    </style>
@endsection
