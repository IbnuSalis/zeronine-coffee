<x-app-layout>

{{-- ═══════════════════════════════════════════
     PAGE HEADER
═══════════════════════════════════════════ --}}
<x-slot name="header">
    <div style="display:flex; align-items:center; justify-content:space-between;">
        <div>
            <div style="font-size:0.75rem; font-weight:600; letter-spacing:0.12em; text-transform:uppercase; color:#8B6340; margin-bottom:0.375rem;">Selamat datang kembali 👋</div>
            <h2 style="font-family:'Playfair Display',Georgia,serif; font-size:1.625rem; font-weight:700; color:#1B120D; line-height:1.2;">
                {{ Auth::user()->name }}
            </h2>
        </div>
        <div style="display:flex; align-items:center; gap:0.75rem;">
            {{-- Live indicator — dark green on cream bg --}}
            <div style="display:inline-flex; align-items:center; gap:0.5rem; background:rgba(21,128,61,0.1); border:1px solid rgba(21,128,61,0.2); border-radius:999px; padding:0.375rem 0.875rem;">
                <span style="width:8px; height:8px; background:#16A34A; border-radius:50%; display:inline-block; animation:pulse 1.5s infinite;"></span>
                <span style="font-size:0.75rem; font-weight:600; color:#15803D; letter-spacing:0.06em;">LIVE</span>
            </div>
            <div style="font-size:0.8125rem; color:#6F4E37;">{{ now()->format('d M Y, H:i') }} WIB</div>
        </div>
    </div>
</x-slot>

<div style="padding:2rem; max-width:1280px; margin:0 auto;">

    {{-- ═══════════════════════════════════════════
         KPI STATS ROW
    ═══════════════════════════════════════════ --}}
    <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:1.25rem; margin-bottom:2rem;">

        @php
        $stats = [
            ['label'=>'Penjualan Hari Ini','value'=>'Rp 2.450.000','delta'=>'+12%','icon'=>'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z','color'=>'#15803D','bg'=>'rgba(21,128,61,0.1)','delta_color'=>'#15803D'],
            ['label'=>'Pesanan Aktif','value'=>'8','delta'=>'3 diproses','icon'=>'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2','color'=>'#C2410C','bg'=>'rgba(194,65,12,0.1)','delta_color'=>'#C2410C'],
            ['label'=>'Pelanggan Baru','value'=>'24','delta'=>'+5 hari ini','icon'=>'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z','color'=>'#8B6340','bg'=>'rgba(139,99,64,0.1)','delta_color'=>'#8B6340'],
            ['label'=>'Rating Rata-Rata','value'=>'4.9 ★','delta'=>'dari 128 ulasan','icon'=>'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z','color'=>'#92650A','bg'=>'rgba(146,101,10,0.1)','delta_color'=>'#92650A'],
        ];
        @endphp

        @foreach($stats as $stat)
        <div class="stat-card" style="position:relative; overflow:hidden;">
            {{-- Subtle glow --}}
            <div style="position:absolute; top:0; right:0; width:80px; height:80px; background:radial-gradient(circle, {{ $stat['bg'] }} 0%, transparent 70%); pointer-events:none;"></div>

            <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:1rem;">
                <div style="width:44px; height:44px; background:{{ $stat['bg'] }}; border-radius:10px; display:flex; align-items:center; justify-content:center; border:1px solid rgba(197,168,128,0.2);">
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="{{ $stat['color'] }}" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $stat['icon'] }}"/>
                    </svg>
                </div>
            </div>

            <div style="font-family:'Playfair Display',Georgia,serif; font-size:1.875rem; font-weight:700; color:#1B120D; line-height:1; margin-bottom:0.375rem;">{{ $stat['value'] }}</div>
            <div style="font-size:0.8125rem; color:#6F4E37; margin-bottom:0.625rem;">{{ $stat['label'] }}</div>
            <div style="font-size:0.75rem; color:{{ $stat['delta_color'] }}; font-weight:600;">{{ $stat['delta'] }}</div>
        </div>
        @endforeach

    </div>

    {{-- ═══════════════════════════════════════════
         MAIN CONTENT GRID
    ═══════════════════════════════════════════ --}}
    <div style="display:grid; grid-template-columns:2fr 1fr; gap:1.5rem; margin-bottom:1.5rem;">

        {{-- Recent Orders --}}
        <div class="glass-card" style="padding:1.75rem;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem;">
                <div>
                    <h3 style="font-family:'Playfair Display',serif; font-size:1.125rem; font-weight:600; color:#1B120D; margin-bottom:0.25rem;">Pesanan Terkini</h3>
                    <p style="font-size:0.8125rem; color:#6F4E37;">Pembaruan secara real-time</p>
                </div>
                <a href="#" style="font-size:0.8125rem; color:#8B6340; text-decoration:none; font-weight:600; display:flex; align-items:center; gap:0.35rem; transition:color 0.2s;" onmouseover="this.style.color='#C5A880'" onmouseout="this.style.color='#8B6340'">
                    Lihat semua
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            @php
            $orders = [
                ['code'=>'ZN-2024-001','customer'=>'Anisa R.','items'=>'Gayo Latte × 2, Croissant × 1','total'=>'Rp 98.000','status'=>'processing','status_label'=>'Diproses','type'=>'Dine In'],
                ['code'=>'ZN-2024-002','customer'=>'Ibnu T.','items'=>'Cold Brew × 1, Matcha Latte × 1','total'=>'Rp 73.000','status'=>'ready','status_label'=>'Siap','type'=>'Take Away'],
                ['code'=>'ZN-2024-003','customer'=>'Septiana D.','items'=>'Caramel Macchiato × 3','total'=>'Rp 126.000','status'=>'pending','status_label'=>'Menunggu','type'=>'Dine In'],
                ['code'=>'ZN-2024-004','customer'=>'Alifah N.','items'=>'Signature Latte × 2','total'=>'Rp 76.000','status'=>'completed','status_label'=>'Selesai','type'=>'Dine In'],
            ];
            {{-- Status colors: tuned for cream/light background --}}
            $statusColors = [
                'processing' => ['bg'=>'rgba(194,65,12,0.1)','color'=>'#C2410C','border'=>'rgba(194,65,12,0.2)'],
                'ready'      => ['bg'=>'rgba(21,128,61,0.1)','color'=>'#15803D','border'=>'rgba(21,128,61,0.2)'],
                'pending'    => ['bg'=>'rgba(146,101,10,0.1)','color'=>'#92650A','border'=>'rgba(146,101,10,0.2)'],
                'completed'  => ['bg'=>'rgba(75,85,99,0.1)','color'=>'#4B5563','border'=>'rgba(75,85,99,0.2)'],
            ];
            @endphp

            <div style="display:flex; flex-direction:column; gap:0.875rem;">
                @foreach($orders as $order)
                @php $sc = $statusColors[$order['status']]; @endphp
                <div style="display:grid; grid-template-columns:auto 1fr auto; gap:1rem; align-items:center; padding:1rem; background:rgba(255,255,255,0.8); border:1px solid rgba(197,168,128,0.2); border-radius:0.75rem; transition:all 0.25s;" onmouseover="this.style.borderColor='rgba(197,168,128,0.4)'; this.style.background='rgba(255,255,255,1)'" onmouseout="this.style.borderColor='rgba(197,168,128,0.2)'; this.style.background='rgba(255,255,255,0.8)'">

                    {{-- Avatar --}}
                    <div style="width:40px; height:40px; background:linear-gradient(135deg,rgba(197,168,128,0.2),rgba(139,99,64,0.15)); border-radius:10px; display:flex; align-items:center; justify-content:center; border:1px solid rgba(197,168,128,0.2);">
                        <span style="font-weight:700; font-size:0.9rem; color:#8B6340;">{{ substr($order['customer'],0,1) }}</span>
                    </div>

                    {{-- Info --}}
                    <div>
                        <div style="display:flex; align-items:center; gap:0.5rem; margin-bottom:0.25rem;">
                            <span style="font-weight:600; font-size:0.9rem; color:#1B120D;">{{ $order['customer'] }}</span>
                            <span style="font-size:0.7rem; color:#8B6340; background:rgba(197,168,128,0.15); padding:0.125rem 0.5rem; border-radius:4px; border:1px solid rgba(197,168,128,0.2);">{{ $order['type'] }}</span>
                        </div>
                        <div style="font-size:0.8rem; color:#3E2C1C; margin-bottom:0.125rem;">{{ $order['items'] }}</div>
                        <div style="font-size:0.75rem; color:#8D6E63;">{{ $order['code'] }}</div>
                    </div>

                    {{-- Status + Amount --}}
                    <div style="text-align:right;">
                        <span style="display:inline-block; background:{{ $sc['bg'] }}; color:{{ $sc['color'] }}; border:1px solid {{ $sc['border'] }}; font-size:0.7rem; font-weight:600; padding:0.2rem 0.6rem; border-radius:999px; margin-bottom:0.375rem; letter-spacing:0.04em;">{{ $order['status_label'] }}</span>
                        <div style="font-weight:600; font-size:0.9rem; color:#8B6340;">{{ $order['total'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Right column --}}
        <div style="display:flex; flex-direction:column; gap:1.25rem;">

            {{-- Quick Actions --}}
            <div class="glass-card" style="padding:1.75rem;">
                <h3 style="font-family:'Playfair Display',serif; font-size:1.125rem; font-weight:600; color:#1B120D; margin-bottom:1.25rem;">Aksi Cepat</h3>
                <div style="display:flex; flex-direction:column; gap:0.625rem;">
                    @php
                    $actions = [
                        ['label'=>'Tambah Menu Baru','icon'=>'M12 4v16m8-8H4','href'=>'#','color'=>'#8B6340'],
                        ['label'=>'Lihat Antrian Dapur','icon'=>'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2','href'=>'#','color'=>'#C2410C'],
                        ['label'=>'Kelola Inventaris','icon'=>'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4','href'=>'#','color'=>'#1D4ED8'],
                        ['label'=>'Export Laporan','icon'=>'M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4','href'=>'#','color'=>'#6D28D9'],
                    ];
                    @endphp
                    @foreach($actions as $action)
                    <a href="{{ $action['href'] }}" style="display:flex; align-items:center; gap:0.875rem; padding:0.75rem 1rem; background:rgba(255,255,255,0.8); border:1px solid rgba(197,168,128,0.2); border-radius:0.625rem; text-decoration:none; transition:all 0.25s;" onmouseover="this.style.background='rgba(255,255,255,1)'; this.style.borderColor='rgba(197,168,128,0.4)'; this.style.transform='translateX(3px)'" onmouseout="this.style.background='rgba(255,255,255,0.8)'; this.style.borderColor='rgba(197,168,128,0.2)'; this.style.transform='translateX(0)'">
                        <div style="width:34px; height:34px; background:rgba(197,168,128,0.1); border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0; border:1px solid rgba(197,168,128,0.15);">
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="{{ $action['color'] }}" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $action['icon'] }}"/></svg>
                        </div>
                        <span style="font-size:0.875rem; font-weight:500; color:#3E2C1C;">{{ $action['label'] }}</span>
                        <svg style="margin-left:auto;" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="#C5A880" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </a>
                    @endforeach
                </div>
            </div>

            {{-- Stock Alert --}}
            <div class="glass-card" style="padding:1.75rem;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.25rem;">
                    <h3 style="font-family:'Playfair Display',serif; font-size:1.125rem; font-weight:600; color:#1B120D;">Alert Stok</h3>
                    <span style="background:rgba(185,28,28,0.1); color:#B91C1C; border:1px solid rgba(185,28,28,0.2); font-size:0.7rem; font-weight:700; padding:0.2rem 0.6rem; border-radius:999px;">3 Item</span>
                </div>
                @php
                $stocks = [
                    ['name'=>'Biji Gayo','stock'=>'120g','min'=>'500g','pct'=>24],
                    ['name'=>'Susu Full Cream','stock'=>'0.8L','min'=>'2L','pct'=>40],
                    ['name'=>'Sirup Karamel','stock'=>'150ml','min'=>'500ml','pct'=>30],
                ];
                @endphp
                <div style="display:flex; flex-direction:column; gap:1rem;">
                    @foreach($stocks as $stock)
                    <div>
                        <div style="display:flex; justify-content:space-between; margin-bottom:0.375rem;">
                            <span style="font-size:0.875rem; color:#3E2C1C; font-weight:500;">{{ $stock['name'] }}</span>
                            <span style="font-size:0.75rem; color:#B91C1C; font-weight:600;">{{ $stock['stock'] }} / {{ $stock['min'] }}</span>
                        </div>
                        <div style="height:5px; background:rgba(197,168,128,0.2); border-radius:999px; overflow:hidden;">
                            <div style="height:100%; width:{{ $stock['pct'] }}%; background:linear-gradient(90deg,#DC2626,#F97316); border-radius:999px;"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

    {{-- ═══════════════════════════════════════════
         BOTTOM ROW
    ═══════════════════════════════════════════ --}}
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:1.5rem;">

        {{-- Top Selling --}}
        <div class="glass-card" style="padding:1.75rem;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem;">
                <h3 style="font-family:'Playfair Display',serif; font-size:1.125rem; font-weight:600; color:#1B120D;">Menu Terlaris</h3>
                <span style="font-size:0.75rem; color:#8D6E63;">Minggu ini</span>
            </div>
            @php
            $topMenus = [
                ['name'=>'Signature Gayo Latte','sold'=>142,'pct'=>100,'revenue'=>'Rp 5.396.000'],
                ['name'=>'Cold Brew Toraja','sold'=>98,'pct'=>69,'revenue'=>'Rp 3.430.000'],
                ['name'=>'Caramel Macchiato','sold'=>76,'pct'=>54,'revenue'=>'Rp 3.192.000'],
                ['name'=>'Matcha Latte','sold'=>61,'pct'=>43,'revenue'=>'Rp 2.318.000'],
            ];
            @endphp
            <div style="display:flex; flex-direction:column; gap:1.125rem;">
                @foreach($topMenus as $i => $m)
                <div style="display:flex; align-items:center; gap:1rem;">
                    <span style="font-family:'Playfair Display',serif; font-size:1.5rem; font-weight:700; color:#C5A880; width:28px; text-align:center; flex-shrink:0;">{{ $i+1 }}</span>
                    <div style="flex:1; min-width:0;">
                        <div style="display:flex; justify-content:space-between; margin-bottom:0.375rem;">
                            <span style="font-size:0.875rem; font-weight:500; color:#1B120D; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $m['name'] }}</span>
                            <span style="font-size:0.8rem; color:#6F4E37; flex-shrink:0; margin-left:0.5rem;">{{ $m['sold'] }} terjual</span>
                        </div>
                        <div style="height:4px; background:rgba(197,168,128,0.2); border-radius:999px; overflow:hidden;">
                            <div style="height:100%; width:{{ $m['pct'] }}%; background:linear-gradient(90deg,#9A7D3A,#C5A880); border-radius:999px;"></div>
                        </div>
                    </div>
                    <span style="font-size:0.8rem; color:#8B6340; font-weight:600; flex-shrink:0; text-align:right; min-width:90px;">{{ $m['revenue'] }}</span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Loyalty & Membership --}}
        <div class="glass-card" style="padding:1.75rem;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem;">
                <h3 style="font-family:'Playfair Display',serif; font-size:1.125rem; font-weight:600; color:#1B120D;">Distribusi Member</h3>
                <a href="#" style="font-size:0.8125rem; color:#8B6340; text-decoration:none; font-weight:600; transition:color 0.2s;" onmouseover="this.style.color='#C5A880'" onmouseout="this.style.color='#8B6340'">Detail</a>
            </div>
            @php
            $tiers = [
                ['name'=>'Platinum','count'=>12,'pct'=>5,'color'=>'#475569','emoji'=>'💎'],
                ['name'=>'Gold','count'=>48,'pct'=>20,'color'=>'#92650A','emoji'=>'🥇'],
                ['name'=>'Silver','count'=>86,'pct'=>36,'color'=>'#64748B','emoji'=>'🥈'],
                ['name'=>'Bronze','count'=>91,'pct'=>38,'color'=>'#92400E','emoji'=>'🥉'],
            ];
            @endphp
            <div style="display:flex; flex-direction:column; gap:1.125rem;">
                @foreach($tiers as $tier)
                <div style="display:flex; align-items:center; gap:1rem;">
                    <span style="font-size:1.25rem; width:28px; text-align:center; flex-shrink:0;">{{ $tier['emoji'] }}</span>
                    <div style="flex:1;">
                        <div style="display:flex; justify-content:space-between; margin-bottom:0.375rem;">
                            <span style="font-size:0.875rem; font-weight:500; color:#3E2C1C;">{{ $tier['name'] }}</span>
                            <span style="font-size:0.8rem; color:#6F4E37;">{{ $tier['count'] }} member</span>
                        </div>
                        <div style="height:4px; background:rgba(197,168,128,0.2); border-radius:999px; overflow:hidden;">
                            <div style="height:100%; width:{{ $tier['pct'] }}%; background:{{ $tier['color'] }}; border-radius:999px; opacity:0.8;"></div>
                        </div>
                    </div>
                    <span style="font-size:0.8rem; color:#6F4E37; font-weight:500; width:36px; text-align:right; flex-shrink:0;">{{ $tier['pct'] }}%</span>
                </div>
                @endforeach
            </div>

            <div style="margin-top:1.5rem; padding-top:1.25rem; border-top:1px solid rgba(197,168,128,0.15);">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <span style="font-size:0.8125rem; color:#8D6E63;">Total member aktif</span>
                    <span style="font-family:'Playfair Display',serif; font-size:1.25rem; font-weight:700; color:#8B6340;">237</span>
                </div>
            </div>
        </div>

    </div>

</div>

{{-- Pulse animation --}}
<style>
@keyframes pulse {
    0%, 100% { opacity:1; transform:scale(1); }
    50% { opacity:0.6; transform:scale(1.15); }
}
</style>

</x-app-layout>