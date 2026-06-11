<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Zero Nine Coffee Shop') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased" style="background:#FDF6EC; color:#1B120D;">
        <div class="min-h-screen" style="background:#FDF6EC;">

            {{-- ── Dark Navbar ── --}}
            <livewire:layout.navigation />

            {{-- ── Page Heading ── --}}
            @if (isset($header))
                <header style="
                    background: rgba(255,255,255,0.75);
                    backdrop-filter: blur(12px);
                    -webkit-backdrop-filter: blur(12px);
                    border-bottom: 1px solid rgba(197,168,128,0.2);
                    box-shadow: 0 1px 3px rgba(139,99,64,0.06);
                ">
                    <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            {{-- ── Page Content ── --}}
            <main style="background:#FDF6EC; min-height:calc(100vh - 72px);">
                {{ $slot }}
            </main>

        </div>
    </body>
</html>