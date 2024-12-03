@extends('adminPage.dashboard')

@section('contentAdmin')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-8">
            <div class="flex items-center space-x-4">
                <a href="{{ route('adminPage.category.index') }}"
                    class="text-gray-600 hover:text-gray-900 transition-all duration-300 ease-in-out transform hover:scale-105">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <h1 class="text-3xl font-bold text-gray-900">Products</h1>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach ($categories as $category)
                <div
                    class="bg-white rounded-lg shadow-lg overflow-hidden transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                    <div class="relative">
                        <img src="{{ asset('storage/' . $category->product_images->first()->image_path) }}"
                            alt="{{ $category->name }}" class="w-full h-48 object-cover">
                        <span class="absolute top-2 right-2 bg-indigo-600 text-white px-2 py-1 rounded-full text-sm">
                            {{ $category->stock }} in stock
                        </span>
                    </div>

                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $category->name }}</h3>
                        <p class="text-gray-600 text-sm mb-4">{{ Str::limit($category->description, 100) }}</p>

                        <div class="flex items-center justify-between">
                            <span class="text-indigo-600 font-bold">${{ number_format($category->price, 2) }}</span>
                            <div class="flex space-x-2">
                                <form action="{{ route('adminPage.category.destroy', $category->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this product?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="p-2 text-red-600 hover:bg-red-50 rounded-full transition-colors duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="mt-4">
                            <div class="w-full bg-gray-200 rounded-full h-1.5">
                                <div class="bg-green-500 h-1.5 rounded-full"
                                    style="width: {{ ($category->stock / 100) * 100 }}%"></div>
                            </div>
                            <p class="text-gray-500 text-xs mt-2">Last updated: {{ $category->updated_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
