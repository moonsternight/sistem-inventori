<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $table = 'penjualan';
    protected $primaryKey = 'id_penjualan';
    protected $fillable = [
        'no_transaksi',
        'tanggal',
        'metode_pembayaran',
        'total'
    ];

    public function rincian()
    {
        return $this->hasMany(DetailPenjualan::class, 'id_penjualan', 'id_penjualan');
    }
}
