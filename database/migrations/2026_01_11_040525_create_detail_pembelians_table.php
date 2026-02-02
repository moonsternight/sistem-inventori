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
        // Menggunakan 'detail_pembelian' (Tanpa s) agar konsisten dengan detail_penjualan
        Schema::create('detail_pembelian', function (Blueprint $table) {
            $table->id('id_detail_pembelian');

            // Foreign Key ke tabel pembelian (Pastikan di Langkah 2 Anda menamakan tabelnya 'pembelian')
            $table->foreignId('id_pembelian')
                ->constrained('pembelian', 'id_pembelian')
                ->onDelete('cascade');

            // Foreign Key ke tabel barang (Pastikan di database Anda namanya 'barang')
            $table->foreignId('id_barang')
                ->constrained('barang', 'id_barang');

            $table->integer('jumlah');
            $table->decimal('harga', 15, 0); // Konsisten tanpa angka di belakang koma
            $table->decimal('subtotal', 15, 0); // Konsisten tanpa angka di belakang koma
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // PERBAIKAN: Harus sama dengan nama di atas agar bisa di-rollback
        Schema::dropIfExists('detail_pembelian');
    }
};
