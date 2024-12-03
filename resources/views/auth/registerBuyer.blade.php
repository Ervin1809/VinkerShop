<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased bg-gray-50">
    @include('components.message')
    <div class="min-h-screen flex flex-col justify-center items-center py-6 sm:py-0">
        <!-- Logo -->
        <div class="mt-8">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-indigo-500" />
            </a>
        </div>

        <!-- Registration Card -->
        <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-6 sm:p-8">
            <h2 class="text-xl font-semibold text-center text-gray-800 mb-6">Create Your Account Buyer</h2>
            <form action="{{ route('registerBuyer.store') }}" method="POST">
                @csrf

                {{-- Full Name Input --}}
                <div class="relative z-0 w-full mb-5 group">
                    <input type="name" name="name" id="name"
                        class="block py-2.5 px-0 w-full text-sm text-white bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-slate-600 dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" " required />
                    <label for="name"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Full
                        Name
                    </label>
                </div>

                {{-- Email Input --}}
                <div class="relative z-0 w-full mb-5 group">
                    <input type="email" name="email" id="email"
                        class="block py-2.5 px-0 w-full text-sm text-white bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-slate-600 dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" " required />
                    <label for="email"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                        Email Addres</label>
                </div>

                {{-- Password Input --}}
                <div class="relative z-0 w-full mb-5 group">
                    <input type="password" name="password" id="password"
                        class="block py-2.5 px-0 w-full text-sm text-white bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-slate-600 dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" " required />
                    <label for="password"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Password</label>
                    <button type="button" onclick="togglePasswordVisibility()"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                        <svg id="eye-icon" class="h-5 w-5 text-gray-500" fill="none"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor">
                            <path id="eye-open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path id="eye-open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.522 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z" />
                            <path id="eye-closed" class="hidden" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2"
                                d="M3 3l18 18M9.9 9.9a3 3 0 014.2 4.2M7.05 7.05a7.003 7.003 0 019.9 9.9M12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7a9.978 9.978 0 01-4.95-1.35" />
                        </svg>
                    </button>
                </div>
                
                <!-- Register Button -->
                <div class="mt-6 flex space-x-4">
                    <a href="{{ route('chooseType.create') }}"
                        class="w-full inline-flex items-center justify-center px-4 py-2 bg-[#915cfc] border border-transparent rounded-md font-medium text-white text-sm uppercase tracking-wider hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-150">
                        Back
                    </a>
                    <button type="submit"
                        class="w-full inline-flex items-center justify-center px-4 py-2 bg-[#915cfc] border border-transparent rounded-md font-medium text-white text-sm uppercase tracking-wider hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-150">
                        Register
                    </button>
                </div>
            </form>
            <p class="text-sm text-gray-600 mt-4 text-center">
                Already have an account?
                <a href="{{ route('login') }}" class="text-[#915cfc] hover:underline">Login here</a>
            </p>
        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const eyeOpenIcon = document.querySelector('#eye-icon #eye-open');
            const eyeClosedIcon = document.querySelector('#eye-icon #eye-closed');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeOpenIcon.classList.add('hidden');
                eyeClosedIcon.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeOpenIcon.classList.remove('hidden');
                eyeClosedIcon.classList.add('hidden');
            }
        }
    </script>
</body>

</html>
