@extends('layouts.customer')

@section('title', 'Riwayat Pesanan — Zero Nine Coffee Shop')

@section('content')
<div class="min-h-screen pt-28 pb-20 bg-stone-200">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <h1 class="font-display text-3xl font-bold text-stone-900 mb-8">Riwayat <span class="text-amber-800">Pesanan Anda</span></h1>

        @if($orders->isEmpty())
            <div class="text-center py-20 bg-stone-100 border border-stone-300 rounded-2xl shadow-sm">
                <span class="text-6xl">📋</span>
                <h3 class="font-display text-2xl font-bold text-stone-800 mt-4">Belum Ada Pesanan</h3>
                <p class="text-stone-500 mt-2">Anda belum memiliki riwayat transaksi pemesanan kopi.</p>
                <a href="{{ route('menu.index') }}"
                   class="inline-flex items-center gap-2 bg-amber-700 hover:bg-amber-800 text-white font-semibold py-2.5 px-5 rounded-xl text-sm transition-colors shadow-sm mt-6">
                    Pesan Kopi Sekarang
                </a>
            </div>
        @else
            <div class="bg-stone-100 border border-stone-300 rounded-2xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-stone-200 border-b border-stone-300">
                                <th class="text-left text-xs font-bold text-stone-600 uppercase tracking-wider px-5 py-3.5">No. Pesanan</th>
                                <th class="text-left text-xs font-bold text-stone-600 uppercase tracking-wider px-5 py-3.5">Tanggal</th>
                                <th class="text-left text-xs font-bold text-stone-600 uppercase tracking-wider px-5 py-3.5">Meja / Tipe</th>
                                <th class="text-left text-xs font-bold text-stone-600 uppercase tracking-wider px-5 py-3.5">Total Belanja</th>
                                <th class="text-left text-xs font-bold text-stone-600 uppercase tracking-wider px-5 py-3.5">Status Pesanan</th>
                                <th class="text-left text-xs font-bold text-stone-600 uppercase tracking-wider px-5 py-3.5">Status Bayar</th>
                                <th class="text-left text-xs font-bold text-stone-600 uppercase tracking-wider px-5 py-3.5">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-200">
                            @foreach($orders as $order)
                                <tr class="hover:bg-stone-50 transition-colors">
                                    <td class="px-5 py-4 font-mono font-bold text-amber-800">#{{ $order->id }}</td>
                                    <td class="px-5 py-4 text-stone-600">{{ $order->created_at->format('d M Y, H:i') }}</td>
                                    <td class="px-5 py-4">
                                        @if($order->order_type === 'dine_in')
                                            <span class="font-semibold text-stone-800">📍 Dine-In (Meja {{ $order->table?->number ?? '-' }})</span>
                                        @elseif($order->order_type === 'takeaway')
                                            <span class="text-stone-700">🛍️ Take-Away</span>
                                        @else
                                            <span class="text-stone-700">🛵 Delivery</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 font-bold text-amber-800">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                    <td class="px-5 py-4">
                                        @if($order->status === 'pending')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-amber-100 text-amber-800 border border-amber-300">Menunggu Antrean</span>
                                        @elseif($order->status === 'processing')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-blue-100 text-blue-800 border border-blue-300">Sedang Dibuat</span>
                                        @elseif($order->status === 'ready')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-emerald-100 text-emerald-800 border border-emerald-300">Siap Disajikan</span>
                                        @elseif($order->status === 'completed')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-stone-200 text-stone-700 border border-stone-400">Selesai</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-red-100 text-red-800 border border-red-300">Dibatalkan</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4">
                                        @if($order->payment_status === 'paid')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-emerald-100 text-emerald-800 border border-emerald-300">Lunas</span>
                                        @elseif($order->payment_status === 'refunded')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-purple-100 text-purple-800 border border-purple-300">Refunded</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-red-100 text-red-800 border border-red-300">Belum Bayar</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4">
                                        <a href="{{ route('customer.orders.show', $order->id) }}"
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
                {{ $orders->links() }}
            </div>
        @endif

    </div>
</div>
@endsection