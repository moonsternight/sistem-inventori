<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;

class StokOpnameController extends Controller
{
    public function index(Request $request)
    {
        $lokasi = $request->query('lokasi');
        $perPage = $request->query('per_page', 5);
        $tampilkan = $request->query('tampilkan', false);
        $dataBarang = Barang::where('id_barang', 0)->paginate($perPage);
        $semuaBarangExport = collect();
        if ($lokasi && $tampilkan) {
            $dataBarang = Barang::where('lokasi', $lokasi)
                ->paginate($perPage)
                ->withQueryString();

            $semuaBarangExport = Barang::where('lokasi', $lokasi)->get();
        }

        return view('stok-opname', [
            'dataBarang'        => $dataBarang,
            'semuaBarangExport' => $semuaBarangExport,
            'perPage'           => $perPage,
            'lokasi'            => $lokasi,
            'totalDicek'        => '—',
            'totalCocok'        => '—',
            'totalKurang'       => '—',
            'totalLebih'        => '—'
        ]);
    }

    public function simpanHasil(Request $request)
    {
        $dataOpname = $request->input('hasil_opname');
        foreach ($dataOpname as $namaBarang => $detail) {
            \App\Models\Barang::where('nama_barang', $namaBarang)
                ->update(['stok_sistem' => $detail['stokFisik']]);
        }

        return response()->json(['success' => true]);
    }
}
