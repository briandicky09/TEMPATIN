<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Facility;
use App\Models\Invoice;
use App\Models\Kos;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 0. Master Facilities
        $this->call(FacilitySeeder::class);

        // 1. Users: Owner & Customer
        $owner = User::firstOrCreate(
            ['email' => 'owner@tempatin.id'],
            [
                'name' => 'Rokhim Wicaksono',
                'phone' => '08028621673',
                'password' => Hash::make('password123'),
                'role' => 'owner',
                'email_verified_at' => now(),
            ]
        );

        $customer = User::firstOrCreate(
            ['email' => 'dewi@email.com'],
            [
                'name' => 'Dewi Sartika',
                'phone' => '081234567890',
                'password' => Hash::make('password123'),
                'role' => 'customer',
                'email_verified_at' => now(),
            ]
        );

        // 2. Kos: 2 Properti milik Owner
        $kosMelati = Kos::firstOrCreate(
            ['slug' => 'kos-putri-melati'],
            [
                'owner_id' => $owner->id,
                'title' => 'Kos Putri Melati',
                'description' => 'Menikmati hunian eksklusif di kawasan Kalirungkut. Fasilitas lengkap, kamar mandi dalam, AC, Wi-Fi, dan lingkungan tenang.',
                'price' => 850000.00,
                'type' => 'Putri',
                'city' => 'Surabaya',
                'address' => 'Jl. Kalirungkut No. 88, Ruko Rungkut Makmur Blok C, Surabaya',
                'thumbnail' => 'assets/img/kos/1.png',
                'status' => 'active',
            ]
        );

        $kosAnggrek = Kos::firstOrCreate(
            ['slug' => 'kos-putra-anggrek'],
            [
                'owner_id' => $owner->id,
                'title' => 'Kos Putra Anggrek',
                'description' => 'Kos putra lokasi strategis dekat kampus dan pusat kota Malang. Lingkungan aman dan fasilitas modern.',
                'price' => 750000.00,
                'type' => 'Putra',
                'city' => 'Malang',
                'address' => 'Jl. Soekarno Hatta No. 12, Malang',
                'thumbnail' => 'assets/img/kos/2.png',
                'status' => 'active',
            ]
        );

        // Pasang relasi fasilitas pada seeder kos
        $melatiFacilities = Facility::whereIn('name', ['WiFi', 'AC', 'Kamar Mandi Dalam', 'Kasur', 'Lemari', 'Listrik'])->pluck('id');
        $kosMelati->facilities()->sync($melatiFacilities);

        $anggrekFacilities = Facility::whereIn('name', ['WiFi', 'Kasur', 'Lemari', 'Meja', 'Kursi', 'Parkir Motor', 'Listrik'])->pluck('id');
        $kosAnggrek->facilities()->sync($anggrekFacilities);

        $kosLavender = Kos::firstOrCreate(
            ['slug' => 'kos-eksklusif-lavender'],
            [
                'owner_id' => $owner->id,
                'title' => "Kos Eksklusif D'Lavender",
                'description' => 'Kos eksklusif modern dekat kampus UGM Yogyakarta. Keamanan 24 jam dengan fasilitas hotel berbintang.',
                'price' => 1500000.00,
                'type' => 'Eksklusif',
                'city' => 'Yogyakarta',
                'address' => 'Jl. Kaliurang KM 5.5 No. 42, Sleman, Yogyakarta',
                'thumbnail' => 'assets/img/kos/3.png',
                'status' => 'active',
            ]
        );
        $kosLavender->facilities()->sync($melatiFacilities);

        $kosCendana = Kos::firstOrCreate(
            ['slug' => 'kos-putra-cendana'],
            [
                'owner_id' => $owner->id,
                'title' => 'Kos Putra Cendana ITB',
                'description' => 'Kos nyaman strategis 5 menit jalan kaki ke kampus ITB Ganesha Bandung. Sirkulasi udara sejuk dan lingkungan tenang.',
                'price' => 950000.00,
                'type' => 'Putra',
                'city' => 'Bandung',
                'address' => 'Jl. Dago Asri No. 18, Bandung',
                'thumbnail' => 'assets/img/kos/4.png',
                'status' => 'active',
            ]
        );
        $kosCendana->facilities()->sync($anggrekFacilities);

        $kosMawar = Kos::firstOrCreate(
            ['slug' => 'kos-putri-mawar-asri'],
            [
                'owner_id' => $owner->id,
                'title' => 'Kos Putri Mawar Asri',
                'description' => 'Hunian tenang khusus mahasiswi dan karyawati di Jakarta Selatan. Dekat stasiun MRT dan pusat perkantoran.',
                'price' => 1250000.00,
                'type' => 'Putri',
                'city' => 'Jakarta',
                'address' => 'Jl. Fatmawati Raya No. 27, Jakarta Selatan',
                'thumbnail' => 'assets/img/kos/5.png',
                'status' => 'active',
            ]
        );
        $kosMawar->facilities()->sync($melatiFacilities);

        $kosHarmoni = Kos::firstOrCreate(
            ['slug' => 'kos-harmoni-residence'],
            [
                'owner_id' => $owner->id,
                'title' => 'Kos Harmoni Residence',
                'description' => 'Kos campur eksklusif dekat kawasan Simpang Lima Semarang. Dilengkapi dapur bersama dan parkir mobil luas.',
                'price' => 1100000.00,
                'type' => 'Campur',
                'city' => 'Semarang',
                'address' => 'Jl. Pandanaran No. 70, Semarang',
                'thumbnail' => 'assets/img/kos/6.png',
                'status' => 'active',
            ]
        );
        $kosHarmoni->facilities()->sync($anggrekFacilities);

        // 3. Booking: Dewi Sartika memesan Kos Putri Melati
        $booking = Booking::firstOrCreate(
            ['booking_code' => 'BKG-202608-0001'],
            [
                'customer_id' => $customer->id,
                'kos_id' => $kosMelati->id,
                'tenant_name' => 'Dewi Sartika',
                'tenant_phone' => '081234567890',
                'tenant_email' => 'dewi@email.com',
                'start_date' => '2026-08-05',
                'end_date' => '2026-09-05',
                'duration_months' => 1,
                'kos_price' => 850000.00,
                'subtotal' => 850000.00,
                'admin_fee' => 25000.00,
                'total_amount' => 875000.00,
                'notes' => 'Mohon disiapkan kamar di lantai 1.',
                'status' => 'confirmed',
            ]
        );

        // 4. Invoice: Berasal dari Booking BKG-202608-0001
        $invoice = Invoice::firstOrCreate(
            ['invoice_number' => 'INV-2026-08-0001'],
            [
                'booking_id' => $booking->id,
                'customer_id' => $customer->id,
                'kos_id' => $kosMelati->id,
                'amount' => 850000.00,
                'admin_fee' => 25000.00,
                'tax' => 0.00,
                'total_amount' => 875000.00,
                'due_date' => '2026-08-03',
                'paid_at' => '2026-08-02 14:30:00',
                'status' => 'paid',
            ]
        );

        // 5. Payment: Pelunasan atas Invoice INV-2026-08-0001
        Payment::firstOrCreate(
            ['payment_code' => 'PAY-202608-0001'],
            [
                'invoice_id' => $invoice->id,
                'payment_method' => 'transfer_bank',
                'payment_channel' => 'BCA',
                'transaction_id' => 'TRX-BCA-202608020001',
                'amount' => 875000.00,
                'payment_proof' => 'assets/img/payment-sample.jpg',
                'status' => 'success',
                'paid_at' => '2026-08-02 14:30:00',
            ]
        );
    }
}
