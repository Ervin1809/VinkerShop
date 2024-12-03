<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Vinker</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-200">
    @vite('resources/css/app.css')

    <!-- Navbar -->
    @include('adminPage.components.navbar')

    <div class="flex pt-16 min-h-screen">
        <!-- Sidebar -->
        <div class="w-48 border-r-2 border-r-slate-200 bg-white">
            @include('adminPage.components.sidebar')
        </div>

        <!-- Content -->
        <div class="flex-1 p-5 overflow-auto">
            @include('components.message')
            @yield('contentAdmin')
        </div>
    </div>
</body>
