@extends('layouts.admin')

@section('title', 'Kelola Reservasi')
@section('page-title', 'Daftar Reservasi')

@section('content')
<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-gray-50/50">
        <h2 class="text-base font-bold text-gray-800">Semua Reservasi</h2>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 border-b border-gray-200 text-gray-600 text-xs uppercase font-bold tracking-wider">
                <tr>
                    <th class="px-6 py-4">Kode / Tgl</th>
                    <th class="px-6 py-4">Pelanggan</th>
                    <th class="px-6 py-4">Detail</th>
                    <th class="px-6 py-4">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($bookings as $booking)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="font-mono font-bold text-gray-900">#{{ $booking->booking_code }}</div>
                            <div class="text-xs text-gray-500 mt-1">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</div>
                            <div class="text-xs text-amber-700 font-semibold mt-0.5">{{ substr($booking->start_time, 0, 5) }} - {{ substr($booking->end_time, 0, 5) }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-900">{{ $booking->contact_name }}</div>
                            <div class="text-xs text-gray-500 mt-0.5">{{ $booking->contact_phone }}</div>
                            @if($booking->user)
                                <div class="text-[10px] bg-blue-100 text-blue-800 px-2 py-0.5 rounded mt-1 inline-block">Registered User</div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-semibold text-gray-800">{{ $booking->guest_count }} Orang</div>
                            <div class="text-xs text-gray-600 mt-0.5">Meja: <span class="font-bold">{{ $booking->table->number }}</span></div>
                            @if($booking->occasion)
                                <div class="text-xs text-emerald-700 mt-1">Acara: {{ $booking->occasion }}</div>
                            @endif
                            @if($booking->special_requests)
                                <div class="text-xs text-amber-600 mt-1 border-l-2 border-amber-400 pl-2 max-w-[200px] truncate" title="{{ $booking->special_requests }}">
                                    {{ $booking->special_requests }}
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <form method="POST" action="{{ route('admin.bookings.update-status', $booking->id) }}">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()" 
                                        class="text-xs font-bold rounded-lg border-gray-300 py-1.5 pl-3 pr-8 focus:ring-amber-500 focus:border-amber-500 cursor-pointer shadow-sm
                                        {{ $booking->status === 'pending' ? 'bg-amber-50 text-amber-800' : '' }}
                                        {{ $booking->status === 'confirmed' ? 'bg-blue-50 text-blue-800' : '' }}
                                        {{ $booking->status === 'checked_in' ? 'bg-emerald-50 text-emerald-800' : '' }}
                                        {{ $booking->status === 'completed' ? 'bg-gray-100 text-gray-700' : '' }}
                                        {{ $booking->status === 'cancelled' ? 'bg-red-50 text-red-800' : '' }}">
                                    <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="checked_in" {{ $booking->status == 'checked_in' ? 'selected' : '' }}>Checked In</option>
                                    <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                                    <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Batal</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                            <div class="text-4xl mb-3">📅</div>
                            <p class="font-bold text-gray-700">Belum ada reservasi</p>
                            <p class="text-sm mt-1">Data reservasi pelanggan akan muncul di sini.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($bookings->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $bookings->links() }}
        </div>
    @endif
</div>
@endsection
