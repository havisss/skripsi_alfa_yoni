<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Marcellus&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 transition-colors duration-500" style="background: linear-gradient(rgba(230, 226, 214, 0.7), rgba(230, 226, 214, 0.9)), url('{{ asset('img/kevala_bg.png') }}'); background-size: cover; background-position: center;">
            <div>
                <a href="/">
                    <x-application-logo class="drop-shadow-md" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-8 px-8 py-8 bg-earth-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden sm:rounded-2xl border border-earth-200/50">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
