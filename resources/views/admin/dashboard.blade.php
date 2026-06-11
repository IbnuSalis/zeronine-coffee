@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Overview')

@section('content')
{{-- Stats Grid --}}
<div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Pendapatan</span>
            <span class="w-8 h-8 bg-gold-50 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </span>
        </div>
        <p class="text-xl font-bold text-gray-800">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Total Pesanan</span>
            <span class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            </span>
        </div>
        <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['total_orders']) }}</p>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Pesanan Aktif</span>
            <span class="w-8 h-8 bg-orange-50 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </span>
        </div>
        <p class="text-2xl font-bold text-orange-600">{{ number_format($stats['active_orders']) }}</p>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Reservasi Hari Ini</span>
            <span class="w-8 h-8 bg-green-50 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </span>
        </div>
        <p class="text-2xl font-bold text-green-600">{{ number_format($stats['today_bookings']) }}</p>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Pelanggan</span>
            <span class="w-8 h-8 bg-purple-50 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </span>
        </div>
        <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['total_customers']) }}</p>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Menu Habis</span>
            <span class="w-8 h-8 bg-red-50 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </span>
        </div>
        <p class="text-2xl font-bold text-red-600">{{ number_format($stats['out_of_stock_menus']) }}</p>
    </div>
</div>

{{-- Quick Actions --}}
<div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6">
    <a href="{{ route('admin.menus.create') }}" class="flex items-center gap-3 bg-[#1B120D] text-white px-4 py-3 rounded-xl hover:bg-coffee-800 transition-all group">
        <svg class="w-5 h-5 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        <span class="text-sm font-semibold">Tambah Menu</span>
    </a>
    <a href="{{ route('admin.categories.create') }}" class="flex items-center gap-3 bg-white border border-gray-200 text-gray-700 px-4 py-3 rounded-xl hover:border-gold-400 hover:bg-gold-50 transition-all">
        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
        <span class="text-sm font-semibold">Tambah Kategori</span>
    </a>
    <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 bg-white border border-gray-200 text-gray-700 px-4 py-3 rounded-xl hover:border-blue-400 hover:bg-blue-50 transition-all">
        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        <span class="text-sm font-semibold">Lihat Pesanan</span>
    </a>
    <a href="{{ route('admin.users.create') }}" class="flex items-center gap-3 bg-white border border-gray-200 text-gray-700 px-4 py-3 rounded-xl hover:border-purple-400 hover:bg-purple-50 transition-all">
        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
        <span class="text-sm font-semibold">Tambah User</span>
    </a>
</div>

{{-- Main Grid --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Recent Orders --}}
    <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-800 text-sm">Pesanan Terbaru</h3>
            <a href="{{ route('admin.orders.index') }}" class="text-xs text-gold-600 hover:text-gold-700 font-medium">Lihat Semua →</a>
        </div>
        <div class="overflow-x-auto">
            @if($recentOrders->isEmpty())
                <div class="text-center py-12 text-gray-400 text-sm">Belum ada pesanan.</div>
            @else
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr class="text-left text-xs text-gray-500 uppercase tracking-wide">
                        <th class="px-6 py-3">ID</th>
                        <th class="px-6 py-3">Pelanggan</th>
                        <th class="px-6 py-3">Total</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Bayar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($recentOrders as $order)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-3.5 font-mono font-bold text-gray-700 text-xs">#{{ $order->id }}</td>
                        <td class="px-6 py-3.5 font-medium text-gray-800">{{ $order->user?->name ?? 'Guest' }}</td>
                        <td class="px-6 py-3.5 font-bold text-gray-800">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        <td class="px-6 py-3.5">
                            @php
                                $statusClass = match($order->status) {
                                    'pending'    => 'bg-yellow-100 text-yellow-700',
                                    'processing' => 'bg-blue-100 text-blue-700',
                                    'ready'      => 'bg-green-100 text-green-700',
                                    'completed'  => 'bg-gray-100 text-gray-600',
                                    default      => 'bg-red-100 text-red-700',
                                };
                            @endphp
                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $statusClass }}">{{ ucfirst($order->status) }}</span>
                        </td>
                        <td class="px-6 py-3.5">
                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $order->payment_status === 'paid' ? 'Lunas' : 'Unpaid' }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>

    {{-- Top Sellers --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-800 text-sm">🔥 Best Sellers</h3>
            <span class="text-xs bg-gold-100 text-gold-700 font-semibold px-2 py-0.5 rounded-full">Top 5</span>
        </div>
        <div class="p-4">
            @if($topMenus->isEmpty())
                <div class="text-center py-12 text-gray-400 text-sm">Belum ada data penjualan.</div>
            @else
                <div class="space-y-3">
                    @foreach($topMenus as $i => $top)
                    <div class="flex items-center gap-3">
                        <span class="w-6 h-6 rounded-full {{ $i === 0 ? 'bg-gold-100 text-gold-700' : 'bg-gray-100 text-gray-500' }} text-xs font-bold flex items-center justify-center flex-shrink-0">{{ $i+1 }}</span>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-800 truncate">{{ $top->menu_name }}</p>
                            <p class="text-xs text-gray-400">{{ $top->total_sold }} terjual</p>
                        </div>
                        <p class="text-sm font-bold text-gold-600 flex-shrink-0">Rp {{ number_format($top->total_revenue, 0, ',', '.') }}</p>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
