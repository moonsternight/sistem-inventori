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
                return back()->withInput();
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

    public function destroy($id, Request $request)
    {
        $cleanId = trim($id);
        DB::beginTransaction();

        try {
            $details = DB::table('detail_pembelian')->where('id_pembelian', $cleanId)->get();
            $barangBaruIds = [];

            foreach ($details as $item) {
                $barang = DB::table('barang')->where('id_barang', $item->id_barang)->first();

                if ($barang) {
                    if ($barang->kategori == '-' && $barang->satuan == '-') {
                        $barangBaruIds[] = $item->id_barang;
                    } else {
                        DB::table('barang')->where('id_barang', $item->id_barang)
                            ->decrement('stok_sistem', $item->jumlah);
                    }
                }
            }

            DB::table('detail_pembelian')->where('id_pembelian', $cleanId)->delete();
            $deleted = DB::table('pembelian')->where('id_pembelian', $cleanId)->delete();

            if (!empty($barangBaruIds)) {
                DB::table('barang')->whereIn('id_barang', $barangBaruIds)->delete();
            }

            if (!$deleted) {
                DB::rollBack();
                return back();
            }

            DB::commit();
            return $this->handleRedirectAfterDelete($request);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus data.');
        }
    }

    private function handleRedirectAfterDelete(Request $request)
    {
        $currentUrl = $request->input('current_url');

        if (!$currentUrl) {
            return back()->with('success', 'Data berhasil dihapus');
        }

        $urlComponents = parse_url($currentUrl);
        parse_str($urlComponents['query'] ?? '', $queryParams);

        $tanggal = $queryParams['tanggal'] ?? null;
        $perPage = (int) ($queryParams['per_page'] ?? 5);
        $currentPage = (int) ($queryParams['page'] ?? 1);

        $sisaData = DB::table('pembelian')->where('tanggal', $tanggal)->count();

        if ($sisaData > 0) {
            $maxPage = ceil($sisaData / $perPage);
            if ($currentPage > $maxPage) {
                $queryParams['page'] = $maxPage;
            }
        } else {
            $queryParams['page'] = 1;
        }

        $newQuery = http_build_query($queryParams);
        $finalUrl = ($urlComponents['path'] ?? '/laporan/faktur-pembelian') . '?' . $newQuery;

        return redirect($finalUrl)->with('success', 'Data berhasil dihapus');
    }
}
