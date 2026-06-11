@extends('layouts.customer')

@section('title', 'Detail Pesanan #' . $order->order_number . ' — Zero Nine Coffee Shop')

@section('content')
<div class="min-h-screen pt-28 pb-20 bg-[#c8a06e]">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Back button --}}
        <a href="{{ route('customer.orders.index') }}" class="inline-flex items-center gap-2 text-[#6b4c2a] hover:text-[#3b2a1a] mb-8 transition-colors text-sm font-medium">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar Pesanan
        </a>

        @if(session('success') || session('snap_token'))
            <div class="bg-green-100 border border-green-300 text-green-800 p-4 rounded-lg mb-6 text-sm">
                {{ session('success') ?? 'Pesanan berhasil dibuat! Silakan lanjutkan pembayaran.' }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-300 text-red-800 p-4 rounded-lg mb-6 text-sm">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 {{ $order->payment_status === 'paid' || $order->status === 'cancelled' ? 'lg:grid-cols-1 max-w-3xl mx-auto' : 'md:grid-cols-3' }} gap-6 items-start">
            
            <div class="{{ $order->payment_status === 'paid' || $order->status === 'cancelled' ? '' : 'md:col-span-2' }} space-y-6">
                
                {{-- Tracking Card --}}
                <div class="bg-[#f5ede0] rounded-2xl shadow-sm p-6">
                    <div class="flex justify-between items-center border-b border-[#d4b896] pb-4 mb-6">
                        <div>
                            <span class="text-xs text-[#6b4c2a]">Kode Pesanan</span>
                            <h2 class="font-mono font-bold text-lg text-[#3b2a1a]">#{{ $order->order_number }}</h2>
                        </div>
                        <div class="text-right">
                            <span class="text-xs text-[#6b4c2a] block mb-1">Tanggal Pesan</span>
                            <span class="text-sm font-medium text-[#3b2a1a]">{{ $order->created_at->format('d M Y, H:i') }}</span>
                        </div>
                    </div>

                    @if($order->status !== 'cancelled')
                        <h3 class="text-xs font-bold text-[#6b4c2a] uppercase tracking-widest mb-6">Status Pengerjaan</h3>
                        
                        <div class="relative flex items-center justify-between">
                            <div class="absolute left-0 right-0 h-1 bg-[#d4b896] z-0"></div>
                            
                            @php
                                $width = '0%';
                                if($order->status === 'processing') $width = '33%';
                                if($order->status === 'ready') $width = '66%';
                                if($order->status === 'completed') $width = '100%';
                            @endphp
                            <div class="absolute left-0 h-1 bg-[#b8860b] z-0 transition-all duration-1000" style="width: {{ $width }}"></div>

                            @foreach([
                                ['label' => 'Diterima', 'statuses' => ['pending','processing','ready','completed']],
                                ['label' => 'Dibuat',   'statuses' => ['processing','ready','completed']],
                                ['label' => 'Siap',     'statuses' => ['ready','completed']],
                                ['label' => 'Selesai',  'statuses' => ['completed']],
                            ] as $i => $step)
                                <div class="flex flex-col items-center z-10">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs transition-colors 
                                        {{ in_array($order->status, $step['statuses']) 
                                            ? 'bg-[#b8860b] text-white shadow-md' 
                                            : 'bg-[#d4b896] text-[#6b4c2a]' }}">
                                        {{ $i + 1 }}
                                    </div>
                                    <span class="text-[10px] font-semibold text-[#6b4c2a] mt-2">{{ $step['label'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-red-50 border border-red-200 text-red-600 p-4 rounded-lg text-sm text-center">
                            ❌ Pesanan ini telah dibatalkan.
                            @if($order->cancellation_reason)
                                <span class="opacity-70">(Alasan: {{ $order->cancellation_reason }})</span>
                            @endif
                        </div>
                    @endif
                </div>

                {{-- Order Items Card --}}
                <div class="bg-[#f5ede0] rounded-2xl shadow-sm p-6">
                    <h3 class="font-display text-base font-bold text-[#3b2a1a] border-b border-[#d4b896] pb-3 mb-4">Daftar Item Menu</h3>
                    <div class="space-y-4">
                        @foreach($order->items as $item)
                            <div class="flex justify-between items-center text-sm border-b border-[#d4b896]/50 pb-3">
                                <div>
                                    <span class="font-semibold text-[#3b2a1a]">{{ $item->menu_name }}</span>
                                    <div class="flex gap-2 text-[10px] text-[#6b4c2a] mt-1">
                                        <span>Jumlah: <strong>{{ $item->quantity }}x</strong></span>
                                        @if($item->customizations)
                                            @foreach($item->customizations as $k => $v)
                                                <span>• {{ ucfirst($k) }}: <strong>{{ $v }}</strong></span>
                                            @endforeach
                                        @endif
                                    </div>
                                    @if($item->notes)
                                        <span class="text-[10px] text-amber-700 italic block mt-1">📝 "{{ $item->notes }}"</span>
                                    @endif
                                </div>
                                <span class="font-bold text-[#3b2a1a]">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-4 pt-4 border-t border-[#d4b896] space-y-2.5 text-xs text-[#6b4c2a]">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span class="font-semibold text-[#3b2a1a]">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Pajak (PPN)</span>
                            <span class="font-semibold text-[#3b2a1a]">Rp {{ number_format($order->tax_amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Service Charge</span>
                            <span class="font-semibold text-[#3b2a1a]">Rp {{ number_format($order->service_charge, 0, ',', '.') }}</span>
                        </div>
                        @if($order->discount_amount > 0)
                            <div class="flex justify-between text-green-700">
                                <span>Promo Potongan</span>
                                <span class="font-semibold">- Rp {{ number_format($order->discount_amount, 0, ',', '.') }}</span>
                            </div>
                        @endif
                        <div class="border-t border-[#d4b896]/50 pt-3 mt-1 flex justify-between font-bold text-base text-[#3b2a1a]">
                            <span>Total Bayar</span>
                            <span class="text-[#b8860b]">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Review Form --}}
                @if($order->status === 'completed')
                    <div class="bg-[#f5ede0] rounded-2xl shadow-sm p-6">
                        <h3 class="font-display text-base font-bold text-[#3b2a1a] border-b border-[#d4b896] pb-3 mb-4">📝 Berikan Ulasan</h3>
                        <form method="POST" action="{{ route('customer.orders.review', $order->id) }}" class="space-y-4">
                            @csrf
                            <div>
                                <label class="text-xs font-medium text-[#6b4c2a] block mb-1">Rating (Bintang)</label>
                                <select name="rating" class="form-input text-sm bg-white border-[#d4b896] text-[#3b2a1a]">
                                    <option value="5">⭐⭐⭐⭐⭐ Sangat Puas</option>
                                    <option value="4">⭐⭐⭐⭐ Puas</option>
                                    <option value="3">⭐⭐⭐ Cukup</option>
                                    <option value="2">⭐⭐ Kurang</option>
                                    <option value="1">⭐ Sangat Kurang</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-xs font-medium text-[#6b4c2a] block mb-1">Komentar / Ulasan</label>
                                <textarea name="comment" rows="2" placeholder="Bagikan pendapat Anda..." class="form-input text-sm bg-white border-[#d4b896] text-[#3b2a1a]"></textarea>
                            </div>
                            <button type="submit" class="btn-primary py-2 px-5 text-sm">Kirim Ulasan</button>
                        </form>
                    </div>
                @endif

                {{-- Cancel Form --}}
                @if($order->status === 'pending' && $order->payment_status === 'unpaid')
                    <div class="bg-[#f5ede0] rounded-2xl shadow-sm p-6">
                        <h3 class="font-display text-base font-bold text-[#3b2a1a] border-b border-[#d4b896] pb-3 mb-4">🚫 Batalkan Pesanan</h3>
                        <form method="POST" action="{{ route('customer.orders.cancel', $order->id) }}" class="flex gap-3">
                            @csrf
                            <input type="text" name="reason" placeholder="Alasan pembatalan..." required class="form-input text-sm flex-1 bg-white border-[#d4b896] text-[#3b2a1a]">
                            <button type="submit" class="btn-danger px-5 py-2 text-sm font-bold rounded-lg transition-all" onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">
                                Batalkan
                            </button>
                        </form>
                    </div>
                @endif

            </div>

            @if($order->payment_status === 'unpaid' && $order->status !== 'cancelled')
            {{-- Payment Card --}}
            <div class="bg-[#f5ede0] rounded-2xl shadow-sm p-5 space-y-5">

                @if($order->payment_method === 'cash')
                    <div class="text-center py-6 px-4 bg-[#fdf6ec] border-2 border-[#d4b896] rounded-xl text-[#6b4c2a] space-y-3 shadow-sm">
                        <p class="text-sm font-bold uppercase tracking-wider text-[#3b2a1a]">💵 Bayar di Kasir</p>
                        <p class="text-xs">Tunjukkan QR Code ini kepada Kasir untuk mempermudah pencarian pesanan.</p>
                        <div class="bg-white p-3 inline-block rounded-xl shadow border border-[#d4b896] mt-2">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&color=3b2a1a&bgcolor=ffffff&data={{ urlencode($order->order_number) }}" alt="Order QR" class="w-32 h-32 rounded">
                        </div>
                        <p class="font-mono font-bold text-lg text-[#b8860b] mt-2 tracking-widest">{{ $order->order_number }}</p>
                    </div>

                @elseif($order->payment_method === 'qris')
                    <div class="text-center py-6 px-4 bg-[#fdf6ec] border-2 border-[#d4b896] rounded-xl text-[#6b4c2a] space-y-3 shadow-sm">
                        <p class="text-sm font-bold uppercase tracking-wider text-[#3b2a1a]">📱 Scan QRIS</p>
                        <p class="text-xs">Scan kode QRIS ini menggunakan aplikasi E-Wallet (Gopay, OVO, DANA) atau Mobile Banking.</p>
                        <div class="bg-white p-3 inline-block rounded-xl shadow border border-[#d4b896] mt-2">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&color=111111&bgcolor=ffffff&data=00020101021126580011ID.CO.QRIS.WWW01189360091530222019010214352726330015ID.CO.QRIS.WWW0215ID10200210344560303UMI51440014ID.CO.QRIS.WWW0215ID10200210344560303UMI5204581453033605802ID5918Zero%20Nine%20Coffee6007Bandung610540112621601050201104031236304FC76" alt="QRIS" class="w-40 h-40 rounded">
                        </div>
                        <p class="text-sm font-bold text-[#b8860b] mt-2 tracking-widest">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                    </div>

                @elseif($order->payment_method === 'transfer')
                    <div class="text-left py-6 px-5 bg-[#fdf6ec] border-2 border-[#d4b896] rounded-xl text-[#6b4c2a] space-y-4 shadow-sm">
                        <p class="text-sm font-bold uppercase tracking-wider text-[#3b2a1a] border-b border-[#d4b896] pb-2">🏦 Transfer Virtual Account</p>
                        <p class="text-xs leading-relaxed">Transfer sesuai nominal <strong class="text-[#3b2a1a] text-sm">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong> ke rekening Virtual Account di bawah ini:</p>
                        
                        <div class="bg-white p-4 rounded-xl shadow-inner border border-[#d4b896] flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mt-2">
                            <div>
                                <p class="font-bold text-[#3b2a1a] text-sm mb-1">Bank BCA</p>
                                <p class="font-mono text-xl tracking-wider text-[#b8860b] font-bold">123 456 7890</p>
                                <p class="text-xs text-gray-500 font-medium uppercase mt-1">A.N. Zero Nine Coffee</p>
                            </div>
                        </div>
                    </div>

                @elseif($order->payment_method === 'cod')
                    <div class="text-center py-6 px-4 bg-[#fdf6ec] border-2 border-[#d4b896] rounded-xl text-[#6b4c2a] space-y-3 shadow-sm">
                        <p class="text-sm font-bold uppercase tracking-wider text-[#3b2a1a]">🛵 Cash on Delivery (COD)</p>
                        <p class="text-xs">Silakan siapkan uang pas sejumlah total bayar untuk diberikan kepada kurir atau kasir kami.</p>
                        <div class="bg-white py-3 px-4 rounded-xl shadow-inner border border-amber-200 inline-block mt-3">
                            <p class="text-xs text-amber-700 font-semibold">Siapkan uang tunai sejumlah:</p>
                            <p class="text-xl font-bold text-[#3b2a1a] mt-1">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                        </div>
                    </div>
                @endif

                <div class="mt-2 pt-2">
                    <form method="POST" action="{{ route('customer.orders.confirm-payment', $order->id) }}">
                        @csrf
                        <button type="submit" class="w-full py-3.5 bg-[#b8860b] hover:bg-[#9a6f09] text-white font-bold text-sm rounded-xl transition-colors shadow-sm flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            Bayar
                        </button>
                    </form>
                </div>
            </div>
            @endif

            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
    function selectTripayMethod(code, label) {
        document.getElementById('tripay_payment_method').value = code;

        document.querySelectorAll('.tripay-method-btn').forEach(btn => {
            btn.classList.remove('border-[#b8860b]', 'bg-[#fdf6ec]');
            btn.classList.add('border-[#d4b896]', 'bg-white');
        });

        const selectedBtn = document.getElementById('method-btn-' + code);
        if (selectedBtn) {
            selectedBtn.classList.remove('border-[#d4b896]', 'bg-white');
            selectedBtn.classList.add('border-[#b8860b]', 'bg-[#fdf6ec]');
        }

        const labelEl = document.getElementById('selected-method-label');
        const displayEl = document.getElementById('selected-method-display');
        if (labelEl) { labelEl.textContent = label; }
        if (displayEl) { displayEl.classList.remove('hidden'); }

        const submitBtn = document.getElementById('tripay-submit-btn');
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.classList.remove('bg-[#d4b896]', 'text-[#a07850]', 'cursor-not-allowed');
            submitBtn.classList.add('bg-[#b8860b]', 'hover:bg-[#9a6f09]', 'text-white', 'cursor-pointer');
        }
    }

    function validateTripayForm() {
        const method = document.getElementById('tripay_payment_method').value;
        if (!method) {
            alert('Silakan pilih metode pembayaran terlebih dahulu.');
            return false;
        }
        return true;
    }
</script>
@endpush
@endsection