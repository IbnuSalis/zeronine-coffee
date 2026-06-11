<nav x-data="{ open: false, scrolled: false }"
     x-on:scroll.window="scrolled = window.scrollY > 60"
     :class="scrolled ? 'bg-coffee-950/95 backdrop-blur-xl border-b border-coffee-800/50 shadow-lg shadow-black/20' : '{{ request()->routeIs('home') ? 'bg-transparent border-b border-transparent' : 'bg-coffee-950 border-b border-coffee-800/50' }}'"
     class="fixed top-0 left-0 right-0 z-50 transition-all duration-500">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-20">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-gold-400 to-gold-600 flex items-center justify-center text-coffee-950 font-bold text-sm font-display transition-transform group-hover:scale-110">
                    09
                </div>
                <div class="hidden sm:block">
                    <span class="font-display font-bold text-lg text-coffee-50 group-hover:text-gold-400 transition-colors">Zero Nine</span>
                    <span class="text-coffee-400 text-sm block leading-none">Coffee Shop</span>
                </div>
            </a>

            {{-- Desktop Nav Links --}}
            <div class="hidden lg:flex items-center gap-1">
                <a href="{{ route('home') }}" class="px-4 py-2 text-sm font-medium text-coffee-300 hover:text-coffee-50 hover:bg-coffee-800/50 rounded-lg transition-all">
                    Home
                </a>
                <a href="{{ route('menu.index') }}" class="px-4 py-2 text-sm font-medium text-coffee-300 hover:text-coffee-50 hover:bg-coffee-800/50 rounded-lg transition-all">
                    Menu
                </a>
                <a href="{{ route('customer.bookings.create') }}" class="px-4 py-2 text-sm font-medium text-coffee-300 hover:text-coffee-50 hover:bg-coffee-800/50 rounded-lg transition-all">
                    Reservasi
                </a>
                <a href="{{ route('home') }}#about"
                   x-on:click.prevent="
                       if (window.location.pathname === '{{ parse_url(route('home'), PHP_URL_PATH) }}') {
                           document.getElementById('about')?.scrollIntoView({ behavior: 'smooth' });
                       } else {
                           window.location.href = '{{ route('home') }}#about';
                       }
                   "
                   class="px-4 py-2 text-sm font-medium text-coffee-300 hover:text-coffee-50 hover:bg-coffee-800/50 rounded-lg transition-all">
                    Tentang Kami
                </a>
            </div>

            {{-- Right Actions --}}
            <div class="flex items-center gap-3">

                @auth
                    {{-- Cart Icon --}}
                    <a href="{{ route('customer.cart.index') }}" class="relative p-2 text-coffee-300 hover:text-coffee-50 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-9H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        @php $cartCount = auth()->user()->cart?->item_count ?? 0; @endphp
                        @if($cartCount > 0)
                            <span class="absolute -top-1 -right-1 w-5 h-5 bg-gold-500 text-coffee-950 text-xs font-bold rounded-full flex items-center justify-center">
                                {{ $cartCount > 9 ? '9+' : $cartCount }}
                            </span>
                        @endif
                    </a>

                    {{-- Notifications --}}
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" @click.outside="open = false"
                                class="relative p-2 text-coffee-300 hover:text-coffee-50 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            @php $unreadCount = auth()->user()->unreadNotifications->count(); @endphp
                            @if($unreadCount > 0)
                                <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center">
                                    {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                                </span>
                            @endif
                        </button>

                        {{-- Dropdown Panel --}}
                        <div x-show="open" x-cloak @click.outside="open = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-1 scale-95"
                             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                             class="absolute right-0 top-full mt-2 w-80 bg-[#1B120D] border border-[#C5A880]/30 rounded-xl shadow-2xl overflow-hidden z-50">

                            {{-- Header --}}
                            <div class="flex items-center justify-between px-4 py-3 border-b border-coffee-700/30">
                                <span class="text-sm font-semibold text-coffee-50">Notifikasi</span>
                                @if($unreadCount > 0)
                                    <form method="POST" action="{{ route('notifications.read-all') }}">
                                        @csrf
                                        <button type="submit" class="text-xs text-gold-400 hover:text-gold-300 transition-colors font-medium">
                                            Tandai semua dibaca
                                        </button>
                                    </form>
                                @endif
                            </div>

                            {{-- Notification List --}}
                            <div class="max-h-72 overflow-y-auto divide-y divide-coffee-800/40">
                                @forelse(auth()->user()->notifications->take(8) as $notif)
                                    <div class="flex items-start gap-3 px-4 py-3 {{ $notif->read_at ? '' : 'bg-coffee-900/50' }} hover:bg-coffee-800/40 transition-colors">
                                        <div class="w-2 h-2 rounded-full mt-1.5 flex-shrink-0 {{ $notif->read_at ? 'bg-coffee-700' : 'bg-gold-400' }}"></div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-xs font-semibold text-coffee-100 leading-snug">
                                                {{ $notif->data['title'] ?? $notif->data['message'] ?? 'Notifikasi baru' }}
                                            </p>
                                            @if(isset($notif->data['body']) || isset($notif->data['message']))
                                                <p class="text-[11px] text-coffee-400 mt-0.5 leading-relaxed line-clamp-2">
                                                    {{ $notif->data['body'] ?? $notif->data['message'] ?? '' }}
                                                </p>
                                            @endif
                                            <p class="text-[10px] text-coffee-600 mt-1">
                                                {{ $notif->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                        @if(!$notif->read_at)
                                            <form method="POST" action="{{ route('notifications.read', $notif->id) }}" class="flex-shrink-0">
                                                @csrf
                                                <button type="submit" title="Tandai dibaca"
                                                        class="text-coffee-600 hover:text-gold-400 transition-colors mt-0.5">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                @empty
                                    <div class="py-10 text-center">
                                        <div class="text-3xl mb-2">🔔</div>
                                        <p class="text-xs text-coffee-500 font-medium">Belum ada notifikasi</p>
                                    </div>
                                @endforelse
                            </div>

                            @if(auth()->user()->notifications->count() > 8)
                                <div class="px-4 py-2.5 border-t border-coffee-700/30 text-center">
                                    <a href="{{ route('customer.orders.index') }}" class="text-xs text-gold-400 hover:text-gold-300 transition-colors font-medium">
                                        Lihat semua →
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>


                    {{-- User Dropdown --}}
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center gap-2 glass-card px-3 py-2 hover:border-gold-500/30 transition-all">
                            <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}"
                                 class="w-7 h-7 rounded-full object-cover ring-1 ring-gold-500/30">
                            <span class="hidden sm:block text-sm font-medium max-w-24 truncate" style="color:#ffffff;">{{ auth()->user()->name }}</span>
                            <svg class="w-4 h-4 text-coffee-400" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div x-show="open" x-cloak @click.outside="open = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-1 scale-95"
                             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                             class="absolute right-0 top-full mt-2 w-56 bg-[#1B120D] border border-[#C5A880]/30 rounded-xl py-1 shadow-2xl">

                            <div class="px-4 py-3 border-b border-coffee-700/30">
                                <p class="text-sm font-semibold text-coffee-50">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-coffee-400">{{ auth()->user()->email }}</p>
                                @if(auth()->user()->membershipTier)
                                    <span class="badge badge-gold mt-1 tier-{{ auth()->user()->membershipTier->slug }}">
                                        ⭐ {{ auth()->user()->membershipTier->name }}
                                    </span>
                                @endif
                            </div>

                            <a href="{{ route('customer.profile.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-coffee-300 hover:text-coffee-50 hover:bg-coffee-800/50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                Profil Saya
                            </a>
                            <a href="{{ route('customer.orders.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-coffee-300 hover:text-coffee-50 hover:bg-coffee-800/50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                Riwayat Pesanan
                            </a>
                            <a href="{{ route('customer.bookings.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-coffee-300 hover:text-coffee-50 hover:bg-coffee-800/50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                Reservasi Saya
                            </a>
                            <a href="{{ route('customer.loyalty') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-coffee-300 hover:text-coffee-50 hover:bg-coffee-800/50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                                Loyalty Points
                                <span class="ml-auto text-xs font-bold text-gold-400">{{ number_format(auth()->user()->loyalty_points) }}</span>
                            </a>

                            @if(auth()->user()->hasAnyRole(['admin', 'super_admin']))
                                <div class="border-t border-coffee-700/30 mt-1 pt-1">
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-coffee-300 hover:text-coffee-50 hover:bg-coffee-800/50 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                                        Admin Dashboard
                                    </a>
                                </div>
                            @endif
                            @if(auth()->user()->hasRole('kitchen_staff'))
                                <a href="{{ route('kitchen.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-coffee-300 hover:text-coffee-50 hover:bg-coffee-800/50 transition-colors">
                                    🍳 Kitchen Screen
                                </a>
                            @endif
                            @if(auth()->user()->hasAnyRole(['cashier', 'admin']))
                                <a href="{{ route('cashier.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-coffee-300 hover:text-coffee-50 hover:bg-coffee-800/50 transition-colors">
                                    💰 Kasir
                                </a>
                            @endif

                            <div class="border-t border-coffee-700/30 mt-1 pt-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-400 hover:text-red-300 hover:bg-red-900/20 transition-colors text-left">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                @else
                    <a href="{{ route('login') }}" class="flex items-center justify-center gap-2 rounded-lg border border-[#C5A880]/50 text-sm font-semibold text-[#FDF6EC] hover:bg-[#FDF6EC] hover:text-[#1B120D] px-4 py-2 transition-all hidden sm:flex">Masuk</a>
                    <a href="{{ route('register') }}" class="btn-primary text-sm">Daftar</a>
                @endauth

                {{-- Mobile menu button --}}
                <button @click="open = !open" class="lg:hidden p-2 text-coffee-300 hover:text-coffee-50 transition-colors">
                    <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="open" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="open" x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="lg:hidden bg-coffee-950/98 backdrop-blur-xl border-t border-coffee-800/50 py-4">
        <div class="max-w-7xl mx-auto px-4 space-y-1">
            <a href="{{ route('home') }}" class="block px-4 py-3 rounded-lg text-coffee-300 hover:text-coffee-50 hover:bg-coffee-800/50 transition-all">Home</a>
            <a href="{{ route('menu.index') }}" class="block px-4 py-3 rounded-lg text-coffee-300 hover:text-coffee-50 hover:bg-coffee-800/50 transition-all">Menu</a>
            <a href="{{ route('customer.bookings.create') }}" class="block px-4 py-3 rounded-lg text-coffee-300 hover:text-coffee-50 hover:bg-coffee-800/50 transition-all">Reservasi</a>
            <a href="{{ route('home') }}#about"
               x-on:click.prevent="
                   if (window.location.pathname === '{{ parse_url(route('home'), PHP_URL_PATH) }}') {
                       document.getElementById('about')?.scrollIntoView({ behavior: 'smooth' });
                       open = false;
                   } else {
                       window.location.href = '{{ route('home') }}#about';
                   }
               "
               class="block px-4 py-3 rounded-lg text-coffee-300 hover:text-coffee-50 hover:bg-coffee-800/50 transition-all">
               Tentang Kami
            </a>
            @guest
                <div class="pt-2 flex gap-2">
                    <a href="{{ route('login') }}" class="btn-secondary flex-1 text-center text-sm">Masuk</a>
                    <a href="{{ route('register') }}" class="btn-primary flex-1 text-center text-sm">Daftar</a>
                </div>
            @endguest
        </div>
    </div>
</nav>