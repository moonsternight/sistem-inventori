<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;

class LaporanRekapPenjualanController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('per_page')) {
            $perPage = $request->input('per_page');
            $masaBerlaku = 60 * 24 * 30;
            cookie()->queue('rekap_penjualan_per_page', $perPage, $masaBerlaku);
        } else {
            $perPage = $request->cookie('rekap_penjualan_per_page', 5);
        }

        if ($request->has('page')) {
            $currentPage = $request->input('page');
            session(['rekap_penjualan_last_page' => $currentPage]);
        } else {
            $currentPage = session('rekap_penjualan_last_page', 1);
            \Illuminate\Pagination\Paginator::currentPageResolver(function () use ($currentPage) {
                return $currentPage;
            });
        }

        $tglMulai = $request->query('tgl_mulai');
        $tglAkhir = $request->query('tgl_akhir');
        if ($tglMulai && $tglAkhir && $tglAkhir < $tglMulai) {
            return redirect()->back();
        }

        $query = Penjualan::select(
            'penjualan.tanggal',
            DB::raw('COUNT(DISTINCT penjualan.id_penjualan) as jumlah_transaksi'),
            DB::raw('(SELECT SUM(p2.total) FROM penjualan p2 WHERE p2.tanggal = penjualan.tanggal) as total_penjualan'),
            DB::raw('SUM((detail_penjualan.harga - detail_penjualan.modal) * detail_penjualan.jumlah) as total_laba')
        )
            ->join('detail_penjualan', 'penjualan.id_penjualan', '=', 'detail_penjualan.id_penjualan')
            ->groupBy('penjualan.tanggal')
            ->orderBy('penjualan.tanggal', 'asc');

        if ($tglMulai && $tglAkhir) {
            $query->whereBetween('penjualan.tanggal', [$tglMulai, $tglAkhir]);
        }

        $dataRekap = $query->paginate($perPage)->withQueryString();

        if ($tglMulai && $tglAkhir && $dataRekap->isEmpty()) {
            return redirect()->back()->with('error_filter', 'Data rekap tidak ditemukan.');
        }

        return view('laporan-rekap-penjualan', compact('dataRekap', 'perPage'));
    }

    public function hapusSemua()
    {
        DB::transaction(function () {
            DB::table('detail_penjualan')->delete();
            DB::table('penjualan')->delete();
            Barang::onlyTrashed()
                ->whereDoesntHave('detailPenjualan')
                ->whereDoesntHave('detailPembelian')
                ->forceDelete();
        });

        return redirect()->route('laporan.rekap.penjualan')
            ->with('success', 'Rekap dikosongkan.');
    }
}
