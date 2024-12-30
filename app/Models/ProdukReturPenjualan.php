<?php

namespace App\Models;

use App\Models\ProdukPenjualan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProdukReturPenjualan extends Model
{
    use HasFactory;
    protected $table = 'produk_retur_penjualan';
    protected $guarded = ['id'];


    function produk_penjualan()
    {
        return $this->belongsTo(ProdukPenjualan::class, 'id_produk_penjualan', 'id');
    }

    function produk()
    {
        return $this->belongsTo(ObatBarang::class, 'id_produk');
    }

    function produkPenjualan()
    {
        return $this->belongsTo(ProdukPenjualan::class, 'id_produk_penjualan');
    }

    function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'id_penjualan');
    }
}