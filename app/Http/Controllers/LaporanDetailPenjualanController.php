<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
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

        $totalProfit = $rincianBarang->sum(function ($detail) {
            return ($detail->harga - $detail->modal) * $detail->jumlah;
        });

        return view('laporan-detail-transaksi-penjualan', compact('penjualan', 'rincianBarang', 'totalProfit'));
    }
}
