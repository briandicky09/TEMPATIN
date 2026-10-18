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
        Schema::create('surveys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kos_id')->constrained('kos')->onDelete('cascade');
            $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');
            $table->date('survey_date');
            $table->string('survey_time', 20); // e.g. "10:00"
            $table->text('notes')->nullable();
            $table->string('status', 30)->default('pending'); // pending, approved, rejected, cancelled, completed
            $table->text('rejection_reason')->nullable();
            $table->timestamps();

            $table->index(['kos_id', 'status']);
            $table->index(['customer_id', 'status']);
            $table->index(['survey_date', 'survey_time']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surveys');
    }
};
