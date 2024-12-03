@extends('buyerPage/dashboard')

{{-- Add Font Awesome in the head section --}}
@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
@endpush

@section('contentBuyer')
    <div class="container mx-auto px-4 py-8 animate-fade-in-up">
        <h2 class="text-3xl font-bold text-gray-800 mb-8">Account Settings</h2>

        <div class="flex flex-col md:flex-row gap-6">
            <!-- Navigation Tabs -->
            <div class="md:w-1/4">
                <div class="bg-white rounded-xl shadow-sm p-4 space-y-2">
                    <button type="button" data-tab="profile"
                        class="w-full flex items-center px-4 py-3 rounded-lg transition-all duration-300 ease-in-out nav-item active bg-gradient-to-r from-[#915cfc] to-[#6a4bff] text-white">
                        <i class="fas fa-user mr-3"></i> Profile
                    </button>
                    <button type="button" data-tab="security"
                        class="w-full flex items-center px-4 py-3 rounded-lg hover:bg-purple-50 text-gray-700 hover:text-[#915cfc] transition-all duration-300 ease-in-out nav-item">
                        <i class="fas fa-shield-alt mr-3"></i> Security
                    </button>
                    <button type="button" data-tab="references"
                        class="w-full flex items-center px-4 py-3 rounded-lg hover:bg-purple-50 text-gray-700 hover:text-[#915cfc] transition-all duration-300 ease-in-out nav-item">
                        <i class="fas fa-cog mr-3"></i> References
                    </button>
                </div>
            </div>

            <!-- Content -->
            <div class="md:w-3/4">
                <div class="tab-content">
                    <!-- Profile Section -->
                    <div id="profile"
                        class="tab-pane min-h-[500px] transform transition-all duration-300 ease-in-out opacity-100 scale-100">
                        <div class="bg-white rounded-xl shadow-sm p-6">
                            <h5 class="text-xl font-semibold text-gray-800 pb-4 mb-6 border-b">Profile Information</h5>

                            <form action="{{ route('profile.update', Auth::user()->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="flex justify-center mb-6">
                                    <div class="relative group">
                                        <!-- Container Avatar -->
                                        @if (Auth::user()->profilePicture == null)
                                            <div
                                                class="w-32 h-32 rounded-full overflow-hidden ring-4 ring-gray-200 bg-gradient-to-tr from-gray-100 via-gray-200 to-gray-300 shadow-md">
                                                <img id="avatar-preview"
                                                    src="{{ asset('storage/' . Auth::user()->profilePicture) }}"
                                                    class="w-full h-full object-cover">
                                            </div>
                                            <!-- Overlay Upload -->
                                            <div id="avatar-overlay"
                                                class="absolute inset-0 bg-black bg-opacity-40 rounded-full opacity-60 group-hover:opacity-90 transition-all flex items-center justify-center">
                                                <label for="profilePicture" id="avatar-label"
                                                    class="text-white cursor-pointer flex flex-col items-center">
                                                    <!-- Ikon Upload -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 mb-2"
                                                        fill="currentColor" viewBox="0 0 24 24">
                                                        <path
                                                            d="M12 2a1 1 0 0 1 .993.883L13 3v11.585l2.293-2.292a1 1 0 0 1 1.32-.083l.094.083a1 1 0 0 1 .083 1.32l-.083.094-4 4-.094.083a1 1 0 0 1-1.32 0l-.094-.083-4-4-.083-.094a1 1 0 0 1 0-1.226l.083-.094a1 1 0 0 1 1.226-.083l.094.083L11 14.584V3a1 1 0 0 1 1-1Zm8 16a1 1 0 0 1 .117 1.993L20 20H4a1 1 0 0 1-.117-1.993L4 18h16Z" />
                                                    </svg>
                                                    <span class="text-sm font-semibold">Unggah Foto</span>
                                                </label>
                                                <input id="profilePicture" name="profilePicture" type="file"
                                                    accept="image/*" class="hidden"
                                                    onchange="cropAndPreviewImage(event, 'avatar-preview')">
                                            </div>
                                        @else
                                            <div
                                                class="w-32 h-32 rounded-full overflow-hidden ring-4 ring-gray-200 bg-gradient-to-tr from-gray-100 via-gray-200 to-gray-300 shadow-md">
                                                <img id="avatar-preview"
                                                    src="{{ asset('storage/' . Auth::user()->profilePicture) }}"
                                                    class="w-full h-full object-cover">
                                            </div>
                                            <!-- Overlay Upload -->
                                            <div id="avatar-overlay"
                                                class="absolute inset-0 bg-black bg-opacity-40 rounded-full opacity-0 group-hover:opacity-90 transition-all flex items-center justify-center">
                                                <label for="profilePicture" id="avatar-label"
                                                    class="text-white cursor-pointer flex flex-col items-center">
                                                    <!-- Ikon Upload -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 mb-2"
                                                        fill="currentColor" viewBox="0 0 24 24">
                                                        <path
                                                            d="M12 2a1 1 0 0 1 .993.883L13 3v11.585l2.293-2.292a1 1 0 0 1 1.32-.083l.094.083a1 1 0 0 1 .083 1.32l-.083.094-4 4-.094.083a1 1 0 0 1-1.32 0l-.094-.083-4-4-.083-.094a1 1 0 0 1 0-1.226l.083-.094a1 1 0 0 1 1.226-.083l.094.083L11 14.584V3a1 1 0 0 1 1-1Zm8 16a1 1 0 0 1 .117 1.993L20 20H4a1 1 0 0 1-.117-1.993L4 18h16Z" />
                                                    </svg>
                                                    <span class="text-sm font-semibold">Unggah Foto</span>
                                                </label>
                                                <input id="profilePicture" name="profilePicture" type="file"
                                                    accept="image/*" class="hidden"
                                                    onchange="cropAndPreviewImage(event, 'avatar-preview')">
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                        <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}"
                                            class="w-full px-4 py-3 rounded-lg border  focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror">
                                        @error('name')
                                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                        <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}"
                                            class="w-full px-4 py-3 rounded-lg border  focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror">
                                        @error('email')
                                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                        <textarea name="address" rows="3"
                                            class="w-full px-4 py-3 rounded-lg border  focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('address') border-red-500 @enderror">{{ old('address', Auth::user()->address) }}</textarea>
                                        @error('address')
                                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <button type="submit"
                                        class="w-full bg-gradient-to-r from-[#915cfc] to-[#6a4bff] text-white font-medium py-3 rounded-lg transition-all duration-300 hover:shadow-lg hover:opacity-90 focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                                        Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Security Section -->
                    <div id="security"
                        class="tab-pane min-h-[500px] transform transition-all duration-300 ease-in-out opacity-0 scale-95 hidden">
                        <div class="bg-white rounded-xl shadow-sm p-6">
                            <h5 class="text-xl font-semibold text-gray-800 pb-4 mb-6 border-b">Security Settings</h5>
                            <form action="{{ route('profile.password.update', Auth::user()->id) }}" method="POST"
                                class="space-y-4">
                                @csrf
                                @method('PUT')

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                                    <div class="relative flex items-center">
                                        <input type="password" name="current_password" id="current_password"
                                            class="w-full px-4 py-3 pr-12 rounded-lg border focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('current_password') border-red-500 @enderror">
                                        <div class="absolute right-3">
                                            <button type="button"
                                                class="text-gray-500 hover:text-gray-700 focus:outline-none"
                                                onclick="togglePassword('current_password')">
                                                <i class="fas fa-eye text-xl" id="current_password_icon"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @error('current_password')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                                    <div class="relative flex items-center">
                                        <input type="password" name="password" id="new_password"
                                            class="w-full px-4 py-3 pr-12 rounded-lg border focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror">
                                        <div class="absolute right-3">
                                            <button type="button"
                                                class="text-gray-500 hover:text-gray-700 focus:outline-none"
                                                onclick="togglePassword('new_password')">
                                                <i class="fas fa-eye text-xl" id="new_password_icon"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @error('password')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                                    <div class="relative flex items-center">
                                        <input type="password" name="password_confirmation" id="confirm_password"
                                            class="w-full px-4 py-3 pr-12 rounded-lg border focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <div class="absolute right-3">
                                            <button type="button"
                                                class="text-gray-500 hover:text-gray-700 focus:outline-none"
                                                onclick="togglePassword('confirm_password')">
                                                <i class="fas fa-eye text-xl" id="confirm_password_icon"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit"
                                    class="w-full bg-gradient-to-r from-[#915cfc] to-[#6a4bff] text-white font-medium py-3 rounded-lg transition-all duration-300 hover:shadow-lg hover:opacity-90 focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                                    Update Password
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- References Section -->
                    <div id="references"
                        class="tab-pane min-h-[500px] transform transition-all duration-300 ease-in-out opacity-0 scale-95 hidden">
                        <div class="bg-white rounded-xl shadow-sm p-6">
                            <h5 class="text-xl font-semibold text-gray-800 pb-4 mb-6 border-b">Account References</h5>
                            <div class="space-y-4">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="w-full flex items-center px-4 py-3 rounded-lg text-left hover:bg-red-50 text-gray-700 hover:text-red-600 transition-all duration-300">
                                        <i class="fas fa-sign-out-alt mr-3"></i> Logout
                                    </button>
                                </form>

                                <form action="{{ route('profile.destroy', Auth::user()->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-full flex items-center px-4 py-3 rounded-lg text-left hover:bg-red-50 text-gray-700 hover:text-red-600 transition-all duration-300">
                                        <i class="fas fa-trash-alt mr-3"></i> Delete Account
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div id='crop-modal' class="hidden">
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white rounded-lg p-4">
                <div class="relative w-[300px] h-[300px]">
                    <img id="cropper-image" class="max-w-full max-h-full">
                </div>
                <div class="mt-4 flex justify-end space-x-2">
                    <button id="crop-cancel" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                    <button id="crop-confirm"
                        class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Crop</button>
                </div>
            </div>
        </div>
    </div>
@endsection


<script>
    let cropper; // Variabel untuk menyimpan instance Cropper.js

    function cropAndPreviewImage(event, previewId) {
        const inputFile = event.target;
        const file = inputFile.files[0];

        if (file) {
            // Validasi tipe file
            const validImageTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp', 'image/heic'];
            if (!validImageTypes.includes(file.type)) {
                alert('File yang dipilih bukan gambar. Harap pilih file gambar.');
                inputFile.value = ''; // Reset input jika file tidak valid
                return;
            }

            // Tampilkan modal untuk crop
            const modal = document.getElementById('crop-modal');
            const cropperImage = document.getElementById('cropper-image');
            const reader = new FileReader();

            reader.onload = function(e) {
                cropperImage.src = e.target.result;
                modal.classList.remove('hidden');

                // Inisialisasi Cropper.js
                if (cropper) {
                    cropper.destroy(); // Hancurkan instance sebelumnya
                }
                cropper = new Cropper(cropperImage, {
                    aspectRatio: 1, // Ratio lingkaran atau persegi
                    viewMode: 1,
                    autoCropArea: 1,
                    responsive: true,
                });
            };
            reader.readAsDataURL(file);

            // Tombol Cancel Crop
            document.getElementById('crop-cancel').addEventListener('click', () => {
                cropper.destroy();
                modal.classList.add('hidden');
                inputFile.value = ''; // Reset input
            });

            // Tombol Confirm Crop
            document.getElementById('crop-confirm').addEventListener('click', () => {
                const canvas = cropper.getCroppedCanvas({
                    width: 200, // Resolusi hasil crop
                    height: 200,
                });

                // Update elemen <img> preview
                const previewImage = document.getElementById(previewId);
                const label = document.getElementById('avatar-label');
                previewImage.src = canvas.toDataURL('image/png'); // Hasil crop sebagai Data URL

                label.classList.add('hidden'); // Sembunyikan label
                modal.classList.add('hidden'); // Sembunyikan modal
                cropper.destroy(); // Hancurkan instance cropper
            });
        }
    }



    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('[data-tab]');
        const tabPanes = document.querySelectorAll('.tab-pane');

        function switchTab(tabId) {
            // First, start transition out for all panes
            tabPanes.forEach(pane => {
                if (!pane.classList.contains('hidden')) {
                    pane.classList.add('opacity-0', 'scale-95');
                    pane.classList.remove('opacity-100', 'scale-100');
                }
            });

            // After small delay, switch visibility
            setTimeout(() => {
                tabPanes.forEach(pane => {
                    pane.classList.add('hidden');
                });

                // Show and animate in the selected pane
                const selectedPane = document.getElementById(tabId);
                selectedPane.classList.remove('hidden');

                // Force a reflow
                selectedPane.offsetHeight;

                selectedPane.classList.remove('opacity-0', 'scale-95');
                selectedPane.classList.add('opacity-100', 'scale-100');
            }, 200);

            // Update active state of tabs
            tabs.forEach(tab => {
                if (tab.dataset.tab === tabId) {
                    tab.classList.add('bg-gradient-to-r', 'from-[#915cfc]', 'to-[#6a4bff]',
                        'text-white');
                    tab.classList.remove('text-gray-700', 'hover:bg-purple-50', 'hover:text-[#915cfc]');
                } else {
                    tab.classList.remove('bg-gradient-to-r', 'from-[#915cfc]', 'to-[#6a4bff]',
                        'text-white');
                    tab.classList.add('text-gray-700', 'hover:bg-purple-50', 'hover:text-[#915cfc]');
                }
            });
        }

        // Add click handlers
        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                switchTab(tab.dataset.tab);
            });
        });

        // Prevent form submission on toggle button clicks
        document.querySelectorAll('button[onclick^="togglePassword"]').forEach(btn => {
            btn.type = 'button'; // Ensure button type is explicitly set
            btn.addEventListener('click', (e) => e.preventDefault());
        });
    });

    // Add this function after your existing scripts
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(inputId + '_icon');

        if (!input || !icon) return; // Guard clause

        // Prevent form submission when clicking the button
        document.querySelectorAll('button[onclick^="togglePassword"]').forEach(btn => {
            btn.addEventListener('click', (e) => e.preventDefault());
        });

        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>



<style>
    .tab-pane {
        backface-visibility: hidden;
        -webkit-backface-visibility: hidden;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in-up {
        animation: fadeInUp 0.5s ease-out;
    }
</style>
