<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanDetailPembelianController extends Controller
{
    public function index(Request $request, $id)
    {
        $tglMulai = $request->get('tgl_mulai');
        $tglAkhir = $request->get('tgl_akhir');

        if ($request->has('tgl_mulai') || $request->has('tgl_akhir')) {

            if (empty($tglMulai) && empty($tglAkhir)) {
                return redirect()->route('laporan.rekap.pembelian');
            }

            if ($tglMulai > $tglAkhir) {
                return back()->withInput();
            }

            $adaData = DB::table('pembelian')
                ->whereBetween('tanggal', [$tglMulai, $tglAkhir])
                ->exists();

            if (!$adaData) {
                return back()->with('error_filter', 'Data rekap tidak ditemukan.');
            }

            return redirect()->route('laporan.rekap.pembelian', [
                'tgl_mulai' => $tglMulai,
                'tgl_akhir' => $tglAkhir
            ]);
        }

        $pembelian = DB::table('pembelian')
            ->where('id_pembelian', $id)
            ->first();

        $detailBarang = DB::table('detail_pembelian')
            ->join('barang', 'detail_pembelian.id_barang', '=', 'barang.id_barang')
            ->where('detail_pembelian.id_pembelian', $id)
            ->select(
                'detail_pembelian.id_detail_pembelian',
                'detail_pembelian.jumlah',
                'detail_pembelian.harga',
                'detail_pembelian.subtotal',
                'barang.nama_barang',
                'barang.merek'
            )
            ->get();

        $semuaBarang = DB::table('barang')->select('nama_barang', 'merek', 'harga_beli')->get();

        return view('laporan-detail-faktur-pembelian', compact('pembelian', 'detailBarang', 'semuaBarang'));
    }

    public function store(Request $request, $id_pembelian)
    {
        // 1. Validasi Input Dasar
        $request->validate([
            'nama_barang' => 'required',
            'merek' => 'required',
            'jumlah' => 'required|numeric|min:1',
            'harga' => 'required',
        ]);

        // Bersihkan format Rupiah agar menjadi angka murni
        $hargaMurni = (int) preg_replace('/[^\d]/', '', $request->harga);
        $jumlah = (int) $request->jumlah;
        $subtotal = $hargaMurni * $jumlah;

        try {
            DB::beginTransaction();

            // 2. Logika "Cek atau Buat" Barang (Inventori)
            // Cari barang berdasarkan Nama dan Merek
            $barang = \App\Models\Barang::where('nama_barang', $request->nama_barang)
                ->where('merek', $request->merek)
                ->first();

            if ($barang) {
                // Jika sudah ada, update stok dan harga beli terakhir
                $barang->stok_sistem += $jumlah;
                $barang->harga_beli = $hargaMurni;
                $barang->save();
            } else {
                // Jika tidak ada, buat sebagai barang "Baru"
                $barang = \App\Models\Barang::create([
                    'nama_barang'   => $request->nama_barang,
                    'merek'         => $request->merek,
                    'stok_sistem'   => $jumlah,
                    'harga_beli'    => $hargaMurni,
                    'kategori'      => "-",
                    'satuan'        => "-",
                    'lokasi'        => "-",
                    'min_stok'      => 0,
                    'harga_jual'    => 0,
                    'tanggal_masuk' => now(),
                ]);
            }

            // 3. Simpan ke Tabel detail_pembelian (Level 3)
            DB::table('detail_pembelian')->insert([
                'id_pembelian' => $id_pembelian,
                'id_barang'    => $barang->id_barang,
                'jumlah'       => $jumlah,
                'harga'        => $hargaMurni,
                'subtotal'     => $subtotal,
            ]);

            // 4. Update Total Pembayaran di Tabel pembelian (Level 2)
            // Hitung ulang semua subtotal untuk faktur ini
            $totalTerbaru = DB::table('detail_pembelian')
                ->where('id_pembelian', $id_pembelian)
                ->sum('subtotal');

            DB::table('pembelian')
                ->where('id_pembelian', $id_pembelian)
                ->update(['total' => $totalTerbaru]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Barang berhasil ditambahkan!',
                'data' => [
                    'nama_barang' => $barang->nama_barang,
                    'merek'       => $barang->merek,
                    'jumlah'      => $jumlah,
                    'harga'       => $hargaMurni,
                    'subtotal'    => $subtotal,
                    'total_faktur' => $totalTerbaru // Untuk update Level 2 & 1 secara visual
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id_detail)
    {
        // Validasi input
        $request->validate([
            'nama_barang' => 'required',
            'merek' => 'required',
            'jumlah' => 'required|numeric|min:1',
            'harga' => 'required',
        ]);

        // Bersihkan format harga (Penting!)
        $hargaMurni = (int) preg_replace('/[^\d]/', '', $request->harga);
        $jumlahBaru = (int) $request->jumlah;
        $subtotalBaru = $hargaMurni * $jumlahBaru;

        try {
            DB::beginTransaction();

            // 1. Ambil data lama
            $detailLama = DB::table('detail_pembelian')->where('id_detail_pembelian', $id_detail)->first();
            $barangLama = \App\Models\Barang::find($detailLama->id_barang);

            // 2. Cari atau Buat Barang Baru (Barang B) berdasarkan Nama & Merek dari Form
            $barangBaru = \App\Models\Barang::where('nama_barang', $request->nama_barang)
                ->where('merek', $request->merek)
                ->first();

            // Jika barang belum ada di inventori, buat baru (Skenario Barang Baru B)
            if (!$barangBaru) {
                $barangBaru = \App\Models\Barang::create([
                    'nama_barang'   => $request->nama_barang,
                    'merek'         => $request->merek,
                    'stok_sistem'   => 0, // Mulai dari 0, nanti ditambah di bawah
                    'harga_beli'    => $hargaMurni,
                    'kategori'      => "-",
                    'satuan'        => "-",
                    'lokasi'        => "-",
                    'min_stok'      => 0,
                    'harga_jual'    => 0,
                    'tanggal_masuk' => now(),
                ]);
            }

            // --- LOGIKA STOK & PERGANTIAN BARANG ---

            // --- LOGIKA STOK & PERGANTIAN BARANG ---

            if ($detailLama->id_barang == $barangBaru->id_barang) {
                // Skenario Barang Tetap (Logika sudah benar)
                $selisih = $jumlahBaru - $detailLama->jumlah;
                $barangBaru->stok_sistem += $selisih;
                $barangBaru->harga_beli = $hargaMurni;
                $barangBaru->save();
                $pesan = "Data telah diperbarui.";
            } else {
                // SKENARIO: Ganti Barang (Urutan harus benar!)

                // 1. Balikkan stok barang lama dulu
                $barangLama->stok_sistem -= $detailLama->jumlah;
                $barangLama->save();

                // 2. UPDATE DETAILNYA DULU (Penting!)
                // Kita pindahkan id_barang ke barang yang baru agar relasinya terputus dari barang lama
                DB::table('detail_pembelian')->where('id_detail_pembelian', $id_detail)->update([
                    'id_barang' => $barangBaru->id_barang,
                    'jumlah' => $jumlahBaru,
                    'harga' => $hargaMurni,
                    'subtotal' => $subtotalBaru,
                ]);

                // 3. BARU HAPUS BARANG LAMA
                // Sekarang barang lama sudah "bebas" karena tidak ada lagi baris di detail_pembelian yang menunjuk ke dia
                if ($barangLama && $barangLama->kategori == "-" && $barangLama->satuan == "-" && $barangLama->harga_jual == 0) {
                    $barangLama->forceDelete();
                }

                // 4. Update stok barang baru
                $barangBaru->stok_sistem += $jumlahBaru;
                $barangBaru->harga_beli = $hargaMurni;
                $barangBaru->save();

                $pesan = "Barang telah diperbarui.";
            }

            // --- UPDATE DATA DETAIL (LEVEL 3) ---
            DB::table('detail_pembelian')->where('id_detail_pembelian', $id_detail)->update([
                'id_barang' => $barangBaru->id_barang,
                'jumlah' => $jumlahBaru,
                'harga' => $hargaMurni,
                'subtotal' => $subtotalBaru,
            ]);

            // --- UPDATE TOTAL FAKTUR (LEVEL 2 & 1) ---
            $totalTerbaru = DB::table('detail_pembelian')
                ->where('id_pembelian', $detailLama->id_pembelian)
                ->sum('subtotal');

            DB::table('pembelian')
                ->where('id_pembelian', $detailLama->id_pembelian)
                ->update(['total' => $totalTerbaru]);

            DB::commit();

            return back()->with('success', $pesan);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error_filter', 'Gagal memperbarui: ' . $e->getMessage());
        }
    }

    public function destroy($id_detail)
    {
        try {
            DB::beginTransaction();

            // 1. Ambil data detail yang akan dihapus
            $detail = DB::table('detail_pembelian')->where('id_detail_pembelian', $id_detail)->first();
            if (!$detail) {
                return back()->with('error_filter', 'Data tidak ditemukan.');
            }

            $id_pembelian = $detail->id_pembelian;
            $id_barang = $detail->id_barang;
            $jumlahHapus = $detail->jumlah;

            // 2. Update Stok Barang (Kurangi stok karena pembelian dibatalkan)
            $barang = \App\Models\Barang::find($id_barang);
            if ($barang) {
                $barang->stok_sistem -= $jumlahHapus;
                $barang->save();
            }

            // 3. Hapus baris di Level 3 (detail_pembelian) - DIPINDAH KE ATAS
            DB::table('detail_pembelian')->where('id_detail_pembelian', $id_detail)->delete();

            // 4. Logika Hapus Permanen Barang Baru
            if ($barang && $barang->kategori == "-" && $barang->satuan == "-" && $barang->harga_jual == 0) {
                // Cek sisa penggunaan setelah baris detail di atas dihapus
                $masihDigunakan = DB::table('detail_pembelian')
                    ->where('id_barang', $id_barang)
                    ->exists();

                if (!$masihDigunakan) {
                    $barang->forceDelete();
                }
            }

            $totalTerbaru = DB::table('detail_pembelian')
                ->where('id_pembelian', $id_pembelian)
                ->sum('subtotal');

            DB::table('pembelian')
                ->where('id_pembelian', $id_pembelian)
                ->update(['total' => $totalTerbaru]);

            DB::commit();
            return back();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error_filter', 'Gagal menghapus: ' . $e->getMessage());
        }
    }

    public function toggleMetode($id)
    {
        try {
            DB::beginTransaction();

            $pembelian = DB::table('pembelian')->where('id_pembelian', $id)->first();

            if (!$pembelian) {
                return response()->json(['success' => false, 'message' => 'Data tidak ditemukan.'], 404);
            }

            $metodeBaru = ($pembelian->metode_pembayaran === 'TUNAI') ? 'TRANSFER BCA' : 'TUNAI';

            DB::table('pembelian')
                ->where('id_pembelian', $id)
                ->update(['metode_pembayaran' => $metodeBaru]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Metode pembayaran berhasil diubah!',
                'metode_baru' => $metodeBaru
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
