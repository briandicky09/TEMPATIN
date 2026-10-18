<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = OFF');

            // 1. Recreate users without role CHECK constraint if needed
            $userSql = DB::select("SELECT sql FROM sqlite_master WHERE name = 'users'")[0]->sql ?? '';
            if (str_contains($userSql, 'check ("role" in') || str_contains($userSql, "check ('role' in")) {
                DB::statement("CREATE TABLE users_temp (
                    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                    name VARCHAR NOT NULL,
                    email VARCHAR NOT NULL UNIQUE,
                    phone VARCHAR(30),
                    password VARCHAR NOT NULL,
                    role VARCHAR(30) NOT NULL DEFAULT 'customer',
                    email_verified_at DATETIME,
                    remember_token VARCHAR,
                    avatar VARCHAR,
                    google_id VARCHAR,
                    created_at DATETIME,
                    updated_at DATETIME
                )");

                DB::statement("INSERT INTO users_temp (id, name, email, phone, password, role, email_verified_at, remember_token, avatar, google_id, created_at, updated_at)
                    SELECT id, name, email, phone, password, role, email_verified_at, remember_token, avatar, google_id, created_at, updated_at FROM users");

                DB::statement("DROP TABLE users");
                DB::statement("ALTER TABLE users_temp RENAME TO users");
                DB::statement("CREATE INDEX IF NOT EXISTS users_role_index ON users(role)");
            }

            // 2. Recreate bookings without status CHECK constraint if needed
            $bookingSql = DB::select("SELECT sql FROM sqlite_master WHERE name = 'bookings'")[0]->sql ?? '';
            if (str_contains($bookingSql, 'check ("status" in') || str_contains($bookingSql, "check ('status' in")) {
                $hasRoomId = Schema::hasColumn('bookings', 'room_id');
                $hasRejection = Schema::hasColumn('bookings', 'rejection_reason');

                $roomCol = $hasRoomId ? 'room_id INTEGER, ' : '';
                $rejectionCol = $hasRejection ? 'rejection_reason TEXT, ' : '';

                $selectCols = "id, customer_id, kos_id, " . ($hasRoomId ? 'room_id, ' : '') . "booking_code, tenant_name, tenant_phone, tenant_email, start_date, end_date, duration_months, kos_price, subtotal, admin_fee, total_amount, notes, status, " . ($hasRejection ? 'rejection_reason, ' : '') . "created_at, updated_at";

                DB::statement("CREATE TABLE bookings_temp (
                    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                    customer_id INTEGER NOT NULL,
                    kos_id INTEGER NOT NULL,
                    {$roomCol}
                    booking_code VARCHAR(50) NOT NULL UNIQUE,
                    tenant_name VARCHAR(100) NOT NULL,
                    tenant_phone VARCHAR(30) NOT NULL,
                    tenant_email VARCHAR(150) NOT NULL,
                    start_date DATE NOT NULL,
                    end_date DATE NOT NULL,
                    duration_months INTEGER NOT NULL DEFAULT 1,
                    kos_price NUMERIC NOT NULL,
                    subtotal NUMERIC NOT NULL,
                    admin_fee NUMERIC NOT NULL DEFAULT 25000.00,
                    total_amount NUMERIC NOT NULL,
                    notes TEXT,
                    status VARCHAR(30) NOT NULL DEFAULT 'pending',
                    {$rejectionCol}
                    created_at DATETIME,
                    updated_at DATETIME,
                    FOREIGN KEY (customer_id) REFERENCES users(id) ON DELETE RESTRICT,
                    FOREIGN KEY (kos_id) REFERENCES kos(id) ON DELETE RESTRICT
                )");

                DB::statement("INSERT INTO bookings_temp ({$selectCols}) SELECT {$selectCols} FROM bookings");

                DB::statement("DROP TABLE bookings");
                DB::statement("ALTER TABLE bookings_temp RENAME TO bookings");
                DB::statement("CREATE INDEX IF NOT EXISTS bookings_customer_id_status_index ON bookings(customer_id, status)");
                DB::statement("CREATE INDEX IF NOT EXISTS bookings_start_date_end_date_index ON bookings(start_date, end_date)");
            }

            // 3. Recreate payments without payment_method CHECK constraint if needed
            $paymentSql = DB::select("SELECT sql FROM sqlite_master WHERE name = 'payments'")[0]->sql ?? '';
            if (str_contains($paymentSql, 'check ("payment_method" in') || str_contains($paymentSql, "check ('payment_method' in")) {
                DB::statement("CREATE TABLE payments_temp (
                    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                    invoice_id INTEGER NOT NULL,
                    payment_code VARCHAR(50) NOT NULL,
                    order_id VARCHAR(100),
                    payment_method VARCHAR(50) NOT NULL DEFAULT 'virtual_account',
                    payment_channel VARCHAR(50),
                    transaction_id VARCHAR(100),
                    amount NUMERIC NOT NULL,
                    snap_token VARCHAR(255),
                    snap_redirect_url TEXT,
                    payment_proof VARCHAR(255),
                    status VARCHAR(50) NOT NULL DEFAULT 'pending',
                    paid_at DATETIME,
                    payload_response TEXT,
                    created_at DATETIME,
                    updated_at DATETIME,
                    FOREIGN KEY (invoice_id) REFERENCES invoices(id) ON DELETE RESTRICT
                )");

                DB::statement("INSERT INTO payments_temp (
                    id, invoice_id, payment_code, order_id, payment_method, payment_channel, transaction_id, amount,
                    snap_token, snap_redirect_url, payment_proof, status, paid_at, payload_response, created_at, updated_at
                ) SELECT 
                    id, invoice_id, payment_code, order_id, payment_method, payment_channel, transaction_id, amount,
                    snap_token, snap_redirect_url, payment_proof, status, paid_at, payload_response, created_at, updated_at
                FROM payments");

                DB::statement("DROP TABLE payments");
                DB::statement("ALTER TABLE payments_temp RENAME TO payments");
                DB::statement("CREATE UNIQUE INDEX IF NOT EXISTS payments_payment_code_unique ON payments(payment_code)");
                DB::statement("CREATE UNIQUE INDEX IF NOT EXISTS payments_transaction_id_unique ON payments(transaction_id)");
                DB::statement("CREATE INDEX IF NOT EXISTS payments_invoice_id_status_index ON payments(invoice_id, status)");
                DB::statement("CREATE INDEX IF NOT EXISTS payments_order_id_index ON payments(order_id)");
            }

            DB::statement('PRAGMA foreign_keys = ON');
        } else {
            // MySQL: modify columns directly
            try {
                DB::statement("ALTER TABLE users MODIFY COLUMN role VARCHAR(30) NOT NULL DEFAULT 'customer'");
                DB::statement("ALTER TABLE bookings MODIFY COLUMN status VARCHAR(30) NOT NULL DEFAULT 'pending'");
                DB::statement("ALTER TABLE payments MODIFY COLUMN payment_method VARCHAR(50) NOT NULL DEFAULT 'virtual_account'");
            } catch (\Throwable $e) {
                // Ignore if already string
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No down migration needed as broadening string types is backwards-compatible
    }
};
