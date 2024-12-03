@extends('adminPage.dashboard')

@section('contentAdmin')
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-50 to-gray-100 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-lg w-full animate-[fadeIn_0.7s_ease-in-out] motion-reduce:animate-none">
            <div class="bg-white p-8 md:p-10 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.05)] space-y-6 transform animate-[slideUp_0.5s_ease-out] motion-reduce:animate-none">
                <div class="space-y-4">
                    <h2 class="text-3xl font-bold text-center text-gray-900">
                        Edit Category
                    </h2>
                    <div class="h-1 w-20 bg-[#915cfc] mx-auto rounded-full"></div>
                </div>

                <form action="{{ route('category.update', $category->id) }}" method="POST" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <div class="space-y-2">
                            <label for="name" class="block text-sm font-semibold text-gray-700">
                                Category Name
                            </label>
                            <input type="text" name="name" id="name" value="{{ $category->name }}" required
                                class="block w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder:text-gray-400 focus:border-[#915cfc] focus:ring focus:ring-[#915cfc] focus:ring-opacity-20 transition-all duration-300 hover:border-[#915cfc] bg-gray-50/30"
                                placeholder="Enter category name">
                        </div>

                        <div class="space-y-2">
                            <label for="description" class="block text-sm font-semibold text-gray-700">
                                Description
                            </label>
                            <textarea name="description" id="description" required rows="4"
                                class="block w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder:text-gray-400 focus:border-[#915cfc] focus:ring focus:ring-[#915cfc] focus:ring-opacity-20 transition-all duration-300 hover:border-[#915cfc] bg-gray-50/30 resize-none"
                                placeholder="Enter category description">{{ $category->description }}</textarea>
                        </div>
                    </div>

                    <div class="flex items-center justify-between gap-4 pt-4">
                        <a href="{{ route('adminPage.category.index') }}"
                            class="w-full text-center py-3 px-6 text-sm font-medium rounded-xl text-gray-700 bg-gray-100 hover:bg-gray-200 hover:shadow-inner transition-all duration-300">
                            Back
                        </a>

                        <button type="submit"
                            class="w-full py-3 px-6 text-sm font-medium rounded-xl text-white bg-[#915cfc] hover:bg-[#8040ff] hover:shadow-lg hover:shadow-[#915cfc]/30 transition-all duration-300">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
    </style>
@endsection
