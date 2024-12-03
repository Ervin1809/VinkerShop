@extends('adminPage.dashboard')

@section('contentAdmin')
    @include('components.message')
    <div x-data="{ showForm: false }"
         x-init="setTimeout(() => showForm = true, 100)"
         class="flex flex-col justify-center items-center mt-16 py-6 sm:py-0">
        <div x-show="showForm"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform scale-90"
             x-transition:enter-end="opacity-100 transform scale-100"
             class="w-full max-w-4xl">
            <div class="bg-white shadow-2xl rounded-lg p-6 sm:p-8 transform hover:scale-[1.01] transition-transform duration-300">
                <div class="mb-8 text-center">
                    <h2 class="text-2xl font-bold text-gray-800">Edit Buyer Account</h2>
                    <p class="text-gray-600 mt-2">Update buyer information below</p>
                </div>

                <form action="{{ route('adminPageBuyer.update', $buyer->id) }}" method="POST"
                      class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Full Name Input --}}
                    <div class="group relative transform transition-all duration-300 hover:-translate-y-1">
                        <input type="name" name="name" id="name"
                            class="peer block w-full border-b-2 border-gray-300 py-3 px-4 text-gray-800 focus:border-[#915cfc] focus:outline-none bg-transparent"
                            placeholder=" " value="{{ $buyer->name }}" required />
                        <label class="absolute left-4 top-3 -translate-y-6 scale-75 text-gray-500 duration-300 peer-placeholder-shown:translate-y-0 peer-placeholder-shown:scale-100 peer-focus:-translate-y-6 peer-focus:scale-75 peer-focus:text-[#915cfc]">
                            Full Name
                        </label>
                    </div>

                    {{-- Email Input --}}
                    <div class="group relative transform transition-all duration-300 hover:-translate-y-1">
                        <input type="email" name="email" id="email"
                            class="peer block w-full border-b-2 border-gray-300 py-3 px-4 text-gray-800 focus:border-[#915cfc] focus:outline-none bg-transparent"
                            placeholder=" " value="{{ $buyer->email }}" required />
                        <label class="absolute left-4 top-3 -translate-y-6 scale-75 text-gray-500 duration-300 peer-placeholder-shown:translate-y-0 peer-placeholder-shown:scale-100 peer-focus:-translate-y-6 peer-focus:scale-75 peer-focus:text-[#915cfc]">
                            Email Address
                        </label>
                    </div>

                    {{-- Password Input --}}
                    <div class="group relative transform transition-all duration-300 hover:-translate-y-1">
                        <input type="password" name="password" id="password"
                            class="peer block w-full border-b-2 border-gray-300 py-3 px-4 text-gray-800 focus:border-[#915cfc] focus:outline-none bg-transparent"
                            placeholder=" " />
                        <label class="absolute left-4 top-3 -translate-y-6 scale-75 text-gray-500 duration-300 peer-placeholder-shown:translate-y-0 peer-placeholder-shown:scale-100 peer-focus:-translate-y-6 peer-focus:scale-75 peer-focus:text-[#915cfc]">
                            New Password (leave empty to keep current)
                        </label>
                        <button type="button" onclick="togglePasswordVisibility()"
                            class="absolute right-0 mr-3 top-3 text-gray-500 hover:text-[#915cfc] transition-colors">
                            <svg id="eye-icon" class="h-5 w-5" fill="none" xmlns="http://www.w3.org/2000/svg"
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

                    <!-- Buttons -->
                    <div class="flex space-x-4 mt-8">
                        <a href="{{ route('adminPageBuyer.index') }}"
                            class="w-full py-3 px-4 text-center text-white bg-gray-500 hover:bg-gray-600 rounded-lg transition-colors duration-300 transform hover:scale-[1.02]">
                            Cancel
                        </a>
                        <button type="submit"
                            class="w-full py-3 px-4 text-white bg-[#915cfc] hover:bg-[#7847d4] rounded-lg transition-colors duration-300 transform hover:scale-[1.02]">
                            Update Account
                        </button>
                    </div>
                </form>
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
