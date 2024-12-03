@extends('adminPage.dashboard')

@section('contentAdmin')
    <div class="p-6 w-full">
        <!-- Dashboard Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Seller Management</h1>
            <a href="{{ route('adminPageSeller.create') }}"
                class="bg-[#915cfc] hover:bg-[#8346ff] text-white px-6 py-2.5 rounded-lg font-medium transition-colors flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Add New Seller
            </a>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <!-- Total Sellers Card -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-blue-50 rounded-lg p-3">
                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-green-500 bg-green-50 px-2.5 py-0.5 rounded-full">+12%</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-700 mb-1">{{ $sellers->count() }}</h3>
                <p class="text-sm text-gray-500">Total Sellers</p>
            </div>

            <!-- Total Orders Card -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-indigo-50 rounded-lg p-3">
                        <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-gray-700 mb-1">{{ number_format($totalOrders) }}</h3>
                <p class="text-sm text-gray-500">Total Orders</p>
            </div>

            <!-- Total Revenue Card -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-green-50 rounded-lg p-3">
                        <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-gray-700 mb-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                <p class="text-sm text-gray-500">Total Revenue</p>
            </div>

            <!-- Average Orders Card -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-yellow-50 rounded-lg p-3">
                        <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-gray-700 mb-1">{{ $avgOrdersPerSeller }}</h3>
                <p class="text-sm text-gray-500">Avg Orders/Seller</p>
            </div>
        </div>

        <!-- Top 3 Sellers Chart -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 mb-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Top 3 Sellers by Sales</h2>
            <canvas id="topSellersChart"></canvas>
        </div>

        <!-- Main Content -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <!-- Search and Filter Header -->
            <div class="p-6 border-b border-gray-100">
                <div class="flex flex-col sm:flex-row gap-4 justify-between">
                    <div class="relative flex-1">
                        <input type="text" id="search-sellers" placeholder="Search sellers..."
                            class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#915cfc] focus:border-transparent transition-all duration-300">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 sticky top-0">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Seller</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Shop
                                Info</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sales
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($sellerYa as $seller)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        @if (\App\Models\User::findOrFail($seller->seller_id)->profilePicture)
                                            <img class="h-10 w-10 rounded-full object-cover"
                                                src="{{ asset('storage/' . \App\Models\User::findOrFail($seller->seller_id)->profilePicture) }}"
                                                alt="{{ $seller->seller_id }}">
                                        @else
                                            <img class="h-10 w-10 rounded-full object-cover"
                                                src="https://ui-avatars.com/api/?name={{ urlencode(\App\Models\User::findOrFail($seller->seller_id)->name) }}&background=915cfc&color=fff"
                                                alt="{{ $seller->seller_id }}">
                                        @endif
                                        <div class="ml-4">
                                            <div class="font-medium text-gray-900">{{ \App\Models\User::findOrFail($seller->seller_id)->name }}</div>
                                            <div class="text-sm text-gray-500">{{ \App\Models\User::findOrFail($seller->seller_id)->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 font-medium">{{ $seller->shopName }}</div>
                                    <div class="text-sm text-gray-500">ID: #{{ $seller->seller_id }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">Rp
                                        {{ number_format($seller->total_sales, 0, ',', '.') }}</div>
                                    <div class="text-sm text-gray-500">{{ $seller->total_order }} orders</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-3 py-1 text-xs font-medium rounded-full
                                        {{ $seller->total_order > $avgOrdersPerSeller ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ $seller->total_order > $avgOrdersPerSeller ? 'High Performing' : 'Average' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">

                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('adminPageSeller.edit', $seller->seller_id) }}"
                                            class="text-gray-400 hover:text-[#915cfc]">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">

                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('adminPageSeller.destroy', $seller->seller_id) }}" method="POST"
                                            class="inline-block"
                                            onsubmit="return confirm('Are you sure you want to delete this seller?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-gray-400 hover:text-red-600">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
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

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-100">
                <!-- Add pagination here if needed -->
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('topSellersChart').getContext('2d');
            var topSellersChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [
                        @foreach($topSellers as $seller)
                            '{{ $seller->shop->shopName }}',
                        @endforeach
                    ],
                    datasets: [{
                        label: 'Total Revenue (Rp)',
                        data: [
                            @foreach($topSellers as $seller)
                                {{ $seller->total_sales }},
                            @endforeach
                        ],
                        backgroundColor: [
                            'rgba(145, 92, 252, 0.4)',
                            'rgba(129, 74, 245, 0.4)',
                            'rgba(112, 56, 237, 0.4)'
                        ],
                        borderColor: [
                            'rgba(145, 92, 252, 1)',
                            'rgba(129, 74, 245, 1)',
                            'rgba(112, 56, 237, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'Revenue: Rp ' + new Intl.NumberFormat('id-ID').format(context.raw);
                                }
                            }
                        }
                    }
                }
            });
        });

        // Add search functionality
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search-sellers');
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
                        const sellerName = row.querySelector('.font-medium.text-gray-900')?.textContent.toLowerCase() || '';
                        const email = row.querySelector('.text-sm.text-gray-500')?.textContent.toLowerCase() || '';
                        const shopName = row.querySelector('.text-sm.text-gray-900.font-medium')?.textContent.toLowerCase() || '';
                        const shopId = row.querySelector('.text-sm.text-gray-500')?.textContent.toLowerCase() || '';

                        if (sellerName.includes(searchText) ||
                            email.includes(searchText) ||
                            shopName.includes(searchText) ||
                            shopId.includes(searchText)) {
                            row.style.display = 'table-row';
                            row.style.visibility = 'visible';
                            requestAnimationFrame(() => {
                                row.style.opacity = '1';
                                row.style.transform = `translateX(0) scale(1)`;
                            });
                            hasResults = true;
                        } else {
                            row.style.opacity = '0';
                            row.style.transform = `translateX(-10px) scale(0.95)`;
                            row.style.position = 'relative';
                            row.style.pointerEvents = 'none';
                            setTimeout(() => {
                                row.style.visibility = 'hidden';
                                row.style.display = 'none';
                                row.style.position = '';
                                row.style.pointerEvents = '';
                            }, 300);
                        }
                    });

                    if (!hasResults) {
                        if (!noResultsMessage) {
                            noResultsMessage = document.createElement('tr');
                            noResultsMessage.style.opacity = '0';
                            noResultsMessage.className = 'animate-fadeIn';
                            noResultsMessage.innerHTML = `
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                    <p class="text-lg">No sellers found matching "${searchText}"</p>
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
                }, 150);
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
            animation: fadeIn 0.4s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        tbody tr {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            transform-origin: center;
            will-change: transform, opacity, visibility;
            backface-visibility: hidden;
            perspective: 1000px;
        }

        #search-sellers {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .table-container {
            min-height: 200px;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>
@endsection
