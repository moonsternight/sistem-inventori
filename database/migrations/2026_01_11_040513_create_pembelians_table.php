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
        Schema::create('pembelian', function (Blueprint $table) {
            $table->id('id_pembelian'); // Primary Key kustom
            $table->string('no_faktur');
            $table->string('pemasok');
            $table->date('tanggal');
            $table->string('metode_pembayaran');
            $table->decimal('total', 15, 0); // Konsisten tanpa desimal sesuai keinginan Anda
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // PERBAIKAN: Ubah 'pembelians' menjadi 'pembelian'
        Schema::dropIfExists('pembelian');
    }
};
