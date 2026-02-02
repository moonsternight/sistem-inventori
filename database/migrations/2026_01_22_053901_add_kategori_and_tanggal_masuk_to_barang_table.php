<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('barang', function (Blueprint $table) {
            // Menambahkan kolom kategori setelah kolom merek
            $table->string('kategori')->after('merek')->nullable();

            // Menambahkan kolom tanggal_masuk setelah kolom lokasi
            $table->date('tanggal_masuk')->after('lokasi')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('barang', function (Blueprint $table) {
            // Menghapus kolom jika migration di-rollback
            $table->dropColumn(['kategori', 'tanggal_masuk']);
        });
    }
};
