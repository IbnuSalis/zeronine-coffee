@extends('layouts.admin')

@section('title', 'Pesanan')
@section('page-title', 'Manajemen Pesanan')

@section('content')
{{-- Filters --}}
<form method="GET" class="bg-white rounded-xl border border-gray-200 p-4 mb-5 flex flex-col sm:flex-row gap-3">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari ID / nama pelanggan..."
           class="flex-1 text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-gold-400/30 focus:border-gold-400">
    <select name="status" class="text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-gold-400/30 focus:border-gold-400 bg-white">
        <option value="">Semua Status</option>
        @foreach(['pending','processing','ready','completed','cancelled'] as $s)
            <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
        @endforeach
    </select>
    <select name="payment_status" class="text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-gold-400/30 focus:border-gold-400 bg-white">
        <option value="">Semua Pembayaran</option>
        <option value="paid" {{ request('payment_status') === 'paid' ? 'selected' : '' }}>Lunas</option>
        <option value="unpaid" {{ request('payment_status') === 'unpaid' ? 'selected' : '' }}>Belum Bayar</option>
    </select>
    <button type="submit" class="bg-gray-800 text-white text-sm font-semibold px-4 py-2 rounded-lg hover:bg-gray-700 transition-all">Filter</button>
    @if(request()->anyFilled(['search','status','payment_status']))
        <a href="{{ route('admin.orders.index') }}" class="text-sm text-gray-500 px-4 py-2 rounded-lg border border-gray-200 hover:bg-gray-50 transition-all text-center">Reset</a>
    @endif
</form>

<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr class="text-left text-xs text-gray-500 uppercase tracking-wide">
                    <th class="px-6 py-3">ID</th>
                    <th class="px-6 py-3">Pelanggan</th>
                    <th class="px-6 py-3">Tipe</th>
                    <th class="px-6 py-3">Total</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Bayar</th>
                    <th class="px-6 py-3">Waktu</th>
                    <th class="px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($orders as $order)
                <tr class="hover:bg-gray-50 transition-colors" x-data="{ open: false }">
                    <td class="px-6 py-3.5 font-mono font-bold text-gray-700 text-xs">#{{ $order->id }}</td>
                    <td class="px-6 py-3.5 font-medium text-gray-800">{{ $order->user?->name ?? 'Guest' }}</td>
                    <td class="px-6 py-3.5">
                        <span class="text-xs font-semibold {{ $order->order_type === 'dine_in' ? 'text-gold-600' : 'text-blue-600' }}">
                            {{ $order->order_type === 'dine_in' ? 'Meja ' . ($order->table?->number ?? '-') : strtoupper($order->order_type) }}
                        </span>
                    </td>
                    <td class="px-6 py-3.5 font-bold text-gray-800">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                    <td class="px-6 py-3.5">
                        @php
                            $sc = match($order->status) {
                                'pending'    => 'bg-yellow-100 text-yellow-700',
                                'processing' => 'bg-blue-100 text-blue-700',
                                'ready'      => 'bg-green-100 text-green-700',
                                'completed'  => 'bg-gray-100 text-gray-600',
                                default      => 'bg-red-100 text-red-700',
                            };
                        @endphp
                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $sc }}">{{ ucfirst($order->status) }}</span>
                    </td>
                    <td class="px-6 py-3.5">
                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $order->payment_status === 'paid' ? 'Lunas' : 'Unpaid' }}
                        </span>
                    </td>
                    <td class="px-6 py-3.5 text-gray-400 text-xs">{{ $order->created_at->format('d/m H:i') }}</td>
                    <td class="px-6 py-3.5">
                        <form method="POST" action="{{ route('admin.orders.update-status', $order) }}" class="flex gap-1">
                            @csrf @method('PATCH')
                            <select name="status" onchange="this.form.submit()"
                                    class="text-xs border border-gray-200 rounded-lg px-2 py-1 focus:outline-none bg-white text-gray-700">
                                @foreach(['pending','processing','ready','completed','cancelled'] as $s)
                                    <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                                @endforeach
                            </select>
                        </form>
                    </td>
                </tr>
                @empty
                    <tr><td colspan="8" class="px-6 py-16 text-center text-gray-400 text-sm">Belum ada pesanan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($orders->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">{{ $orders->links() }}</div>
    @endif
</div>
@endsection
