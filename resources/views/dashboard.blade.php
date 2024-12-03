<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @vite('resources/css/app.css')

    @include('components.navbar')
    <br>
    <div>
        @include('components.message')
        @yield('content')
    </div>
    <br>
    @include('components.footer')
</body>
</html>