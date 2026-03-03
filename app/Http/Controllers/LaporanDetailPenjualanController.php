<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;

class LaporanDetailPenjualanController extends Controller
{
    public function index(Request $request, $id_penjualan)
    {
        $tglMulai = $request->query('tgl_mulai');
        $tglAkhir = $request->query('tgl_akhir');

        if ($request->has('tgl_mulai') || $request->has('tgl_akhir')) {
            if (empty($tglMulai) && empty($tglAkhir)) {
                return redirect()->route('laporan.rekap.penjualan');
            }

            if ($tglMulai && $tglAkhir && $tglMulai > $tglAkhir) {
                return back()->withInput();
            }

            $adaData = Penjualan::whereBetween('tanggal', [$tglMulai, $tglAkhir])->exists();

            if (!$adaData) {
                return back()->with('error_filter', 'Data rekap tidak ditemukan.');
            }

            return redirect()->route('laporan.rekap.penjualan', [
                'tgl_mulai' => $tglMulai,
                'tgl_akhir' => $tglAkhir
            ]);
        }

        $penjualan = Penjualan::where('id_penjualan', $id_penjualan)->firstOrFail();

        $rincianBarang = DetailPenjualan::with(['barang'])
            ->where('id_penjualan', $id_penjualan)
            ->get();

        $totalProfit = $rincianBarang->sum(function ($item) {
            return ($item->harga - $item->modal) * $item->jumlah;
        });

        $barang = Barang::all();

        return view('laporan-detail-transaksi-penjualan', compact(
            'penjualan',
            'rincianBarang',
            'totalProfit',
            'barang'
        ));
    }

    public function tambahBarang(Request $request)
    {
        $barang = Barang::where('nama_barang', trim($request->nama_barang))
            ->where('merek', trim($request->merek))
            ->first();

        if (!$barang) {
            return back()->with('error_filter', 'Barang tidak ditemukan.');
        }

        $jumlahDiminta = abs((int)$request->jumlah);

        // PERBAIKAN DI SINI: Menggunakan 'stok_sistem' sesuai nama kolom database kamu
        $stokTersedia = (int)$barang->stok_sistem;

        if ($stokTersedia < $jumlahDiminta) {
            return back()->with('error_filter', "Sisa stok " . $stokTersedia);
        }

        DB::beginTransaction();
        try {
            $hargaJual = (int) preg_replace('/[^0-9]/', '', $request->harga);
            $subtotal = $jumlahDiminta * $hargaJual;
            $labaBaru = ($hargaJual - $barang->harga_beli) * $jumlahDiminta;

            DetailPenjualan::create([
                'id_penjualan' => $request->id_penjualan,
                'id_barang'    => $barang->id_barang,
                'modal'        => $barang->harga_beli,
                'jumlah'       => $jumlahDiminta,
                'harga'        => $hargaJual,
                'subtotal'     => $subtotal,
                'laba'         => $labaBaru,
            ]);

            // PERBAIKAN DI SINI JUGA: Memotong kolom 'stok_sistem'
            $barang->decrement('stok_sistem', $jumlahDiminta);

            $penjualan = Penjualan::find($request->id_penjualan);
            $penjualan->increment('total', $subtotal);
            $penjualan->increment('total_laba', $labaBaru);

            DB::commit();
            return back()->with('success', 'Barang ditambahkan.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error_filter', 'Gagal: ' . $e->getMessage());
        }
    }

    public function updateBarang(Request $request, $id_detail_penjualan)
    {
        DB::beginTransaction();
        try {
            $detail = DetailPenjualan::findOrFail($id_detail_penjualan);
            $penjualan = Penjualan::findOrFail($detail->id_penjualan);
            $barangLamaData = Barang::find($detail->id_barang);

            $barangBaru = Barang::where('nama_barang', trim($request->nama_barang))
                ->where('merek', trim($request->merek))
                ->first();

            if (!$barangBaru) {
                return back()->with('error_filter', 'Barang tidak ditemukan di sistem!');
            }

            $hargaBaru = (int) preg_replace('/[^\d]/', '', $request->harga);
            $jumlahBaru = (int) $request->jumlah;

            if ($hargaBaru <= 0 || $jumlahBaru <= 0) {
                return back()->with('error_filter', 'Harga atau jumlah tidak valid.');
            }

            $isBarangBerubah = ($detail->id_barang != $barangBaru->id_barang);

            if ($isBarangBerubah) {
                if ($barangLamaData) {
                    $barangLamaData->increment('stok_sistem', $detail->jumlah);
                }

                $stokTersedia = (int)$barangBaru->stok_sistem;
                if ($stokTersedia < $jumlahBaru) {
                    DB::rollback();
                    return back()->with('error_filter', "Sisa stok " . $stokTersedia);
                }
                $barangBaru->decrement('stok_sistem', $jumlahBaru);
            } else {
                $selisihJumlah = $jumlahBaru - $detail->jumlah;
                $stokTersedia = (int)$barangBaru->stok_sistem;

                if ($selisihJumlah > $stokTersedia) {
                    DB::rollback();
                    return back()->with('error_filter', "Sisa stok " . $stokTersedia);
                }
                $barangBaru->decrement('stok_sistem', $selisihJumlah);
            }

            $subtotalBaru = $hargaBaru * $jumlahBaru;
            $labaBaru = ($hargaBaru - $barangBaru->harga_beli) * $jumlahBaru;

            $detail->update([
                'id_barang' => $barangBaru->id_barang,
                'modal'     => $barangBaru->harga_beli,
                'jumlah'    => $jumlahBaru,
                'harga'     => $hargaBaru,
                'subtotal'  => $subtotalBaru,
                'laba'      => $labaBaru
            ]);

            $totalSemuaDetail = DetailPenjualan::where('id_penjualan', $detail->id_penjualan)->sum('subtotal');
            $totalLabaSemuaDetail = DetailPenjualan::where('id_penjualan', $detail->id_penjualan)->sum('laba');

            $penjualan->update([
                'total' => $totalSemuaDetail,
                'total_laba' => $totalLabaSemuaDetail
            ]);

            DB::commit();

            $pesan = $isBarangBerubah ? 'Barang telah diperbarui.' : 'Data telah diperbarui.';

            return back()->with('success', $pesan);
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error_filter', 'Gagal memperbarui: ' . $e->getMessage());
        }
    }

    public function hapusBarang($id_detail_penjualan)
    {
        DB::beginTransaction();
        try {
            // 1. Cari data detail penjualan berdasarkan ID
            $detail = DetailPenjualan::findOrFail($id_detail_penjualan);

            // 2. Cari transaksi induknya (Penjualan)
            $penjualan = Penjualan::findOrFail($detail->id_penjualan);

            // 3. Cari barang untuk mengembalikan stok ke 'stok_sistem'
            $barang = Barang::find($detail->id_barang);
            if ($barang) {
                // Stok bertambah karena barang batal dijual
                $barang->increment('stok_sistem', $detail->jumlah);
            }

            // 4. Update total bayar dan total laba di tabel Penjualan
            // Kita gunakan decrement karena nilai total dan laba berkurang
            $penjualan->decrement('total', $detail->subtotal);
            $penjualan->decrement('total_laba', $detail->laba);

            // 5. Hapus baris detail
            $detail->delete();

            DB::commit();
            return back();
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error_filter', 'Gagal menghapus: ' . $e->getMessage());
        }
    }

    public function toggleMetode($id_penjualan)
    {
        try {
            // Ambil data transaksi berdasarkan ID
            // Sesuaikan 'Penjualan' dengan nama Model Anda jika berbeda
            $penjualan = \App\Models\Penjualan::findOrFail($id_penjualan);

            // Logika Tukar: Jika TUNAI jadi TRANSFER BCA, dan sebaliknya
            if ($penjualan->metode_pembayaran === 'TUNAI') {
                $penjualan->metode_pembayaran = 'TRANSFER BCA';
            } else {
                $penjualan->metode_pembayaran = 'TUNAI';
            }

            $penjualan->save();

            return response()->json([
                'success' => true,
                'new_metode' => $penjualan->metode_pembayaran
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah data'
            ], 500);
        }
    }
}
