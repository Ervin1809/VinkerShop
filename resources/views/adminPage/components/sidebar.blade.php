<aside class="h-full bg-gradient-to-b from-white to-gray-50 " aria-label="Sidebar">
    <div class="h-full px-4 py-6 overflow-y-auto">
        <ul class="space-y-1.5 font-medium">
            {{-- Users Section --}}
            <li class="mb-4">
                <span class="px-3 text-xs font-semibold text-gray-400 uppercase">Users Management</span>
                <a href="{{ route('adminPageSeller.index') }}"
                    class="flex items-center px-3 py-2 mt-2 text-sm text-gray-700 rounded-lg hover:bg-purple-50 hover:text-purple-600 transition-colors {{ request()->routeIs('adminPageSeller.index') ? 'bg-purple-50 text-purple-600' : '' }}">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span class="ms-3">Seller</span>
                </a>
                <a href="{{ route('adminPageBuyer.index') }}"
                    class="flex items-center px-3 py-2 mt-1 text-sm text-gray-700 rounded-lg hover:bg-purple-50 hover:text-purple-600 transition-colors {{ request()->routeIs('adminPageBuyer.index') ? 'bg-purple-50 text-purple-600' : '' }}">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span class="ms-3">Buyer</span>
                </a>
            </li>

            {{-- Categories Section --}}
            <li class="mb-4">
                <span class="px-3 text-xs font-semibold text-gray-400 uppercase">Categories</span>
                <a href="{{ route('adminPage.category.index') }}"
                    class="flex items-center px-3 py-2 mt-2 text-sm text-gray-700 rounded-lg hover:bg-purple-50 hover:text-purple-600 transition-colors {{ request()->routeIs('adminPage.category.index') ? 'bg-purple-50 text-purple-600' : '' }}">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                    <span class="ms-3">Category List</span>
                </a>
            </li>

            {{-- Logout Section --}}
            <li class="mt-4 pt-4 border-t border-gray-100">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-3 py-2 text-sm text-gray-700 rounded-lg hover:bg-red-50 hover:text-red-600 transition-colors">
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
