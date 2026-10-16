<?php

namespace App\Http\Controllers;

use App\Services\MidtransService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransNotificationController extends Controller
{
    protected MidtransService $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    /**
     * Endpoint webhook notifikasi server-to-server dari Midtrans.
     * Route ini tidak menggunakan middleware autentikasi dan dikecualikan dari CSRF token.
     */
    public function handle(Request $request): JsonResponse
    {
        $payload = $request->all();

        Log::info('Menerima webhook notifikasi Midtrans', [
            'order_id' => $payload['order_id'] ?? null,
            'transaction_status' => $payload['transaction_status'] ?? null,
            'status_code' => $payload['status_code'] ?? null,
        ]);

        $result = $this->midtransService->handleNotification($payload);

        if (!$result['success']) {
            return response()->json([
                'status' => 'error',
                'message' => $result['message'],
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => $result['message'],
            'payment_status' => $result['payment_status'],
        ], 200);
    }
}
