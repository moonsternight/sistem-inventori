<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanFakturPembelianController extends Controller
{
    public function index(Request $request)
    {
        $tglMulai = $request->get('tgl_mulai');
        $tglAkhir = $request->get('tgl_akhir');
        $tanggal = $request->get('tanggal');
        $perPage = $request->get('per_page', 5);
        $rekapPage = $request->query('rekap_page', 1);

        if ($request->has('tgl_mulai') || $request->has('tgl_akhir')) {

            if (empty($tglMulai) && empty($tglAkhir)) {
                session()->forget('rekap_pembelian_last_page');
                return redirect()->route('laporan.rekap.pembelian')->with(['page' => 1]);
            }

            if ($tglMulai > $tglAkhir) {
                return back();
            }

            $adaData = DB::table('pembelian')
                ->whereBetween('tanggal', [$tglMulai, $tglAkhir])
                ->exists();

            if (!$adaData) {
                return back()->with('error_filter', 'Data rekap tidak ditemukan.');
            }

            session(['rekap_pembelian_last_page' => 1]);
            return redirect()->route('laporan.rekap.pembelian', [
                'tgl_mulai' => $tglMulai,
                'tgl_akhir' => $tglAkhir,
                'page' => 1
            ]);
        }

        $transaksiPembelian = DB::table('pembelian')
            ->where('tanggal', $tanggal)
            ->orderBy('created_at', 'asc')
            ->paginate($perPage)
            ->withQueryString();

        return view('laporan-faktur-pembelian', compact('transaksiPembelian', 'tanggal', 'perPage', 'rekapPage'));
    }
}
