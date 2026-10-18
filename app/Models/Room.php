<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'kos_id',
        'room_number',
        'floor',
        'room_type',
        'price_override',
        'status', // available, occupied, maintenance
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'price_override' => 'decimal:2',
        ];
    }

    /**
     * Properti kos tempat kamar ini berada.
     */
    public function kos(): BelongsTo
    {
        return $this->belongsTo(Kos::class, 'kos_id');
    }

    /**
     * Seluruh booking yang pernah memilih kamar ini.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'room_id');
    }

    /**
     * Booking aktif saat ini (jika ada).
     */
    public function activeBooking(): ?Booking
    {
        return $this->bookings()
            ->whereIn('status', ['confirmed', 'active'])
            ->latest('id')
            ->first();
    }

    /**
     * Laporan kerusakan yang terjadi pada kamar ini.
     */
    public function maintenanceReports(): HasMany
    {
        return $this->hasMany(MaintenanceReport::class, 'room_id');
    }

    /**
     * Cek apakah kamar siap huni.
     */
    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }

    /**
     * Cek apakah kamar sedang dihuni.
     */
    public function isOccupied(): bool
    {
        return $this->status === 'occupied';
    }

    /**
     * Label status bahasa Indonesia.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'available' => 'Tersedia',
            'occupied' => 'Terisi',
            'maintenance' => 'Perbaikan',
            default => ucfirst((string) $this->status),
        };
    }

    /**
     * Harga efektif kamar (menggunakan price_override jika ada, fallback ke kos->price).
     */
    public function getEffectivePriceAttribute(): float
    {
        if ($this->price_override !== null && (float) $this->price_override > 0) {
            return (float) $this->price_override;
        }

        return (float) ($this->kos?->price ?? 0.0);
    }
}
