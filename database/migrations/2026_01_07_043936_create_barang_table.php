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
        Schema::create('barang', function (Blueprint $table) {
            $table->id('id_barang'); // Primary Key sesuai permintaan
            $table->string('nama_barang');
            $table->string('merek');
            $table->string('satuan');
            $table->integer('stok_sistem'); // Menggunakan stok_sistem sesuai permintaan
            $table->integer('min_stok');
            $table->decimal('harga_beli', 15, 0);
            $table->decimal('harga_jual', 15, 0);
            $table->string('lokasi');
            $table->timestamps(); // Tetap disarankan ada
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
