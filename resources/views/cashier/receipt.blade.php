<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Struk #{{ $order->order_number }} — Zero Nine Coffee</title>
    <style>
        /* ── Reset & Base ── */
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Courier New', Courier, monospace;
            background: #f3f4f6;
            display: flex;
            justify-content: center;
            padding: 24px 16px 48px;
            min-height: 100vh;
        }

        /* ── Struk Container ── */
        .receipt {
            background: #fff;
            width: 100%;
            max-width: 320px;
            padding: 24px 20px;
            border-radius: 4px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.10);
            position: relative;
        }

        /* Efek gigi atas & bawah */
        .receipt::before,
        .receipt::after {
            content: '';
            display: block;
            height: 12px;
            background: radial-gradient(circle at 6px 50%, #f3f4f6 6px, transparent 6px);
            background-size: 12px 12px;
            background-repeat: repeat-x;
        }
        .receipt::before { margin: -24px -20px 16px; }
        .receipt::after  { margin: 16px -20px -24px; }

        /* ── Header ── */
        .header {
            text-align: center;
            padding-bottom: 12px;
            border-bottom: 1px dashed #d1d5db;
            margin-bottom: 14px;
        }
        .logo-circle {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, #b8860b, #8b6309);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 8px;
            color: #fff; font-weight: 900; font-size: 13px;
        }
        .shop-name   { font-size: 15px; font-weight: 900; letter-spacing: 1px; color: #1B120D; text-transform: uppercase; }
        .shop-sub    { font-size: 10px; color: #6b7280; margin-top: 2px; }
        .receipt-no  { margin-top: 10px; font-size: 11px; color: #4b5563; }
        .receipt-no strong { color: #1B120D; }

        /* ── Meta info ── */
        .meta { font-size: 10px; color: #6b7280; margin-bottom: 12px; }
        .meta .row { display: flex; justify-content: space-between; margin-bottom: 3px; }
        .meta .val { color: #1f2937; font-weight: 600; text-align: right; max-width: 60%; }

        /* ── Divider ── */
        .dashed { border: none; border-top: 1px dashed #d1d5db; margin: 12px 0; }

        /* ── Items ── */
        .section-label {
            font-size: 9px; font-weight: 700; color: #9ca3af;
            text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;
        }
        .items { font-size: 11px; color: #1f2937; }
        .item-row { margin-bottom: 7px; }
        .item-name { font-weight: 600; word-break: break-word; }
        .item-detail {
            display: flex; justify-content: space-between;
            color: #6b7280; font-size: 10px; margin-top: 2px;
        }
        .item-subtotal { font-weight: 700; color: #1B120D; }

        /* ── Totals ── */
        .totals { font-size: 11px; }
        .total-row { display: flex; justify-content: space-between; margin-bottom: 4px; color: #4b5563; }
        .total-row.discount { color: #15803d; }
        .total-row.grand {
            font-size: 14px; font-weight: 900; color: #1B120D;
            border-top: 2px solid #1B120D; padding-top: 8px; margin-top: 8px;
        }
        .total-row.grand .amount { color: #b8860b; }

        /* ── Payment status badge ── */
        .pay-status {
            margin: 14px 0;
            text-align: center;
            padding: 8px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .pay-status.paid   { background: #d1fae5; color: #065f46; }
        .pay-status.unpaid { background: #fef3c7; color: #92400e; }

        /* ── Footer ── */
        .footer {
            text-align: center;
            font-size: 10px;
            color: #9ca3af;
            margin-top: 14px;
            padding-top: 12px;
            border-top: 1px dashed #d1d5db;
            line-height: 1.6;
        }
        .footer strong { color: #1B120D; }
        .tagline { font-size: 11px; font-weight: 700; color: #b8860b; margin-bottom: 4px; }

        /* ── Print Button (tidak cetak) ── */
        .print-actions {
            position: fixed;
            bottom: 16px;
            right: 16px;
            display: flex;
            gap: 8px;
            z-index: 100;
        }
        .btn-print {
            background: #1B120D; color: #fff;
            border: none; padding: 10px 20px;
            border-radius: 8px; font-size: 13px; font-weight: 600;
            cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }
        .btn-close {
            background: #f3f4f6; color: #374151;
            border: 1px solid #d1d5db; padding: 10px 16px;
            border-radius: 8px; font-size: 13px; font-weight: 600;
            cursor: pointer; text-decoration: none;
        }

        @media print {
            body { background: #fff; padding: 0; }
            .receipt { box-shadow: none; max-width: 100%; padding: 12px; }
            .receipt::before, .receipt::after { display: none; }
            .print-actions { display: none; }
        }
    </style>
</head>
<body>

<div class="receipt">

    {{-- Header --}}
    <div class="header">
        <div class="logo-circle">09</div>
        <div class="shop-name">Zero Nine Coffee</div>
        <div class="shop-sub">Coffee Shop &amp; More</div>
        <div class="receipt-no">
            Struk No. <strong>{{ $order->order_number }}</strong>
        </div>
    </div>

    {{-- Meta Info --}}
    <div class="meta">
        <div class="row">
            <span>Tanggal</span>
            <span class="val">{{ $order->created_at->format('d/m/Y H:i') }}</span>
        </div>
        <div class="row">
            <span>Tipe Pesanan</span>
            <span class="val">
                @if($order->order_type === 'dine_in') Makan di Tempat
                @elseif($order->order_type === 'takeaway') Take Away
                @else Delivery
                @endif
            </span>
        </div>
        @if($order->table)
        <div class="row">
            <span>Meja</span>
            <span class="val">Meja {{ $order->table->number }}
                @if($order->table->name) — {{ $order->table->name }}@endif
            </span>
        </div>
        @endif
        <div class="row">
            <span>Pelanggan</span>
            <span class="val">{{ $order->user?->name ?? 'Tamu' }}</span>
        </div>
        @if($order->payment_method)
        <div class="row">
            <span>Metode Bayar</span>
            <span class="val">{{ strtoupper($order->payment_method) }}</span>
        </div>
        @endif
        <div class="row">
            <span>Kasir</span>
            <span class="val">{{ auth()->user()->name }}</span>
        </div>
    </div>

    <hr class="dashed">

    {{-- Item List --}}
    <div class="section-label">Detail Pesanan</div>
    <div class="items">
        @foreach($order->items as $item)
        <div class="item-row">
            <div class="item-name">{{ $item->menu_name }}</div>
            <div class="item-detail">
                <span>{{ $item->quantity }} x Rp {{ number_format($item->menu_price, 0, ',', '.') }}</span>
                <span class="item-subtotal">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
            </div>
            @if($item->notes)
            <div style="font-size:9px;color:#f59e0b;margin-top:2px;">📝 {{ $item->notes }}</div>
            @endif
        </div>
        @endforeach
    </div>

    <hr class="dashed">

    {{-- Totals --}}
    <div class="totals">
        <div class="total-row">
            <span>Subtotal</span>
            <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
        </div>
        @if($order->discount_amount > 0)
        <div class="total-row discount">
            <span>Diskon
                @if($order->promo) ({{ $order->promo->code }})@endif
            </span>
            <span>- Rp {{ number_format($order->discount_amount, 0, ',', '.') }}</span>
        </div>
        @endif
        <div class="total-row">
            <span>PPN (10%)</span>
            <span>Rp {{ number_format($order->tax_amount, 0, ',', '.') }}</span>
        </div>
        <div class="total-row">
            <span>Service Charge (5%)</span>
            <span>Rp {{ number_format($order->service_charge, 0, ',', '.') }}</span>
        </div>
        <div class="total-row grand">
            <span>TOTAL</span>
            <span class="amount">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
        </div>
    </div>

    {{-- Payment Status --}}
    <div class="pay-status {{ $order->payment_status === 'paid' ? 'paid' : 'unpaid' }}">
        @if($order->payment_status === 'paid')
            ✅ PEMBAYARAN LUNAS
            @if($order->paid_at)
                <div style="font-size:9px;font-weight:400;margin-top:3px;">
                    {{ $order->paid_at->format('d/m/Y H:i') }}
                </div>
            @endif
        @else
            ⏳ BELUM DIBAYAR
        @endif
    </div>

    @if($order->special_notes)
    <div style="font-size:10px;color:#92400e;background:#fef3c7;border-radius:4px;padding:6px 8px;margin-bottom:10px;">
        📝 <strong>Catatan:</strong> {{ $order->special_notes }}
    </div>
    @endif

    {{-- Footer --}}
    <div class="footer">
        <div class="tagline">Terima Kasih!</div>
        Selamat menikmati kopi Anda ☕<br>
        <strong>Zero Nine Coffee Shop</strong><br>
        <span style="font-size:9px;">Struk ini merupakan bukti pembayaran yang sah.</span>
    </div>

</div>

{{-- Print Actions --}}
<div class="print-actions">
    <a href="{{ url()->previous() }}" class="btn-close">✕ Tutup</a>
    <button onclick="window.print()" class="btn-print">🖨 Cetak Struk</button>
</div>

</body>
</html>
