@extends('layouts.customer')

@section('title', 'Reservasi Meja Saya — Zero Nine Coffee Shop')

@section('content')
<div class="min-h-screen pt-28 pb-20" style="background:#FDF6EC;">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
            <div>
                <h1 class="font-display text-3xl font-bold text-stone-900">Reservasi <span class="text-amber-800">Meja Anda</span></h1>
                <p class="text-stone-600 mt-1 text-sm">Kelola daftar pemesanan meja dan VIP lounge Zero Nine.</p>
            </div>
            <a href="{{ route('customer.bookings.create') }}" class="inline-flex items-center gap-2 bg-amber-700 hover:bg-amber-800 text-white font-semibold py-2.5 px-5 rounded-xl text-sm transition-colors shadow-sm">
                📅 Buat Reservasi Baru
            </a>
        </div>

        @if(session('success'))
            <div class="flex items-start gap-3 bg-emerald-50 border border-emerald-300 text-emerald-800 p-4 rounded-xl mb-6 text-sm shadow-sm">
                <span class="text-xl leading-none mt-0.5">✅</span>
                <div>
                    <p class="font-semibold">Reservasi Berhasil Dibuat!</p>
                    <p class="text-emerald-700 mt-0.5">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if($bookings->isEmpty())
            <div class="text-center py-20 rounded-2xl" style="background:rgba(255,255,255,0.7); border:1px solid rgba(197,168,128,0.3);">
                <span class="text-6xl">📅</span>
                <h3 class="font-display text-2xl font-bold text-stone-800 mt-4">Belum Ada Reservasi</h3>
                <p class="text-stone-500 mt-2">Anda belum memiliki riwayat atau pemesanan meja aktif.</p>
                <a href="{{ route('customer.bookings.create') }}" class="inline-flex items-center gap-2 bg-amber-700 hover:bg-amber-800 text-white font-semibold py-2.5 px-5 rounded-xl text-sm transition-colors shadow-sm mt-6">
                    Pesan Meja Sekarang
                </a>
            </div>
        @else
            <div class="rounded-2xl overflow-hidden" style="background:rgba(255,255,255,0.7); border:1px solid rgba(197,168,128,0.3);">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr style="background:rgba(197,168,128,0.12); border-bottom:1px solid rgba(197,168,128,0.3);">
                                <th class="text-left text-xs font-bold text-stone-600 uppercase tracking-wider px-5 py-3.5">Kode Booking</th>
                                <th class="text-left text-xs font-bold text-stone-600 uppercase tracking-wider px-5 py-3.5">Tanggal</th>
                                <th class="text-left text-xs font-bold text-stone-600 uppercase tracking-wider px-5 py-3.5">Waktu</th>
                                <th class="text-left text-xs font-bold text-stone-600 uppercase tracking-wider px-5 py-3.5">Meja</th>
                                <th class="text-left text-xs font-bold text-stone-600 uppercase tracking-wider px-5 py-3.5">Jumlah Tamu</th>
                                <th class="text-left text-xs font-bold text-stone-600 uppercase tracking-wider px-5 py-3.5">Status</th>
                                <th class="text-left text-xs font-bold text-stone-600 uppercase tracking-wider px-5 py-3.5">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-200">
                            @foreach($bookings as $booking)
                                <tr class="hover:bg-stone-50 transition-colors">
                                    <td class="px-5 py-4 font-mono font-bold text-amber-800">#{{ $booking->booking_code }}</td>
                                    <td class="px-5 py-4 text-stone-700">{{ Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</td>
                                    <td class="px-5 py-4">
                                        <span class="font-semibold text-stone-800">
                                            {{ substr($booking->start_time, 0, 5) }} – {{ substr($booking->end_time, 0, 5) }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4">
                                        <span class="text-amber-800 font-semibold">Meja {{ $booking->table->number }}</span>
                                        <span class="text-[10px] text-stone-500 block">{{ $booking->table->name }}</span>
                                    </td>
                                    <td class="px-5 py-4 font-bold text-stone-800">{{ $booking->guest_count }} Orang</td>
                                    <td class="px-5 py-4">
                                        @if($booking->status === 'pending')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-amber-100 text-amber-800 border border-amber-300">Menunggu Persetujuan</span>
                                        @elseif($booking->status === 'confirmed')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-blue-100 text-blue-800 border border-blue-300">Telah Dikonfirmasi</span>
                                        @elseif($booking->status === 'checked_in')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-emerald-100 text-emerald-800 border border-emerald-300">Checked In</span>
                                        @elseif($booking->status === 'completed')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-stone-200 text-stone-700 border border-stone-400">Selesai</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-red-100 text-red-800 border border-red-300">Dibatalkan</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4">
                                        <a href="{{ route('customer.bookings.show', $booking->id) }}"
                                           class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-white border border-stone-300 text-stone-700 hover:bg-stone-50 hover:border-stone-400 transition-colors">
                                            Lihat Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6">
                {{ $bookings->links() }}
            </div>
        @endif

    </div>
</div>
@endsection