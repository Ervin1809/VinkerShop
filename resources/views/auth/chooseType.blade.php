<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Choose Type</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased bg-gray-50">
    @include('components.message')
    <div class="min-h-screen flex flex-col justify-center items-center py-6 sm:py-0">
        <!-- Logo -->
        <div class="mb-6">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-indigo-500" />
            </a>
        </div>

        <!-- Login Card -->
        <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-6 sm:p-8">
            <h2 class="text-xl font-semibold text-center text-gray-800 mb-6">Choose Your Type Account</h2>
            <form action="{{ route('chooseType.store') }}" method="POST">
                @csrf
                <!-- Type Dropdown -->
                <div class="relative mb-6">
                    <label for="role" class="block text-lg font-extralight text-gray-700">Account Type</label>
                    <select id="role" name="role"
                        class="bg-slate-500 text-slate-600 bg-opacity-10 mt-1 block w-full rounded-md shadow-sm text-lg p-2.5 border border-gray-100 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 appearance-none pr-10"
                        required>
                        <option value="" disabled selected>Select account type</option>
                        <option value="buyer">Buyer</option>
                        <option value="seller">Seller</option>
                        {{-- <option value="admin">Admin</option> --}}
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pt-8 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>

                <!-- Login Button -->
                <div class="mt-6 flex space-x-4">
                    <a href="{{ route('login') }}"
                        class="w-full inline-flex items-center justify-center px-4 py-2 bg-[#915cfc] border border-transparent rounded-md font-medium text-white text-sm uppercase tracking-wider hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-150">
                        Back
                    </a>
                    <button type="submit"
                        class="w-full inline-flex items-center justify-center px-4 py-2 bg-[#915cfc] border border-transparent rounded-md font-medium text-white text-sm uppercase tracking-wider hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-150">
                        Next
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
