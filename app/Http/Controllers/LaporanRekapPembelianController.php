<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;

class LaporanRekapPembelianController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('per_page')) {
            $perPage = $request->input('per_page');
            $masaBerlaku = 60 * 24 * 30;
            cookie()->queue('rekap_pembelian_per_page', $perPage, $masaBerlaku);
        } else {
            $perPage = $request->cookie('rekap_pembelian_per_page', 5);
        }

        if ($request->has('page')) {
            session(['rekap_pembelian_last_page' => $request->input('page')]);
        } else {
            $currentPage = session('rekap_pembelian_last_page', 1);
            \Illuminate\Pagination\Paginator::currentPageResolver(function () use ($currentPage) {
                return $currentPage;
            });
        }

        $tglMulai = $request->query('tgl_mulai');
        $tglAkhir = $request->query('tgl_akhir');

        if ($request->has('tgl_mulai') && empty($tglMulai) && empty($tglAkhir)) {
            return redirect()->route('laporan.rekap.pembelian');
        }

        if ($tglMulai && $tglAkhir && $tglAkhir < $tglMulai) {
            return redirect()->back();
        }

        $query = DB::table('pembelian')
            ->select(
                'tanggal',
                DB::raw('count(*) as jumlah_faktur'),
                DB::raw('sum(total) as total_nominal')
            )
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc');

        if ($tglMulai && $tglAkhir) {
            $query->whereBetween('tanggal', [$tglMulai, $tglAkhir]);
        }

        $rekapPembelian = $query->paginate($perPage)->withQueryString();

        if ($tglMulai && $tglAkhir && $rekapPembelian->isEmpty()) {
            return redirect()->back()->with('error_filter', 'Data rekap tidak ditemukan.');
        }

        return view('laporan-rekap-pembelian', compact('rekapPembelian', 'perPage'));
    }

    public function hapusSemua()
    {
        DB::transaction(function () {
            DB::table('detail_pembelian')->delete();
            DB::table('pembelian')->delete();
            Barang::onlyTrashed()
                ->whereDoesntHave('detailPenjualan')
                ->whereDoesntHave('detailPembelian')
                ->forceDelete();
        });

        return redirect()->route('laporan.rekap.pembelian')
            ->with('success', 'Rekap dikosongkan.');
    }
}
