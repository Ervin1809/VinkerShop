<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Vinker</title>
    <!-- Cropper CSS -->
    <link href="https://cdn.jsdelivr.net/npm/cropperjs/dist/cropper.min.css" rel="stylesheet">
    <!-- Cropper JS -->
    <script src="https://cdn.jsdelivr.net/npm/cropperjs"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body class="bg-gray-200">
    @vite('resources/css/app.css')

    <!-- Navbar -->
    @include('sellerPage.components.navbar')

    <!-- Main Layout -->
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-64 min-h-screen bg-white shadow-sm">
            @include('sellerPage.components.sidebar')
        </div>

        <!-- Content -->
        <div class="flex-1 p-5 mt-16">
            @include('components.message')
            @yield('contentSeller')
        </div>
    </div>
</body>
</html>
