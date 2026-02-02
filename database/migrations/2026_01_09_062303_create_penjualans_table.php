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
        Schema::create('penjualan', function (Blueprint $table) {
            $table->id('id_penjualan');
            $table->string('no_transaksi')->unique(); // Contoh: TRANS-20260109-001
            $table->date('tanggal'); // Tanggal transaksi hari ini
            $table->string('metode_pembayaran'); // Tunai atau Transfer BCA
            $table->decimal('total', 15, 0); // Total akhir yang harus dibayar
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualans');
    }
};
