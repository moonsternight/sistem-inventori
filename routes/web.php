<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AutentikasiController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PembelianController;

// --- CONTROLLER PEMBELIAN ---
use App\Http\Controllers\LaporanRekapPembelianController;
use App\Http\Controllers\LaporanFakturPembelianController;
use App\Http\Controllers\LaporanDetailPembelianController;

// --- CONTROLLER LAPORAN ---
use App\Http\Controllers\LaporanRekapPenjualanController;
use App\Http\Controllers\LaporanTransaksiPenjualanController;
use App\Http\Controllers\LaporanDetailPenjualanController;

// --- CONTROLLER STOK OPNAME ---
use App\Http\Controllers\StokOpnameController;

/*
|--------------------------------------------------------------------------
| Web Routes - Toko Mekar Jaya
|--------------------------------------------------------------------------
*/

// ==========================================================
// 1. AUTENTIKASI
// ==========================================================
Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/proses-login', [AutentikasiController::class, 'login'])->name('login.proses');
Route::get('/keluar', [AutentikasiController::class, 'logout'])->name('keluar');


// ==========================================================
// PROTEKSI MIDDLEWARE AUTH
// ==========================================================
Route::middleware(['auth.pemilik'])->group(function () {

    // 2. MODUL INVENTORI
    Route::prefix('inventori')->group(function () {
        Route::get('/', [InventoryController::class, 'index'])->name('inventori');
        Route::post('/simpan', [InventoryController::class, 'store'])->name('barang.simpan');
        Route::put('/update/{id_barang}', [InventoryController::class, 'update'])->name('barang.update');
        Route::delete('/hapus/{id_barang}', [InventoryController::class, 'destroy'])->name('barang.hapus');
    });


    // 3. MODUL PENJUALAN
    Route::prefix('penjualan')->group(function () {
        Route::get('/', [PenjualanController::class, 'index'])->name('penjualan');
        Route::post('/selesai', [PenjualanController::class, 'store'])->name('penjualan.store');
    });


    // 4. MODUL PEMBELIAN
    Route::prefix('pembelian')->group(function () {
        Route::get('/', [PembelianController::class, 'index'])->name('pembelian');
        Route::get('/cari-barang', [InventoryController::class, 'cariBarang'])->name('pembelian.cari');
        Route::post('/selesai', [PembelianController::class, 'store'])->name('pembelian.store');
    });


    // 5. MODUL LAPORAN
    Route::prefix('laporan')->group(function () {

        // --- Laporan Penjualan ---
        Route::get('/rekap-penjualan', [LaporanRekapPenjualanController::class, 'index'])->name('laporan.rekap.penjualan');
        Route::delete('/rekap-penjualan/hapus-semua', [LaporanRekapPenjualanController::class, 'hapusSemua'])->name('laporan.rekap.hapus-semua');
        Route::get('/penjualan/transaksi', [LaporanTransaksiPenjualanController::class, 'index'])->name('laporan.penjualan.transaksi');
        Route::get('/transaksi-penjualan/detail/{id_penjualan}', [LaporanDetailPenjualanController::class, 'index'])->name('laporan.penjualan.nota');

        // --- Laporan Pembelian ---
        Route::get('/rekap-pembelian', [LaporanRekapPembelianController::class, 'index'])->name('laporan.rekap.pembelian');
        Route::delete('/rekap-pembelian/hapus-semua', [LaporanRekapPembelianController::class, 'hapusSemua'])->name('laporan.rekap.pembelian.hapus-semua');
        Route::get('/faktur-pembelian', [LaporanFakturPembelianController::class, 'index'])->name('laporan.pembelian.faktur');
        Route::get('/faktur-pembelian/detail/{id}', [LaporanDetailPembelianController::class, 'index'])->name('laporan.pembelian.detail');
    });


    // 6. MODUL STOK OPNAME
    Route::prefix('stok-opname')->group(function () {
        Route::get('/', [StokOpnameController::class, 'index'])->name('stok.opname');
        Route::post('/simpan', [StokOpnameController::class, 'simpanHasil'])->name('stok.opname.simpan');
    });
});
