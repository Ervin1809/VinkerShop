@extends('adminPage.dashboard')

@section('contentAdmin')
    <div class="container px-6 py-4 animate-fadeIn">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-gray-800 hover:scale-105 transition-transform duration-300">Categories</h2>
            <a href="{{ route('adminPage.category.create') }}"
                class="flex items-center px-4 py-2 bg-[#915cfc] text-white rounded-lg hover:bg-[#7340d3] hover:scale-105 transform transition-all duration-300 ease-in-out">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 animate-bounce" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                        clip-rule="evenodd" />
                </svg>
                Add Category
            </a>
        </div>

        <div class="mb-6">
            <div class="relative transform transition-all duration-300 hover:scale-[1.01]">
                <input type="text" id="search-categories"
                    class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:border-[#915cfc] focus:ring-2 focus:ring-[#915cfc] focus:outline-none transition-all duration-300 ease-in-out"
                    placeholder="Search categories...">
                <svg class="w-5 h-5 text-gray-500 absolute left-3 top-3.5 transition-transform duration-300 hover:scale-110"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>


        {{-- category list --}}
        @if ($categories->isEmpty())
            <div class="text-center py-8 text-gray-500">
                <p class="text-lg">No categories available</p>
                <p class="text-sm mt-2">Please add some categories to get started</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($categories as $category)
                    <div class="cursor-pointer"
                        onclick="window.location='{{ route('adminPage.category.productList', $category->id) }}'">
                        <div
                            class="bg-white rounded-lg shadow-md hover:shadow-xl transform transition-all duration-300 ease-in-out hover:scale-105 hover:-translate-y-1 flex flex-col justify-between h-full">
                            <div class="p-6 flex-grow">
                                <div class="flex justify-between items-start mb-4">
                                    <h3
                                        class="text-xl font-semibold text-gray-800 hover:text-[#915cfc] transition-colors duration-300">
                                        {{ $category->name }}</h3>
                                    <div class="flex space-x-2">
                                        <a href="{{ route('adminPage.category.edit', $category->id) }}"
                                            class="text-blue-600 hover:text-blue-800 transition-all duration-300 hover:scale-110 transform">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path
                                                    d="M17.414 2.586a2 2 0 0 1 0 2.828l-1.828 1.828-2.828-2.828L14.586 2.586a2 2 0 0 1 2.828 0zM2 13.586V17h3.414l9.293-9.293-2.828-2.828L2 13.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('adminPage.category.destroy', $category->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this category?')"
                                            class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 hover:text-red-800 transition-all duration-300 hover:scale-110 transform">
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
                                <p class="text-gray-600 transition-all duration-300 hover:text-gray-900">
                                    {{ $category->description }}</p>
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
                transform: translateY(10px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.4s ease-out forwards;
        }

        .grid>div {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        #search-categories {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .grid {
            min-height: 200px;
            transition: all 0.3s ease-in-out;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search-categories');
            const grid = document.querySelector('.grid');
            let noResultsMessage = null;

            function performSearch() {
                const searchText = searchInput.value.toLowerCase().trim();
                const cards = grid.querySelectorAll('.grid > div');
                let hasResults = false;

                cards.forEach(card => {
                    const categoryName = card.querySelector('h3').textContent.toLowerCase();
                    const categoryDesc = card.querySelector('p').textContent.toLowerCase();

                    if (categoryName.includes(searchText) || categoryDesc.includes(searchText)) {
                        card.style.display = '';
                        setTimeout(() => {
                            card.style.opacity = '1';
                            card.style.transform = 'translateX(0) scale(1)';
                        }, 50);
                        hasResults = true;
                    } else {
                        card.style.opacity = '0';
                        card.style.transform = 'translateX(-10px) scale(0.95)';
                        setTimeout(() => {
                            card.style.display = 'none';
                        }, 300);
                    }
                });

                // Handle no results found
                if (!hasResults) {
                    if (!noResultsMessage) {
                        noResultsMessage = document.createElement('div');
                        noResultsMessage.className = 'col-span-full text-center py-8 text-gray-500 animate-fadeIn';
                        noResultsMessage.innerHTML = `
                            <p class="text-lg">No categories found matching "${searchText}"</p>
                            <p class="text-sm mt-2">Try adjusting your search terms</p>
                        `;
                        grid.appendChild(noResultsMessage);
                    }
                } else if (noResultsMessage) {
                    noResultsMessage.remove();
                    noResultsMessage = null;
                }
            }

            // Add event listeners for real-time search
            searchInput.addEventListener('input', performSearch);
            searchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    searchInput.value = '';
                    performSearch();
                    searchInput.blur();
                }
            });

            // Add loading state
            searchInput.addEventListener('focus', function() {
                this.classList.add('bg-purple-50');
            });


            searchInput.addEventListener('blur', function() {
                this.classList.remove('bg-purple-50');
            });
        });
    </script>
@endsection
