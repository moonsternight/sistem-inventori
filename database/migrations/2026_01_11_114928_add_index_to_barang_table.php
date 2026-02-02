<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk menambah index.
     */
    public function up()
    {
        Schema::table('barang', function (Blueprint $table) {
            $table->index('nama_barang');
            $table->index('merek');
        });
    }

    /**
     * Batalkan migrasi dan hapus index.
     */
    public function down(): void
    {
        Schema::table('barang', function (Blueprint $table) {
            // Menghapus index jika migrasi di-rollback
            $table->dropIndex(['nama_barang']);
            $table->dropIndex(['merek']);
        });
    }
};
