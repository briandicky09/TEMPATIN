<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RentalContract extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'contract_number',
        'terms',
        'signed_at',
        'signer_ip',
        'status', // draft, active, completed
    ];

    protected function casts(): array
    {
        return [
            'signed_at' => 'datetime',
        ];
    }

    /**
     * Booking yang melandasi terbitnya kontrak ini.
     */
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    /**
     * Generate nomor kontrak unik server-side (format: CTR-YYYYMM-XXXX).
     */
    public static function generateContractNumber(): string
    {
        $prefix = 'CTR-' . now()->format('Ym') . '-';
        do {
            $code = $prefix . strtoupper(\Illuminate\Support\Str::random(5));
        } while (static::where('contract_number', $code)->exists());

        return $code;
    }

    /**
     * Cek apakah kontrak sudah disepakati / ditandatangani secara digital.
     */
    public function isSigned(): bool
    {
        return $this->signed_at !== null && in_array($this->status, ['active', 'completed']);
    }

    /**
     * Generate template klausul kontrak sewa standar berdasarkan data booking.
     */
    public static function createDefaultTerms(Booking $booking): string
    {
        $owner = $booking->kos->owner;
        $customer = $booking->customer;
        $room = $booking->room;
        $roomText = $room ? "Kamar Nomor {$room->room_number} (Lantai {$room->floor})" : "Kamar Standar Properti";

        $startDateStr = $booking->start_date ? (is_string($booking->start_date) ? date('d M Y', strtotime($booking->start_date)) : $booking->start_date->format('d M Y')) : '-';
        $endDateStr = $booking->end_date ? (is_string($booking->end_date) ? date('d M Y', strtotime($booking->end_date)) : $booking->end_date->format('d M Y')) : '-';

        return "PERJANJIAN SEWA MENYEWA KAMAR KOS\n\n"
            . "Tanggal Penerbitan: " . now()->format('d F Y') . "\n\n"
            . "PIHAK PERTAMA (PEMILIK PROPERTI):\n"
            . "Nama: " . ($owner->name ?? 'Pemilik Kos') . "\n"
            . "Kontak / Telepon: " . ($owner->phone ?? '-') . "\n"
            . "Email: " . ($owner->email ?? '-') . "\n\n"
            . "PIHAK KEDUA (PENYEWA / PENGHUNI):\n"
            . "Nama: " . ($booking->tenant_name ?? ($customer->name ?? 'Penyewa')) . "\n"
            . "Kontak / Telepon: " . ($booking->tenant_phone ?? ($customer->phone ?? '-')) . "\n"
            . "Email: " . ($booking->tenant_email ?? ($customer->email ?? '-')) . "\n\n"
            . "OBJEK DAN JANGKA WAKTU SEWA:\n"
            . "Nama Kos: " . ($booking->kos->title ?? $booking->kos->name ?? 'Kos') . "\n"
            . "Alamat Kos: " . ($booking->kos->address ?? '') . ", " . ($booking->kos->city ?? '') . "\n"
            . "Alokasi Kamar: " . $roomText . "\n"
            . "Periode Sewa: " . $startDateStr . " s/d " . $endDateStr . " (" . $booking->duration_months . " Bulan)\n\n"
            . "NILAI SEWA & PEMBAYARAN:\n"
            . "Tarif Sewa Bulanan: Rp " . number_format($booking->kos_price ?? 0, 0, ',', '.') . "\n"
            . "Total Nilai Transaksi: Rp " . number_format($booking->total_amount ?? 0, 0, ',', '.') . "\n\n"
            . "HAK DAN KEWAJIBAN:\n"
            . "1. PIHAK KEDUA berhak menempati kamar yang telah disepakati selama periode sewa yang telah dibayar lunas.\n"
            . "2. PIHAK KEDUA wajib menjaga ketertiban, kebersihan kamar dan fasilitas bersama, serta mematuhi norma dan peraturan lingkungan setempat.\n"
            . "3. PIHAK KEDUA dilarang mengalihkan, memindahtangankan, atau menyewakan kembali (sub-lease) kamar kepada pihak ketiga tanpa izin tertulis dari PIHAK PERTAMA.\n"
            . "4. Kerusakan fasilitas kamar akibat kelalaian PIHAK KEDUA menjadi tanggung jawab PIHAK KEDUA untuk biaya perbaikan atau penggantiannya.\n"
            . "5. PIHAK PERTAMA berhak melakukan pemeriksaan kamar berkala dengan pemberitahuan wajar demi keamanan dan pemeliharaan properti.\n"
            . "6. Perjanjian ini tunduk pada hukum yang berlaku di Republik Indonesia.";
    }

    /**
     * Ambil kontrak yang sudah ada atau buat draf kontrak baru untuk booking.
     */
    public static function firstOrCreateForBooking(Booking $booking): self
    {
        $contract = static::where('booking_id', $booking->id)->first();
        if ($contract) {
            return $contract;
        }

        return static::create([
            'booking_id' => $booking->id,
            'contract_number' => static::generateContractNumber(),
            'terms' => static::createDefaultTerms($booking),
            'status' => 'draft',
        ]);
    }
}
