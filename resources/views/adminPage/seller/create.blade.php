@extends('adminPage.dashboard')

@section('contentAdmin')
    @include('components.message')
    <div class="min-h-screen flex flex-col justify-center items-center p-4 bg-gray-50">
        <div class="w-full max-w-4xl">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <!-- Header Section -->
                <div class="bg-gradient-to-r from-purple-600 to-indigo-600 p-8">
                    <h2 class="text-3xl font-bold text-white text-center">Create Seller Account</h2>
                    <p class="text-white/80 text-center mt-2">Fill in the details to register a new seller</p>
                </div>

                <!-- Form Section -->
                <div class="p-8">
                    <form action="{{ route('adminPageSeller.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Full Name Input -->
                            <div class="form-group">
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                                <input type="text" name="name" id="name"
                                    class="form-input w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-600 focus:border-transparent transition duration-200"
                                    required placeholder="Enter full name">
                            </div>

                            <!-- Email Input -->
                            <div class="form-group">
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                                <input type="email" name="email" id="email"
                                    class="form-input w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-600 focus:border-transparent transition duration-200"
                                    required placeholder="Enter email address">
                            </div>

                            <!-- Password Input -->
                            <div class="form-group relative">
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                                <div class="relative">
                                    <input type="password" name="password" id="password"
                                        class="form-input w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-600 focus:border-transparent transition duration-200"
                                        required placeholder="Enter password">
                                    <button type="button" onclick="togglePasswordVisibility()"
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2">
                                        <svg class="h-5 w-5 text-gray-500" fill="none" id="eye-icon" viewBox="0 0 24 24" stroke="currentColor">
                                            <path id="eye-open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path id="eye-open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.522 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z" />
                                            <path id="eye-closed" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 3l18 18M9.9 9.9a3 3 0 014.2 4.2M7.05 7.05a7.003 7.003 0 019.9 9.9M12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7a9.978 9.978 0 01-4.95-1.35" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Shop Name Input -->
                            <div class="form-group">
                                <label for="shopName" class="block text-sm font-medium text-gray-700 mb-2">Shop Name</label>
                                <input type="text" name="shopName" id="shopName"
                                    class="form-input w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-600 focus:border-transparent transition duration-200"
                                    required placeholder="Enter shop name">
                            </div>

                            <!-- Phone Input -->
                            <div class="form-group md:col-span-2">
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                                <input type="tel" name="phone" id="phone"
                                    class="form-input w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-600 focus:border-transparent transition duration-200"
                                    required placeholder="Enter phone number (e.g., 082-333-444-555)">
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="mt-8 flex space-x-4">
                            <a href="{{ route('adminPageSeller.index') }}"
                                class="w-full bg-gray-100 text-gray-800 hover:bg-gray-200 font-semibold py-3 px-6 rounded-lg transition duration-200 text-center">
                                Back
                            </a>
                            <button type="submit"
                                class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-semibold py-3 px-6 rounded-lg hover:opacity-90 transition duration-200">
                                Register Seller
                            </button>
                        </div>
                    </form>
                </div>
            </div>
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
@endsection
