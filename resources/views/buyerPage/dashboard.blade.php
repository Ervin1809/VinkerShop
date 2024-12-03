<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Vinker</title>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

    @stack('styles')  {{-- Add this line if not exists --}}
</head>

<body class="bg-gray-200">
    @vite('resources/css/app.css')
    @include('buyerPage.components.navbar')
    <br>
    <div class="bg-gray-200 p-8">
        @include('components.message')
        @yield('contentBuyer')
    </div>
    <br>
    @include('buyerPage.components.footer')
</body>

</html>
