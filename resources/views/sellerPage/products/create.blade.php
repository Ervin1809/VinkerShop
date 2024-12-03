@extends('sellerPage/dashboard')

@section('contentSeller')
    <div class="max-w-4xl mx-auto p-6 animate-fade-in">
        <h2 class="text-2xl font-bold text-gray-800 mb-8 text-center animate-slide-down">Add New Product</h2>

        <div class="bg-white rounded-xl shadow-lg overflow-hidden transform hover:shadow-2xl transition-all duration-300">
            <div class="p-8">
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Product Name -->
                    <div class="form-group">
                        <label class="text-sm font-semibold text-gray-700 mb-2 block">Product Name</label>
                        <input type="text" name="productName" value="{{ old('productName') }}"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-400 focus:border-transparent transition-all duration-200 ease-in-out bg-gray-50 hover:bg-gray-100"
                            placeholder="Enter product name">
                    </div>

                    <!-- Description -->
                    <div class="form-group">
                        <label class="text-sm font-semibold text-gray-700 mb-2 block">Description</label>
                        <textarea name="description" rows="4"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-400 focus:border-transparent transition-all duration-200 ease-in-out bg-gray-50 hover:bg-gray-100"
                            placeholder="Describe your product">{{ old('description') }}</textarea>
                    </div>

                    <!-- Price and Stock -->
                    <div class="grid grid-cols-2 gap-6">
                        <div class="form-group">
                            <label class="text-sm font-semibold text-gray-700 mb-2 block">Price</label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-gray-500">Rp</span>
                                <input type="number" name="price" value="{{ old('price') }}"
                                    class="w-full pl-12 pr-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-400 focus:border-transparent transition-all duration-200 ease-in-out bg-gray-50 hover:bg-gray-100"
                                    step="1000">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="text-sm font-semibold text-gray-700 mb-2 block">Stock</label>
                            <input type="number" name="stock" value="{{ old('stock') }}"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-400 focus:border-transparent transition-all duration-200 ease-in-out bg-gray-50 hover:bg-gray-100"
                                min="1">
                        </div>
                    </div>

                    <!-- Image Upload -->
                    <div class="form-group">
                        <label class="text-sm font-semibold text-gray-700 mb-2 block">Product Images</label>
                        <div class="grid grid-cols-4 gap-4">
                            @for ($i = 0; $i < 4; $i++)
                                <div class="relative group" id="image-container-{{ $i }}">
                                    <div
                                        class="w-full h-32 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center bg-gray-50 hover:bg-gray-100 transition-all duration-200">
                                        <img src="" alt=""
                                            class="hidden w-full h-32 object-cover rounded-lg"
                                            id="preview-{{ $i }}">
                                        <div class="upload-placeholder">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                        </div>
                                    </div>
                                    <input type="file" name="photo[]" id="photo-{{ $i }}"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                        onchange="previewImage(event, {{ $i }})">

                                    <div class="hidden" id="overlay-{{ $i }}">
                                        <div
                                            class="absolute inset-0 bg-black bg-opacity-50 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200 items-center justify-center flex ">
                                            <button type="button" onclick="clearImage({{ $i }})"
                                                class="text-white hover:text-red-400">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>

                    <!-- Category -->
                    <div class="form-group">
                        <label class="text-sm font-semibold text-gray-700 mb-2 block">Category</label>
                        <div class="relative">
                            <select name="category_id"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-400 focus:border-transparent transition-all duration-200 ease-in-out bg-gray-50 hover:bg-gray-100 appearance-none">
                                <option value="" disabled selected>Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end space-x-4 pt-6">
                        <button type="submit"
                            class="px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transform hover:-translate-y-0.5 transition-all duration-200">
                            Add Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function previewImage(event, id) {
            const file = event.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            const preview = document.getElementById(`preview-${id}`);
            const placeholder = event.target.parentElement.querySelector('.upload-placeholder');
            const overlay = document.getElementById(`overlay-${id}`);

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
                overlay.classList.remove('hidden');
            };

            reader.readAsDataURL(file);
        }

        function clearImage(id) {
            const container = document.getElementById(`image-container-${id}`);
            const preview = document.getElementById(`preview-${id}`);
            const placeholder = container.querySelector('.upload-placeholder');
            const overlay = document.getElementById(`overlay-${id}`);
            const input = document.getElementById(`photo-${id}`);

            preview.src = '';
            preview.classList.add('hidden');
            placeholder.classList.remove('hidden');
            overlay.classList.add('hidden');
            input.value = '';
        }
    </script>
    <style>
        .form-group {
            @apply relative;
            animation: slideUp 0.5s ease-out forwards;
            opacity: 0;
        }

        .form-group:nth-child(1) { animation-delay: 0.1s; }
        .form-group:nth-child(2) { animation-delay: 0.2s; }
        .form-group:nth-child(3) { animation-delay: 0.3s; }
        .form-group:nth-child(4) { animation-delay: 0.4s; }
        .form-group:nth-child(5) { animation-delay: 0.5s; }

        .form-group:focus-within label {
            @apply text-purple-600;
            transform: translateY(-2px);
            transition: all 0.3s ease;
        }

        input, textarea, select {
            transition: all 0.3s ease;
        }

        input:focus, textarea:focus, select:focus {
            transform: scale(1.01);
        }

        .upload-placeholder {
            transition: all 0.3s ease;
        }

        .upload-placeholder:hover svg {
            transform: scale(1.1);
            transition: transform 0.3s ease;
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

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }

        .animate-slide-down {
            animation: slideDown 0.5s ease-out forwards;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endsection
