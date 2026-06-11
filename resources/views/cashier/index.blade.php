<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="refresh" content="15">
    <title>Kasir — Zero Nine Coffee</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        :root {
            --color-bg-primary:    #ffffff;
            --color-bg-secondary:  #f5f5f5;
            --color-bg-tertiary:   #ebebeb;
            --color-bg-card:       #ffffff;
            --color-text-primary:  #111111;
            --color-text-secondary:#555555;
            --color-text-tertiary: #888888;
            --color-border:        #e0e0e0;
            --border-radius-lg:    12px;
            --border-radius-md:    8px;
            --border-radius-sm:    5px;
        }
        * { box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--color-bg-secondary);
            color: var(--color-text-primary);
            font-size: 13px;
            margin: 0;
        }

        /* ── Topbar ── */
        .topbar {
            background: #1a1a1a;
            height: 60px;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 24px;
            position: sticky; top: 0; z-index: 100;
            box-shadow: 0 2px 8px rgba(0,0,0,.25);
        }
        .topbar-left  { display: flex; align-items: center; gap: 12px; }
        .topbar-logo  {
            width: 36px; height: 36px; border-radius: 50%;
            background: linear-gradient(135deg, #d4a017, #b8860b);
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 900; font-size: 12px; flex-shrink: 0;
            box-shadow: 0 2px 6px rgba(184,134,11,.4);
        }
        .topbar-outlet { color: #f5f5f5; font-size: 14px; font-weight: 700; line-height: 1.3; }
        .topbar-sub    { color: #888; font-size: 11px; }
        .topbar-right  { display: flex; align-items: center; gap: 20px; }
        .topbar-kasir-name  { color: #f0f0f0; font-size: 13px; font-weight: 600; text-align: right; line-height: 1.3; }
        .topbar-kasir-label { color: #777; font-size: 10px; text-align: right; text-transform: uppercase; letter-spacing: 0.5px; }
        .topbar-clock  { color: #b8860b; font-size: 15px; font-weight: 700; font-variant-numeric: tabular-nums; min-width: 70px; }
        .topbar-logout {
            color: #fff; font-size: 12px; font-weight: 700;
            background: #dc2626; border: none;
            padding: 7px 16px; border-radius: 6px; cursor: pointer;
            transition: background .15s;
        }
        .topbar-logout:hover { background: #b91c1c; }

        /* ── Main ── */
        .main { max-width: 1100px; margin: 0 auto; padding: 16px 16px 48px; }

        /* ── Metrics ── */
        .metrics { display: grid; grid-template-columns: repeat(3,1fr); gap: 10px; margin-bottom: 14px; }
        .metric-card {
            background: var(--color-bg-card); border: 0.5px solid var(--color-border);
            border-radius: var(--border-radius-lg); padding: 14px 16px; text-align: center;
        }
        .metric-label { font-size: 11px; color: var(--color-text-tertiary); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; }
        .metric-value { font-size: 22px; font-weight: 800; }
        .metric-value.orange { color: #e07b00; }
        .metric-value.green  { color: #1D9E75; }
        .metric-value.gold   { color: #b8860b; font-size: 17px; }

        /* ── Filter Bar ── */
        .filter-bar { display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 14px; align-items: center; }
        .filter-chip {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 5px 12px; border-radius: 20px; font-size: 11px; font-weight: 600;
            border: 0.5px solid var(--color-border);
            background: var(--color-bg-card); color: var(--color-text-secondary);
            cursor: pointer; user-select: none; transition: all .12s;
        }
        .filter-chip:hover { border-color: #aaa; color: var(--color-text-primary); }
        .filter-chip.active { background: #111; color: #fff; border-color: #111; }
        .chip-badge {
            background: #1D9E75; color: #fff;
            border-radius: 10px; padding: 0 6px; font-size: 10px; font-weight: 700; line-height: 16px;
        }
        .filter-chip.active .chip-badge { background: #0d7a5a; }

        /* ── Section Divider ── */
        .section-divider {
            font-size: 10px; font-weight: 700; color: var(--color-text-tertiary);
            text-transform: uppercase; letter-spacing: 1px;
            padding: 8px 0 6px;
            width: 100%;
            display: block;
        }

        /* ── Order Grid ── */
        .order-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; }
        @media (max-width: 620px) { .order-grid { grid-template-columns: 1fr; } }

        /* ── Order Card ── */
        .order-card {
            background: var(--color-bg-card); border: 0.5px solid var(--color-border);
            border-radius: var(--border-radius-lg); overflow: hidden;
            display: flex; flex-direction: column;
        }
        .order-card.ready { border: 2px solid #1D9E75; }

        /* Card Header */
        .card-header {
            padding: 9px 13px; display: flex; align-items: center;
            justify-content: space-between; gap: 8px;
            border-bottom: 0.5px solid var(--color-border);
            background: var(--color-bg-secondary);
        }
        .order-card.ready .card-header { background: #E1F5EE; border-bottom-color: #c2e8d9; }
        .card-header-left  { display: flex; align-items: center; gap: 6px; flex-wrap: wrap; }
        .card-header-right { display: flex; align-items: center; gap: 5px; flex-shrink: 0; }

        .order-num { font-size: 12px; font-weight: 800; }

        /* Type badges */
        .badge-type {
            font-size: 10px; font-weight: 700; padding: 2px 7px; border-radius: 20px; white-space: nowrap;
        }
        .badge-delivery  { background: #dbeafe; color: #1e40af; }
        .badge-takeaway  { background: #ede9fe; color: #5b21b6; }
        .badge-dine      { background: #e5e7eb; color: #374151; }
        .badge-priority  { background: #0F6E56; color: #fff; font-size: 10px; font-weight: 700; padding: 2px 7px; border-radius: 20px; }

        /* Status */
        .status-dot { width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0; }
        .dot-pending    { background: #BA7517; }
        .dot-processing { background: #185fa5; }
        .dot-ready      { background: #3b6d11; }
        .dot-completed  { background: #1D9E75; }
        .status-text { font-size: 11px; font-weight: 600; color: var(--color-text-secondary); }
        .card-time { font-size: 11px; color: var(--color-text-tertiary); }

        /* Card Body */
        .card-body { padding: 11px 13px; flex: 1; }
        .customer-row { font-size: 11px; color: var(--color-text-tertiary); margin-bottom: 8px; }
        .customer-row strong { color: var(--color-text-primary); }

        .item-list { display: flex; flex-direction: column; gap: 4px; margin-bottom: 8px; }
        .item-row  { display: flex; justify-content: space-between; align-items: flex-start; gap: 8px; }
        .item-info { flex: 1; }
        .item-name { font-size: 12px; color: var(--color-text-primary); line-height: 1.4; }
        .item-qty  { font-size: 10px; color: var(--color-text-tertiary); margin-top: 1px; }
        .item-price{ font-size: 12px; color: var(--color-text-secondary); flex-shrink: 0; }

        .breakdown {
            padding-top: 7px; border-top: 0.5px solid var(--color-border);
            display: flex; flex-direction: column; gap: 3px;
        }
        .breakdown-row { display: flex; justify-content: space-between; font-size: 11px; color: var(--color-text-tertiary); }
        .breakdown-row.fee { color: var(--color-text-secondary); }

        .special-note {
            margin-top: 7px; padding: 4px 8px;
            background: #fef3c7; border-radius: var(--border-radius-sm);
            font-size: 11px; color: #92400e;
        }

        /* Card Footer */
        .card-footer {
            padding: 9px 13px; border-top: 0.5px solid var(--color-border);
            background: var(--color-bg-secondary);
            display: flex; align-items: center; justify-content: space-between;
        }
        .order-card.ready .card-footer { background: #f0fbf6; border-top-color: #c2e8d9; }
        .footer-total-label  { font-size: 11px; color: var(--color-text-tertiary); margin-bottom: 1px; }
        .footer-total-amount { font-size: 15px; font-weight: 800; }
        .footer-actions { display: flex; gap: 6px; align-items: center; }

        /* Buttons */
        .btn-pay {
            font-size: 12px; font-weight: 700; padding: 6px 14px;
            border-radius: var(--border-radius-sm); border: none; cursor: pointer;
            background: #111; color: #fff; transition: opacity .12s;
            display: inline-flex; align-items: center; gap: 5px;
        }
        .btn-pay:hover { opacity: .8; }
        .btn-pay.green { background: #0F6E56; color: #fff; }
        .btn-pay.disabled {
            background: var(--color-bg-tertiary); color: var(--color-text-tertiary);
            cursor: default;
        }
        .btn-pay.disabled:hover { opacity: 1; }

        .btn-icon {
            width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;
            border: 0.5px solid var(--color-border); border-radius: var(--border-radius-sm);
            background: var(--color-bg-card); cursor: pointer; font-size: 13px; color: var(--color-text-secondary);
            text-decoration: none; transition: background .12s;
        }
        .btn-icon:hover { background: var(--color-bg-tertiary); }

        /* Payment dropdown */
        .pay-dropdown { position: relative; }
        .pay-dropdown-menu {
            position: absolute; right: 0; bottom: calc(100% + 6px);
            width: 160px; background: var(--color-bg-card);
            border: 0.5px solid var(--color-border); border-radius: var(--border-radius-md);
            box-shadow: 0 4px 16px rgba(0,0,0,.08); overflow: hidden; z-index: 50;
        }
        .pay-dropdown-item {
            display: flex; align-items: center; gap: 8px;
            padding: 9px 12px; font-size: 12px; color: var(--color-text-primary);
            cursor: pointer; border: none; background: none; width: 100%; text-align: left;
            transition: background .1s;
        }
        .pay-dropdown-item:hover { background: var(--color-bg-secondary); }

        /* Flash message */
        .flash {
            margin: 12px auto 0;
            max-width: 1100px;
            padding: 10px 14px; border-radius: var(--border-radius-md);
            font-size: 12px; font-weight: 600;
            display: flex; align-items: center; gap: 8px;
        }
        .flash.success { background: #d1fae5; color: #065f46; border: 0.5px solid #a7f3d0; }
        .flash.error   { background: #fee2e2; color: #991b1b; border: 0.5px solid #fca5a5; }

        /* Empty state */
        .empty-state { text-align: center; padding: 64px 16px; color: var(--color-text-tertiary); }
        .empty-icon { font-size: 48px; margin-bottom: 12px; }
        .empty-title { font-size: 15px; font-weight: 700; color: var(--color-text-secondary); margin-bottom: 4px; }
        .empty-sub { font-size: 12px; }
    </style>
</head>
<body>

{{-- ── Topbar ── --}}
<header class="topbar">
    <div class="topbar-left">
        <div class="topbar-logo">09</div>
        <div>
            <div class="topbar-outlet">Zero Nine Coffee Shop</div>
            <div class="topbar-sub">Outlet Utama · POS Kasir</div>
        </div>
    </div>
    <div class="topbar-right">
        <div>
            <div class="topbar-kasir-name">{{ auth()->user()->name }}</div>
            <div class="topbar-kasir-label">Kasir</div>
        </div>
        <div class="topbar-clock" id="clock"></div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="topbar-logout">Keluar</button>
        </form>
    </div>
</header>

{{-- ── Flash Messages ── --}}
@if(session('success'))
    <div class="flash success" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
        <span>✓</span> {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="flash error">
        <span>⚠</span> {{ session('error') }}
    </div>
@endif

{{-- ── Main Content ── --}}
<main class="main">

    {{-- Metrics --}}
    <div class="metrics">
        <div class="metric-card">
            <div class="metric-label">Antrian Aktif</div>
            <div class="metric-value orange">{{ $pendingOrders->count() }}</div>
        </div>
        <div class="metric-card">
            <div class="metric-label">Selesai Hari Ini</div>
            <div class="metric-value green">{{ $completedToday }}</div>
        </div>
        <div class="metric-card">
            <div class="metric-label">Pendapatan Hari Ini</div>
            <div class="metric-value gold">Rp {{ number_format($revenueToday, 0, ',', '.') }}</div>
        </div>
    </div>

    {{-- Filter Bar --}}
    @php
        $readyCount  = $pendingOrders->where('status', 'ready')->count();
        $readyOrders = $pendingOrders->where('status', 'ready');
        $otherOrders = $pendingOrders->where('status', '!=', 'ready');
    @endphp

    <div class="filter-bar" x-data="{ active: 'semua' }">
        <button class="filter-chip" :class="{ active: active === 'semua' }"       @click="active = 'semua';       filterOrders('semua')">Semua</button>
        <button class="filter-chip" :class="{ active: active === 'ready' }"       @click="active = 'ready';       filterOrders('ready')">
            Ready @if($readyCount > 0) <span class="chip-badge">{{ $readyCount }}</span> @endif
        </button>
        <button class="filter-chip" :class="{ active: active === 'pending' }"     @click="active = 'pending';     filterOrders('pending')">Pending</button>
        <button class="filter-chip" :class="{ active: active === 'processing' }"  @click="active = 'processing';  filterOrders('processing')">Processing</button>
        <button class="filter-chip" :class="{ active: active === 'delivery' }"    @click="active = 'delivery';    filterOrders('delivery')">Delivery</button>
        <button class="filter-chip" :class="{ active: active === 'takeaway' }"    @click="active = 'takeaway';    filterOrders('takeaway')">Takeaway</button>
    </div>

    {{-- ── Siap Bayar Section ── --}}
    @if($readyOrders->isNotEmpty())
        <div class="section-divider">● Siap Bayar — Prioritas</div>
        <div class="order-grid" id="order-grid-ready">
            @foreach($readyOrders as $order)
                @include('cashier._order_card', ['order' => $order, 'isReady' => true])
            @endforeach
        </div>
    @endif

    {{-- ── Antrian Lainnya Section ── --}}
    @if($otherOrders->isNotEmpty())
        <div class="section-divider" style="margin-top:16px;">○ Antrian Lainnya</div>
        <div class="order-grid" id="order-grid-others">
            @foreach($otherOrders as $order)
                @include('cashier._order_card', ['order' => $order, 'isReady' => false])
            @endforeach
        </div>
    @endif

    @if($pendingOrders->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">☕</div>
            <div class="empty-title">Tidak ada pesanan aktif</div>
            <div class="empty-sub">Semua pesanan telah diproses!</div>
        </div>
    @endif

</main>

@livewireScripts
<script>
    // Live clock
    function tick() {
        const now = new Date();
        const el = document.getElementById('clock');
        if (el) el.textContent = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
    }
    tick();
    setInterval(tick, 1000);

    // Filter cards
    function filterOrders(filter) {
        const readyGrid  = document.getElementById('order-grid-ready');
        const othersGrid = document.getElementById('order-grid-others');
        const readyDiv   = document.querySelector('[id="order-grid-ready"]')?.previousElementSibling;
        const othersDiv  = document.querySelector('[id="order-grid-others"]')?.previousElementSibling;

        const allCards = document.querySelectorAll('.order-card');

        if (filter === 'semua') {
            allCards.forEach(c => c.style.display = '');
            if (readyGrid)  readyGrid.style.display  = '';
            if (othersGrid) othersGrid.style.display = '';
            return;
        }

        allCards.forEach(card => {
            const status = card.dataset.status || '';
            const type   = card.dataset.type   || '';
            let visible  = false;

            if (filter === 'ready')      visible = status === 'ready';
            else if (filter === 'pending')    visible = status === 'pending';
            else if (filter === 'processing') visible = status === 'processing';
            else if (filter === 'delivery')   visible = type   === 'delivery';
            else if (filter === 'takeaway')   visible = type   === 'takeaway';

            card.style.display = visible ? '' : 'none';
        });

        // Sembunyikan grid jika tidak ada card visible
        if (readyGrid) {
            const anyReady = Array.from(readyGrid.querySelectorAll('.order-card')).some(c => c.style.display !== 'none');
            readyGrid.style.display = anyReady ? '' : 'none';
        }
        if (othersGrid) {
            const anyOthers = Array.from(othersGrid.querySelectorAll('.order-card')).some(c => c.style.display !== 'none');
            othersGrid.style.display = anyOthers ? '' : 'none';
        }
    }
</script>
</body>
</html>