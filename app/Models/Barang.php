<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\DetailPenjualan;
use App\Models\DetailPembelian;

class Barang extends Model
{
    use SoftDeletes;

    protected $table = 'barang';
    protected $primaryKey = 'id_barang';
    protected $fillable = [
        'nama_barang',
        'merek',
        'kategori',
        'satuan',
        'stok_sistem',
        'min_stok',
        'harga_beli',
        'harga_jual',
        'lokasi',
        'tanggal_masuk',
    ];

    public function detailPenjualan()
    {
        return $this->hasMany(DetailPenjualan::class, 'id_barang', 'id_barang');
    }

    public function detailPembelian()
    {
        return $this->hasMany(DetailPembelian::class, 'id_barang', 'id_barang');
    }
}
