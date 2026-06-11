@extends('layouts.customer')

@section('title', 'Zero Nine Coffee Shop — Premium Specialty Coffee')
@section('meta_description', 'Nikmati pengalaman kopi premium yang tak terlupakan. Specialty coffee, artisan brewing, dan suasana mewah yang memukau di Zero Nine Coffee Shop.')

@push('styles')
<style>
    #hero-canvas { display: block; }
    [x-cloak] { display: none !important; }
</style>
@endpush

@section('content')

{{-- ═══════════════════════════════════════════════════════
     HERO SECTION — 3D Interactive Coffee Cup
════════════════════════════════════════════════════════ --}}
<section id="hero-section" class="relative min-h-screen flex items-center overflow-hidden pt-20">

    {{-- Background gradient --}}
    <div class="absolute inset-0 bg-coffee-950 overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-b from-coffee-900 to-transparent"></div>
        <div class="absolute -top-[30%] -right-[10%] w-[70%] h-[70%] rounded-full bg-gradient-radial from-gold-500/20 to-transparent blur-3xl opacity-50"></div>
        <div class="absolute -bottom-[20%] -left-[10%] w-[60%] h-[60%] rounded-full bg-gradient-radial from-coffee-800/40 to-transparent blur-3xl opacity-50"></div>
    </div>
    <div class="absolute inset-0" style="background: radial-gradient(ellipse 80% 60% at 60% 50%, rgba(197,168,128,0.2) 0%, transparent 70%);"></div>

    {{-- 3D Canvas --}}
    <div class="absolute right-0 top-0 w-full lg:w-[55%] h-full">
        <canvas id="hero-canvas" class="w-full h-full opacity-80"></canvas>
    </div>

    {{-- Floating grain texture overlay --}}
    <div class="absolute inset-0 opacity-[0.03]" style="background-image: url('data:image/svg+xml,...'); background-size: 100px;"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-32">
        <div class="max-w-2xl">

            {{-- Pre-headline badge --}}
            <div data-reveal class="flex items-center gap-3 mb-8">
                <div class="h-px w-12 bg-gold-500"></div>
                <span class="badge badge-gold text-xs tracking-widest uppercase font-medium">Specialty Coffee • Est. 2019</span>
            </div>

            {{-- Main Headline --}}
            <h1 data-reveal class="font-display text-5xl sm:text-6xl lg:text-7xl font-bold leading-[1.05] mb-6">
                <span class="text-coffee-50">Di Setiap</span><br>
                <span class="text-gradient-gold">Tegukan</span><br>
                <span class="text-coffee-50">Ada Cerita</span>
            </h1>

            {{-- Subheadline --}}
            <p data-reveal class="text-coffee-200 text-lg sm:text-xl leading-relaxed mb-10 max-w-lg">
                Dari biji Arabika pilihan petani Gayo dan Toraja, kami sajikan pengalaman kopi premium yang menceritakan keindahan Nusantara dalam setiap cangkir.
            </p>

            {{-- CTA Buttons --}}
            <div data-reveal class="flex flex-col sm:flex-row gap-4 mb-14">
                <a href="{{ route('menu.index') }}" class="btn-primary text-base px-8 py-4 justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    Lihat Menu
                </a>
                <a href="{{ route('customer.bookings.create') }}" class="btn-ghost flex items-center justify-center gap-2 text-base px-8 py-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Reservasi Meja
                </a>
            </div>

            {{-- Stats --}}
            <div data-reveal class="grid grid-cols-3 gap-6 border-t border-[#C5A880]/30 pt-8">
                <div>
                    <div class="text-2xl sm:text-3xl font-display font-bold text-gradient-gold" data-count="2500">0</div>
                    <div class="text-coffee-300 text-sm mt-1">Pelanggan Setia</div>
                </div>
                <div>
                    <div class="text-2xl sm:text-3xl font-display font-bold text-gradient-gold" data-count="14">0</div>
                    <div class="text-coffee-300 text-sm mt-1">Menu Premium</div>
                </div>
                <div>
                    <div class="text-2xl sm:text-3xl font-display font-bold text-gradient-gold">4.9★</div>
                    <div class="text-coffee-300 text-sm mt-1">Rating Pelanggan</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Scroll indicator --}}
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 animate-float">
        <span class="text-coffee-500 text-xs tracking-widest uppercase">Scroll</span>
        <svg class="w-5 h-5 text-gold-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </div>
</section>

<div class="bg-[#FDF6EC]">
{{-- ═══════════════════════════════════════════════════════
     FEATURED MENU SECTION
════════════════════════════════════════════════════════ --}}
<section class="py-24 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Section Header --}}
        <div class="text-center mb-16" data-reveal>
            <div class="flex items-center justify-center gap-3 mb-4">
                <div class="h-px w-12 bg-gold-500"></div>
                <span class="badge badge-gold text-xs tracking-widest uppercase">Menu Pilihan</span>
                <div class="h-px w-12 bg-gold-500"></div>
            </div>
            <h2 class="font-display text-4xl sm:text-5xl font-bold text-[#1B120D] mb-4">
                Crafted with <span class="text-gradient-gold">Passion</span>
            </h2>
            <p class="text-[#6F4E37] text-lg max-w-2xl mx-auto">
                Setiap menu adalah karya — dibuat dengan bahan terbaik, teknik presisi, dan cinta yang tulus untuk kopi.
            </p>
        </div>

        {{-- Featured Menu Grid --}}
        <div data-stagger class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            @foreach($featuredMenus as $menu)
                <a href="{{ route('menu.show', $menu->slug) }}" data-stagger-item class="menu-card group">
                    <div class="relative h-56 overflow-hidden">
                        <div class="w-full h-full bg-gradient-to-br from-coffee-800 to-coffee-900 flex items-center justify-center">
                            @if($menu->image)
                                <img src="{{ $menu->image_url }}" alt="{{ $menu->name }}"
                                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            @else
                                <div class="text-7xl opacity-30">☕</div>
                            @endif
                        </div>

                        {{-- Badges --}}
                        <div class="absolute top-3 left-3 flex flex-wrap gap-1.5">
                            @if($menu->is_best_seller)
                                <span class="badge badge-gold text-[10px]">⭐ Best Seller</span>
                            @endif
                            @if($menu->is_new)
                                <span class="badge badge-green text-[10px]">✨ Baru</span>
                            @endif
                        </div>

                        {{-- Add to cart hover button --}}
                        <div class="absolute inset-0 flex items-center justify-center bg-coffee-950/60 opacity-0 group-hover:opacity-100 transition-all duration-300">
                            <span class="btn-primary text-sm px-6 py-2.5 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                                Lihat Detail →
                            </span>
                        </div>
                    </div>

                    <div class="p-5">
                        <div class="flex items-start justify-between mb-2">
                            <div>
                                <p class="text-[#6F4E37] text-xs font-medium uppercase tracking-wide mb-1">{{ $menu->category->name }}</p>
                                <h3 class="font-display font-semibold text-[#1B120D] text-lg leading-tight group-hover:text-gold-600 transition-colors">
                                    {{ $menu->name }}
                                </h3>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-gold-600 text-lg">{{ $menu->formatted_price }}</p>
                            </div>
                        </div>
                        <p class="text-[#6F4E37] text-sm line-clamp-2 leading-relaxed mb-4">{{ $menu->description }}</p>
                        <div class="flex items-center justify-between text-xs text-[#3E2C1C]">
                            <span class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ $menu->preparation_time }} menit
                            </span>
                            @if($menu->review_count > 0)
                                <span class="flex items-center gap-1 text-gold-600">
                                    ★ {{ number_format($menu->average_rating, 1) }}
                                    <span class="text-[#6F4E37]">({{ $menu->review_count }})</span>
                                </span>
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="text-center" data-reveal>
            <a href="{{ route('menu.index') }}" class="btn-secondary text-base px-10 py-3.5">
                Lihat Semua Menu →
            </a>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     STORYTELLING — THE COFFEE JOURNEY
════════════════════════════════════════════════════════ --}}
<section id="about" class="py-24 relative overflow-hidden bg-[#F5ECD7]">
    <div class="absolute inset-0 bg-gradient-to-b from-transparent via-[#FDF6EC]/50 to-transparent"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

            <div data-reveal>
                <div class="flex items-center gap-3 mb-6">
                    <div class="h-px w-12 bg-gold-500"></div>
                    <span class="badge badge-gold text-xs tracking-widest uppercase">Perjalanan Kami</span>
                </div>
                <h2 class="font-display text-4xl sm:text-5xl font-bold text-[#1B120D] mb-6 leading-[1.1]">
                    Dari Kebun ke<br><span class="text-gradient-gold">Cangkir Anda</span>
                </h2>
                <p class="text-[#3E2C1C] text-lg leading-relaxed mb-6">
                    Zero Nine lahir dari kecintaan mendalam terhadap kopi Indonesia. Kami bekerja langsung dengan petani di Gayo, Toraja, dan Flores untuk memastikan setiap biji dipetik di puncak kematangannya.
                </p>
                <p class="text-[#6F4E37] leading-relaxed mb-8">
                    Proses roasting kami dilakukan dengan cermat oleh roaster berpengalaman, menciptakan profil rasa yang unik — dari keasaman citrus yang segar hingga cokelat hitam yang dalam dan memikat.
                </p>

                <div class="grid grid-cols-2 gap-4">
                    <div class="glass-card p-4">
                        <div class="text-2xl font-display font-bold text-gradient-gold mb-1">100%</div>
                        <div class="text-[#6F4E37] text-sm">Arabika Single Origin</div>
                    </div>
                    <div class="glass-card p-4">
                        <div class="text-2xl font-display font-bold text-gradient-gold mb-1">3+</div>
                        <div class="text-[#6F4E37] text-sm">Mitra Petani Lokal</div>
                    </div>
                    <div class="glass-card p-4">
                        <div class="text-2xl font-display font-bold text-gradient-gold mb-1">18 Jam</div>
                        <div class="text-[#6F4E37] text-sm">Proses Cold Brew</div>
                    </div>
                    <div class="glass-card p-4">
                        <div class="text-2xl font-display font-bold text-gradient-gold mb-1">Setiap Hari</div>
                        <div class="text-[#6F4E37] text-sm">Roasting Segar</div>
                    </div>
                </div>
            </div>

            <div data-reveal class="relative">
                <div class="aspect-square rounded-2xl overflow-hidden glass-card p-1">
                    <div class="w-full h-full rounded-xl bg-gradient-to-br from-coffee-800 to-coffee-950 flex items-center justify-center">
                        <div class="text-center p-8">
                            <div class="text-[8rem] mb-4 animate-float">☕</div>
                            <p class="font-display text-2xl font-bold text-gradient-gold">Zero Nine</p>
                            <p class="text-coffee-400 text-sm mt-1">Premium Coffee Experience</p>
                        </div>
                    </div>
                </div>
                {{-- Floating accent cards --}}
                <div class="absolute -top-4 -right-4 glass-card p-4 animate-float-delay">
                    <div class="text-3xl">🌿</div>
                    <p class="text-coffee-300 text-xs mt-1 font-medium">Organic</p>
                </div>
                <div class="absolute -bottom-4 -left-4 glass-card p-4 animate-float">
                    <div class="text-3xl">🏆</div>
                    <p class="text-coffee-300 text-xs mt-1 font-medium">Award Winning</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     LOYALTY PROGRAM SECTION
════════════════════════════════════════════════════════ --}}
<section class="py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="glass-card p-8 sm:p-12 text-center relative overflow-hidden" data-reveal>
            <div class="absolute inset-0 bg-gradient-to-br from-gold-600/10 to-transparent pointer-events-none"></div>

            <div class="relative z-10">
                <span class="badge badge-gold text-xs tracking-widest uppercase mb-4 inline-flex">⭐ Loyalty Program</span>
                <h2 class="font-display text-4xl sm:text-5xl font-bold text-[#1B120D] mb-4">
                    Setiap Tegukan <span class="text-gradient-gold">Memberikan Reward</span>
                </h2>
                <p class="text-[#6F4E37] text-lg mb-10 max-w-2xl mx-auto">
                    Kumpulkan poin dari setiap pembelian dan nikmati privilege eksklusif. Semakin banyak kamu minum kopi, semakin besar reward yang kamu dapatkan.
                </p>

                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
                    @foreach([
                        ['name' => 'Bronze', 'emoji' => '🥉', 'pts' => '0 pts', 'color' => 'from-amber-700/20', 'benefit' => '1% cashback'],
                        ['name' => 'Silver', 'emoji' => '🥈', 'pts' => '500 pts', 'color' => 'from-slate-400/20', 'benefit' => '5% diskon'],
                        ['name' => 'Gold', 'emoji' => '🥇', 'pts' => '2.000 pts', 'color' => 'from-yellow-500/20', 'benefit' => '10% diskon'],
                        ['name' => 'Platinum', 'emoji' => '💎', 'pts' => '5.000 pts', 'color' => 'from-purple-400/20', 'benefit' => '15% diskon'],
                    ] as $tier)
                        <div class="glass-card-dark p-5 bg-gradient-to-b {{ $tier['color'] }} to-transparent">
                            <div class="text-3xl mb-2">{{ $tier['emoji'] }}</div>
                            <div class="font-display font-bold text-[#1B120D] text-lg">{{ $tier['name'] }}</div>
                            <div class="text-[#6F4E37] text-xs mb-2">{{ $tier['pts'] }}</div>
                            <div class="text-[#3E2C1C] text-sm font-semibold">{{ $tier['benefit'] }}</div>
                        </div>
                    @endforeach
                </div>

                @guest
                    <a href="{{ route('register') }}" class="btn-primary text-base px-10 py-4">
                        Mulai Kumpulkan Poin →
                    </a>
                @else
                    <a href="{{ route('customer.loyalty') }}" class="btn-primary text-base px-10 py-4">
                        Cek Poin Saya →
                    </a>
                @endguest
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     BEST SELLER SECTION
════════════════════════════════════════════════════════ --}}
@if($bestSellers->isNotEmpty())
<section class="py-24 bg-[#F5ECD7]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-reveal>
            <h2 class="font-display text-4xl font-bold text-[#1B120D] mb-3">
                Yang Paling <span class="text-gradient-gold">Dicintai</span>
            </h2>
            <p class="text-[#6F4E37]">Menu favorit ribuan pelanggan setia kami</p>
        </div>

        <div data-stagger class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach($bestSellers as $menu)
                <a href="{{ route('menu.show', $menu->slug) }}" data-stagger-item
                   class="group flex items-center gap-4 glass-card p-4 hover:border-gold-500/30 transition-all">
                    <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-coffee-800 to-coffee-950 flex-shrink-0 flex items-center justify-center overflow-hidden">
                        @if($menu->image)
                            <img src="{{ $menu->image_url }}" alt="{{ $menu->name }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-2xl opacity-50">☕</span>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-[#1B120D] text-sm group-hover:text-gold-600 transition-colors truncate">{{ $menu->name }}</p>
                        <p class="text-gold-600 text-sm font-bold mt-0.5">{{ $menu->formatted_price }}</p>
                        <p class="text-[#6F4E37] text-xs mt-1">⭐ Best Seller</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ═══════════════════════════════════════════════════════
     CTA SECTION — Reservation
════════════════════════════════════════════════════════ --}}
<section class="py-32 relative overflow-hidden">
    <div class="absolute inset-0" style="background: radial-gradient(ellipse 70% 50% at 50% 50%, rgba(197,168,128,0.06) 0%, transparent 70%);"></div>

    <div class="max-w-4xl mx-auto px-4 text-center relative z-10" data-reveal>
        <div class="text-6xl mb-6 animate-float">☕</div>
        <h2 class="font-display text-4xl sm:text-6xl font-bold text-[#1B120D] mb-6 leading-tight">
            Siap Untuk Pengalaman<br><span class="text-gradient-gold">Kopi Premium?</span>
        </h2>
        <p class="text-[#3E2C1C] text-xl mb-10 max-w-2xl mx-auto leading-relaxed">
            Reservasi meja sekarang dan rasakan kehangatan Zero Nine Coffee Shop. Setiap detail dirancang untuk menciptakan momen yang tak terlupakan.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('customer.bookings.create') }}" class="btn-primary text-base px-10 py-4">
                📅 Reservasi Sekarang
            </a>
            <a href="{{ route('menu.index') }}" class="btn-secondary text-base px-10 py-4">
                ☕ Jelajahi Menu
            </a>
        </div>
    </div>
</section>
</div>

@endsection

@push('scripts')
@vite('resources/js/landing.js')
@endpush
