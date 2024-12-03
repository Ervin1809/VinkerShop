@extends('buyerPage.dashboard')

@section('contentBuyer')
    <div class="min-h-screen  bg-gradient-to-br from-purple-50 via-white to-purple-50 rounded-3xl p-4 mb-16">
        <!-- Back Button -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4 pb-2">
            <button onclick="window.history.back()" class="text-black hover:text-purple-800 transition-all duration-300">
                <svg class="w-[48px] h-[48px] text-gray-800 dark:text-[#915cfc]" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 12h14M5 12l4-4m-4 4 4 4" />
                </svg>
            </button>
        </div>

        <!-- Shop Banner Carousel -->
        <div x-data="{ activeSlide: 0 }" class="relative h-[580px] overflow-hidden rounded-3xl shadow-lg -mt-2">
            <div class="relative h-full bg-gray-900">
                <!-- Shop Images -->
                @foreach ($imagePaths as $index => $path)
                    <div x-show="activeSlide === {{ $index }}" x-transition:enter="transition ease-out duration-500"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-300"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-95" class="absolute inset-0">
                        <img src="{{ asset('storage/' . $path) }}" class="w-full h-full object-cover">
                    </div>
                @endforeach

                <!-- Enhanced Blur Effect at Bottom -->
                <div
                    class="absolute bottom-0 left-0 right-0 h-[600px] bg-gradient-to-t from-white/25 via-white/50 to-transparent backdrop-blur-none">
                </div>
                <div
                    class="absolute bottom-0 left-0 right-0 h-60 bg-gradient-to-t from-purple-200 via-white/50 to-transparent backdrop-blur-none">
                </div>
                <div
                    class="absolute bottom-0 left-0 right-0 h-[600px] bg-gradient-to-b from-black via-black/50 to-transparent backdrop-blur-none">
                </div>

                <!-- Enhanced Carousel Controls -->
                @if (count($imagePaths) > 1)
                    <div class="absolute inset-y-0 left-0 flex items-center">
                        <button @click="activeSlide = activeSlide === 0 ? {{ count($imagePaths) - 1 }} : activeSlide - 1"
                            class="px-6 py-20 text-white bg-black/20 hover:bg-black/40 rounded-r-lg transition-colors">
                            <i class="fas fa-chevron-left text-3xl"></i>
                        </button>
                    </div>
                    <div class="absolute inset-y-0 right-0 flex items-center">
                        <button @click="activeSlide = activeSlide === {{ count($imagePaths) - 1 }} ? 0 : activeSlide + 1"
                            class="px-6 py-20 text-white bg-black/20 hover:bg-black/40 rounded-l-lg transition-colors">
                            <i class="fas fa-chevron-right text-3xl"></i>
                        </button>
                    </div>

                    <!-- Enhanced Carousel Indicators -->
                    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 flex space-x-3">
                        @foreach ($imagePaths as $index => $path)
                            <button @click="activeSlide = {{ $index }}"
                                :class="{
                                    'w-4 h-4 bg-white': activeSlide ===
                                        {{ $index }},
                                    'w-3 h-3 bg-white/50': activeSlide !== {{ $index }}
                                }"
                                class="rounded-full transition-all duration-300">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Shop Info -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-20 relative">
            <div class="bg-white/80 backdrop-blur-md rounded-xl shadow-lg p-6 border border-purple-100">
                <div class="flex flex-col md:flex-row gap-6">
                    <!-- Profile Image -->
                    <div class="flex-shrink-0 -mt-20">
                        <img src="{{ asset('storage/' . $shop->seller->profilePicture) ?? 'default-shop-image.jpg' }}"
                            class="w-32 h-32 rounded-full border-4 border-white object-cover shadow-xl">
                    </div>

                    <!-- Shop Details -->
                    <div class="flex-1">
                        <h1 class="text-3xl font-bold text-gray-900">{{ $shop->name }}</h1>
                        <div class="mt-4 flex items-center space-x-6">
                            <div class="flex items-center">
                                <span class="text-yellow-400 text-xl">★ ★ ★ ★ ☆</span>
                                <span class="ml-2 text-gray-600">(4.5)</span>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-box mr-2"></i>
                                <span>{{ $products_count ?? '0' }} Products</span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex space-x-3 md:self-start">
                        <button class="px-6 py-3 bg-[#915cfc] text-white rounded-lg hover:bg-[#6a4bff] transition-colors">
                            <i class="fas fa-heart mr-2"></i>Follow
                        </button>
                        <button
                            class="px-6 py-3 border-2 border-[#915cfc] text-[#915cfc] rounded-lg hover:bg-purple-50 transition-colors">
                            <i class="fas fa-message mr-2"></i>Contact
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-16">

            <div class="mt-12">
                <div
                    class="flex justify-between items-center bg-white/60 backdrop-blur-sm p-4 rounded-xl border border-purple-100">
                    <h2 class="text-2xl font-bold text-gray-900">Products</h2>
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-50">
                            Sort by
                            <i class="fas fa-chevron-down ml-2"></i>
                        </button>
                        <div x-show="open" @click.away="open = false"
                            class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                            <div class="py-1">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Newest</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Best
                                    Selling</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Price: Low
                                    to High</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Price:
                                    High to Low</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @forelse($products as $product)
                        <a href="{{ route('products.detailBuyer', $product->id) }}">
                            <div class="group">
                                <div
                                    class="relative bg-white/80 backdrop-blur-sm rounded-lg shadow-sm overflow-hidden transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-purple-200/50 border border-purple-50">
                                    <!-- Stock Badge -->
                                    <div class="absolute top-2 right-2">
                                        <div @class([
                                            'px-2 py-1 rounded-full text-xs font-semibold backdrop-blur-md border',
                                            'bg-green-50/80 text-green-700 border-green-200' => $product->stock > 10,
                                            'bg-yellow-50/80 text-yellow-700 border-yellow-200' =>
                                                $product->stock <= 10 && $product->stock > 0,
                                            'bg-red-50/80 text-red-700 border-red-200' => $product->stock == 0,
                                        ])>
                                            <div class="flex items-center space-x-1">
                                                <i @class([
                                                    'fas fa-circle text-[0.5rem]',
                                                    'text-green-500' => $product->stock > 10,
                                                    'text-yellow-500' => $product->stock <= 10 && $product->stock > 0,
                                                    'text-red-500' => $product->stock == 0,
                                                ])></i>
                                                <span>{{ $product->stock > 0 ? $product->stock . ' in stock' : 'Out of stock' }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <img src="{{ asset('storage/' . $product->product_images->first()->image_path) }}"
                                        class="h-48 w-full object-cover">
                                    <div class="p-4">
                                        <h3 class="text-sm font-medium text-gray-900 truncate">{{ $product->name }}</h3>
                                        <p class="mt-1 text-lg font-bold text-[#915cfc]">Rp
                                            {{ number_format($product->price, 0, ',', '.') }}</p>
                                        <div class="mt-2 flex justify-between items-center text-sm text-gray-500">
                                            <span class="flex items-center">
                                                <span class="text-yellow-400">★ ★ ★ ★ ☆</span>
                                                <span class="ml-1">{{ $product->rating }}</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="col-span-full text-center py-12">
                            <i class="fas fa-store-alt-slash text-4xl text-gray-400"></i>
                            <p class="mt-2 text-gray-500">No products available yet</p>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-8 flex justify-center">
                    {{-- {{ $products->links() }} --}}
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            /* Custom color palette */
            :root {
                --primary: #915cfc;
                --primary-dark: #6a4bff;
                --primary-light: #b794f6;
                --secondary: #f0e7ff;
            }

            /* Smooth background animation */
            .bg-gradient-to-br {
                background-size: 400% 400%;
                animation: gradientShift 15s ease infinite;
            }

            @keyframes gradientShift {
                0% {
                    background-position: 0% 50%;
                }

                50% {
                    background-position: 100% 50%;
                }

                100% {
                    background-position: 0% 50%;
                }
            }

            /* Enhanced card hover effects */
            .group:hover div {
                border-color: var(--primary-light);
                box-shadow: 0 20px 25px -5px rgba(145, 92, 252, 0.1),
                    0 10px 10px -5px rgba(145, 92, 252, 0.04);
            }

            /* Glassmorphism effects */
            .backdrop-blur-sm {
                backdrop-filter: blur(8px);
            }

            /* Button hover enhancement */
            button.bg-[#915cfc]:hover {
                background-color: var(--primary-dark);
                box-shadow: 0 4px 12px rgba(145, 92, 252, 0.25);
            }

            button.border-[#915cfc]:hover {
                background-color: var(--secondary);
                border-color: var(--primary-light);
            }

            /* Stock badge animation */
            .group:hover .absolute.top-2.right-2>div {
                transform: scale(1.05);
            }

            .absolute.top-2.right-2>div {
                transition: all 0.3s ease;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            }
        </style>
    @endpush
@endsection
