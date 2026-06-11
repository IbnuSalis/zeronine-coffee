@extends('layouts.customer')

@section('title', 'Zero Nine Loyalty Club')

@section('content')
<div class="min-h-screen pt-28 pb-20" style="background-color: #F5ECD7;">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <h1 class="font-display text-3xl font-bold mb-8" style="color: #1B120D;">
            Loyalty <span class="text-gradient-gold">Club Member</span>
        </h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-stretch mb-10">
            
            {{-- Point Balance Card --}}
            <div class="p-6 flex flex-col justify-between shadow-lg relative overflow-hidden group" style="background:#fff8ee; border:1px solid #C5A880; border-radius:12px;">
                <div>
                    <span class="text-xs uppercase tracking-widest block mb-3 font-bold" style="color:#6F4E37;">Total Poin Saya</span>
                    <div class="flex items-end gap-2">
                        <span style="font-size:3rem; font-weight:800; color:#b45309; line-height:1; font-variant-numeric:tabular-nums; font-family:ui-monospace,monospace">
                            {{ number_format($summary['points']) }}
                        </span>
                        <span class="text-sm mb-1" style="color:#6F4E37;">poin</span>
                    </div>
                </div>
                <div class="mt-6 pt-4 flex justify-between items-center text-xs" style="border-top:1px solid #C5A880; color:#6F4E37;">
                    <span>Estimasi nilai tukar:</span>
                    <strong style="color:#1B120D;">Rp {{ number_format($summary['redeem_value'], 0, ',', '.') }}</strong>
                </div>
            </div>

            {{-- Membership Tier Card --}}
            <div class="p-6 flex flex-col justify-between md:col-span-2 relative overflow-hidden" style="background:#fff8ee; border:1px solid #C5A880; border-radius:12px;">
                <div>
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <span class="text-xs uppercase tracking-widest block font-bold mb-1" style="color:#6F4E37;">Tingkat Keanggotaan</span>
                            <h2 class="font-display text-2xl font-bold" style="color:#1B120D;">
                                ⭐ {{ $summary['tier']?->name ?? 'Regular Member' }}
                            </h2>
                        </div>
                        <span class="text-[10px] uppercase font-bold px-3 py-1 rounded-full" style="background:#b45309; color:#fff8ee;">Aktif</span>
                    </div>

                    @if($summary['next_tier'])
                        @php
                            $minPrev = $summary['tier']?->min_points ?? 0;
                            $minNext = $summary['next_tier']->min_points;
                            $range = $minNext - $minPrev;
                            $diff = $summary['points'] - $minPrev;
                            $percent = $range > 0 ? min(100, max(0, ($diff / $range) * 100)) : 0;
                        @endphp
                        <div class="space-y-2 mt-4">
                            <div class="flex justify-between text-xs" style="color:#6F4E37;">
                                <span>Kemajuan ke <strong style="color:#1B120D;">{{ $summary['next_tier']->name }}</strong></span>
                                <span style="font-variant-numeric:tabular-nums">{{ number_format($summary['points']) }} / {{ number_format($summary['next_tier']->min_points) }} Pts</span>
                            </div>
                            <div style="width:100%; height:10px; background:rgba(101,67,33,0.15); border-radius:999px; overflow:hidden; border:1px solid rgba(101,67,33,0.2)">
                                <div style="height:100%; width:{{ $percent }}%; background:linear-gradient(to right, #92400e, #b45309); border-radius:999px; transition:width 0.7s ease; min-width:{{ $percent > 0 ? '6px' : '0px' }}"></div>
                            </div>
                            <div class="flex justify-between text-[10px] mt-1" style="color:#6F4E37;">
                                <span class="italic">
                                    Kumpulkan <strong style="color:#b45309;">{{ number_format($summary['points_to_next']) }}</strong> poin lagi untuk naik ke tingkat {{ $summary['next_tier']->name }}.
                                </span>
                                <span style="color:#b45309; font-weight:600;">{{ number_format($percent, 1) }}%</span>
                            </div>
                        </div>
                    @else
                        <p class="text-xs font-semibold mt-4" style="color:#166534;">
                            🎉 Selamat! Anda telah mencapai tingkatan keanggotaan tertinggi (Platinum Tier). Nikmati seluruh keuntungan eksklusif kami!
                        </p>
                    @endif
                </div>
            </div>

        </div>

        {{-- Tier Benefit Table --}}
        <div class="p-6 mb-10" style="background:#fff8ee; border:1px solid #C5A880; border-radius:12px;">
            <h3 class="font-display text-base font-bold pb-3 mb-4" style="color:#1B120D; border-bottom:1px solid #C5A880;">
                💎 Keuntungan Anggota Berdasarkan Tier
            </h3>
            
            @php $currentTierName = $summary['tier']?->name ?? ''; @endphp

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-center">

                <div class="p-4 rounded-lg transition-all" style="{{ $currentTierName === 'Bronze' ? 'background:rgba(180,83,9,0.12); border:1px solid rgba(180,83,9,0.4); box-shadow:0 0 0 1px rgba(180,83,9,0.15)' : 'background:rgba(101,67,33,0.06); border:1px solid #C5A880' }}">
                    <span class="text-2xl block mb-2">🥉</span>
                    <h4 class="font-bold text-xs mb-1" style="color:#92400e;">Bronze Tier</h4>
                    <span class="text-[10px] block" style="color:#6F4E37;">Poin 0 – 999</span>
                    <span class="text-[10px] block mt-2" style="color:#166534;">1 Poin per Rp 1.000</span>
                    @if($currentTierName === 'Bronze')
                        <span class="text-[10px] rounded px-2 py-0.5 mt-2 inline-block font-semibold" style="background:rgba(180,83,9,0.15); color:#92400e;">Tier Kamu</span>
                    @endif
                </div>

                <div class="p-4 rounded-lg transition-all" style="{{ $currentTierName === 'Silver' ? 'background:rgba(107,114,128,0.12); border:1px solid rgba(107,114,128,0.4); box-shadow:0 0 0 1px rgba(107,114,128,0.15)' : 'background:rgba(101,67,33,0.06); border:1px solid #C5A880' }}">
                    <span class="text-2xl block mb-2">🥈</span>
                    <h4 class="font-bold text-xs mb-1" style="color:#4B5563;">Silver Tier</h4>
                    <span class="text-[10px] block" style="color:#6F4E37;">Poin 1.000 – 4.999</span>
                    <span class="text-[10px] block mt-2" style="color:#166534;">Diskon 5% Semua Menu</span>
                    @if($currentTierName === 'Silver')
                        <span class="text-[10px] rounded px-2 py-0.5 mt-2 inline-block font-semibold" style="background:rgba(107,114,128,0.15); color:#4B5563;">Tier Kamu</span>
                    @endif
                </div>

                <div class="p-4 rounded-lg transition-all" style="{{ $currentTierName === 'Gold' ? 'background:rgba(202,138,4,0.12); border:1px solid rgba(202,138,4,0.4); box-shadow:0 0 0 1px rgba(202,138,4,0.15)' : 'background:rgba(101,67,33,0.06); border:1px solid #C5A880' }}">
                    <span class="text-2xl block mb-2">🥇</span>
                    <h4 class="font-bold text-xs mb-1" style="color:#a16207;">Gold Tier</h4>
                    <span class="text-[10px] block" style="color:#6F4E37;">Poin 5.000 – 9.999</span>
                    <span class="text-[10px] block mt-2" style="color:#166534;">Diskon 10% Semua Menu</span>
                    @if($currentTierName === 'Gold')
                        <span class="text-[10px] rounded px-2 py-0.5 mt-2 inline-block font-semibold" style="background:rgba(202,138,4,0.15); color:#a16207;">Tier Kamu</span>
                    @endif
                </div>

                <div class="p-4 rounded-lg transition-all" style="{{ $currentTierName === 'Platinum' ? 'background:rgba(37,99,235,0.12); border:1px solid rgba(37,99,235,0.4); box-shadow:0 0 0 1px rgba(37,99,235,0.15)' : 'background:rgba(101,67,33,0.06); border:1px solid #C5A880' }}">
                    <span class="text-2xl block mb-2">💎</span>
                    <h4 class="font-bold text-xs mb-1" style="color:#1d4ed8;">Platinum Tier</h4>
                    <span class="text-[10px] block" style="color:#6F4E37;">Poin 10.000+</span>
                    <span class="text-[10px] block mt-2" style="color:#166534;">Diskon 15% + Reservasi VIP</span>
                    @if($currentTierName === 'Platinum')
                        <span class="text-[10px] rounded px-2 py-0.5 mt-2 inline-block font-semibold" style="background:rgba(37,99,235,0.15); color:#1d4ed8;">Tier Kamu</span>
                    @endif
                </div>

            </div>
        </div>

        {{-- Points Transaction History --}}
        <div class="p-6" style="background:#fff8ee; border:1px solid #C5A880; border-radius:12px;">
            <h3 class="font-display text-base font-bold pb-3 mb-4" style="color:#1B120D; border-bottom:1px solid #C5A880;">
                📋 Riwayat Transaksi Poin
            </h3>
            
            @if($summary['history']->isEmpty())
                <div class="text-center py-10 text-sm" style="color:#6F4E37;">
                    <span class="text-3xl block mb-3">🎯</span>
                    Belum ada riwayat perolehan atau penukaran poin.<br>
                    <span class="text-xs mt-1 block">Selesaikan pesanan untuk mulai mengumpulkan poin!</span>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($summary['history'] as $log)
                        <div class="flex justify-between items-center text-sm pb-3 last:pb-0" style="border-bottom:1px solid #C5A880;">
                            <div>
                                <span class="font-semibold block" style="color:#1B120D;">{{ $log->description }}</span>
                                <span class="text-[10px] block mt-0.5" style="color:#6F4E37;">
                                    {{ $log->created_at->format('d M Y, H:i') }}
                                </span>
                            </div>
                            <div class="text-right">
                                <span class="font-bold text-sm block" style="font-variant-numeric:tabular-nums; color:{{ $log->type === 'earned' ? '#166534' : '#991b1b' }}">
                                    {{ $log->type === 'earned' ? '+' : '-' }}{{ number_format(abs($log->points)) }} Pts
                                </span>
                                <span class="text-[10px] block" style="color:#6F4E37; font-variant-numeric:tabular-nums;">
                                    Sisa: {{ number_format($log->balance_after) }} Pts
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
</div>
@endsection