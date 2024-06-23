<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>

<body class="bg-dark">
    <div class="max-w-[1280px] mx-auto">
        <h1 class="text-h1 font-h1 text-brown-active font-norse text-center my-10">Caro fighters</h1>
        <nav class="mx-3 flex flex-1 justify-center">
            @auth
            <x-link href="{{ url('/dashboard') }}">
                Dashboard
            </x-link>
            @else
            <x-link href="{{ route('login') }}">
                Login
            </x-link>
            <x-link href="{{ route('register') }}">
                Register
            </x-link>
            @endauth
        </nav>
    </div>
</body>

</html>