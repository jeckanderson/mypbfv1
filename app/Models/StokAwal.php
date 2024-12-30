<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class StokAwal extends Model
{
    use HasFactory;

    protected $table = 'stok_awal';
    protected $guarded = ['id'];


    public function produk()
    {
        return $this->hasOne(ObatBarang::class, 'id', 'id_obat_barang');
    }

    public function getByIdPerusahaan()
    {
        return $this->where('id_perusahaan', Auth::user()->id_perusahaan)->get();
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

    public function satuanStok()
    {
        return $this->hasOne(Satuan::class, 'id', 'satuan');
    }

    public function histori()
    {
        return $this->belongsTo(HistoryStok::class, 'id_histori');
    }
}