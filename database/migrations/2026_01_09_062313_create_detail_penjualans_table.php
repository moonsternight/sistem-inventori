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
        Schema::create('detail_penjualan', function (Blueprint $table) {
            $table->id('id_detail');

            // Relasi ke tabel penjualan
            $table->foreignId('id_penjualan')->constrained('penjualan', 'id_penjualan')->onDelete('cascade');

            // Relasi ke tabel barang (asumsi Primary Key di tabel barang adalah id_barang)
            $table->foreignId('id_barang')->constrained('barang', 'id_barang');

            $table->integer('jumlah'); // Jumlah barang yang dibeli (misal: 2, 10)
            $table->decimal('harga', 15, 0); // Harga satuan barang saat transaksi terjadi
            $table->decimal('subtotal', 15, 0); // Hasil dari jumlah x harga
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_penjualans');
    }
};
