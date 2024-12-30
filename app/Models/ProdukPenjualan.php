<?php

namespace App\Models;

use App\Models\Satuan;
use App\Models\Penjualan;
use App\Models\ObatBarang;
use App\Models\SPPenjualan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProdukPenjualan extends Model
{
    use HasFactory;

    protected $table = 'produk_penjualan';
    protected $guarded = ['id'];

    public function produk()
    {
        return $this->hasOne(ObatBarang::class, 'id', 'id_produk');
    }

    public function penjualan()
    {
        return $this->hasOne(Penjualan::class, 'id', 'id_penjualan');
    }

    public function satuanProduk()
    {
        return $this->hasOne(Satuan::class, 'id', 'satuan');
    }
    public function spPenjualan()
    {
        return $this->hasOne(SPPenjualan::class, 'id', 'id_sp_penjualan');
    }

    public function profile()
    {
        return $this->hasOne(Profile::class, 'id', 'id_perusahaan');
    }

    public function histori()
    {
        return $this->hasOne(HistoryStok::class, 'id', 'id_sumber');
    }

    public function retur()
    {
        return $this->hasMany(ProdukReturPenjualan::class, 'id_produk_penjualan');
    }

    public function getGudang()
    {
        return $this->belongsTo(Gudang::class, 'gudang');
    }

    public function getRak()
    {
        return $this->belongsTo(Rak::class, 'rak');
    }

    public function getSubRak()
    {
        return $this->belongsTo(SubRak::class, 'sub_rak');
    }

    public function historiCekSp()
    {
        return $this->belongsTo(HistoryStok::class, 'id_sumber');
    }

    public function historiPenjualan()
    {
        return $this->belongsTo(HistoryStok::class, 'id_histori');
    }
}
