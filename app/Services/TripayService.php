<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TripayService
{
    private string $apiKey;
    private string $privateKey;
    private string $merchantCode;
    private bool   $isSandbox;

    // ─── Daftar channel pembayaran yang didukung ──────────────────────────────
    // Digunakan untuk validasi dan tampilan UI
    public const CHANNELS = [
        'QRIS'   => ['label' => 'QRIS (Semua Dompet)',  'icon' => '📱', 'type' => 'redirect'],
        'QRISD'  => ['label' => 'GoPay via QRIS',       'icon' => '🟢', 'type' => 'redirect'],
        'OVO'    => ['label' => 'OVO',                  'icon' => '💜', 'type' => 'redirect'],
        'DANA'   => ['label' => 'DANA',                 'icon' => '🔵', 'type' => 'redirect'],
        'BCAVA'  => ['label' => 'Virtual Account BCA',  'icon' => '🏦', 'type' => 'va'],
        'BNIVA'  => ['label' => 'Virtual Account BNI',  'icon' => '🏦', 'type' => 'va'],
        'BRIVA'  => ['label' => 'Virtual Account BRI',  'icon' => '🏦', 'type' => 'va'],
        'COD'    => ['label' => 'Bayar di Tempat (COD)', 'icon' => '💵', 'type' => 'offline'],
    ];

    // ─── Konstruktor ─────────────────────────────────────────────────────────

    public function __construct()
    {
        $this->apiKey       = config('services.tripay.api_key', '');
        $this->privateKey   = config('services.tripay.private_key', '');
        $this->merchantCode = config('services.tripay.merchant_code', '');
        $this->isSandbox    = config('services.tripay.mode', 'sandbox') === 'sandbox';
    }

    // ─── URL Helper ──────────────────────────────────────────────────────────

    /**
     * Base URL API Tripay berdasarkan mode sandbox/production.
     */
    public function getApiBaseUrl(): string
    {
        return $this->isSandbox
            ? 'https://tripay.co.id/api-sandbox'
            : 'https://tripay.co.id/api';
    }

    // ─── Signature Builder ───────────────────────────────────────────────────

    /**
     * Buat HMAC-SHA256 signature untuk request ke Tripay.
     * Format: merchantCode + merchantRef + amount
     */
    public function buildSignature(string $merchantRef, int $amount): string
    {
        return hash_hmac(
            'sha256',
            $this->merchantCode . $merchantRef . $amount,
            $this->privateKey
        );
    }

    /**
     * Verifikasi signature callback dari Tripay.
     * Tripay mengirim header 'X-Callback-Signature' berisi HMAC-SHA256 dari raw body.
     */
    public function verifyCallbackSignature(string $rawBody, string $signature): bool
    {
        $expected = hash_hmac('sha256', $rawBody, $this->privateKey);

        return hash_equals($expected, $signature);
    }

    // ─── Channel List ────────────────────────────────────────────────────────

    /**
     * Ambil daftar channel pembayaran aktif dari API Tripay.
     * Digunakan untuk memastikan channel yang dipilih user memang aktif.
     */
    public function getPaymentChannels(): array
    {
        try {
            $response = Http::withToken($this->apiKey)
                ->get($this->getApiBaseUrl() . '/merchant/payment-channel');

            if ($response->successful()) {
                return $response->json('data', []);
            }

            Log::warning('Tripay: Gagal mengambil daftar channel pembayaran.', [
                'response' => $response->body(),
            ]);
        } catch (\Exception $e) {
            Log::error('Tripay getPaymentChannels error: ' . $e->getMessage());
        }

        return [];
    }

    // ─── Create Transaction ──────────────────────────────────────────────────

    /**
     * Buat transaksi ke Tripay dan simpan hasilnya ke order.
     *
     * @param  Order  $order  — Order yang akan dibayar
     * @param  string $paymentMethod — Kode metode pembayaran Tripay (QRIS, OVO, BCAVA, dll)
     * @return array          — Data transaksi dari Tripay
     *
     * @throws \Exception jika API call gagal
     */
    public function createTransaction(Order $order, string $paymentMethod): array
    {
        $order->load(['user', 'items']);

        // Validasi channel pembayaran
        if (!array_key_exists($paymentMethod, self::CHANNELS)) {
            throw new \InvalidArgumentException(
                "Metode pembayaran '{$paymentMethod}' tidak didukung."
            );
        }

        $merchantRef = $order->order_number; // Gunakan order_number sebagai referensi unik
        $amount      = (int) $order->total_amount;
        $signature   = $this->buildSignature($merchantRef, $amount);

        $payload = [
            'method'         => $paymentMethod,
            'merchant_ref'   => $merchantRef,
            'amount'         => $amount,
            'customer_name'  => $order->user->name,
            'customer_email' => $order->user->email,
            'customer_phone' => $order->user->phone ?? '08000000000',
            'order_items'    => $this->buildOrderItems($order),
            'callback_url'   => route('payment.tripay.callback'),
            'return_url'     => route('customer.orders.show', $order->id),
            'expired_time'   => now()->addHours(24)->timestamp, // 24 jam
            'signature'      => $signature,
        ];

        Log::info('Tripay: Membuat transaksi', [
            'order_number' => $order->order_number,
            'method'       => $paymentMethod,
            'amount'       => $amount,
        ]);

        $response = Http::withToken($this->apiKey)
            ->post($this->getApiBaseUrl() . '/transaction/create', $payload);

        if (!$response->successful() || $response->json('success') !== true) {
            $message = $response->json('message', 'Gagal membuat transaksi Tripay.');
            Log::error('Tripay: Gagal membuat transaksi.', [
                'order'   => $order->order_number,
                'payload' => $payload,
                'error'   => $message,
                'body'    => $response->body(),
            ]);
            throw new \Exception("Tripay: {$message}");
        }

        $data = $response->json('data');

        // Simpan data Tripay ke order
        $order->update([
            'payment_method'     => $paymentMethod,
            'payment_url'        => $data['checkout_url'] ?? null,
            'tripay_reference'   => $data['reference']   ?? null,
            'payment_expired_at' => isset($data['expired_time'])
                ? \Carbon\Carbon::createFromTimestamp($data['expired_time'])
                : now()->addHours(24),
        ]);

        Log::info('Tripay: Transaksi berhasil dibuat.', [
            'order_number' => $order->order_number,
            'reference'    => $data['reference'] ?? null,
            'checkout_url' => $data['checkout_url'] ?? null,
        ]);

        return $data;
    }

    // ─── Handle Callback ─────────────────────────────────────────────────────

    /**
     * Proses callback/webhook dari Tripay.
     * Dipanggil dari PaymentController@tripayCallback.
     *
     * @param  string $rawBody    — Raw request body untuk verifikasi signature
     * @param  string $signature  — Nilai header X-Callback-Signature dari Tripay
     * @param  array  $data       — Data callback yang sudah di-decode dari JSON
     * @return Order              — Order yang diperbarui
     *
     * @throws \Exception jika signature tidak valid atau order tidak ditemukan
     */
    public function handleCallback(string $rawBody, string $signature, array $data): Order
    {
        // 1. Verifikasi keaslian callback via HMAC signature
        if (!$this->verifyCallbackSignature($rawBody, $signature)) {
            Log::warning('Tripay: Signature callback tidak valid.', [
                'signature' => $signature,
            ]);
            throw new \Exception('Tripay callback signature tidak valid.');
        }

        $merchantRef = $data['merchant_ref'] ?? null;
        $tripayStatus = $data['status'] ?? null;

        if (!$merchantRef) {
            throw new \Exception('Tripay callback: merchant_ref kosong.');
        }

        // 2. Cari order berdasarkan order_number (= merchant_ref yang kita kirim)
        $order = Order::where('order_number', $merchantRef)->firstOrFail();

        // 3. Map status Tripay ke payment_status internal kita
        $paymentStatus = $this->mapTripayStatus($tripayStatus, $order->payment_status);

        $updates = [
            'payment_status' => $paymentStatus,
        ];

        if ($paymentStatus === 'paid') {
            $updates['paid_at'] = now();
            $updates['status']  = 'confirmed'; // Konfirmasi otomatis setelah bayar

            Log::info("Tripay: Pembayaran LUNAS untuk order {$order->order_number}.", [
                'tripay_status' => $tripayStatus,
                'reference'     => $data['reference'] ?? null,
            ]);
        }

        $order->update($updates);

        // 4. Broadcast real-time update (menggunakan event yang sudah ada)
        try {
            broadcast(new \App\Events\OrderStatusUpdated($order->fresh()))->toOthers();
        } catch (\Exception $e) {
            // Jangan gagalkan callback hanya karena broadcast error
            Log::warning('Tripay: Broadcast error setelah callback: ' . $e->getMessage());
        }

        return $order->fresh();
    }

    // ─── Private Helpers ─────────────────────────────────────────────────────

    /**
     * Build array order_items sesuai format yang dibutuhkan Tripay.
     */
    private function buildOrderItems(Order $order): array
    {
        $items = $order->items->map(fn ($item) => [
            'sku'       => 'MENU-' . $item->menu_id,
            'name'      => substr($item->menu_name, 0, 250), // Tripay max 250 char
            'price'     => (int) $item->menu_price,
            'quantity'  => (int) $item->quantity,
            'subtotal'  => (int) $item->subtotal,
            'product_url' => url('/menu'),
            'image_url'   => '',
        ])->toArray();

        // Tambah pajak jika ada
        if ($order->tax_amount > 0) {
            $items[] = [
                'sku'      => 'TAX',
                'name'     => 'Pajak (PPN 10%)',
                'price'    => (int) $order->tax_amount,
                'quantity' => 1,
                'subtotal' => (int) $order->tax_amount,
            ];
        }

        // Tambah service charge jika ada
        if ($order->service_charge > 0) {
            $items[] = [
                'sku'      => 'SERVICE',
                'name'     => 'Biaya Layanan (5%)',
                'price'    => (int) $order->service_charge,
                'quantity' => 1,
                'subtotal' => (int) $order->service_charge,
            ];
        }

        // Kurangi diskon jika ada
        if ($order->discount_amount > 0) {
            $items[] = [
                'sku'      => 'DISCOUNT',
                'name'     => 'Diskon Promo',
                'price'    => -(int) $order->discount_amount,
                'quantity' => 1,
                'subtotal' => -(int) $order->discount_amount,
            ];
        }

        return $items;
    }

    /**
     * Map status dari Tripay ke nilai payment_status internal project.
     *
     * Status Tripay: UNPAID | PAID | FAILED | REFUND | EXPIRED
     */
    private function mapTripayStatus(string $tripayStatus, string $currentStatus): string
    {
        return match (strtoupper($tripayStatus)) {
            'PAID'   => 'paid',
            'FAILED' => 'failed',
            'REFUND' => 'refunded',
            'EXPIRED'=> 'expired',
            'UNPAID' => 'unpaid',
            default  => $currentStatus, // Pertahankan status saat ini jika tidak dikenali
        };
    }
}
