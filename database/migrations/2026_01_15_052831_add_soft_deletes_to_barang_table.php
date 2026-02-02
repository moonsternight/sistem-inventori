<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk menambahkan kolom deleted_at.
     */
    public function up(): void
    {
        Schema::table('barang', function (Blueprint $table) {
            // Menambahkan kolom deleted_at yang dibutuhkan Laravel
            $table->softDeletes();
        });
    }

    /**
     * Batalkan migrasi (Rollback).
     */
    public function down(): void
    {
        Schema::table('barang', function (Blueprint $table) {
            // Menghapus kolom deleted_at jika migrasi dibatalkan
            $table->dropSoftDeletes();
        });
    }
};
