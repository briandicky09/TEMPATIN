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
        Schema::create('maintenance_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
            $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('kos_id')->constrained('kos')->onDelete('cascade');
            $table->foreignId('room_id')->nullable()->constrained('rooms')->nullOnDelete();
            $table->string('title', 150);
            $table->text('description');
            $table->string('photo')->nullable();
            $table->string('status', 30)->default('open'); // open, in_progress, resolved, rejected
            $table->text('owner_notes')->nullable();
            $table->timestamps();

            $table->index(['kos_id', 'status']);
            $table->index(['customer_id', 'status']);
            $table->index(['booking_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_reports');
    }
};
