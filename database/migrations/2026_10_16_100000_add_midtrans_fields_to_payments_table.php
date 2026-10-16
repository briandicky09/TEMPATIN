<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            if (!Schema::hasColumn('payments', 'order_id')) {
                $table->string('order_id', 100)->nullable()->after('payment_code')->index();
            }
            if (!Schema::hasColumn('payments', 'snap_token')) {
                $table->string('snap_token', 255)->nullable()->after('amount');
            }
            if (!Schema::hasColumn('payments', 'snap_redirect_url')) {
                $table->text('snap_redirect_url')->nullable()->after('snap_token');
            }
            if (!Schema::hasColumn('payments', 'payload_response')) {
                $table->json('payload_response')->nullable()->after('paid_at');
            }
        });

        // Ubah payment_method agar mendukung kanal pembayaran dinamis dari Midtrans
        try {
            DB::statement("ALTER TABLE payments MODIFY COLUMN payment_method VARCHAR(50) NOT NULL DEFAULT 'virtual_account'");
        } catch (\Throwable $e) {
            // Fallback jika database bukan MySQL murni
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            if (Schema::hasColumn('payments', 'order_id')) {
                $table->dropIndex(['order_id']);
                $table->dropColumn('order_id');
            }
            if (Schema::hasColumn('payments', 'snap_token')) {
                $table->dropColumn('snap_token');
            }
            if (Schema::hasColumn('payments', 'snap_redirect_url')) {
                $table->dropColumn('snap_redirect_url');
            }
            if (Schema::hasColumn('payments', 'payload_response')) {
                $table->dropColumn('payload_response');
            }
        });
    }
};
