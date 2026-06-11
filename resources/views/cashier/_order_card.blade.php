{{--
    Partial: cashier/_order_card.blade.php
    Variables expected:
        $order   — App\Models\Order (with user, table, items loaded)
        $isReady — bool
--}}
@php
    $statusDotClass = match($order->status) {
        'pending'    => 'dot-pending',
        'processing' => 'dot-processing',
        'ready'      => 'dot-ready',
        'completed'  => 'dot-completed',
        default      => 'dot-pending',
    };
    $statusLabel = match($order->status) {
        'pending'    => 'Pending',
        'processing' => 'Diproses',
        'ready'      => 'Ready',
        'completed'  => 'Selesai',
        default      => ucfirst($order->status),
    };
    $typeClass = match($order->order_type) {
        'delivery' => 'badge-delivery',
        'takeaway' => 'badge-takeaway',
        default    => 'badge-dine',
    };
    $typeLabel = match($order->order_type) {
        'delivery' => 'Delivery',
        'takeaway' => 'Takeaway',
        default    => ($order->table ? 'Meja ' . $order->table->number : 'Dine In'),
    };
@endphp

<div class="order-card {{ $isReady ? 'ready' : '' }}"
     data-status="{{ $order->status }}"
     data-type="{{ $order->order_type }}">

    {{-- Card Header --}}
    <div class="card-header">
        <div class="card-header-left">
            <span class="order-num">#{{ $order->id }}</span>
            <span class="badge-type {{ $typeClass }}">{{ $typeLabel }}</span>
            @if($isReady)
                <span class="badge-priority">Siap bayar</span>
            @endif
        </div>
        <div class="card-header-right">
            <span class="status-dot {{ $statusDotClass }}"></span>
            <form method="POST" action="{{ route('cashier.update-status', $order) }}" class="inline-block m-0 p-0" style="margin-right: 0.5rem">
                @csrf
                @method('PATCH')
                <select name="status" onchange="this.form.submit()" class="text-xs font-semibold bg-transparent border-0 focus:ring-0 cursor-pointer p-0 m-0" style="color: inherit; appearance: none; padding-right: 14px; background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%234b5563%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right center; background-size: 8px auto;">
                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Diproses</option>
                    <option value="ready" {{ $order->status == 'ready' ? 'selected' : '' }}>Ready</option>
                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                </select>
            </form>
            <span class="card-time">{{ $order->created_at->format('H:i') }}</span>
        </div>
    </div>

    {{-- Card Body --}}
    <div class="card-body">
        {{-- Pelanggan --}}
        <div class="customer-row">
            Pelanggan: <strong>{{ $order->user?->name ?? 'Tamu' }}</strong>
        </div>

        {{-- Item list --}}
        <div class="item-list">
            @foreach($order->items as $item)
                <div class="item-row">
                    <div class="item-info">
                        <div class="item-name">{{ $item->menu_name }}</div>
                        <div class="item-qty">{{ $item->quantity }} pcs</div>
                    </div>
                    <div class="item-price">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</div>
                </div>
            @endforeach
        </div>

        {{-- Breakdown biaya --}}
        <div class="breakdown">
            <div class="breakdown-row">
                <span>Subtotal</span>
                <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
            </div>
            @if($order->discount_amount > 0)
                <div class="breakdown-row fee" style="color:#1D9E75">
                    <span>Diskon</span>
                    <span>- Rp {{ number_format($order->discount_amount, 0, ',', '.') }}</span>
                </div>
            @endif
            <div class="breakdown-row fee">
                <span>PPN 10%</span>
                <span>Rp {{ number_format($order->tax_amount, 0, ',', '.') }}</span>
            </div>
            <div class="breakdown-row fee">
                <span>Service 5%</span>
                <span>Rp {{ number_format($order->service_charge, 0, ',', '.') }}</span>
            </div>
        </div>

        {{-- Catatan khusus --}}
        @if($order->special_notes)
            <div class="special-note">📝 {{ $order->special_notes }}</div>
        @endif
    </div>

    {{-- Card Footer --}}
    <div class="card-footer">
        <div>
            <div class="footer-total-label">Total</div>
            <div class="footer-total-amount">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</div>
        </div>

        <div class="footer-actions">
            @if($order->payment_status === 'paid')
                <span style="font-size:11px;font-weight:700;color:#1D9E75;background:#d1fae5;padding:5px 10px;border-radius:5px;">
                    ✓ Lunas
                </span>
            @endif

            {{-- Tombol Struk --}}
            <a href="{{ route('cashier.receipt', $order) }}"
               target="_blank"
               class="btn-icon"
               title="Cetak Struk"
               style="width:34px;height:34px;display:inline-flex;align-items:center;justify-content:center;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 6 2 18 2 18 9"></polyline>
                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                    <rect x="6" y="14" width="12" height="8"></rect>
                </svg>
            </a>
        </div>
    </div>

</div>
