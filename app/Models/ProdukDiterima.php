<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukDiterima extends Model
{
    use HasFactory;

    protected $table = 'produk_diterima';
    protected $guarded = ['id'];

    public function produk()
    {
        return $this->hasOne(ObatBarang::class, 'id', 'id_produk');
    }

    public function order()
    {
        return $this->hasOne(RencanaOrder::class, 'id', 'id_order');
    }

    public function produkPembelian()
    {
        return $this->hasOne(ProdukPembelian::class, 'id_pembelian', 'id_pembelian');
    }

    public function diterimaToPembelian()
    {
        return $this->hasOne(ProdukPembelian::class, 'id_order', 'id_order');
    }

    public function pembelian()
    {
        return $this->hasOne(Pembelian::class, 'id', 'id_pembelian');
    }

    public function sp()
    {
        return $this->hasOne(SPPembelian::class, 'id', 'id_sp');
    }

    public function TerimaBarang()
    {
        return $this->hasOne(TerimaBarang::class, 'id', 'id_terima_barang');
    }

    public function gudangStok()
    {
        return $this->hasOne(Gudang::class, 'id', 'gudang');
    }

    public function rakStok()
    {
        return $this->hasOne(Rak::class, 'id', 'rak');
    }
    public function subRak()
    {
        return $this->hasOne(SubRak::class, 'id', 'sub_rak');
    }

    public function histori()
    {
        return $this->belongsTo(HistoryStok::class, 'id_histori');
    }
}