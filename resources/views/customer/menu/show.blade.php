@extends('layouts.customer')

@section('title', $menu->name . ' — Zero Nine Coffee Shop')

@section('content')
<div class="min-h-screen pt-28 pb-20">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Breadcrumb / Back button --}}
        <a href="{{ route('menu.index') }}" class="inline-flex items-center gap-2 text-[#6F4E37] hover:text-[#1B120D] mb-8 transition-colors text-sm font-medium">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Katalog Menu
        </a>

        {{-- Product Details Frame --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-stretch mb-16">
            
            {{-- Product Image Container --}}
            <div class="glass-card overflow-hidden p-2 flex items-center justify-center min-h-[350px] md:min-h-none">
                <div class="relative w-full h-full rounded-lg bg-gradient-to-br from-coffee-800 to-coffee-900 flex items-center justify-center overflow-hidden">
                    @if($menu->image)
                        <img src="{{ $menu->image_url }}" alt="{{ $menu->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="text-[9rem] opacity-20 py-20">☕</div>
                    @endif
                    
                    {{-- Stock / Best Seller Badge --}}
                    <div class="absolute top-4 left-4 flex flex-wrap gap-2">
                        @if($menu->is_best_seller)
                            <span class="badge badge-gold px-3 py-1 text-xs">⭐ Best Seller</span>
                        @endif
                        @if($menu->is_new)
                            <span class="badge badge-green px-3 py-1 text-xs">✨ Baru</span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Product Info Column --}}
            <div class="flex flex-col justify-between glass-card p-6 sm:p-8">
                <div>
                    {{-- Category and Name --}}
                    <span class="text-gold-600 font-bold tracking-widest text-xs uppercase mb-2 block">{{ $menu->category->name }}</span>
                    <h1 class="font-display text-3xl sm:text-4xl font-bold text-[#1B120D] mb-3 leading-tight">{{ $menu->name }}</h1>
                    
                    {{-- Rating / Details Row --}}
                    <div class="flex items-center gap-6 mb-6 text-sm text-[#3E2C1C]">
                        <span class="font-bold text-2xl text-gold-600">{{ $menu->formatted_price }}</span>
                        <div class="h-4 w-px bg-[#C5A880]/30"></div>
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-[#6F4E37]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $menu->preparation_time }} mnt penyajian
                        </span>
                    </div>

                    <div class="border-t border-[#C5A880]/40 pt-5 mb-6">
                        <h3 class="text-xs font-bold text-[#3E2C1C] uppercase tracking-widest mb-2">Deskripsi Rasa</h3>
                        <p class="text-[#6F4E37] text-sm leading-relaxed">{{ $menu->description }}</p>
                    </div>

                    {{-- Stock Warning --}}
                    <div class="mb-6 flex items-center gap-2 text-xs">
                        <span class="text-[#6F4E37]">Status Ketersediaan:</span>
                        @if($menu->stock > 0)
                            <span class="badge badge-green">Tersedia (Sisa {{ $menu->stock }} porsi)</span>
                        @else
                            <span class="badge badge-red">Habis Terjual</span>
                        @endif
                    </div>
                </div>

                {{-- Add to Cart Form --}}
                @auth
                    @if($menu->stock > 0)
                        <form method="POST" action="{{ route('customer.cart.add') }}" class="border-t border-[#C5A880]/40 pt-6">
                            @csrf
                            <input type="hidden" name="menu_id" value="{{ $menu->id }}">

                            {{-- Deteksi kategori: makanan atau minuman --}}
                            @php
                                $categoryName = strtolower($menu->category->slug ?? $menu->category->name ?? '');
                                $isFood = str_contains($categoryName, 'food')
                                       || str_contains($categoryName, 'makanan')
                                       || str_contains($categoryName, 'snack')
                                       || str_contains($categoryName, 'meal')
                                       || str_contains($categoryName, 'dessert')
                                       || str_contains($categoryName, 'pastry');
                                $isDrink = !$isFood;
                            @endphp

                            @if($isDrink)
                                {{-- Customization khusus MINUMAN --}}
                                <p class="text-xs font-bold text-[#3E2C1C] uppercase tracking-widest mb-3">Kustomisasi Minuman</p>
                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label class="form-label text-xs">Sugar Level</label>
                                        <select name="customizations[sugar]" class="form-input text-sm">
                                            <option value="Normal">Normal Sugar</option>
                                            <option value="Less Sugar">Less Sugar (50%)</option>
                                            <option value="Extra Sugar">Extra Sugar</option>
                                            <option value="No Sugar">No Sugar</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="form-label text-xs">Ice Level</label>
                                        <select name="customizations[ice]" class="form-input text-sm">
                                            <option value="Normal">Normal Ice</option>
                                            <option value="Less Ice">Less Ice</option>
                                            <option value="No Ice">No Ice</option>
                                            <option value="Extra Ice">Extra Ice</option>
                                        </select>
                                    </div>
                                </div>
                            @else
                                {{-- Customization khusus MAKANAN --}}
                                <p class="text-xs font-bold text-[#3E2C1C] uppercase tracking-widest mb-3">Kustomisasi Makanan</p>
                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label class="form-label text-xs">Tingkat Kematangan</label>
                                        <select name="customizations[doneness]" class="form-input text-sm">
                                            <option value="Normal">Normal</option>
                                            <option value="Well Done">Well Done</option>
                                            <option value="Medium">Medium</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="form-label text-xs">Porsi</label>
                                        <select name="customizations[portion]" class="form-input text-sm">
                                            <option value="Regular">Regular</option>
                                            <option value="Large">Large (+Rp 5.000)</option>
                                        </select>
                                    </div>
                                </div>
                            @endif

                            {{-- Catatan Opsional --}}
                            <div class="mb-6">
                                <label class="form-label text-xs">
                                    Catatan untuk Dapur
                                    <span class="text-[#C5A880] font-normal normal-case tracking-normal">(opsional)</span>
                                </label>
                                <textarea 
                                    name="customizations[notes]" 
                                    rows="2"
                                    class="form-input text-sm resize-none"
                                    placeholder="{{ $isFood ? 'Contoh: tanpa bawang, tidak pedas, alergi kacang...' : 'Contoh: tidak terlalu manis, tambah susu oat, less caffeine...' }}"
                                ></textarea>
                            </div>

                            {{-- Quantity selector and submit button --}}
                            <div class="flex flex-col sm:flex-row gap-4 items-stretch sm:items-center">
                                
                                {{-- Pure JS Quantity Selector --}}
                                <div class="flex items-center border border-[#C5A880]/50 rounded-lg overflow-hidden w-full sm:w-32 bg-[#F5ECD7] justify-between">
                                    <button type="button" onclick="changeQty(-1)"
                                            class="px-3 py-2 text-[#3E2C1C] hover:text-[#1B120D] hover:bg-[#EADDCD] transition-colors font-bold text-lg select-none">−</button>
                                    <input type="number" id="qty-input" name="quantity" 
                                           value="1" min="1" max="{{ $menu->stock }}"
                                           class="w-12 text-center bg-transparent border-none text-[#1B120D] font-bold focus:outline-none focus:ring-0 appearance-none">
                                    <button type="button" onclick="changeQty(1)"
                                            class="px-3 py-2 text-[#3E2C1C] hover:text-[#1B120D] hover:bg-[#EADDCD] transition-colors font-bold text-lg select-none">+</button>
                                </div>

                                <button type="submit" class="btn-primary flex-1 justify-center py-3.5">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-9H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                    Masukkan Keranjang
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="border-t border-[#C5A880]/40 pt-6">
                            <button disabled class="w-full btn-ghost py-3.5 font-bold cursor-not-allowed justify-center flex text-[#6F4E37] bg-white/40">
                                ❌ Menu Habis Sementara
                            </button>
                        </div>
                    @endif
                @else
                    <div class="border-t border-[#C5A880]/40 pt-6 text-center">
                        <a href="{{ route('login') }}" class="btn-primary w-full justify-center">
                            🔑 Login untuk Memesan
                        </a>
                    </div>
                @endauth

            </div>
        </div>

        {{-- Related Items Grid --}}
        @if($relatedMenus->isNotEmpty())
            <div class="border-t border-[#C5A880]/40 pt-16">
                <h2 class="font-display text-2xl font-bold text-[#1B120D] mb-8">Rekomendasi Menu Lainnya</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                    @foreach($relatedMenus as $rMenu)
                        <a href="{{ route('menu.show', $rMenu->slug) }}" class="group glass-card p-4 hover:border-gold-500/30 transition-all flex flex-col justify-between h-full">
                            <div class="aspect-square rounded-lg bg-gradient-to-br from-coffee-800 to-coffee-950 flex items-center justify-center overflow-hidden mb-4">
                                @if($rMenu->image)
                                    <img src="{{ $rMenu->image_url }}" alt="{{ $rMenu->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <span class="text-4xl opacity-50">☕</span>
                                @endif
                            </div>
                            <div>
                                <h4 class="font-semibold text-sm text-[#1B120D] group-hover:text-gold-600 transition-colors leading-tight mb-1 truncate">{{ $rMenu->name }}</h4>
                                <span class="font-bold text-xs text-gold-600">{{ $rMenu->formatted_price }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</div>

@push('scripts')
<script>
    const maxStock = {{ $menu->stock }};

    function changeQty(delta) {
        const input = document.getElementById('qty-input');
        let current = parseInt(input.value) || 1;
        let newVal = current + delta;
        if (newVal < 1) newVal = 1;
        if (newVal > maxStock) newVal = maxStock;
        input.value = newVal;
    }

    // Cegah input manual di luar batas
    document.getElementById('qty-input').addEventListener('change', function () {
        let val = parseInt(this.value) || 1;
        if (val < 1) val = 1;
        if (val > maxStock) val = maxStock;
        this.value = val;
    });
</script>
@endpush

@endsection