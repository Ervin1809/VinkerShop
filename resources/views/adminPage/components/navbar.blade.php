<nav class="fixed z-50 w-full bg-white shadow-md transition-all duration-300 ease-in-out">
    <div class="max-w-screen-xl flex items-center justify-between mx-auto py-3 px-4">
        {{-- Logo dan Nama Toko --}}
        <a href="#" class="flex items-center group hover:opacity-90 transition-opacity duration-200">
            <div class="w-12 h-12 flex items-center">
                <x-logoVinkerPurple alt="Store Logo" />
            </div>
            <div class="ml-3 flex flex-col justify-center">
                <span class="text-xl font-bold bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent leading-tight">
                    VINKER
                </span>
                <span class="text-xs font-medium text-gray-600">Admin Center</span>
            </div>
        </a>

        <div class="flex items-center space-x-6">
            <div class="flex items-center">
                <a href="" class="px-4 py-2 rounded-full bg-gradient-to-r from-purple-50 to-indigo-50
                    hover:from-purple-100 hover:to-indigo-100 transition-all duration-300 group">
                    <div class="flex items-center space-x-3">
                        <img src="{{ asset('storage/'. Auth::user()->profilePicture) }}"
                            alt="Admin Image"
                            class="w-8 h-8 rounded-full object-cover border-2 border-purple-200"
                            onerror="this.src='https://upload.wikimedia.org/wikipedia/commons/thumb/2/2c/Default_pfp.svg/1200px-Default_pfp.svg.png'">
                        <span class="font-semibold text-gray-700 group-hover:text-purple-600 transition-colors duration-200">
                            {{ Auth::user()->name }}
                        </span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</nav>
