<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    /**
     * Biaya administrasi standar sesuai aturan project.
     */
    public const DEFAULT_ADMIN_FEE = 25000.00;

    /**
     * Generate unique booking code server-side (format: BKG-YYYYMM-XXXXX).
     */
    public static function generateBookingCode(): string
    {
        do {
            $random = strtoupper(\Illuminate\Support\Str::random(5));
            $code = 'BKG-' . now()->format('Ym') . '-' . $random;
        } while (static::where('booking_code', $code)->exists());

        return $code;
    }

    protected $fillable = [
        'customer_id',
        'kos_id',
        'booking_code',
        'tenant_name',
        'tenant_phone',
        'tenant_email',
        'start_date',
        'end_date',
        'duration_months',
        'kos_price',
        'subtotal',
        'admin_fee',
        'total_amount',
        'notes',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'duration_months' => 'integer',
            'kos_price' => 'decimal:2',
            'subtotal' => 'decimal:2',
            'admin_fee' => 'decimal:2',
            'total_amount' => 'decimal:2',
        ];
    }

    /**
     * Accessor total alias untuk total_amount.
     */
    public function getTotalAttribute(): float
    {
        return (float) ($this->total_amount ?? ((float) $this->subtotal + (float) $this->admin_fee));
    }

    /**
     * Customer / penyewa yang melakukan booking ini.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * Kos yang dipesan.
     */
    public function kos(): BelongsTo
    {
        return $this->belongsTo(Kos::class, 'kos_id');
    }

    /**
     * Seluruh invoice tagihan yang dihasilkan dari booking ini.
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, 'booking_id');
    }

    /**
     * Invoice tagihan utama untuk booking ini.
     */
    public function invoice(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Invoice::class, 'booking_id');
    }

    /**
     * Cek apakah status booking saat ini pending.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }
}

