@extends('adminPage.dashboard')

@section('contentAdmin')
    <div class="p-4">
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 animate-fade-in">
            <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200 transform transition-all duration-300 translate-y-4 opacity-0 animate-slide-up">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 mr-4">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Total Buyers</p>
                        <h3 class="text-2xl font-bold">{{ $buyers->count() }}</h3>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200 transform transition-all duration-300 translate-y-4 opacity-0 animate-slide-up delay-100">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 mr-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">New Buyers (This Month)</p>
                        <h3 class="text-2xl font-bold">{{ $buyers->where('created_at', '>=', now()->startOfMonth())->count() }}</h3>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200 transform transition-all duration-300 translate-y-4 opacity-0 animate-slide-up delay-200">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 mr-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Active Buyers</p>
                        <h3 class="text-2xl font-bold">{{ $buyers->where('status', 'active')->count() }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="bg-white rounded-lg shadow-sm transform transition-all duration-300 translate-y-4 opacity-0 animate-slide-up delay-300">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-semibold text-gray-800">Buyer Management</h2>
                    <a href="{{ route('adminPageBuyer.create') }}"
                        class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors duration-200 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Add New Buyer
                    </a>
                </div>
            </div>

            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <div class="relative w-1/3">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" id="table-search-users"
                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500 text-sm"
                            placeholder="Search buyers...">
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Buyer</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact Info</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($buyers as $buyer)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded-full object-cover"
                                                     src="{{ $buyer->profile_photo ?? 'https://ui-avatars.com/api/?name=' . urlencode($buyer->name) }}"
                                                     alt="{{ $buyer->name }}">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $buyer->name }}</div>
                                                <div class="text-sm text-gray-500">Joined {{ $buyer->created_at->format('M d, Y') }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $buyer->email }}</div>
                                        <div class="text-sm text-gray-500">{{ $buyer->phone }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Active
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="flex justify-center space-x-2">
                                            <a href="{{ route('adminPageBuyer.edit', $buyer->id) }}"
                                                class="text-blue-600 hover:text-blue-900">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('adminPageBuyer.destroy', $buyer->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this buyer?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('table-search-users');
            const tableBody = document.querySelector('tbody');
            let noResultsMessage = null;
            let searchTimeout;

            function performSearch() {
                clearTimeout(searchTimeout);

                searchTimeout = setTimeout(() => {
                    const searchText = searchInput.value.toLowerCase().trim();
                    const rows = tableBody.querySelectorAll('tr');
                    let hasResults = false;

                    rows.forEach((row, index) => {
                        const name = row.querySelector('.text-sm.font-medium').textContent.toLowerCase();
                        const email = row.querySelector('.text-sm.text-gray-900').textContent.toLowerCase();
                        const phone = row.querySelector('.text-sm.text-gray-500').textContent.toLowerCase();

                        if (name.includes(searchText) || email.includes(searchText) || phone.includes(searchText)) {
                            row.style.display = 'table-row';
                            requestAnimationFrame(() => {
                                row.style.opacity = '1';
                                row.style.transform = `translateX(0) scale(1)`;
                                row.style.visibility = 'visible';
                            });
                            hasResults = true;
                        } else {
                            row.style.transform = `translateX(-10px) scale(0.95)`;
                            row.style.opacity = '0';
                            setTimeout(() => {
                                row.style.visibility = 'hidden';
                                row.style.display = 'none';
                            }, 300);
                        }
                    });

                    // Handle no results with smooth transition
                    if (!hasResults) {
                        if (!noResultsMessage) {
                            noResultsMessage = document.createElement('tr');
                            noResultsMessage.style.opacity = '0';
                            noResultsMessage.className = 'animate-fadeIn';
                            noResultsMessage.innerHTML = `
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                    <p class="text-lg">No buyers found matching "${searchText}"</p>
                                    <p class="text-sm mt-2">Try adjusting your search terms</p>
                                </td>
                            `;
                            tableBody.appendChild(noResultsMessage);
                            requestAnimationFrame(() => {
                                noResultsMessage.style.opacity = '1';
                            });
                        }
                    } else if (noResultsMessage) {
                        noResultsMessage.style.opacity = '0';
                        setTimeout(() => noResultsMessage.remove(), 300);
                        noResultsMessage = null;
                    }
                }, 150); // Debounce delay
            }

            // Event listeners remain the same
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
            animation: fadeIn 0.5s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        tbody tr {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            transform-origin: center;
            will-change: transform, opacity, visibility;
        }

        #table-search-users {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .table-container {
            min-height: 200px;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        tr {
            backface-visibility: hidden;
            perspective: 1000px;
        }
    </style>

    <style>
        @keyframes fade-in {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

        @keyframes slide-up {
            0% {
                transform: translateY(1rem);
                opacity: 0;
            }
            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .animate-fade-in {
            animation: fade-in 0.6s ease-out forwards;
        }

        .animate-slide-up {
            animation: slide-up 0.6s ease-out forwards;
        }

        .delay-100 {
            animation-delay: 0.1s;
        }

        .delay-200 {
            animation-delay: 0.2s;
        }

        .delay-300 {
            animation-delay: 0.3s;
        }
    </style>
@endsection
