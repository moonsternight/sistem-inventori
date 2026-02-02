<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;

class InventoryController extends Controller
{
    public function cariBarang(Request $request)
    {
        $term = $request->get('term');
        $type = $request->get('type');

        if (strlen($term) < 1) {
            return response()->json([]);
        }

        $results = Barang::select('id_barang', 'nama_barang', 'merek', 'harga_beli')
            ->where(function ($query) use ($term, $type) {
                if ($type === 'nama') {
                    $query->where('nama_barang', 'like', '%' . $term . '%');
                } else {
                    $query->where('merek', 'like', '%' . $term . '%');
                }
            })
            ->take(3)
            ->get();

        return response()->json($results);
    }

    public function index(Request $request)
    {
        if ($request->has('per_page')) {
            $perPage = $request->input('per_page');
            $masaBerlaku = 60 * 24 * 30;
            cookie()->queue('inventori_per_page', $perPage, $masaBerlaku);
        } else {
            $perPage = $request->cookie('inventori_per_page', 5);
        }

        if ($request->has('page')) {
            $currentPage = $request->input('page');
            session(['inventori_last_page' => $currentPage]);
        } else {
            $currentPage = session('inventori_last_page', 1);
            \Illuminate\Pagination\Paginator::currentPageResolver(function () use ($currentPage) {
                return $currentPage;
            });
        }

        $nama     = $request->input('nama');
        $merek    = $request->input('merek');
        $kategori = $request->input('kategori');
        $status   = $request->input('status');
        $lokasi   = $request->input('lokasi');

        $query = Barang::query();

        if ($nama) {
            $query->where('nama_barang', 'like', '%' . $nama . '%');
        }

        if ($merek) {
            $query->where('merek', 'like', '%' . $merek . '%');
        }

        if ($kategori) {
            $query->where('kategori', $kategori);
        }

        if ($lokasi) {
            $query->where('lokasi', $lokasi);
        }

        if ($status) {
            if ($status == 'habis') {
                $query->where('stok_sistem', 0);
            } elseif ($status == 'kritis') {
                $query->whereRaw('stok_sistem > 0 AND stok_sistem <= min_stok');
            } elseif ($status == 'aman') {
                $query->whereRaw('stok_sistem > min_stok');
            } elseif ($status == 'baru') {
                $query->where('satuan', '-');
            }
        }

        $data_barang = $query->paginate($perPage)->withQueryString();
        $totalBarang  = Barang::count();
        $barangHabis  = Barang::where('satuan', '!=', '-')->where('stok_sistem', 0)->count();
        $barangKritis = Barang::where('satuan', '!=', '-')
            ->whereRaw('stok_sistem > 0 AND stok_sistem <= min_stok')->count();
        $barangAman   = Barang::where('satuan', '!=', '-')
            ->whereRaw('stok_sistem > min_stok')->count();

        return view('inventori', compact(
            'data_barang',
            'totalBarang',
            'barangAman',
            'barangKritis',
            'barangHabis',
            'perPage'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_barang'    => 'required|string|max:255',
            'merek'          => 'required|string',
            'kategori'       => 'required|string',
            'satuan'         => 'required|string',
            'stok_sistem'    => 'required|integer|min:0',
            'min_stok'       => 'required|integer|min:0',
            'harga_beli'     => 'required|numeric|min:0',
            'harga_jual'     => 'required|numeric|min:0',
            'lokasi'         => 'required|string',
            'tanggal_masuk'  => 'required|date',
        ]);

        Barang::create($validated);

        $targetUrl = $request->input('current_url', route('inventori'));

        return redirect($targetUrl)->with('success', 'Barang telah disimpan.');
    }

    public function update(Request $request, $id_barang)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'merek'       => 'required|string',
            'kategori'    => 'required|string',
            'satuan'      => 'required|string',
            'stok_sistem' => 'required|integer|min:0',
            'min_stok'    => 'required|integer|min:0',
            'harga_beli'  => 'required|numeric|min:0',
            'harga_jual'  => 'required|numeric|min:0',
            'lokasi'      => 'required|string',
        ]);

        $barang = Barang::findOrFail($id_barang);

        $barang->update($validated);

        $targetUrl = $request->input('current_url', route('inventori'));
        return redirect($targetUrl)->with('success', 'Data telah diperbarui. ');
    }

    public function destroy(Request $request, $id_barang)
    {
        $barang = Barang::withTrashed()->findOrFail($id_barang);

        $pernahTerjual = \Illuminate\Support\Facades\DB::table('detail_penjualan')
            ->where('id_barang', $id_barang)->exists();

        $pernahDibeli = \Illuminate\Support\Facades\DB::table('detail_pembelian')
            ->where('id_barang', $id_barang)->exists();

        if ($pernahTerjual || $pernahDibeli) {
            $barang->delete();
        } else {
            $barang->forceDelete();
        }

        $targetUrl = $request->input('current_url', route('inventori'));
        $urlComponents = parse_url($targetUrl);
        parse_str($urlComponents['query'] ?? '', $params);

        if (isset($params['page']) && $params['page'] > 1) {
            $currentPage = (int)$params['page'];
            $perPage = $params['per_page'] ?? 5;
            $totalBarangAktif = Barang::count();
            $maxPage = ceil($totalBarangAktif / $perPage);

            if ($currentPage > $maxPage && $maxPage > 0) {
                $params['page'] = $maxPage;
                $newQuery = http_build_query($params);
                $targetUrl = ($urlComponents['path'] ?? route('inventori')) . '?' . $newQuery;
            }
        }

        return redirect($targetUrl)->with('success', 'Barang telah dihapus. ');
    }
}
