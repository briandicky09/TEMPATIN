<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    /**
     * Generate payment code unik (format: PAY-YYYYMM-XXXXX).
     */
    public static function generatePaymentCode(): string
    {
        do {
            $random = strtoupper(\Illuminate\Support\Str::random(5));
            $code = 'PAY-' . now()->format('Ym') . '-' . $random;
        } while (static::where('payment_code', $code)->exists());

        return $code;
    }

    protected $fillable = [
        'invoice_id',
        'payment_code',
        'order_id',
        'payment_method',
        'payment_channel',
        'transaction_id',
        'amount',
        'snap_token',
        'snap_redirect_url',
        'payment_proof',
        'status',
        'paid_at',
        'payload_response',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'paid_at' => 'datetime',
            'payload_response' => 'array',
        ];
    }

    /**
     * Invoice tagihan yang dibayarkan oleh transaksi ini.
     */
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }
}
