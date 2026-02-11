<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use Illuminate\Support\Facades\DB;

class LaporanTransaksiPenjualanController extends Controller
{
    public function index(Request $request)
    {
        $tglMulai = $request->query('tgl_mulai');
        $tglAkhir = $request->query('tgl_akhir');
        $tanggal = $request->query('tanggal');
        $perPage = $request->query('per_page', 5);
        $rekapPage = $request->query('rekap_page', 1);

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

            session(['rekap_penjualan_last_page' => 1]);
            return redirect()->route('laporan.rekap.penjualan', [
                'tgl_mulai' => $tglMulai,
                'tgl_akhir' => $tglAkhir,
                'page' => 1
            ]);
        }

        $dataTransaksi = Penjualan::select(
            'penjualan.*',
            DB::raw('SUM((detail_penjualan.harga - detail_penjualan.modal) * detail_penjualan.jumlah) as laba_faktur')
        )
            ->leftJoin('detail_penjualan', 'penjualan.id_penjualan', '=', 'detail_penjualan.id_penjualan')
            ->whereDate('penjualan.tanggal', $tanggal)
            ->groupBy('penjualan.id_penjualan')
            ->orderBy('penjualan.no_transaksi', 'asc')
            ->paginate($perPage)
            ->withQueryString();

        if ($dataTransaksi->isEmpty()) {
            return redirect()->back()->with('error_filter', 'Data rekap tidak ditemukan.');
        }

        $totalLabaHalaman = $dataTransaksi->sum('laba_faktur');
        $totalOmzetHalaman = $dataTransaksi->sum('total');

        return view('laporan-transaksi-penjualan', compact(
            'dataTransaksi',
            'tanggal',
            'perPage',
            'totalLabaHalaman',
            'totalOmzetHalaman',
            'rekapPage'
        ));
    }
}
