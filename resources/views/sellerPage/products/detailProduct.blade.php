@extends('sellerPage/dashboard')

@section('contentSeller')
    <style>
        .image-wrapper {
            position: relative;
            overflow: hidden;
        }

        .slide-image {
            transition: all 0.3s ease-in-out;
        }

        .slide-out {
            transform: translateX(-100%);
            opacity: 0;
        }

        .slide-in {
            transform: translateX(0);
            opacity: 1;
        }

        /* Add these new animation classes */
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.5s ease-out, transform 0.5s ease-out;
        }

        .fade-in.active {
            opacity: 1;
            transform: translateY(0);
        }
    </style>

    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-lg p-6 fade-in">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Left Column - Images -->
                <div class="lg:w-1/2">
                    <div class="relative aspect-square mb-4 image-wrapper">
                        <img id="mainImage" src="{{ asset('storage/' . $photos[0]->image_path) }}" alt="Main Product Image"
                            class="w-full h-full object-cover rounded-lg shadow-md slide-image">
                        <img id="nextImage" src="{{ asset('storage/' . $photos[0]->image_path) }}" alt="Next Product Image"
                            class="w-full h-full object-cover rounded-lg shadow-md slide-image absolute top-0 left-0 opacity-0">
                    </div>
                    <div class="overflow-x-auto pb-2">
                        <div class="flex gap-2 min-w-max mt-2 ml-2">
                            @foreach ($photos as $index => $photo)
                                <div class="w-24 aspect-square flex-shrink-0">
                                    <img src="{{ asset('storage/' . $photo->image_path) }}" alt="Product Thumbnail"
                                        onclick="changeMainImage('{{ asset('storage/' . $photo->image_path) }}')"
                                        class="w-full h-full object-cover rounded-md cursor-pointer hover:opacity-75 transition
                                            {{ $index === 0 ? 'ring-2 ring-[#915cfc]' : '' }}">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Right Column - Product Info -->
                <div class="lg:w-1/2">
                    <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $product->name }}</h1>

                    <div class="bg-purple-50 rounded-lg p-4 mb-6">
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-[#915cfc]">{{ $product->formatted_price }}</span>
                            <span class="bg-[#915cfc] text-white px-4 py-1 rounded-full text-sm">
                                Stock: {{ $product->stock }}
                            </span>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h2 class="text-lg font-semibold text-gray-700 mb-2">Category</h2>
                        <div class="inline-block bg-gray-100 px-4 py-2 rounded-full">
                            {{ $product->category->name }}
                        </div>
                    </div>

                    <div class="mb-6">
                        <h2 class="text-lg font-semibold text-gray-700 mb-2">Description</h2>
                        <p class="text-gray-600 leading-relaxed">
                            {{ $product->description }}
                        </p>
                    </div>

                    <div class="flex gap-4">
                        <a href="{{ route('sellerPage.products.index') }}"
                            class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition duration-200 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back
                        </a>
                        <a href="{{ route('products.edit', $product->id) }}"
                            class="px-6 py-3 bg-[#915cfc] hover:bg-[#7340d3] text-white rounded-lg transition duration-200 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit Product
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentImageVisible = 'mainImage';

        // Add this initialization code
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                document.querySelector('.fade-in').classList.add('active');
            }, 100);
        });

        function changeMainImage(imagePath) {
            const mainImage = document.getElementById('mainImage');
            const nextImage = document.getElementById('nextImage');

            // Setup next image
            if (currentImageVisible === 'mainImage') {
                nextImage.src = imagePath;
                nextImage.style.transform = 'translateX(100%)';
                nextImage.style.opacity = '0';

                // Trigger animation
                setTimeout(() => {
                    mainImage.style.transform = 'translateX(-100%)';
                    mainImage.style.opacity = '0';
                    nextImage.style.transform = 'translateX(0)';
                    nextImage.style.opacity = '1';
                }, 50);

                currentImageVisible = 'nextImage';
            } else {
                mainImage.src = imagePath;
                mainImage.style.transform = 'translateX(100%)';
                mainImage.style.opacity = '0';

                // Trigger animation
                setTimeout(() => {
                    nextImage.style.transform = 'translateX(-100%)';
                    nextImage.style.opacity = '0';
                    mainImage.style.transform = 'translateX(0)';
                    mainImage.style.opacity = '1';
                }, 50);

                currentImageVisible = 'mainImage';
            }

            // Update thumbnails
            const thumbnails = document.querySelectorAll('.w-24 img');
            thumbnails.forEach(thumb => {
                if (thumb.src === imagePath) {
                    thumb.classList.add('ring-2', 'ring-[#915cfc]');
                } else {
                    thumb.classList.remove('ring-2', 'ring-[#915cfc]');
                }
            });
        }
    </script>
@endsection
