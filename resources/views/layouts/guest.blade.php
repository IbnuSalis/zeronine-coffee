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

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-[#1B120D] antialiased bg-[#FDF6EC]">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[#FDF6EC] relative overflow-hidden">
            {{-- Aesthetic Background Blur Orbs --}}
            <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-[#C5A880]/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-[#9A7D3A]/10 rounded-full blur-3xl"></div>

            <div class="z-10 flex flex-col items-center">
                <a href="/" class="flex flex-col items-center gap-3 group">
                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-gold-400 to-gold-600 flex items-center justify-center text-coffee-950 font-bold text-2xl font-display shadow-lg shadow-gold-500/20 transition-transform group-hover:scale-110">
                        09
                    </div>
                    <span class="font-display font-bold text-xl text-[#1B120D] group-hover:text-gold-600 transition-colors">Zero Nine</span>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-8 py-8 glass-card shadow-2xl z-10">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
