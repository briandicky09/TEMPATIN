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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained('invoices')->onDelete('restrict');
            $table->string('payment_code', 50)->unique();
            $table->string('payment_method', 50)->default('virtual_account');
            $table->string('payment_channel', 50)->nullable();
            $table->string('transaction_id', 100)->nullable()->unique();
            $table->decimal('amount', 12, 2);
            $table->string('payment_proof')->nullable();
            $table->enum('status', ['pending', 'success', 'failed', 'expired'])->default('pending');
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->index(['invoice_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
