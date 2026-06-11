<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — Zero Nine Coffee</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50" x-data="{ sidebarOpen: false }">

{{-- Sidebar Overlay (mobile) --}}
<div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"
     class="fixed inset-0 bg-black/50 z-20 lg:hidden"></div>

{{-- Sidebar --}}
<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
       class="fixed top-0 left-0 h-full w-64 bg-[#1B120D] z-30 transform transition-transform duration-300 lg:translate-x-0 flex flex-col shadow-xl">

    {{-- Logo --}}
    <div class="flex items-center gap-3 px-6 py-5 border-b border-coffee-800/40">
        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-gold-400 to-gold-600 flex items-center justify-center text-coffee-950 font-bold text-sm flex-shrink-0">09</div>
        <div>
            <p class="font-display font-bold text-coffee-50 text-sm leading-tight">Zero Nine</p>
            <p class="text-coffee-400 text-xs">Admin Panel</p>
        </div>
    </div>

    {{-- Nav --}}
    <nav class="flex-1 overflow-y-auto py-4 px-3">
        <p class="text-coffee-600 text-[10px] font-bold uppercase tracking-wider px-3 mb-2">Utama</p>

        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg mb-0.5 text-sm font-medium transition-all
                  {{ request()->routeIs('admin.dashboard') ? 'bg-gold-500/20 text-gold-400' : 'text-coffee-300 hover:bg-coffee-800/40 hover:text-coffee-50' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Dashboard
        </a>

        <p class="text-coffee-600 text-[10px] font-bold uppercase tracking-wider px-3 mt-5 mb-2">Katalog</p>

        <a href="{{ route('admin.menus.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg mb-0.5 text-sm font-medium transition-all
                  {{ request()->routeIs('admin.menus*') ? 'bg-gold-500/20 text-gold-400' : 'text-coffee-300 hover:bg-coffee-800/40 hover:text-coffee-50' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            Menu Produk
        </a>

        <a href="{{ route('admin.categories.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg mb-0.5 text-sm font-medium transition-all
                  {{ request()->routeIs('admin.categories*') ? 'bg-gold-500/20 text-gold-400' : 'text-coffee-300 hover:bg-coffee-800/40 hover:text-coffee-50' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
            Kategori
        </a>

        <p class="text-coffee-600 text-[10px] font-bold uppercase tracking-wider px-3 mt-5 mb-2">Operasional</p>

        <a href="{{ route('admin.orders.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg mb-0.5 text-sm font-medium transition-all
                  {{ request()->routeIs('admin.orders*') ? 'bg-gold-500/20 text-gold-400' : 'text-coffee-300 hover:bg-coffee-800/40 hover:text-coffee-50' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            Pesanan
        </a>

        <a href="{{ route('admin.bookings.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg mb-0.5 text-sm font-medium transition-all
                  {{ request()->routeIs('admin.bookings*') ? 'bg-gold-500/20 text-gold-400' : 'text-coffee-300 hover:bg-coffee-800/40 hover:text-coffee-50' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            Reservasi
        </a>

        <a href="{{ route('admin.tables.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg mb-0.5 text-sm font-medium transition-all
                  {{ request()->routeIs('admin.tables*') ? 'bg-gold-500/20 text-gold-400' : 'text-coffee-300 hover:bg-coffee-800/40 hover:text-coffee-50' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
            Meja
        </a>

        <a href="{{ route('admin.promos.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg mb-0.5 text-sm font-medium transition-all
                  {{ request()->routeIs('admin.promos*') ? 'bg-gold-500/20 text-gold-400' : 'text-coffee-300 hover:bg-coffee-800/40 hover:text-coffee-50' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
            Promo
        </a>

        <p class="text-coffee-600 text-[10px] font-bold uppercase tracking-wider px-3 mt-5 mb-2">Pengguna</p>

        <a href="{{ route('admin.users.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg mb-0.5 text-sm font-medium transition-all
                  {{ request()->routeIs('admin.users*') ? 'bg-gold-500/20 text-gold-400' : 'text-coffee-300 hover:bg-coffee-800/40 hover:text-coffee-50' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            Pengguna
        </a>

        <a href="{{ route('admin.reviews.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg mb-0.5 text-sm font-medium transition-all
                  {{ request()->routeIs('admin.reviews*') ? 'bg-gold-500/20 text-gold-400' : 'text-coffee-300 hover:bg-coffee-800/40 hover:text-coffee-50' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
            Ulasan
        </a>
    </nav>

    {{-- User Info & Logout --}}
    <div class="border-t border-coffee-800/40 p-4">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-gold-400 to-gold-600 flex items-center justify-center text-coffee-950 font-bold text-xs flex-shrink-0">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-coffee-50 text-xs font-semibold truncate">{{ auth()->user()->name }}</p>
                <p class="text-coffee-500 text-[10px] truncate">{{ auth()->user()->email }}</p>
            </div>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('home') }}" target="_blank" class="flex-1 text-center text-xs text-coffee-400 hover:text-coffee-200 py-1.5 rounded border border-coffee-800/50 hover:border-coffee-600/50 transition-all">
                Lihat Web
            </a>
            <form method="POST" action="{{ route('logout') }}" class="flex-1">
                @csrf
                <button type="submit" class="w-full text-center text-xs text-coffee-400 hover:text-red-400 py-1.5 rounded border border-coffee-800/50 hover:border-red-500/50 transition-all">
                    Keluar
                </button>
            </form>
        </div>
    </div>
</aside>

{{-- Main Content --}}
<div class="lg:ml-64 min-h-screen flex flex-col">

    {{-- Top Bar --}}
    <header class="bg-white border-b border-gray-200 sticky top-0 z-10">
        <div class="flex items-center justify-between px-4 sm:px-6 h-14">
            <div class="flex items-center gap-4">
                {{-- Mobile hamburger --}}
                <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                {{-- Breadcrumb --}}
                <div>
                    <h1 class="text-sm font-bold text-gray-800">@yield('page-title', 'Dashboard')</h1>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <span class="flex items-center gap-1.5 text-xs text-gray-500">
                    <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                    Live
                </span>
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-gold-400 to-gold-600 flex items-center justify-center text-coffee-950 font-bold text-xs">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            </div>
        </div>
    </header>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
             class="mx-4 sm:mx-6 mt-4 bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-lg flex items-center gap-2">
            <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
             class="mx-4 sm:mx-6 mt-4 bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-lg flex items-center gap-2">
            <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- Page Content --}}
    <main class="flex-1 p-4 sm:p-6">
        @yield('content')
    </main>

</div>

@livewireScripts
@stack('scripts')
</body>
</html>
