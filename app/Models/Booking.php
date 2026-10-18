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
        'room_id',
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
        'rejection_reason',
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
     * Kamar individual spesifik yang dibooking (jika ada).
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    /**
     * Kontrak sewa digital untuk booking ini.
     */
    public function contract(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(RentalContract::class, 'booking_id');
    }

    /**
     * Laporan kerusakan yang berkaitan dengan booking masa sewa ini.
     */
    public function maintenanceReports(): HasMany
    {
        return $this->hasMany(MaintenanceReport::class, 'booking_id');
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
     * Cek apakah status booking saat ini pending (menunggu persetujuan owner).
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Cek apakah status booking disetujui owner dan siap dibayar.
     */
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    /**
     * Cek apakah booking sudah berhasil dibayar / dikonfirmasi.
     */
    public function isConfirmed(): bool
    {
        return $this->status === 'confirmed';
    }

    /**
     * Cek apakah penyewa sudah aktif menghuni (check-in).
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Cek apakah masa sewa sudah selesai (check-out).
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Cek apakah booking ditolak owner.
     */
    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    /**
     * Cek apakah booking dibatalkan.
     */
    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    /**
     * Label status bahasa Indonesia.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Menunggu Persetujuan',
            'approved' => 'Disetujui (Menunggu Pembayaran)',
            'confirmed' => 'Terkonfirmasi (Sudah Bayar)',
            'active' => 'Aktif Menghuni',
            'completed' => 'Selesai Sewa',
            'rejected' => 'Ditolak',
            'cancelled' => 'Dibatalkan',
            default => ucfirst((string) $this->status),
        };
    }
}

