<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kos extends Model
{
    use SoftDeletes;

    protected $table = 'kos';

    protected $fillable = [
        'owner_id',
        'title',
        'slug',
        'description',
        'price',
        'type',
        'city',
        'address',
        'thumbnail',
        'status',
        'area',
        'rooms',
        'bathrooms',
        'bedrooms',
        'garages',
        'latitude',
        'longitude',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'latitude' => 'float',
            'longitude' => 'float',
        ];
    }

    /**
     * Pemilik properti kos ini.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Seluruh fasilitas yang dimiliki oleh kos ini.
     */
    public function facilities(): BelongsToMany
    {
        return $this->belongsToMany(Facility::class, 'facility_kos');
    }

    /**
     * Seluruh foto galeri milik kos ini terurut berdasarkan sort_order.
     */
    public function photos(): HasMany
    {
        return $this->hasMany(KosPhoto::class, 'kos_id')->orderBy('sort_order', 'asc');
    }

    /**
     * Seluruh pemesanan / booking yang terjadi pada kos ini.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'kos_id');
    }

    /**
     * Seluruh invoice tagihan yang terkait dengan kos ini.
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, 'kos_id');
    }

    /**
     * Seluruh ulasan / review penghuni kos ini.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'kos_id')->latest();
    }

    /**
     * Rata-rata skor rating kos.
     */
    public function getRatingAttribute(): float
    {
        $avg = $this->reviews()->avg('rating');
        return $avg ? round((float) $avg, 1) : 0.0;
    }

    /**
     * Total jumlah ulasan kos.
     */
    public function getReviewCountAttribute(): int
    {
        return $this->reviews()->count();
    }

    /**
     * Scope untuk kos yang aktif saja.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Accessor thumbnail default jika kosong.
     */
    public function getThumbnailAttribute($value): string
    {
        return $value ?: 'assets/img/kos/1.png';
    }

    /**
     * Accessor nama pemilik untuk tampilan view.
     */
    public function getOwnerNameAttribute(): ?string
    {
        return $this->owner?->name;
    }

    /**
     * Accessor nomor telepon pemilik.
     */
    public function getOwnerPhoneAttribute(): ?string
    {
        return $this->owner?->phone;
    }

    /**
     * Accessor email pemilik.
     */
    public function getOwnerEmailAttribute(): ?string
    {
        return $this->owner?->email;
    }

    /**
     * Accessor label status bahasa Indonesia.
     */
    public function getStatusLabelAttribute(): string
    {
        return $this->status === 'active' ? 'Aktif' : 'Nonaktif';
    }
}
