<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Barang;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    public function index()
    {
        $today = Carbon::now()->format('Ymd');

        $lastTransaction = Penjualan::whereDate('created_at', Carbon::today())
            ->orderBy('id_penjualan', 'desc')
            ->first();

        if (!$lastTransaction) {
            $nextNumber = '001';
        } else {
            $lastNumber = substr($lastTransaction->no_transaksi, -3);
            $nextNumber = str_pad((int)$lastNumber + 1, 3, '0', STR_PAD_LEFT);
        }

        $no_transaksi = 'TRANS-' . $today . '-' . $nextNumber;
        $barang = Barang::select('id_barang', 'nama_barang', 'merek', 'harga_jual', 'stok_sistem')->get();

        return view('penjualan', compact('no_transaksi', 'barang'));
    }

    public function store(Request $request)
    {
        $keranjang = $request->input('keranjang');
        $metodePembayaran = $request->input('metode_pembayaran');
        $totalPembayaran = $request->input('total_pembayaran');

        try {
            DB::beginTransaction();

            $currentNoTransaksi = $this->generateNoTransaksi();

            $penjualan = new Penjualan();
            $penjualan->no_transaksi = $currentNoTransaksi;
            $penjualan->metode_pembayaran = $metodePembayaran;
            $penjualan->total = $totalPembayaran;
            $penjualan->tanggal = Carbon::now()->format('Y-m-d');
            $penjualan->save();

            foreach ($keranjang as $item) {
                $barang = Barang::select('id_barang', 'stok_sistem', 'harga_beli')
                    ->where('nama_barang', trim($item['nama']))
                    ->where('merek', trim($item['merek']))
                    ->first();

                if ($barang) {
                    if ($barang->stok_sistem < (int)$item['jumlah']) {
                        throw new \Exception("Stok " . $item['nama'] . " tidak mencukupi. Sisa: " . $barang->stok_sistem);
                    }

                    $hargaMurni = (int) preg_replace('/[^0-9]/', '', $item['harga']);
                    $subtotalMurni = (int) preg_replace('/[^0-9]/', '', $item['subtotal']);

                    DB::table('detail_penjualan')->insert([
                        'id_penjualan' => $penjualan->id_penjualan,
                        'id_barang'    => $barang->id_barang,
                        'modal'        => $barang->harga_beli,
                        'jumlah'       => (int) $item['jumlah'],
                        'harga'        => $hargaMurni,
                        'subtotal'     => $subtotalMurni,
                        'created_at'   => Carbon::now(),
                        'updated_at'   => Carbon::now(),
                    ]);
                    $barang->stok_sistem -= (int)$item['jumlah'];
                    $barang->save();
                } else {
                    throw new \Exception("Barang " . $item['nama'] . " tidak ditemukan di database.");
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Anda berhasil membuat transaksi baru',
                'next_no_transaksi' => $this->generateNoTransaksi()
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    private function generateNoTransaksi()
    {
        $today = Carbon::now()->format('Ymd');
        $lastTransaction = Penjualan::whereDate('created_at', Carbon::today())
            ->orderBy('id_penjualan', 'desc')
            ->first();

        if (!$lastTransaction) {
            $nextNumber = '001';
        } else {
            $lastNumber = substr($lastTransaction->no_transaksi, -3);
            $nextNumber = str_pad((int)$lastNumber + 1, 3, '0', STR_PAD_LEFT);
        }

        return 'TRANS-' . $today . '-' . $nextNumber;
    }
}
