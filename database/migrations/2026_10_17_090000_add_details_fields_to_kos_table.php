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
        Schema::table('kos', function (Blueprint $table) {
            if (!Schema::hasColumn('kos', 'area')) {
                $table->string('area', 50)->nullable()->after('address');
            }
            if (!Schema::hasColumn('kos', 'rooms')) {
                $table->string('rooms', 50)->nullable()->after('area');
            }
            if (!Schema::hasColumn('kos', 'bathrooms')) {
                $table->string('bathrooms', 50)->nullable()->after('rooms');
            }
            if (!Schema::hasColumn('kos', 'bedrooms')) {
                $table->string('bedrooms', 50)->nullable()->after('bathrooms');
            }
            if (!Schema::hasColumn('kos', 'garages')) {
                $table->string('garages', 50)->nullable()->after('bedrooms');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kos', function (Blueprint $table) {
            $columns = ['area', 'rooms', 'bathrooms', 'bedrooms', 'garages'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('kos', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
