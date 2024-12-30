<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokOpname extends Model
{
    use HasFactory;

    protected $table = 'stok_opname';
    protected $guarded = ['id'];

    public function produk()
    {
        return $this->hasOne(ObatBarang::class, 'id', 'id_produk');
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

    public function stokAwal()
    {
        return $this->hasOne(StokAwal::class, 'id_sumber');
    }

    public function pembelian()
    {
        return $this->hasOne(ProdukDiterima::class, 'id_sumber');
    }

    public function histori()
    {
        return $this->belongsTo(HistoryStok::class, 'id_histori');
    }
}