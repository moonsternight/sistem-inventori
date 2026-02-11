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
                'detail_pembelian.jumlah',
                'detail_pembelian.harga',
                'detail_pembelian.subtotal',
                'barang.nama_barang',
                'barang.merek'
            )
            ->get();

        return view('laporan-detail-faktur-pembelian', compact('pembelian', 'detailBarang'));
    }
}
