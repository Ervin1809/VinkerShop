<!-- Login and Register Buttons -->
<nav class="border-gray-200 bg-[#915cfc]">
    @if(Auth::guest())
        <div class="flex justify-end p-2 gap-2 border">
            <a href="{{ route('login') }}" class="border-2 px-3 py-1 text-white rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                Login
            </a>
            <a href="{{ route('login') }}" class="border-2 px-3 py-1 text-white rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                Register
            </a>
        </div>
    @endguest

    <div class="max-w-screen-xl flex items-center justify-between mx-auto p-2">
        <!-- Logo dan Nama Toko -->
        <a href="{{ route('buyer.products.index') }}" class="flex items-center rtl:space-x-reverse ml-4 hover:opacity-55">
            <x-logoVinkerWhite alt="Store Logo" />
            <span class="ml-4 text-2xl font-extrabold text-white tracking-widest ">V I N K E R</span>
        </a>

        <!-- Search Bar (dengan wrapper Flexbox) -->
        @if (!in_array(Route::currentRouteName(), ['cart.index', 'favorite.index', 'order.success']))
            <div class="flex-1 flex justify-center">
                <div class="relative w-2/4">
                    <form action="{{ route('buyer.products.index') }}" method="GET" class="relative">
                        <input type="text" name="search" id="search-navbar"
                            class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Search..."
                            value="{{ request('search') }}">
                        <button type="submit" class="absolute inset-y-0 left-0 flex items-center ps-3 hover:opacity-75">
                            <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        @endif

        <!-- Icon Keranjang atau Kembali -->
        <div class="flex items-center ml-14 mr-12">
            @if (Route::currentRouteName() === 'cart.index')
                <!-- Icon Kembali -->
                <a href="{{ route('buyer.products.index') }}" class="p-2 text-white rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                    <svg class="w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
            @else
                <!-- Icon Keranjang -->
                <a href="{{ route('cart.index') }}" class="p-2 text-white rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                    <svg class="w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l1.5-6H6.4M7 13l-1.5 6h13L17 13M7 13h10M7 13l-1.5 6m0 0H17l1.5-6m-13 6a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zm15 0a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                    </svg>
                </a>
            @endif
        </div>
    </div>
</nav>

<style>
    nav {
        background: linear-gradient(to right, #915cfc, #6a4bff);
    }

    /* Add logo hover animation */
    a.flex.items-center {
        transition: transform 0.3s ease-in-out;
    }

    a.flex.items-center:hover {
        transform: scale(1.05);
    }
</style>
