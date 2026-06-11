<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Zero Nine Coffee Shop')</title>
    <meta name="description" content="@yield('meta_description', 'Zero Nine Coffee Shop — Pengalaman kopi premium yang tak terlupakan. Specialty coffee, artisan brewing, dan suasana yang memukau.')">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;0,900;1,400;1,600&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
    @stack('styles')
</head>
<body class="bg-gradient-to-br from-[#C5A880] to-[#8B6340] min-h-screen text-[#1B120D] antialiased">

    {{-- Navigation --}}
    @include('layouts.partials.navbar')

    {{-- Flash Messages --}}
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-[-1rem]"
             x-transition:enter-end="opacity-1 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-end="opacity-0"
             class="fixed top-20 right-4 z-50 glass-card px-5 py-3 text-green-700 border-green-500/30 max-w-sm">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
             class="fixed top-20 right-4 z-50 glass-card px-5 py-3 text-red-700 border-red-500/30 max-w-sm">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                {{ session('error') }}
            </div>
        </div>
    @endif

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('layouts.partials.footer')

    @livewireScripts
    @stack('scripts')
</body>
</html>
