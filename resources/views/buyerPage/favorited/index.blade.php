@extends('buyerPage/dashboard')

@section('contentBuyer')
    <div class="container mx-auto px-4 py-8 opacity-0 animate-fadeIn">
        <h1 class="text-3xl font-bold mb-8 text-center">My Favorite Products</h1>

        @if ($favorites->isEmpty())
            <div class="text-center py-12 opacity-0 animate-fadeIn" style="animation-delay: 0.2s">
                <div class="text-gray-500 text-xl mb-4">No favorite products yet</div>
                <a href="{{ route('buyer.products.index') }}" class="bg-[#915cfc] hover:bg-[#6a4bff] text-white px-4 py-2 rounded-md text-sm font-medium transition duration-300 ease-in-out">
                    Browse Products
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($favorites as $favorite)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 opacity-0 animate-fadeIn"
                         style="animation-delay: {{ $loop->index * 0.1 }}s">
                        <div class="relative pb-[100%]">
                            <img src="{{ asset('storage/' . $favorite->product->product_images->first()->image_path) }}"
                                alt="{{ $favorite->product->name }}" class="absolute h-full w-full object-cover">
                        </div>
                        <div class="p-4">
                            <h3 class="text-lg font-semibold mb-2">{{ $favorite->product->name }}</h3>
                            <p class="text-gray-600 mb-2 line-clamp-2">{{ $favorite->product->description }}</p>
                            <div class="flex flex-col gap-3">
                                <span class="text-lg font-semibold text-gray-800">
                                    Rp{{ number_format($favorite->product->price, 0, ',', '.') }}
                                </span>
                                <div class="flex justify-between items-center">
                                    <form action="{{ route('favorite.store', $favorite->product->id) }}" method="POST" class="flex gap-2 group">
                                        @csrf
                                        @if ($favorite)
                                            <button type="submit"
                                                class="text-red-500 transform transition-all duration-300 hover:scale-125 active:scale-95">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                                    class="w-6 h-6 animate-bounce">
                                                    <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
                                                </svg>
                                            </button>
                                            <p class="favorite-label font-medium transition-all duration-300 text-red-500 group-hover:translate-x-1">
                                                <span class="inline-block animate-pulse">Favorited</span>
                                            </p>
                                        @else
                                            <button type="submit"
                                                class="text-gray-400 transform transition-all duration-300 hover:scale-125 hover:text-red-500 active:scale-95 hover:rotate-12">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor"
                                                    class="w-6 h-6 transition-all duration-300 hover:stroke-2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                                </svg>
                                            </button>
                                            <p class="favorite-label font-medium text-gray-500 transition-all duration-300 group-hover:text-red-500 group-hover:translate-x-1">
                                                Add to Favorites
                                            </p>
                                        @endif
                                    </form>
                                    <a href="{{ route('products.detailBuyer', $favorite->product->id) }}"
                                        class="bg-[#915cfc] hover:bg-[#6a4bff] text-white px-4 py-2 rounded-md text-sm font-medium transition duration-300 ease-in-out">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
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

        .animate-fadeIn {
            animation: fadeIn 0.5s ease-out forwards;
        }
    </style>
@endsection
