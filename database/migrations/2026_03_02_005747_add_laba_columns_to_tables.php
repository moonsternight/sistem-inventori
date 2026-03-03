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
        // 1. Menambahkan kolom total_laba di tabel penjualan
        Schema::table('penjualan', function (Blueprint $table) {
            if (!Schema::hasColumn('penjualan', 'total_laba')) {
                $table->decimal('total_laba', 15, 0)->after('total')->default(0);
            }
        });

        // 2. Menambahkan kolom laba di tabel detail_penjualan
        Schema::table('detail_penjualan', function (Blueprint $table) {
            if (!Schema::hasColumn('detail_penjualan', 'laba')) {
                $table->decimal('laba', 15, 0)->after('subtotal')->default(0);
            }
            // Kamu tadi menyebutkan sudah ada kolom 'modal', 
            // tapi jika ternyata belum ada di database, tambahkan baris di bawah ini:
            // $table->decimal('modal', 15, 0)->after('harga')->default(0);
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
            // $table->dropColumn('modal'); // Aktifkan jika tadi kamu menambahkan kolom modal
        });
    }
};
