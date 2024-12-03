@extends('buyerPage/dashboard')

<!-- Import Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600;700&display=swap"
    rel="stylesheet">

<style>
    body {
        font-family: 'Inter', sans-serif;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        font-family: 'Poppins', sans-serif;
    }

    .price-text {
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
    }

    .btn-text {
        font-family: 'Inter', sans-serif;
        font-weight: 500;
    }

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

@section('contentBuyer')
<div class="bg-white shadow-md rounded-lg overflow-hidden flex mb-6 p-4 opacity-0 animate-fadeIn">
        <div class="absolute z-10 max-w-7xl mx-auto">
            <a href="{{ route("buyer.products.index") }}" class="text-black hover:text-purple-800 transition-all duration-300">
                <svg class="w-[48px] h-[48px] text-gray-800 dark:text-[#915cfc]" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 12h14M5 12l4-4m-4 4 4 4" />
                </svg>
            </a>
        </div>
        <!-- Gambar Produk (Carousel) -->
        <div class="w-1/3 h-96 relative opacity-0 animate-fadeIn" style="animation-delay: 0.2s">
            <div id="carousel-{{ $product->id }}" class="carousel relative w-full h-full">
                <!-- Wrapper untuk gambar -->
                <div class="carousel-images relative flex w-96 h-96 overflow-hidden">
                    @foreach ($product->product_images as $image)
                        <img class="w-96 h-w-96 object-cover absolute opacity-0 transition-all duration-700 ease-in-out transform scale-95 rounded-md"
                            src="{{ asset('storage/' . $image->image_path) }}" alt="Foto Produk">
                    @endforeach
                </div>

                <!-- Navigasi Kiri -->
                <button
                    class="absolute left-0 top-1/2 transform -translate-y-1/2 text-white rounded-r-lg p-2 hover:bg-black/70 transition-all z-10"
                    onclick="moveSlide('carousel-{{ $product->id }}', -1)">
                    &larr;
                </button>

                <!-- Navigasi Kanan -->
                <button
                    class="absolute right-1.5 top-1/2 transform -translate-y-1/2 text-white rounded-l-lg p-2 hover:bg-black/70 transition-all z-10"
                    onclick="moveSlide('carousel-{{ $product->id }}', 1)">
                    &rarr;
                </button>
            </div>
            <div class="mt-2 flex items-center space-x-4">
                <!-- Label -->
                <p class="text-gray-700">Share:</p>

                <!-- Facebook -->
                <a href="https://facebook.com" target="_blank" rel="noopener noreferrer"
                    class="text-blue-600 transform transition-all duration-300 hover:scale-125">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-5 h-5">
                        <path
                            d="M22.675 0H1.325C.593 0 0 .593 0 1.325v21.351C0 23.407.593 24 1.325 24h11.495v-9.294H9.692v-3.622h3.128V8.413c0-3.1 1.894-4.788 4.659-4.788 1.325 0 2.463.098 2.795.143v3.24h-1.917c-1.504 0-1.795.714-1.795 1.762v2.31h3.59l-.467 3.622h-3.123V24h6.125C23.407 24 24 23.407 24 22.675V1.325C24 .593 23.407 0 22.675 0z" />
                    </svg>
                </a>

                <!-- Instagram -->
                <a href="https://instagram.com" target="_blank" rel="noopener noreferrer"
                    class="text-pink-600 transform transition-all duration-300 hover:scale-125">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-5 h-5">
                        <path
                            d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.334 3.608 1.31.975.975 1.247 2.242 1.31 3.608.058 1.265.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.062 1.366-.334 2.633-1.31 3.608-.975.975-2.242 1.247-3.608 1.31-1.265.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.366-.062-2.633-.334-3.608-1.31-.975-.975-1.247-2.242-1.31-3.608-.058-1.265-.07-1.646-.07-4.85s.012-3.584.07-4.85c.062-1.366.334-2.633 1.31-3.608.975-.975 2.242-1.247 3.608-1.31 1.265-.058 1.646-.07 4.85-.07zm0-2.163C8.737 0 8.332.013 7.052.07 5.737.127 4.677.404 3.74 1.34 2.804 2.276 2.526 3.336 2.469 4.65c-.058 1.28-.07 1.685-.07 4.85s.013 3.584.07 4.85c.057 1.314.335 2.374 1.27 3.31.936.936 1.996 1.213 3.31 1.27 1.28.057 1.685.07 4.85.07s3.584-.013 4.85-.07c1.314-.057 2.374-.335 3.31-1.27.936-.936 1.213-1.996 1.27-3.31.057-1.28.07-1.685.07-4.85s-.013-3.584-.07-4.85c-.057-1.314-.335-2.374-1.27-3.31-.936-.936-1.996-1.213-3.31-1.27C15.584.013 15.18 0 12 0z" />
                        <path
                            d="M12 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zm0 10.162a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0-2.882 0 1.44 1.44 0 0 0 2.882 0z" />
                    </svg>
                </a>

                <!-- WhatsApp -->
                <a href="https://wa.me/?text=Check%20this%20out!" target="_blank" rel="noopener noreferrer"
                    class=" text-green-500 transform transition-all duration-300 hover:scale-125">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-5 h-5">
                        <path
                            d="M20.5 3.5a9.68 9.68 0 0 0-13.68 0A9.69 9.69 0 0 0 2 11.5c0 1.71.45 3.42 1.33 4.89L2 22l5.67-1.33a9.61 9.61 0 0 0 4.89 1.33c5.31 0 9.68-4.38 9.68-9.69s-4.38-9.68-9.69-9.68zM12 20c-1.44 0-2.86-.38-4.11-1.1l-.3-.18-3.36.79.7-3.44-.2-.29A8.6 8.6 0 0 1 3.4 11.5a8.63 8.63 0 0 1 14.77-6.1 8.57 8.57 0 0 1 2.53 6.1A8.63 8.63 0 0 1 12 20zm4.85-6.14c-.25-.13-1.47-.73-1.69-.81-.22-.08-.38-.13-.54.13s-.62.81-.76.98c-.14.16-.28.18-.53.06-.25-.13-1.06-.39-2.02-1.25a7.56 7.56 0 0 1-1.4-1.73c-.14-.25-.01-.38.1-.5l.23-.27c.12-.14.16-.23.24-.37.08-.14.04-.26-.02-.39-.06-.13-.54-1.3-.74-1.76-.2-.48-.4-.41-.54-.42-.14 0-.3-.01-.46-.01-.15 0-.39.06-.59.26-.2.2-.78.77-.78 1.88 0 1.11.8 2.19.92 2.34.13.16 1.57 2.38 3.8 3.34.53.23.94.37 1.26.48.53.17 1.02.15 1.4.09.43-.06 1.47-.6 1.68-1.18.21-.58.21-1.08.14-1.18-.07-.1-.23-.16-.48-.28z" />
                    </svg>
                </a>

                <p class="mx-96">|</p>

                <form action="{{ route('favorite.store', $product->id) }}" method="POST" class="flex gap-2 mt-4 group">
                    @csrf
                    @if ($favorite)
                        <button type="submit"
                            class="text-red-500 transform transition-all duration-300 hover:scale-125 active:scale-95"
                            data-product-id="1">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="w-6 h-6 animate-bounce">
                                <path
                                    d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
                            </svg>
                        </button>
                        <p
                            class="favorite-label font-medium transition-all duration-300 text-red-500 group-hover:translate-x-1">
                            <span class="inline-block animate-pulse"></span> Favorites
                        </p>
                    @else
                        <button type="submit"
                            class="text-gray-400 transform transition-all duration-300 hover:scale-125 hover:text-red-500 active:scale-95 hover:rotate-12"
                            data-product-id="1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6 transition-all duration-300 hover:stroke-2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                            </svg>
                        </button>
                        <p
                            class="favorite-label font-medium text-gray-500 transition-all duration-300 group-hover:text-red-500 group-hover:translate-x-1">
                            Add to Favorites
                        </p>
                    @endif
                </form>
            </div>

        </div>

        <!-- Informasi Produk -->
        <div class="p-6 w-2/3 opacity-0 animate-fadeIn" style="animation-delay: 0.4s">
            <!-- Nama Produk -->
            <h2 class="text-gray-800 font-semibold text-xl mb-2 font-poppins">{{ $product->name }}</h2>

            <!-- Rating Produk (Opsional) -->
            <div class="flex items-center mb-4">
                <span class="text-yellow-400 text-sm">★ ★ ★ ★ ☆</span>
                <span class="text-gray-600 ml-2 text-sm">(4.5)</span>
            </div>

            <!-- Harga Produk -->
            <p class="text-[#915cfc] font-bold text-3xl mb-4 w-full bg-slate-100 p-5 price-text">
                {{ $product->formatted_price }}</p>

            <!-- Deskripsi Produk -->

            <table class="mb-12">
                <tr>
                    <td class="w-40">Pengiriman</td>
                    <td class="h-16">Kota Makassar</td>
                    {{-- <td id="batasStock" value={{ $product->stock }}> {{ $product->stock }}</td> --}}
                </tr>
                <tr>
                    <td class="w-40">Jumlah Barang</td>
                    <td>

                        <form class="max-w-xs mx-auto">
                            <div class="relative flex items-center max-w-[8rem]">
                                <!-- Tombol Decrement -->
                                <button type="button" id="decrement-button" data-input-counter-decrement="quantity-input"
                                    onclick="decrementStock()"
                                    class="flex items-center justify-center bg-gray-100 dark:bg-white dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 p-2.5 w-8 h-8 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none ">
                                    <svg class="w-3 h-3 text-gray-500 dark:text-gray-500" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M1 1h16" />
                                    </svg>
                                </button>

                                <!-- Input Jumlah -->
                                <input type="text" name="stock" id="stock" value="0"
                                    aria-describedby="helper-text-explanation"
                                    class="border bg-gray-50 border-x-0 border-gray-300 h-8 text-center text-gray-500 text-sm focus:ring-blue-500 focus:border-blue-500 block w-12 dark:bg-white dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-500 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="0" required />

                                <!-- Tombol Increment -->
                                <button type="button" id="increment-button" data-input-counter-increment="quantity-input"
                                    onclick="incrementStock()"
                                    class="flex items-center justify-center bg-gray-100 dark:bg-white dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 p-2.5 w-8 h-8 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
                                    <svg class="w-3 h-3 text-gray-500 dark:text-gray-500" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M9 1v16M1 9h16" />
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </td>
                </tr>

            </table>
            {{-- <p class="text-gray-600 mb-4">{{ $product->description }}</p> --}}


            <!-- Tombol Aksi -->
            <div class="flex space-x-4">
                <div class="flex items-center space-x-4">
                    <form action="{{ route('cart.store') }}" method="POST" id="cart-form">
                        @csrf
                        <input type="hidden" name="productId" id='productId' value='{{ $product->id }}'>
                        <input type="hidden" name="quantity" id="quantity-input-hidden" value="0">
                        <button type="submit"
                            class="btn-text h-auto flex items-center justify-center border border-[#915cfc] text-[#915cfc] bg-indigo-100 px-6 py-3 hover:bg-indigo-50 transition-colors duration-200">
                            <!-- Icon Keranjang -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"
                                class="w-5 h-5 mr-2">
                                <path
                                    d="M3.25 2a.75.75 0 0 0 0 1.5h1.56l1.38 6.33.03.16-1.36 2.32A2.75 2.75 0 0 0 6.44 15h10.89a2.75 2.75 0 0 0 2.55-3.68l-1.38-3.78a.76.76 0 0 0-.14-.23l-.05-.05a.75.75 0 0 0-.47-.2H6.57L5.87 3H3.25Zm3.25 7.5h10.28l1.1 3.02a1.25 1.25 0 0 1-1.16 1.68H6.44a1.25 1.25 0 0 1-1.1-1.88l1.16-1.82Zm7.25 9a1.5 1.5 0 1 0-1.5-1.5 1.5 1.5 0 0 0 1.5 1.5Zm-6 0a1.5 1.5 0 1 0-1.5-1.5 1.5 1.5 0 0 0 1.5 1.5Z" />
                            </svg>
                            Tambah ke Keranjang
                        </button>
                    </form>

                    <form action="{{ route('cart.buy.store') }}" method="POST" id="buy">
                        @csrf
                        <input type="hidden" name="productId" id='productId' value='{{ $product->id }}'>
                        <input type="hidden" name="quantity" id="quantity-input1-hidden" value="0">
                        <button type="submit"
                            class="btn-text h-12 px-9 py-3 bg-[#915cfc] text-white text-sm font-semibold hover:bg-purple-600 transition-colors duration-200">
                            Beli Sekarang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Nama Toko -->
    <div class="bg-white shadow-md rounded-lg p-7 mb-6 opacity-0 animate-fadeIn" style="animation-delay: 0.6s">
        <div class="flex items-center">
            <img class="w-16 h-16 object-cover rounded-full mr-4" src="{{ asset('storage/' . $shop->seller->profilePicture) }}"
                alt="Foto Toko">
            <div class="ml-6">
                <h3 class="text-gray-800 font-semibold">{{ $shop->shopName }}</h3>
                <h6 class="text-sm text-gray-500">Aktif 2 Jam Lalu</h6>
                <div class="flex space-x-4 mt-3">
                    <!-- Tombol Chat -->
                    <button
                        class="flex items-center border border-[#915cfc] text-[#915cfc] bg-indigo-100 px-6 py-1 hover:bg-indigo-50">
                        <!-- Icon Pesan/Chat -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"
                            class="w-5 h-5 mr-2">
                            <path
                                d="M21 5.25H3A1.25 1.25 0 0 0 1.75 6.5v8A1.25 1.25 0 0 0 3 15.75h5v3.19a.75.75 0 0 0 1.2.6l4.36-3.79h7.44A1.25 1.25 0 0 0 22.25 14.5v-8A1.25 1.25 0 0 0 21 5.25ZM3 4h18a2.75 2.75 0 0 1 2.75 2.75v8A2.75 2.75 0 0 1 21 17.5h-7.13l-3.84 3.33A2.25 2.25 0 0 1 7.75 19.5V17.5H3a2.75 2.75 0 0 1-2.75-2.75v-8A2.75 2.75 0 0 1 3 4Z" />
                        </svg>
                        Chat Sekarang
                    </button>

                    <!-- Tombol Kunjungi -->
                    <a href="{{ route('buyer.products.shop', $shop->id) }}" class="flex items-center border border-gray-200 text-gray-700 px-6 py-1 hover:bg-gray-200">
                        <!-- Icon Shop -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"
                            class="w-5 h-5 mr-2">
                            <path
                                d="M12 2.75a.75.75 0 0 0-.75.75v.25H9.75A3.25 3.25 0 0 0 6.5 7v1H3a.75.75 0 0 0-.75.75v11a3.25 3.25 0 0 0 3.25 3.25h13a3.25 3.25 0 0 0 3.25-3.25v-11A.75.75 0 0 0 21 8H17.5V7a3.25 3.25 0 0 0-3.25-3.25H12.75V3.5A.75.75 0 0 0 12 2.75Zm1.75 2.25a1.75 1.75 0 0 1 1.75 1.75v1h-7V7a1.75 1.75 0 0 1 1.75-1.75h3.5ZM3.75 9.5h16.5v10.75a1.75 1.75 0 0 1-1.75 1.75H5.5a1.75 1.75 0 0 1-1.75-1.75V9.5Zm4.25 3.75a1.25 1.25 0 0 1 1.25 1.25v4a1.25 1.25 0 0 1-2.5 0v-4a1.25 1.25 0 0 1 1.25-1.25Zm7.25 0a1.25 1.25 0 0 1 1.25 1.25v4a1.25 1.25 0 0 1-2.5 0v-4a1.25 1.25 0 0 1 1.25-1.25Z" />
                        </svg>
                        Kunjungi
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Produk Lainnya -->
    <div class="flex items-center mb-4">
        <div class="flex-grow border-t border-gray-300"></div>
        <h3 class="text-gray-400 font-semibold text-xl mx-4">Produk Lainnya</h3>
        <div class="flex-grow border-t border-gray-300"></div>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4 p-4 mb-16">
        @foreach ($relatedProducts as $relatedProduct)
            <!-- Card Produk -->
            <a href="{{ route('products.detailBuyer', $relatedProduct->id) }}"
                class="block transform transition-transform hover:scale-105">
                <div class="bg-white shadow-md rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <!-- Gambar Produk -->
                    @if ($relatedProduct->product_images->isNotEmpty())
                        <img class="w-full h-36 object-cover"
                            src="{{ asset('storage/' . $relatedProduct->product_images->first()->image_path) }}"
                            alt="{{ $relatedProduct->name }}">
                    @endif

                    <!-- Informasi Produk -->
                    <div class="p-3">
                        <h3 class="text-gray-900 font-semibold text-base truncate">{{ $relatedProduct->name }}</h3>
                        <p class="text-gray-700 mt-1 font-bold text-lg">{{ $relatedProduct->formatted_price }}</p>
                        <div class="flex items-center mt-1">
                            <span class="text-yellow-400 text-xs">★ ★ ★ ★ ☆</span>
                            <span class="text-gray-600 ml-1 text-xs">(4.5)</span>
                        </div>
                        <div class="mt-3 flex justify-end items-center">
                            <button
                                class="px-3 py-1 bg-[#915cfc] text-white text-xs font-semibold rounded-lg hover:bg-purple-400 transition-colors duration-200 flex items-center">
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


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const carousels = document.querySelectorAll('.carousel');

            carousels.forEach(carousel => {
                const images = carousel.querySelectorAll('.carousel-images img');
                let currentIndex = 0;
                let intervalId;

                // Function to show image with animation
                const showImage = (index) => {
                    images.forEach((img, i) => {
                        if (i === index) {
                            img.classList.remove('opacity-0', 'scale-95');
                            img.classList.add('opacity-100', 'scale-100');
                            img.style.zIndex = '1';
                        } else {
                            img.classList.add('opacity-0', 'scale-95');
                            img.classList.remove('opacity-100', 'scale-100');
                            img.style.zIndex = '0';
                        }
                    });
                };

                // Show first image
                showImage(currentIndex);

                // Auto-scroll function
                const autoScroll = () => {
                    const nextIndex = (currentIndex + 1) % images.length;
                    showImage(nextIndex);
                    currentIndex = nextIndex;
                };

                // Start auto-scroll
                const startAutoScroll = () => {
                    intervalId = setInterval(autoScroll, 3000);
                };

                // Stop auto-scroll
                const stopAutoScroll = () => {
                    clearInterval(intervalId);
                };

                startAutoScroll();

                // Mouse hover handlers
                carousel.addEventListener('mouseenter', stopAutoScroll);
                carousel.addEventListener('mouseleave', startAutoScroll);

                // Navigation function
                window.moveSlide = (carouselId, direction) => {
                    const currentCarousel = document.querySelector(`#${carouselId}`);
                    const images = currentCarousel.querySelectorAll('.carousel-images img');

                    const nextIndex = (currentIndex + direction + images.length) % images.length;
                    showImage(nextIndex);
                    currentIndex = nextIndex;
                };
            });

            window.decrementStock = () => {
                const stockInput = document.getElementById('stock');
                let stockValue = parseInt(stockInput.value);
                if (stockValue > 0) {
                    stockInput.value = stockValue - 1;
                }
            };

            window.incrementStock = () => {
                const stockInput = document.getElementById('stock');
                let stockValue = parseInt(stockInput.value);
                stockInput.value = stockValue + 1;
            };

        });
        document.getElementById('cart-form').addEventListener('submit', function(event) {
            const quantity = document.getElementById('stock').value;

            document.getElementById('quantity-input-hidden').value = quantity;
        });
        document.getElementById('buy').addEventListener('submit', function(event) {
            const quantity = document.getElementById('stock').value;

            document.getElementById('quantity-input1-hidden').value = quantity;
        });
    </script>
@endsection
