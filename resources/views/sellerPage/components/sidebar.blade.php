<aside class="h-full bg-gradient-to-b from-white to-gray-50 mt-14" aria-label="Sidebar">
    <div class="h-full px-4 py-6 overflow-y-auto">
        <ul class="space-y-1.5 font-medium">
            {{-- Products Section --}}
            <li class="mb-4">
                <span class="px-3 text-xs font-semibold text-gray-400 uppercase">Products</span>
                <a href="{{ route('sellerPage.products.index') }}"
                    class="flex items-center px-3 py-2 mt-2 text-sm text-gray-700 rounded-lg hover:bg-purple-50 hover:text-purple-600 transition-colors {{ request()->routeIs('sellerPage.products.index') ? 'bg-purple-50 text-purple-600' : '' }}">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    <span class="ms-3">Product List</span>
                </a>
                <a href="{{ route('products.create') }}"
                    class="flex items-center px-3 py-2 mt-1 text-sm text-gray-700 rounded-lg hover:bg-purple-50 hover:text-purple-600 transition-colors {{ request()->routeIs('products.create') ? 'bg-purple-50 text-purple-600' : '' }}">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span class="ms-3">Add Product</span>
                </a>
            </li>

            {{-- Orders Section --}}
            <li class="mb-4">
                <span class="px-3 text-xs font-semibold text-gray-400 uppercase">Orders Management</span>
                <a href="{{ route('seller.orders') }}"
                    class="flex items-center px-3 py-2 mt-2 text-sm text-gray-700 rounded-lg hover:bg-purple-50 hover:text-purple-600 transition-colors {{ request()->routeIs('seller.orders') ? 'bg-purple-50 text-purple-600' : '' }}">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 2H5a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2zm0 18H5V4h14v16z" />
                    </svg>
                    <span class="ms-3">New Orders</span>
                </a>
                <a href="{{ route('seller.shipped') }}"
                    class="flex items-center px-3 py-2 mt-1 text-sm text-gray-700 rounded-lg hover:bg-purple-50 hover:text-purple-600 transition-colors {{ request()->routeIs('seller.shipped') ? 'bg-purple-50 text-purple-600' : '' }}">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8" />
                    </svg>
                    <span class="ms-3">Shipped</span>
                </a>
                <a href="{{ route('seller.completed') }}"
                    class="flex items-center px-3 py-2 mt-1 text-sm text-gray-700 rounded-lg hover:bg-purple-50 hover:text-purple-600 transition-colors {{ request()->routeIs('seller.completed') ? 'bg-purple-50 text-purple-600' : '' }}">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z" />
                    </svg>
                    <span class="ms-3">Completed</span>
                </a>
                <a href="{{ route('seller.cancelled') }}"
                    class="flex items-center px-3 py-2 mt-1 text-sm text-gray-700 rounded-lg hover:bg-purple-50 hover:text-purple-600 transition-colors {{ request()->routeIs('seller.cancelled') ? 'bg-purple-50 text-purple-600' : '' }}">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span class="ms-3">Cancelled</span>
                </a>
            </li>

            {{-- Settings & Logout --}}
            <li class="mt-4 pt-4 border-t border-gray-100">
                <a href="{{ route('seller.settings.index') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 rounded-lg hover:bg-purple-50 hover:text-purple-600 transition-colors">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                    </svg>
                    <span class="ms-3">Settings</span>
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-3 py-2 mt-1 text-sm text-gray-700 rounded-lg hover:bg-red-50 hover:text-red-600 transition-colors">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span class="ms-3">Log Out</span>
                    </button>
                </form>
            </li>
        </ul>
    </div>
</aside>
