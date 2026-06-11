@extends('layouts.customer')

@section('title', 'Checkout Pembayaran — Zero Nine Coffee Shop')

@section('content')
<div class="min-h-screen pt-28 pb-20">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <h1 class="font-display text-3xl font-bold text-[#1B120D] mb-8">
            Checkout <span class="text-gradient-gold">Pesanan</span>
        </h1>

        <form method="POST" action="{{ route('customer.checkout.store') }}" class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            @csrf

            {{-- Form Input Column --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Customer Info --}}
                <div class="glass-card p-6">
                    <h3 class="font-display text-lg font-bold text-[#1B120D] mb-4 border-b border-[#C5A880]/40 pb-2">
                        Informasi Kontak
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label text-xs">Nama Lengkap</label>
                            <input type="text" value="{{ auth()->user()->name }}"
                                   class="form-input text-sm bg-[#F5ECD7]/60 text-[#6F4E37] cursor-not-allowed" disabled>
                        </div>
                        <div>
                            <label class="form-label text-xs">Alamat Email</label>
                            <input type="email" value="{{ auth()->user()->email }}"
                                   class="form-input text-sm bg-[#F5ECD7]/60 text-[#6F4E37] cursor-not-allowed" disabled>
                        </div>
                    </div>
                </div>

                {{-- Order Type --}}
                <div class="glass-card p-6">
                    <h3 class="font-display text-lg font-bold text-[#1B120D] mb-4 border-b border-[#C5A880]/40 pb-2">
                        Metode Pemesanan
                    </h3>

                    <div class="grid grid-cols-3 gap-3 mb-5">
                        <label id="label-dine_in"
                               class="order-type-label flex flex-col items-center justify-center p-4 rounded-lg border cursor-pointer transition-all border-gold-500 bg-[#F5ECD7] text-[#3E2C1C]"
                               onclick="selectType('dine_in')">
                            <input type="radio" name="order_type" value="dine_in" id="type-dine_in" class="hidden" checked>
                            <span class="text-2xl mb-1">🍽️</span>
                            <span class="text-xs font-semibold">Dine In</span>
                        </label>

                        <label id="label-takeaway"
                               class="order-type-label flex flex-col items-center justify-center p-4 rounded-lg border cursor-pointer transition-all border-[#C5A880]/40 bg-white/30 text-[#6F4E37] hover:bg-[#F5ECD7]/60"
                               onclick="selectType('takeaway')">
                            <input type="radio" name="order_type" value="takeaway" id="type-takeaway" class="hidden">
                            <span class="text-2xl mb-1">🛍️</span>
                            <span class="text-xs font-semibold">Take Away</span>
                        </label>

                        <label id="label-delivery"
                               class="order-type-label flex flex-col items-center justify-center p-4 rounded-lg border cursor-pointer transition-all border-[#C5A880]/40 bg-white/30 text-[#6F4E37] hover:bg-[#F5ECD7]/60"
                               onclick="selectType('delivery')">
                            <input type="radio" name="order_type" value="delivery" id="type-delivery" class="hidden">
                            <span class="text-2xl mb-1">🛵</span>
                            <span class="text-xs font-semibold">Delivery</span>
                        </label>
                    </div>

                    <div id="panel-dine_in" class="order-panel p-4 rounded-lg bg-[#F5ECD7]/60 border border-[#C5A880]/40 text-sm text-[#3E2C1C]">
                        @if($summary['cart']->table)
                            <span class="flex items-center gap-2">
                                📍 Kamu memesan dari meja:
                                <strong class="text-gold-600">Meja {{ $summary['cart']->table->number }} — {{ $summary['cart']->table->name }}</strong>
                            </span>
                        @else
                            <span class="flex items-start gap-2 text-yellow-700">
                                <span class="mt-0.5">⚠️</span>
                                <span>Kamu belum memilih meja. Jangan khawatir, Anda dapat memesan sekarang dan mengkonfirmasi meja pada saat pemesanan selesai.</span>
                            </span>
                        @endif
                    </div>

                    <div id="panel-takeaway" class="order-panel hidden p-4 rounded-lg bg-[#F5ECD7]/60 border border-[#C5A880]/40 text-sm text-[#3E2C1C]">
                        <span class="flex items-center gap-2">
                            🛍️ Pesanan Anda akan disiapkan untuk dibawa pulang. Ambil di kasir saat siap.
                        </span>
                    </div>

                    <div id="panel-delivery" class="order-panel hidden p-4 rounded-lg bg-[#F5ECD7]/60 border border-[#C5A880]/40 text-sm text-[#3E2C1C]">
                        <span class="flex items-center gap-2">
                            🛵 Layanan pesan antar akan dikoordinasikan oleh staf kami ke alamat default Anda.
                        </span>
                    </div>
                </div>

                {{-- Metode Pembayaran --}}
                <div class="glass-card p-6">
                    <h3 class="font-display text-lg font-bold text-[#1B120D] mb-4 border-b border-[#C5A880]/40 pb-2">
                        Metode Pembayaran
                    </h3>

                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">

                        <label id="label-pay-cash" onclick="selectPayment('cash')" class="cursor-pointer">
                            <input type="radio" name="payment_method" value="cash" id="pay-cash" class="hidden" checked>
                            <div id="card-pay-cash" class="border-2 border-gold-500 bg-[#F5ECD7] rounded-xl p-4 text-center transition-all h-full">
                                <div class="text-2xl mb-2">💵</div>
                                <div class="font-bold text-sm text-[#3E2C1C]">Kasir</div>
                                <div class="text-[10px] text-[#6F4E37] mt-1">Bayar Tunai</div>
                            </div>
                        </label>

                        <label id="label-pay-qris" onclick="selectPayment('qris')" class="cursor-pointer">
                            <input type="radio" name="payment_method" value="qris" id="pay-qris" class="hidden">
                            <div id="card-pay-qris" class="border-2 border-[#C5A880]/40 bg-white/30 rounded-xl p-4 text-center transition-all hover:bg-[#F5ECD7]/60 h-full">
                                <div class="text-2xl mb-2">📱</div>
                                <div class="font-bold text-sm text-[#3E2C1C]">QRIS</div>
                                <div class="text-[10px] text-[#6F4E37] mt-1">E-Wallet/M-Banking</div>
                            </div>
                        </label>

                        <label id="label-pay-transfer" onclick="selectPayment('transfer')" class="cursor-pointer">
                            <input type="radio" name="payment_method" value="transfer" id="pay-transfer" class="hidden">
                            <div id="card-pay-transfer" class="border-2 border-[#C5A880]/40 bg-white/30 rounded-xl p-4 text-center transition-all hover:bg-[#F5ECD7]/60 h-full">
                                <div class="text-2xl mb-2">🏦</div>
                                <div class="font-bold text-sm text-[#3E2C1C]">Transfer</div>
                                <div class="text-[10px] text-[#6F4E37] mt-1">Transfer Bank</div>
                            </div>
                        </label>

                        <label id="label-pay-cod" onclick="selectPayment('cod')" class="cursor-pointer">
                            <input type="radio" name="payment_method" value="cod" id="pay-cod" class="hidden">
                            <div id="card-pay-cod" class="border-2 border-[#C5A880]/40 bg-white/30 rounded-xl p-4 text-center transition-all hover:bg-[#F5ECD7]/60 h-full">
                                <div class="text-2xl mb-2">🛵</div>
                                <div class="font-bold text-sm text-[#3E2C1C]">COD</div>
                                <div class="text-[10px] text-[#6F4E37] mt-1">Bayar di Tempat</div>
                            </div>
                        </label>

                    </div>

                    @error('payment_method')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Special Notes --}}
                <div class="glass-card p-6">
                    <h3 class="font-display text-lg font-bold text-[#1B120D] mb-4 border-b border-[#C5A880]/40 pb-2">
                        Catatan Tambahan
                    </h3>
                    <div>
                        <label class="form-label text-xs">
                            Permintaan khusus
                            <span class="text-[#C5A880] font-normal normal-case tracking-normal">(opsional)</span>
                        </label>
                        <textarea name="special_notes" rows="3"
                                  placeholder="Contoh: Es dipisah, kurangi gula, dll."
                                  class="form-input text-sm resize-none"></textarea>
                    </div>
                </div>

            </div>

            {{-- Summary Card --}}
            <div class="glass-card p-5 space-y-5 lg:sticky lg:top-28">
                <h3 class="text-xs font-bold text-[#3E2C1C] uppercase tracking-widest border-b border-[#C5A880]/40 pb-3">
                    Detail Tagihan
                </h3>

                <div class="space-y-3 max-h-48 overflow-y-auto pr-1">
                    @foreach($summary['cart']->items as $item)
                        <div class="flex justify-between items-start gap-2 text-xs">
                            <div class="min-w-0">
                                <span class="font-semibold text-[#1B120D] block truncate">{{ $item->menu->name }}</span>
                                <span class="text-[#6F4E37] block mt-0.5">{{ $item->quantity }} x Rp {{ number_format($item->menu->price, 0, ',', '.') }}</span>
                            </div>
                            <span class="font-bold text-[#1B120D] flex-shrink-0">
                                Rp {{ number_format($item->menu->price * $item->quantity, 0, ',', '.') }}
                            </span>
                        </div>
                    @endforeach
                </div>

                <div class="border-t border-[#C5A880]/40 pt-4 space-y-2.5 text-xs text-[#6F4E37]">
                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span class="font-medium text-[#3E2C1C]">Rp {{ number_format($summary['subtotal'], 0, ',', '.') }}</span>
                    </div>
                    @if($summary['discount'] > 0)
                        <div class="flex justify-between text-green-600">
                            <span>Diskon Voucher</span>
                            <span class="font-medium">− Rp {{ number_format($summary['discount'], 0, ',', '.') }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between">
                        <span>PPN (10%)</span>
                        <span class="font-medium text-[#3E2C1C]">Rp {{ number_format($summary['tax'], 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Service (5%)</span>
                        <span class="font-medium text-[#3E2C1C]">Rp {{ number_format($summary['service'], 0, ',', '.') }}</span>
                    </div>
                    <div class="border-t border-[#C5A880]/40 pt-3 flex justify-between font-bold text-base text-[#1B120D]">
                        <span>Total Pembayaran</span>
                        <span class="text-gradient-gold">Rp {{ number_format($summary['total'], 0, ',', '.') }}</span>
                    </div>
                </div>

                {{-- Tombol submit — label berubah dinamis via JS --}}
                <button type="submit" id="submit-btn" class="btn-primary w-full py-3.5 justify-center font-bold">
                    💳 Buat Pesanan & Bayar Online
                </button>
            </div>

        </form>
    </div>
</div>

@push('scripts')
<script>
    const types = ['dine_in', 'takeaway', 'delivery'];

    function selectType(selected) {
        types.forEach(type => {
            const label = document.getElementById('label-' + type);
            const panel = document.getElementById('panel-' + type);
            const radio = document.getElementById('type-' + type);
            const isSelected = type === selected;

            label.classList.toggle('border-gold-500', isSelected);
            label.classList.toggle('bg-[#F5ECD7]', isSelected);
            label.classList.toggle('text-[#3E2C1C]', isSelected);
            label.classList.toggle('border-[#C5A880]/40', !isSelected);
            label.classList.toggle('bg-white/30', !isSelected);
            label.classList.toggle('text-[#6F4E37]', !isSelected);
            panel.classList.toggle('hidden', !isSelected);
            radio.checked = isSelected;
        });
    }

    const payMethods = ['cash', 'qris', 'transfer', 'cod'];

    function selectPayment(selected) {
        payMethods.forEach(method => {
            const card  = document.getElementById('card-pay-' + method);
            const radio = document.getElementById('pay-' + method);
            const isSelected = method === selected;

            card.classList.toggle('border-gold-500', isSelected);
            card.classList.toggle('bg-[#F5ECD7]', isSelected);
            card.classList.toggle('border-[#C5A880]/40', !isSelected);
            card.classList.toggle('bg-white/30', !isSelected);
            radio.checked = isSelected;
        });

        const btn = document.getElementById('submit-btn');
        if (selected === 'cash') {
            btn.innerHTML = '🛎️ Buat Pesanan (Bayar Kasir)';
        } else if (selected === 'qris') {
            btn.innerHTML = '📱 Buat Pesanan (Scan QRIS)';
        } else if (selected === 'transfer') {
            btn.innerHTML = '🏦 Buat Pesanan (Transfer Bank)';
        } else if (selected === 'cod') {
            btn.innerHTML = '🛵 Buat Pesanan (COD)';
        }
    }
</script>
@endpush

@endsection