@extends('layouts.customer')

@section('title', 'Keranjang Belanja — Zero Nine Coffee Shop')

@section('content')
<div class="min-h-screen pt-28 pb-20">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <h1 class="font-display text-3xl font-bold text-[#1B120D] mb-8">
            Keranjang <span class="text-gradient-gold">Belanja Anda</span>
        </h1>

        @if($summary['cart']->items->isEmpty())
            <div class="text-center py-20 glass-card">
                <span class="text-6xl">🛒</span>
                <h3 class="font-display text-2xl font-bold text-[#1B120D] mt-4">Keranjang Anda Kosong</h3>
                <p class="text-[#6F4E37] mt-2">Anda belum menambahkan menu apa pun ke keranjang belanja.</p>
                <a href="{{ route('menu.index') }}" class="btn-primary mt-6 inline-flex">Jelajahi Menu</a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

                {{-- Items Column --}}
                <div class="lg:col-span-2 space-y-4">
                    @foreach($summary['cart']->items as $item)
                        <div class="glass-card p-5" id="cart-item-{{ $item->id }}">

                            {{-- Baris atas: Gambar + Info --}}
                            <div class="flex flex-col sm:flex-row gap-4">

                                {{-- Gambar --}}
                                <div class="w-20 h-20 rounded-xl bg-gradient-to-br from-coffee-800 to-coffee-900 overflow-hidden flex-shrink-0 flex items-center justify-center">
                                    @if($item->menu->image)
                                        <img src="{{ $item->menu->image_url }}" alt="{{ $item->menu->name }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-3xl">☕</span>
                                    @endif
                                </div>

                                {{-- Info Menu --}}
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-2">
                                        <div>
                                            <h3 class="font-semibold text-[#1B120D] text-base leading-tight">{{ $item->menu->name }}</h3>
                                            <p class="text-gold-600 text-sm font-bold mt-0.5">
                                                Rp {{ number_format($item->menu->price, 0, ',', '.') }}
                                            </p>
                                        </div>
                                        {{-- Delete Button --}}
                                        <button type="button" onclick="deleteItem({{ $item->id }})"
                                                class="text-red-400 hover:text-red-600 p-1 transition-colors flex-shrink-0" title="Hapus">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>

                                    {{-- Customization Badges --}}
                                    @if($item->customizations)
                                        @php
                                            $notes = $item->customizations['notes'] ?? null;
                                            $customs = collect($item->customizations)->except('notes');
                                        @endphp

                                        @if($customs->isNotEmpty())
                                            <div class="flex flex-wrap gap-1.5 mt-2">
                                                @foreach($customs as $key => $val)
                                                    <span class="inline-flex items-center gap-1 bg-[#F5ECD7] border border-[#C5A880]/40 text-[#6F4E37] text-[11px] font-medium px-2 py-0.5 rounded-full">
                                                        <span class="text-[#C5A880]">{{ ucfirst($key) }}:</span> {{ $val }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @endif

                                        @if($notes)
                                            <div class="mt-2 flex items-start gap-1.5 text-xs text-[#6F4E37] bg-[#F5ECD7]/60 border border-[#C5A880]/30 rounded-lg px-3 py-1.5">
                                                <svg class="w-3.5 h-3.5 mt-0.5 flex-shrink-0 text-[#C5A880]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                                <span><span class="font-semibold text-[#3E2C1C]">Catatan:</span> {{ $notes }}</span>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>

                            {{-- Baris bawah: Qty + Total (pure JS, pakai stock dari $item->menu->stock) --}}
                            <div class="flex items-center justify-between mt-4 pt-4 border-t border-[#C5A880]/30">
                                
                                {{-- Quantity Selector --}}
                                <div class="flex items-center border border-[#C5A880]/50 rounded-lg overflow-hidden bg-[#F5ECD7]">
                                    <button type="button" onclick="updateQty({{ $item->id }}, -1)"
                                            class="px-3 py-1.5 text-[#3E2C1C] hover:bg-[#EADDCD] transition-colors font-bold text-base select-none">−</button>
                                    <span id="qty-text-{{ $item->id }}"
                                          class="w-9 text-center text-sm text-[#1B120D] font-bold select-none">{{ $item->quantity }}</span>
                                    <button type="button" onclick="updateQty({{ $item->id }}, 1)"
                                            class="px-3 py-1.5 text-[#3E2C1C] hover:bg-[#EADDCD] transition-colors font-bold text-base select-none">+</button>
                                </div>

                                {{-- Total per item --}}
                                <span class="font-bold text-[#1B120D] text-base" id="total-price-{{ $item->id }}">
                                    Rp {{ number_format($item->menu->price * $item->quantity, 0, ',', '.') }}
                                </span>
                            </div>

                        </div>
                    @endforeach
                </div>

                {{-- Summary Checkout Card --}}
                <div class="space-y-4 lg:sticky lg:top-28">

                    {{-- Promo Coupon Box --}}
                    <div class="glass-card p-5">
                        <h3 class="text-xs font-bold text-[#3E2C1C] uppercase tracking-widest mb-3">
                            🏷️ Kode Promo / Voucher
                        </h3>
                        <div class="flex gap-2">
                            <input type="text" id="promo-code"
                                   value="{{ $summary['cart']->promo?->code }}"
                                   placeholder="Ketik kode kupon..."
                                   class="form-input text-sm flex-1 uppercase"
                                   {{ $summary['cart']->promo_id ? 'disabled' : '' }}>
                            <button type="button" id="promo-btn" onclick="togglePromo()"
                                    class="px-4 py-2 text-sm font-bold rounded-lg transition-all {{ $summary['cart']->promo_id ? 'btn-danger' : 'btn-primary' }}">
                                {{ $summary['cart']->promo_id ? 'Hapus' : 'Gunakan' }}
                            </button>
                        </div>
                        <div id="promo-alert" class="text-xs mt-2 hidden"></div>

                        @if($summary['cart']->promo_id)
                            <div class="mt-2 flex items-center gap-1.5 text-xs text-green-700 bg-green-50 border border-green-200 rounded-lg px-3 py-1.5">
                                <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Promo <strong>{{ $summary['cart']->promo->code }}</strong> berhasil diterapkan!
                            </div>
                        @endif
                    </div>

                    {{-- Receipt Breakdown Box --}}
                    <div class="glass-card p-5">
                        <h3 class="text-xs font-bold text-[#3E2C1C] uppercase tracking-widest border-b border-[#C5A880]/40 pb-3 mb-4">
                            Ringkasan Pesanan
                        </h3>

                        <div class="space-y-2.5 text-sm text-[#6F4E37]">
                            <div class="flex justify-between">
                                <span>Subtotal</span>
                                <span id="subtotal-val" class="font-medium text-[#3E2C1C]">
                                    Rp {{ number_format($summary['subtotal'], 0, ',', '.') }}
                                </span>
                            </div>

                            <div class="flex justify-between text-green-600 {{ $summary['discount'] > 0 ? '' : 'hidden' }}" id="discount-row">
                                <span>Diskon Promo</span>
                                <span id="discount-val" class="font-medium">
                                    − Rp {{ number_format($summary['discount'], 0, ',', '.') }}
                                </span>
                            </div>

                            <div class="flex justify-between">
                                <span>Pajak (PPN 10%)</span>
                                <span id="tax-val" class="font-medium text-[#3E2C1C]">
                                    Rp {{ number_format($summary['tax'], 0, ',', '.') }}
                                </span>
                            </div>

                            <div class="flex justify-between">
                                <span>Service Charge (5%)</span>
                                <span id="service-val" class="font-medium text-[#3E2C1C]">
                                    Rp {{ number_format($summary['service'], 0, ',', '.') }}
                                </span>
                            </div>

                            <div class="border-t border-[#C5A880]/40 pt-3 mt-1 flex justify-between font-bold text-base text-[#1B120D]">
                                <span>Total Pembayaran</span>
                                <span id="total-val" class="text-gradient-gold text-lg">
                                    Rp {{ number_format($summary['total'], 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        <a href="{{ route('customer.checkout.index') }}" class="btn-primary w-full py-3.5 justify-center font-bold mt-5 flex">
                            🛍️ Lanjutkan ke Checkout
                        </a>
                    </div>

                </div>
            </div>
        @endif

    </div>
</div>

@push('scripts')
<script>
    function updateQty(itemId, delta) {
        const qtySpan = document.getElementById('qty-text-' + itemId);
        let newQty = parseInt(qtySpan.textContent) + delta;
        if (newQty <= 0) return deleteItem(itemId);

        fetch(`/cart/items/${itemId}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ quantity: newQty })
        })
        .then(res => {
            if (!res.ok) throw new Error('Stok tidak mencukupi.');
            return res.json();
        })
        .then(() => window.location.reload())
        .catch(err => alert(err.message));
    }

    function deleteItem(itemId) {
        if (!confirm('Hapus menu ini dari keranjang?')) return;

        fetch(`/cart/items/${itemId}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        })
        .then(res => res.json())
        .then(() => window.location.reload());
    }

    function togglePromo() {
        const promoBtn = document.getElementById('promo-btn');
        const isApplied = promoBtn.classList.contains('btn-danger');

        if (isApplied) {
            fetch(`/cart/promo`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            })
            .then(res => res.json())
            .then(() => window.location.reload());
        } else {
            const code = document.getElementById('promo-code').value.trim();
            const alertBox = document.getElementById('promo-alert');
            if (!code) return alert('Ketik kode promo terlebih dahulu!');

            fetch(`/cart/promo`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ code: code })
            })
            .then(res => {
                if (!res.ok) return res.json().then(d => { throw new Error(d.message) });
                return res.json();
            })
            .then(() => window.location.reload())
            .catch(err => {
                alertBox.textContent = err.message;
                alertBox.className = "text-xs mt-2 text-red-500 font-semibold block";
            });
        }
    }
</script>
@endpush
@endsection