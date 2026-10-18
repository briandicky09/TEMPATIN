<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'google_id',
        'phone',
        'avatar',
        'password',
        'role', // owner | customer
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Properti kos yang dimiliki oleh owner ini.
     */
    public function kos(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Kos::class, 'owner_id');
    }

    /**
     * Booking yang dilakukan oleh customer ini.
     */
    public function bookings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Booking::class, 'customer_id');
    }

    /**
     * Tagihan/invoice milik customer ini.
     */
    public function invoices(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Invoice::class, 'customer_id');
    }

    /**
     * Cek apakah user memiliki peran sebagai owner.
     */
    public function isOwner(): bool
    {
        return $this->role === 'owner';
    }

    /**
     * Cek apakah user memiliki peran sebagai customer.
     */
    public function isCustomer(): bool
    {
        return $this->role === 'customer';
    }

    /**
     * Cek apakah user memiliki peran sebagai admin platform.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Record favorit yang disimpan oleh user ini.
     */
    public function favorites(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Favorite::class, 'user_id');
    }

    /**
     * Kos yang difavoritkan oleh user ini.
     */
    public function favoriteKos(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Kos::class, 'favorites', 'user_id', 'kos_id')->withTimestamps();
    }

    /**
     * Alias untuk favoriteKos.
     */
    public function favoritedKos(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->favoriteKos();
    }

    /**
     * Pengajuan survei yang dibuat oleh customer ini.
     */
    public function surveys(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Survey::class, 'customer_id');
    }

    /**
     * Laporan kerusakan yang diajukan oleh user ini.
     */
    public function maintenanceReports(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(MaintenanceReport::class, 'customer_id');
    }

    /**
     * Percakapan chat sebagai customer.
     */
    public function customerConversations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Conversation::class, 'customer_id');
    }

    /**
     * Percakapan chat sebagai owner.
     */
    public function ownerConversations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Conversation::class, 'owner_id');
    }
}
