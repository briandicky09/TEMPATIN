<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Survey extends Model
{
    use HasFactory;

    protected $fillable = [
        'kos_id',
        'customer_id',
        'survey_date',
        'survey_time',
        'notes',
        'status', // pending, approved, rejected, cancelled, completed
        'rejection_reason',
    ];

    protected function casts(): array
    {
        return [
            'survey_date' => 'date',
        ];
    }

    /**
     * Kos yang akan disurvei.
     */
    public function kos(): BelongsTo
    {
        return $this->belongsTo(Kos::class, 'kos_id');
    }

    /**
     * Customer yang mengajukan survei.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * Label status bahasa Indonesia.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Menunggu Persetujuan',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'cancelled' => 'Dibatalkan',
            'completed' => 'Selesai',
            default => ucfirst((string) $this->status),
        };
    }
}
