<?php

namespace App\Http\Controllers;

use App\Services\PaymentService;
use App\Services\TripayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function __construct(
        private readonly PaymentService $paymentService,
        private readonly TripayService $tripayService,
    ) {}

    /**
     * Handle Midtrans payment notification webhook.
     * This endpoint is called by Midtrans server — no CSRF, no auth required.
     */
    public function notification(Request $request)
    {
        try {
            $order = $this->paymentService->handleNotification($request->all());
            Log::info("Payment notification processed for order: {$order->order_number}", [
                'status' => $order->payment_status,
            ]);
            return response()->json(['message' => 'OK'], 200);
        } catch (\Exception $e) {
            Log::error("Midtrans webhook error: " . $e->getMessage(), $request->all());
            return response()->json(['message' => 'Error'], 500);
        }
    }

    /**
     * Handle Tripay payment callback/webhook.
     *
     * Tripay server mengirim POST request ke endpoint ini setelah status pembayaran berubah.
     * Autentikasi menggunakan HMAC-SHA256 di header X-Callback-Signature (bukan CSRF).
     *
     * Endpoint ini dikecualikan dari CSRF di routes/web.php.
     */
    public function tripayCallback(Request $request)
    {
        $rawBody   = $request->getContent();
        $signature = $request->header('X-Callback-Signature', '');
        $data      = $request->json()->all();

        // Tolak request tanpa signature
        if (empty($signature)) {
            Log::warning('Tripay callback: Request tanpa signature ditolak.', [
                'ip' => $request->ip(),
            ]);
            return response()->json(['message' => 'Unauthorized: Missing signature.'], 401);
        }

        // Tolak request tanpa data
        if (empty($data)) {
            Log::warning('Tripay callback: Request dengan body kosong ditolak.');
            return response()->json(['message' => 'Bad Request: Empty body.'], 400);
        }

        try {
            $order = $this->tripayService->handleCallback($rawBody, $signature, $data);

            Log::info("Tripay callback diproses untuk order: {$order->order_number}", [
                'payment_status' => $order->payment_status,
                'tripay_status'  => $data['status'] ?? null,
            ]);

            return response()->json(['message' => 'OK'], 200);

        } catch (\Exception $e) {
            Log::error("Tripay callback error: " . $e->getMessage(), [
                'data' => $data,
                'ip'   => $request->ip(),
            ]);

            // Kembalikan 200 agar Tripay tidak terus-menerus retry
            // Tapi log error untuk investigasi manual
            return response()->json(['message' => 'Error processed.'], 200);
        }
    }
}

