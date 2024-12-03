@extends('sellerPage/dashboard')

@section('contentSeller')
    <div class="container mx-auto px-4 py-8 animate-fade-in">
        @if ($products->isEmpty())
            <div class="flex flex-col items-center justify-center h-[580px] bg-gray-50 rounded-lg animate-slide-up">
                <svg class="w-20 h-20 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
                <h3 class="text-2xl font-semibold text-gray-600">No Products Found</h3>
                <p class="text-gray-500 mt-2">Start adding your products to see them here</p>
                <a href="{{ route('products.create') }}"
                    class="mt-4 px-6 py-2 bg-[#915cfc] hover:bg-[#6a4bff] text-white rounded-lg transition-colors">
                    Add Your First Product
                </a>
            </div>
        @else
            <div class="flex justify-between items-center mb-6 animate-slide-up">
                <h2 class="text-2xl font-bold text-gray-800">Your Products</h2>
                <a href="{{ route('products.create') }}"
                    class="px-4 py-2 bg-[#915cfc] hover:bg-[#6a4bff] text-white rounded-lg transition-colors ">
                    + Add New Product
                </a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach ($products as $product)
                    <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 animate-slide-up"
                         style="animation-delay: {{ $loop->iteration * 0.1 }}s">
                        <div class="relative">
                            <img src="{{ asset('storage/' . $product->product_images->first()->image_path) }}"
                                alt="{{ $product->name }}" class="w-full h-40 object-cover rounded-t-xl"
                                onerror="this.src='https://via.placeholder.com/300x200?text=No+Image'">

                            <div class="absolute top-2 right-2 flex space-x-1">
                                <a href="{{ route('products.edit', $product->id) }}"
                                    class="p-1.5 bg-white rounded-full shadow hover:bg-gray-100 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#915cfc]"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path
                                            d="M17.414 2.586a2 2 0 0 1 0 2.828l-1.828 1.828-2.828-2.828L14.586 2.586a2 2 0 0 1 2.828 0zM2 13.586V17h3.414l9.293-9.293-2.828-2.828L2 13.586z" />
                                    </svg>
                                </a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this product?')"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="p-1.5 bg-white rounded-full shadow hover:bg-red-50 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="p-3">
                            <h3 class="text-base font-semibold text-gray-800 mb-1 truncate">{{ $product->name }}</h3>
                            <p class="text-gray-600 text-xs mb-2 line-clamp-2">{{ $product->description }}</p>

                            <div class="flex justify-between items-center mb-2">
                                <span class="px-2 py-0.5 bg-gray-100 text-gray-600 rounded-full text-xs">
                                    {{ $product->category->name }}
                                </span>
                                <span class="text-sm font-bold text-[#915cfc]">
                                    {{ $product->formatted_price }}
                                </span>
                            </div>

                            <a href="{{ route('products.detail', $product->id) }}"
                                class="block w-full text-center py-1.5 text-sm border border-[#915cfc] text-[#915cfc] rounded-lg hover:bg-[#915cfc] hover:text-white transition-colors">
                                View Details
                            </a>
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
            }
            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
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
            animation: fadeIn 0.6s ease-out forwards;
        }

        .animate-slide-up {
            animation: slideUp 0.6s ease-out forwards;
            opacity: 0;
        }

        .hover\:bg-\[\#6a4bff\]:hover {
            background-color: #6a4bff;
        }
    </style>
@endsection
