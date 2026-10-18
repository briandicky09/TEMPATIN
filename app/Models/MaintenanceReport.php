<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaintenanceReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'customer_id',
        'kos_id',
        'room_id',
        'title',
        'description',
        'photo',
        'status', // open, in_progress, resolved, rejected
        'owner_notes',
    ];

    /**
     * Booking masa sewa terkait.
     */
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    /**
     * Penghuni / penyewa yang melaporkan.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * Properti kos tempat kerusakan terjadi.
     */
    public function kos(): BelongsTo
    {
        return $this->belongsTo(Kos::class, 'kos_id');
    }

    /**
     * Kamar spesifik jika ada.
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    /**
     * Label status bahasa Indonesia.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'open' => 'Menunggu Penanganan',
            'in_progress' => 'Sedang Diproses',
            'resolved' => 'Selesai Diperbaiki',
            'rejected' => 'Ditolak',
            default => ucfirst((string) $this->status),
        };
    }
}
