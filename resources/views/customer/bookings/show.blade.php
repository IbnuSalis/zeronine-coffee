@extends('layouts.customer')

@section('title', 'Detail Reservasi #' . $booking->booking_code . ' — Zero Nine Coffee Shop')

@section('content')
<div class="min-h-screen pt-28 pb-20" style="background:#FDF6EC;">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <a href="{{ route('customer.bookings.index') }}" class="inline-flex items-center gap-2 text-amber-800 hover:text-amber-950 mb-8 transition-colors text-sm font-medium">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar Reservasi
        </a>

        @if(session('success'))
            <div class="flex items-start gap-3 bg-emerald-50 border border-emerald-300 text-emerald-800 p-4 rounded-xl mb-6 text-sm shadow-sm">
                <span class="text-xl leading-none mt-0.5">✅</span>
                <div>
                    <p class="font-semibold">Berhasil!</p>
                    <p class="text-emerald-700 mt-0.5">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="flex items-start gap-3 bg-red-50 border border-red-300 text-red-800 p-4 rounded-xl mb-6 text-sm shadow-sm">
                <span class="text-xl leading-none mt-0.5">⚠️</span>
                <div>
                    <p class="font-semibold">Terjadi Kesalahan</p>
                    <p class="text-red-700 mt-0.5">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">

            {{-- Details Info Card --}}
            <div class="md:col-span-2 space-y-6">

                {{-- Summary Info Card --}}
                <div class="rounded-2xl p-6" style="background:rgba(255,255,255,0.7); border:1px solid rgba(197,168,128,0.3);">
                    <div class="flex justify-between items-center border-b border-stone-300 pb-4 mb-6">
                        <div>
                            <span class="text-xs text-stone-500 uppercase tracking-wide font-semibold">Kode Booking</span>
                            <h2 class="font-mono font-bold text-xl text-amber-800 mt-0.5">#{{ $booking->booking_code }}</h2>
                        </div>
                        <div class="text-right">
                            <span class="text-xs text-stone-500 uppercase tracking-wide font-semibold block mb-1">Tanggal Request</span>
                            <span class="text-sm font-semibold text-stone-700">{{ $booking->created_at->format('d M Y') }}</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-y-5 text-sm">
                        <div>
                            <span class="text-xs text-stone-500 uppercase tracking-wide font-semibold block mb-1">Nama Kontak</span>
                            <span class="font-bold text-stone-900">{{ $booking->contact_name }}</span>
                        </div>
                        <div>
                            <span class="text-xs text-stone-500 uppercase tracking-wide font-semibold block mb-1">No. Telepon</span>
                            <span class="font-bold text-stone-900">{{ $booking->contact_phone }}</span>
                        </div>
                        <div>
                            <span class="text-xs text-stone-500 uppercase tracking-wide font-semibold block mb-1">Jadwal Jam</span>
                            <span class="font-bold text-stone-900">{{ substr($booking->start_time, 0, 5) }} – {{ substr($booking->end_time, 0, 5) }}</span>
                        </div>
                        <div>
                            <span class="text-xs text-stone-500 uppercase tracking-wide font-semibold block mb-1">Jumlah Tamu</span>
                            <span class="font-bold text-stone-900">{{ $booking->guest_count }} Orang</span>
                        </div>
                        @if($booking->occasion)
                            <div class="col-span-2">
                                <span class="text-xs text-stone-500 uppercase tracking-wide font-semibold block mb-1">Acara</span>
                                <span class="inline-flex items-center px-3 py-1 rounded-lg bg-amber-100 border border-amber-300 text-amber-800 font-semibold text-sm">{{ $booking->occasion }}</span>
                            </div>
                        @endif
                        @if($booking->special_requests)
                            <div class="col-span-2">
                                <span class="text-xs text-stone-500 uppercase tracking-wide font-semibold block mb-2">Catatan Tambahan</span>
                                <p class="text-stone-700 bg-white border border-stone-300 p-3 rounded-xl text-sm italic">"{{ $booking->special_requests }}"</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Cancel Booking --}}
                @if(in_array($booking->status, ['pending', 'confirmed']))
                    <div class="rounded-2xl p-6" style="background:rgba(255,255,255,0.7); border:1px solid rgba(197,168,128,0.3);">
                        <h3 class="font-display text-base font-bold text-red-700 border-b border-stone-300 pb-3 mb-4">🚫 Batalkan Reservasi</h3>
                        <form method="POST" action="{{ route('customer.bookings.cancel', $booking->id) }}" class="flex gap-3">
                            @csrf
                            <input type="text" name="reason" placeholder="Ketik alasan pembatalan..." required
                                class="flex-1 px-3 py-2.5 rounded-xl border border-stone-400 bg-white text-stone-800 text-sm focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-red-400 transition">
                            <button type="submit"
                                class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white text-sm font-bold rounded-xl transition-colors shadow-sm"
                                onclick="return confirm('Apakah Anda yakin ingin membatalkan booking ini?')">
                                Batalkan
                            </button>
                        </form>
                    </div>
                @endif

            </div>

            {{-- Status and Table Info Side Card --}}
            <div class="space-y-5" style="background:rgba(255,255,255,0.7); border:1px solid rgba(197,168,128,0.3); border-radius:1rem; padding:1.25rem;">
                <h3 class="text-xs font-bold text-stone-600 uppercase tracking-widest border-b border-stone-300 pb-3">Status & Detail Meja</h3>

                {{-- Status Banner --}}
                <div>
                    @if($booking->status === 'pending')
                        <div class="flex items-center justify-center gap-2 bg-amber-100 border border-amber-300 text-amber-800 py-3 px-4 rounded-xl font-bold text-sm text-center">
                            🕐 Menunggu Persetujuan
                        </div>
                    @elseif($booking->status === 'confirmed')
                        <div class="flex items-center justify-center gap-2 bg-blue-100 border border-blue-300 text-blue-800 py-3 px-4 rounded-xl font-bold text-sm text-center">
                            ✅ Telah Dikonfirmasi
                        </div>
                    @elseif($booking->status === 'checked_in')
                        <div class="flex items-center justify-center gap-2 bg-emerald-100 border border-emerald-300 text-emerald-800 py-3 px-4 rounded-xl font-bold text-sm text-center">
                            🟢 Checked In
                        </div>
                    @elseif($booking->status === 'completed')
                        <div class="flex items-center justify-center gap-2 bg-stone-200 border border-stone-400 text-stone-700 py-3 px-4 rounded-xl font-bold text-sm text-center">
                            🏁 Selesai
                        </div>
                    @else
                        <div class="bg-red-100 border border-red-300 text-red-800 py-3 px-4 rounded-xl font-bold text-sm text-center">
                            🚫 Dibatalkan
                        </div>
                        @if($booking->cancellation_reason)
                            <p class="text-xs text-stone-600 mt-2 text-center italic">Alasan: {{ $booking->cancellation_reason }}</p>
                        @endif
                    @endif
                </div>

                {{-- Table Information --}}
                <div class="p-4 rounded-xl text-center" style="background:rgba(255,255,255,0.9); border:1px solid rgba(197,168,128,0.3);">
                    <span class="text-3xl block mb-2">🪑</span>
                    <h4 class="font-bold text-stone-900 text-base">Meja {{ $booking->table->number }}</h4>
                    <p class="text-xs text-stone-500 mt-1">Kapasitas Maksimal: {{ $booking->table->capacity }} Orang</p>
                    <span class="inline-block mt-3 px-3 py-1 rounded-lg bg-amber-100 border border-amber-300 text-amber-800 text-[10px] font-bold uppercase tracking-wider">
                        {{ $booking->table->name }}
                    </span>
                </div>

                {{-- Booking Date --}}
                <div class="p-4 rounded-xl text-center" style="background:rgba(255,255,255,0.9); border:1px solid rgba(197,168,128,0.3);">
                    <span class="text-xs text-stone-500 uppercase tracking-wide font-semibold block mb-1">Tanggal Reservasi</span>
                    <span class="font-bold text-stone-900 text-base">{{ Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</span>
                    <span class="text-sm text-stone-600 block mt-0.5">{{ Carbon\Carbon::parse($booking->booking_date)->translatedFormat('l') }}</span>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection