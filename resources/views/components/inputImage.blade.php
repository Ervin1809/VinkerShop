<!-- resources/views/components/dropzone.blade.php -->
<div
    class="relative flex flex-col items-center justify-center w-16 h-16 border-2 border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-200 hover:bg-gray-100 dark:border-gray-300 dark:hover:border-gray-500 dark:hover:bg-gray-300">
    <label for="{{ $id }}" class="flex flex-col items-center justify-center w-full h-full">
        <div id="{{ $id }}-preview" class="flex flex-col items-center justify-center">
            <svg class="w-6 h-6 mb-2 text-gray-500 dark:text-gray-400" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 4v16m8-8H4" />
            </svg>
            <p class="text-xs text-gray-500 dark:text-gray-400">Upload</p>
        </div>
    </label>
    <input id="{{ $id }}" name="{{ $name }}" type="file" accept="image/*" class="hidden" onchange="cropAndPreviewImage(event, '{{ $id }}')" />
</div>

<script>
    function cropAndPreviewImage(event, id) {
        const fileInput = event.target;
        const previewContainer = document.getElementById(`${id}-preview`);

        if (fileInput.files && fileInput.files[0]) {
            const file = fileInput.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                const img = new Image();
                img.src = e.target.result;

                img.onload = function() {
                    // Tentukan ukuran output (persegi)
                    const size = Math.min(img.width, img.height);
                    const canvas = document.createElement('canvas');
                    const ctx = canvas.getContext('2d');

                    canvas.width = size;
                    canvas.height = size;

                    // Crop gambar ke tengah
                    const offsetX = (img.width - size) / 2;
                    const offsetY = (img.height - size) / 2;

                    ctx.drawImage(img, offsetX, offsetY, size, size, 0, 0, size, size);

                    // Tampilkan hasil crop di preview
                    previewContainer.innerHTML =
                        `<img src="${canvas.toDataURL('image/png')}" alt="Cropped Image" class="w-full h-full object-cover rounded-lg" />`;
                };
            };

            reader.readAsDataURL(file);
        }
    }
</script>
