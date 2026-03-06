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
        $request->validate([
            'nama_barang' => 'required',
            'merek' => 'required',
            'jumlah' => 'required|numeric|min:1',
            'harga' => 'required',
        ]);

        $hargaMurni = (int) preg_replace('/[^\d]/', '', $request->harga);
        $jumlah = (int) $request->jumlah;
        $subtotal = $hargaMurni * $jumlah;

        try {
            DB::beginTransaction();

            $barang = \App\Models\Barang::where('nama_barang', $request->nama_barang)
                ->where('merek', $request->merek)
                ->first();

            if ($barang) {
                $barang->stok_sistem += $jumlah;
                $barang->harga_beli = $hargaMurni;
                $barang->save();
            } else {
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

            DB::table('detail_pembelian')->insert([
                'id_pembelian' => $id_pembelian,
                'id_barang'    => $barang->id_barang,
                'jumlah'       => $jumlah,
                'harga'        => $hargaMurni,
                'subtotal'     => $subtotal,
            ]);

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
                    'total_faktur' => $totalTerbaru
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
        $request->validate([
            'nama_barang' => 'required',
            'merek' => 'required',
            'jumlah' => 'required|numeric|min:1',
            'harga' => 'required',
        ]);

        $hargaMurni = (int) preg_replace('/[^\d]/', '', $request->harga);
        $jumlahBaru = (int) $request->jumlah;
        $subtotalBaru = $hargaMurni * $jumlahBaru;

        try {
            DB::beginTransaction();

            $detailLama = DB::table('detail_pembelian')->where('id_detail_pembelian', $id_detail)->first();
            $barangLama = \App\Models\Barang::find($detailLama->id_barang);
            $barangBaru = \App\Models\Barang::where('nama_barang', $request->nama_barang)
                ->where('merek', $request->merek)
                ->first();

            if (!$barangBaru) {
                $barangBaru = \App\Models\Barang::create([
                    'nama_barang'   => $request->nama_barang,
                    'merek'         => $request->merek,
                    'stok_sistem'   => 0,
                    'harga_beli'    => $hargaMurni,
                    'kategori'      => "-",
                    'satuan'        => "-",
                    'lokasi'        => "-",
                    'min_stok'      => 0,
                    'harga_jual'    => 0,
                    'tanggal_masuk' => now(),
                ]);
            }

            if ($detailLama->id_barang == $barangBaru->id_barang) {
                $selisih = $jumlahBaru - $detailLama->jumlah;
                $barangBaru->stok_sistem += $selisih;
                $barangBaru->harga_beli = $hargaMurni;
                $barangBaru->save();
                $pesan = "Data telah diperbarui.";
            } else {

                $barangLama->stok_sistem -= $detailLama->jumlah;
                $barangLama->save();

                DB::table('detail_pembelian')->where('id_detail_pembelian', $id_detail)->update([
                    'id_barang' => $barangBaru->id_barang,
                    'jumlah' => $jumlahBaru,
                    'harga' => $hargaMurni,
                    'subtotal' => $subtotalBaru,
                ]);

                if ($barangLama && $barangLama->kategori == "-" && $barangLama->satuan == "-" && $barangLama->harga_jual == 0) {
                    $barangLama->forceDelete();
                }

                $barangBaru->stok_sistem += $jumlahBaru;
                $barangBaru->harga_beli = $hargaMurni;
                $barangBaru->save();

                $pesan = "Barang telah diperbarui.";
            }

            DB::table('detail_pembelian')->where('id_detail_pembelian', $id_detail)->update([
                'id_barang' => $barangBaru->id_barang,
                'jumlah' => $jumlahBaru,
                'harga' => $hargaMurni,
                'subtotal' => $subtotalBaru,
            ]);

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

            $detail = DB::table('detail_pembelian')->where('id_detail_pembelian', $id_detail)->first();
            if (!$detail) {
                return back()->with('error_filter', 'Data tidak ditemukan.');
            }

            $id_pembelian = $detail->id_pembelian;
            $id_barang = $detail->id_barang;
            $jumlahHapus = $detail->jumlah;
            $barang = \App\Models\Barang::find($id_barang);
            if ($barang) {
                $barang->stok_sistem -= $jumlahHapus;
                $barang->save();
            }

            DB::table('detail_pembelian')->where('id_detail_pembelian', $id_detail)->delete();

            if ($barang && $barang->kategori == "-" && $barang->satuan == "-" && $barang->harga_jual == 0) {
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

            $cekMetode = trim(strtoupper($pembelian->metode_pembayaran));
            $metodeBaru = ($cekMetode === 'TUNAI') ? 'TRANSFER BCA' : 'TUNAI';

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
