<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembelian;
use App\Models\DetailPembelian;
use App\Models\Barang;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PembelianController extends Controller
{
    public function index()
    {
        $semuaBarang = Barang::select('id_barang', 'nama_barang', 'merek', 'harga_beli')
            ->get();

        return view('pembelian', compact('semuaBarang'));
    }

    public function store(Request $request)
    {
        $keranjang = $request->input('keranjang');
        $noFaktur = $request->input('no_faktur');
        $pemasok = $request->input('pemasok');
        $metode = $request->input('metode_pembayaran');
        $totalBayar = (int) preg_replace('/[^\d]/', '', $request->input('total_pembayaran'));

        try {
            DB::beginTransaction();
            $pembelian = Pembelian::create([
                'no_faktur' => $noFaktur,
                'pemasok' => $pemasok,
                'metode_pembayaran' => $metode,
                'tanggal' => now(),
                'total' => $totalBayar,
            ]);

            foreach ($keranjang as $item) {
                $hargaBeliBaru = (int) preg_replace('/[^\d]/', '', $item['harga']);
                $jumlahBeli = (int) $item['jumlah'];
                $barang = Barang::select('id_barang', 'nama_barang', 'merek', 'stok_sistem', 'harga_beli')
                    ->where('nama_barang', $item['nama'])
                    ->where('merek', $item['merek'])
                    ->first();

                if ($barang) {
                    $barang->stok_sistem += $jumlahBeli;
                    $barang->harga_beli = $hargaBeliBaru;
                    $barang->save();
                } else {
                    $barang = Barang::create([
                        'nama_barang'   => $item['nama'],
                        'merek'         => $item['merek'],
                        'stok_sistem'   => $jumlahBeli,
                        'harga_beli'    => $hargaBeliBaru,
                        'kategori'      => "-",
                        'satuan'        => "-",
                        'lokasi'        => "-",
                        'min_stok'      => 0,
                        'harga_jual'    => 0,
                        'tanggal_masuk' => now(),
                    ]);
                }

                DetailPembelian::create([
                    'id_pembelian' => $pembelian->id_pembelian,
                    'id_barang'    => $barang->id_barang,
                    'jumlah'       => $jumlahBeli,
                    'harga'        => $hargaBeliBaru,
                    'subtotal'     => (int) preg_replace('/[^\d]/', '', $item['subtotal']),
                ]);
            }

            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan: ' . $e->getMessage()
            ]);
        }
    }
}
