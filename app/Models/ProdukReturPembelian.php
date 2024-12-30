<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukReturPembelian extends Model
{
    use HasFactory;

    protected $table = 'produk_retur_pembelian';
    protected $guarded = ['id'];

    public function produk()
    {
        return $this->hasOne(ObatBarang::class, 'id', 'id_produk');
    }

    public function history()
    {
        return $this->hasOne(HistoryStok::class, 'id', 'id_histori');
    }

    public function pembelian()
    {
        return $this->hasOne(Pembelian::class, 'id', 'id_pembelian');
    }
}
