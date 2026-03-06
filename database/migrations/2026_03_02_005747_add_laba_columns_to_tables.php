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
        Schema::table('penjualan', function (Blueprint $table) {
            if (!Schema::hasColumn('penjualan', 'total_laba')) {
                $table->decimal('total_laba', 15, 0)->after('total')->default(0);
            }
        });

        Schema::table('detail_penjualan', function (Blueprint $table) {
            if (!Schema::hasColumn('detail_penjualan', 'laba')) {
                $table->decimal('laba', 15, 0)->after('subtotal')->default(0);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penjualan', function (Blueprint $table) {
            $table->dropColumn('total_laba');
        });

        Schema::table('detail_penjualan', function (Blueprint $table) {
            $table->dropColumn('laba');
        });
    }
};
