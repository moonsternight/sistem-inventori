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
        Schema::create('detail_pembelian', function (Blueprint $table) {
            $table->id('id_detail_pembelian');
            $table->foreignId('id_pembelian')
                ->constrained('pembelian', 'id_pembelian')
                ->onDelete('cascade');

            $table->foreignId('id_barang')
                ->constrained('barang', 'id_barang');

            $table->integer('jumlah');
            $table->decimal('harga', 15, 0);
            $table->decimal('subtotal', 15, 0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pembelian');
    }
};
