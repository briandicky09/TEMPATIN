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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kos_id')->constrained('kos')->onDelete('cascade');
            $table->string('room_number', 50);
            $table->string('floor', 20)->nullable();
            $table->string('room_type', 50)->nullable();
            $table->decimal('price_override', 12, 2)->nullable();
            $table->string('status', 30)->default('available'); // available, occupied, maintenance
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['kos_id', 'room_number']);
            $table->index(['kos_id', 'status']);
        });

        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings', 'room_id')) {
                $table->foreignId('room_id')->nullable()->after('kos_id')->constrained('rooms')->nullOnDelete();
            }
            if (!Schema::hasColumn('bookings', 'rejection_reason')) {
                $table->text('rejection_reason')->nullable()->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (Schema::hasColumn('bookings', 'room_id')) {
                $table->dropForeign(['room_id']);
                $table->dropColumn('room_id');
            }
            if (Schema::hasColumn('bookings', 'rejection_reason')) {
                $table->dropColumn('rejection_reason');
            }
        });

        Schema::dropIfExists('rooms');
    }
};
