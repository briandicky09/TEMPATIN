<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $fillable = [
        'kos_id',
        'user_id',
        'booking_id',
        'reviewer_name',
        'is_verified_tenant',
        'rating',
        'comment',
        'reply',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
            'is_verified_tenant' => 'boolean',
        ];
    }

    /**
     * Properti kos yang diulas.
     */
    public function kos(): BelongsTo
    {
        return $this->belongsTo(Kos::class, 'kos_id');
    }

    /**
     * Pengguna/penghuni yang memberikan ulasan jika terdaftar.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Booking sewa yang menjadi dasar verifikasi ulasan ini.
     */
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }
}
