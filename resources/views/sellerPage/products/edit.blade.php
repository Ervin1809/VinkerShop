@extends('sellerPage/dashboard')

@section('contentSeller')
    <div class="max-w-4xl mx-auto p-6 opacity-0 animate-fade-down">
        <h2 class="text-2xl font-bold text-gray-800 mb-8 text-center">Edit Product</h2>

        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="p-8">
                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Product Name -->
                    <div class="form-group">
                        <label class="text-sm font-semibold text-gray-700 mb-2 block">Product Name</label>
                        <input type="text" name="productName" value="{{ $product->name }}"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-400 focus:border-transparent transition-all duration-200 ease-in-out bg-gray-50 hover:bg-gray-100"
                            placeholder="Enter product name">
                    </div>

                    <!-- Description -->
                    <div class="form-group">
                        <label class="text-sm font-semibold text-gray-700 mb-2 block">Description</label>
                        <textarea name="description" rows="4"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-400 focus:border-transparent transition-all duration-200 ease-in-out bg-gray-50 hover:bg-gray-100"
                            placeholder="Describe your product">{{ $product->description }}</textarea>
                    </div>

                    <!-- Price and Stock -->
                    <div class="grid grid-cols-2 gap-6">
                        <div class="form-group">
                            <label class="text-sm font-semibold text-gray-700 mb-2 block">Price</label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-gray-500">Rp</span>
                                <input type="number" name="price" value="{{ $product->price }}"
                                    class="w-full pl-12 pr-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-400 focus:border-transparent transition-all duration-200 ease-in-out bg-gray-50 hover:bg-gray-100"
                                    step="1000">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="text-sm font-semibold text-gray-700 mb-2 block">Stock</label>
                            <input type="number" name="stock" value="{{ $product->stock }}"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-400 focus:border-transparent transition-all duration-200 ease-in-out bg-gray-50 hover:bg-gray-100"
                                min="1">
                        </div>
                    </div>

                    <!-- Image Upload -->
                    <div class="form-group">
                        <label class="text-sm font-semibold text-gray-700 mb-2 block">Product Images</label>
                        <div class="grid grid-cols-4 gap-4">
                            @foreach ($photos as $index => $image)
                                <div class="relative group">
                                    <div class="w-full h-32 border-2 border-gray-300 rounded-lg overflow-hidden">
                                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="Product Image"
                                            class="w-full h-full object-cover transition-transform duration-200 group-hover:scale-105"
                                            id="image-{{ $image->id }}">
                                    </div>

                                    <!-- Input file tersembunyi -->
                                    <input type="file" name="photo[{{ $image->id }}]" class="hidden"
                                        id="file-input-{{ $image->id }}"
                                        onchange="previewImage(event, {{ $image->id }})">

                                    <!-- Checkbox tersembunyi untuk menandai perubahan -->
                                    <input type="checkbox" name="delete_photos[]" value="{{ $image->id }}"
                                        class="delete-photo-checkbox hidden" id="delete-photo-{{ $image->id }}">

                                    <!-- Overlay efek hover dengan onclick -->
                                    <div class="absolute inset-0 bg-black bg-opacity-50 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex items-center justify-center cursor-pointer"
                                        onclick="toggleInputAndCheckbox({{ $image->id }})">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </div>
                                </div>
                            @endforeach

                            @for ($i = count($photos); $i < 4; $i++)
                                <div class="relative">
                                    <div
                                        class="w-full h-32 border-2 border-dashed border-gray-300 rounded-lg overflow-hidden">
                                        <img src="" alt="" class="hidden w-full h-full object-cover"
                                            id="preview-new-{{ $i }}">
                                        <div class="upload-placeholder flex items-center justify-center h-full">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                        </div>
                                    </div>
                                    <input type="file" name="photo[]"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                        id="file-input-new-{{ $i }}"
                                        onchange="previewNewImage(event, {{ $i }})">
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
                                <option value="" disabled>Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
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

                    <!-- Buttons -->
                    <div class="flex justify-end space-x-4 pt-6">
                        <a href="{{ route('sellerPage.products.index') }}"
                            class="px-6 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transform hover:-translate-y-0.5 transition-all duration-200">
                            Back
                        </a>
                        <button type="submit"
                            class="px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transform hover:-translate-y-0.5 transition-all duration-200">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .form-group {
            @apply relative;
        }

        .form-group:focus-within label {
            @apply text-purple-600;
        }

        /* Animation keyframes */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
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

        @keyframes fadeDown {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-down {
            animation: fadeDown 0.8s ease-out forwards;
        }

        /* Staggered animations for form elements */
        .form-group {
            opacity: 0;
            transform: translateY(20px);
            animation: formSlideUp 0.5s ease-out forwards;
        }

        @keyframes formSlideUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-group:nth-child(1) { animation-delay: 0.3s; }
        .form-group:nth-child(2) { animation-delay: 0.4s; }
        .form-group:nth-child(3) { animation-delay: 0.5s; }
        .form-group:nth-child(4) { animation-delay: 0.6s; }
        .form-group:nth-child(5) { animation-delay: 0.7s; }
    </style>

    <script>
        // Fungsi untuk menampilkan input file dan checkbox saat gambar diklik
        function toggleInputAndCheckbox(photoId) {
            const fileInput = document.getElementById('file-input-' + photoId);
            const checkbox = document.getElementById('delete-photo-' + photoId);

            fileInput.click();
            checkbox.checked = true;
        }

        // Fungsi untuk preview gambar yang dipilih
        function previewImage(event, id) {
            const file = event.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            const img = document.getElementById('image-' + id);

            reader.onload = function(e) {
                img.src = e.target.result;
            }

            reader.readAsDataURL(file);
        }

        function previewNewImage(event, id) {
            const file = event.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            const preview = document.getElementById(`preview-new-${id}`);
            const placeholder = event.target.parentElement.querySelector('.upload-placeholder');

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            };

            reader.readAsDataURL(file);
        }
    </script>
@endsection
