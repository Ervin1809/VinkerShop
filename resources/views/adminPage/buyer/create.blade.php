@extends('adminPage.dashboard')

@section('contentAdmin')
    @include('components.message')
    <div class="flex flex-col justify-center items-center min-h-screen p-6 animate-fadeIn">
        <div class="w-full max-w-xl bg-white backdrop-blur-lg bg-opacity-95 rounded-2xl shadow-2xl p-8 transform hover:scale-[1.02] transition-all duration-300 animate-slideUp">
            <div class="mb-8 text-center">
                <h2 class="text-3xl font-bold text-gray-800 mb-2">Create New Account</h2>
                <p class="text-gray-600">Enter the details for the new buyer account</p>
            </div>

            <form action="{{ route('adminPageBuyer.store') }}" method="POST" class="space-y-6">
                @csrf

                {{-- Full Name Input --}}
                <div class="relative group">
                    <input type="name" name="name" id="name"
                        class="block w-full px-4 py-3 text-gray-700 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition-all duration-200"
                        required />
                    <label for="name"
                        class="absolute left-2 -top-2.5 bg-white px-2 text-sm text-purple-600 transition-all duration-200">
                        Full Name
                    </label>
                </div>

                {{-- Email Input --}}
                <div class="relative group">
                    <input type="email" name="email" id="email"
                        class="block w-full px-4 py-3 text-gray-700 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition-all duration-200"
                        required />
                    <label for="email"
                        class="absolute left-2 -top-2.5 bg-white px-2 text-sm text-purple-600 transition-all duration-200">
                        Email Address
                    </label>
                </div>

                {{-- Password Input --}}
                <div class="relative group">
                    <input type="password" name="password" id="password"
                        class="block w-full px-4 py-3 text-gray-700 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition-all duration-200"
                        required />
                    <label for="password"
                        class="absolute left-2 -top-2.5 bg-white px-2 text-sm text-purple-600 transition-all duration-200">
                        Password
                    </label>
                    <button type="button" onclick="togglePasswordVisibility()"
                        class="absolute right-3 top-3 text-gray-400 hover:text-purple-600 transition-colors duration-200">
                        <svg id="eye-icon" class="h-6 w-6" fill="none" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24" stroke="currentColor">
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

                <div class="flex gap-4 pt-4">
                    <a href="{{ route('adminPageBuyer.index') }}"
                        class="w-full py-3 px-4 text-center text-purple-600 bg-purple-50 rounded-lg hover:bg-purple-100 transition-all duration-200 font-medium">
                        Back
                    </a>
                    <button type="submit"
                        class="w-full py-3 px-4 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transform hover:-translate-y-0.5 transition-all duration-200 font-medium">
                        Create Account
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .animate-fadeIn {
            animation: fadeIn 0.6s ease-in;
        }
        .animate-slideUp {
            animation: slideUp 0.5s ease-out 0.3s both;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

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
@endsection
