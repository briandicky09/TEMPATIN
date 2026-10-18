<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('reviews') && !Schema::hasColumn('reviews', 'is_verified_tenant')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->boolean('is_verified_tenant')->default(false)->after('reviewer_name');
                $table->foreignId('booking_id')->nullable()->after('user_id')->constrained('bookings')->nullOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('reviews') && Schema::hasColumn('reviews', 'is_verified_tenant')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->dropForeign(['booking_id']);
                $table->dropColumn(['is_verified_tenant', 'booking_id']);
            });
        }
    }
};
