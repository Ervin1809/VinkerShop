@extends('adminPage.dashboard')

@section('contentAdmin')
    <style>
        @keyframes slideIn {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-slide-in {
            animation: slideIn 0.6s ease-out forwards;
        }

        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
    </style>

    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-2xl shadow-xl transform transition-all hover:scale-[1.01] opacity-0 animate-slide-in">
            <!-- Decorative Header -->
            <div class="text-center opacity-0 animate-slide-in delay-100">
                <div class="mx-auto h-12 w-12 bg-gradient-to-r from-purple-600 to-indigo-600 rounded-xl flex items-center justify-center">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                </div>
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">Add New Category</h2>
                <p class="mt-2 text-sm text-gray-600">Create a new category for your products</p>
            </div>

            <form action="{{ route('category.store') }}" method="POST" class="mt-8 space-y-6">
                @csrf

                <!-- Category Name Input -->
                <div class="group opacity-0 animate-slide-in delay-200">
                    <label for="name" class="block text-sm font-medium text-gray-700">Category Name</label>
                    <div class="mt-1">
                        <input type="text" name="name" id="name" required
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400
                            focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200
                            hover:border-purple-400"
                            placeholder="Enter category name">
                    </div>
                </div>

                <!-- Description Input -->
                <div class="group opacity-0 animate-slide-in delay-200">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <div class="mt-1">
                        <textarea name="description" id="description" required rows="4"
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400
                            focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200
                            hover:border-purple-400"
                            placeholder="Enter category description"></textarea>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-between space-x-4 mt-8 opacity-0 animate-slide-in delay-300">
                    <a href="{{ route('adminPage.category.index') }}"
                        class="group relative w-1/2 flex justify-center py-2 px-4 border border-gray-300 rounded-lg text-sm font-medium text-gray-700
                        hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all duration-200">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-gray-500 group-hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                        </span>
                        Back
                    </a>
                    <button type="submit"
                        class="group relative w-1/2 flex justify-center py-2 px-4 border border-transparent rounded-lg text-sm font-medium text-white
                        bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700
                        focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all duration-200">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-purple-200 group-hover:text-purple-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                        </span>
                        Add Category
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
