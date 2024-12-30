<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MutasiStok extends Model
{
    use HasFactory;

    protected $table = 'mutasi_stok';
    protected $guarded = ['id'];

    public function produk()
    {
        return $this->hasOne(ObatBarang::class, 'id', 'id_produk');
    }

    public function stokAwal()
    {
        return $this->hasOne(StokAwal::class, 'id', 'id_sumber');
    }

    public function pembelian()
    {
        return $this->hasOne(ProdukDiterima::class, 'id', 'id_sumber');
    }

    public function stokMasuk()
    {
        return $this->hasOne(StokOpname::class, 'id', 'id_sumber');
    }

    public function gudangSebelum()
    {
        return $this->hasOne(Gudang::class, 'id', 'gudang_asal');
    }
    public function rakSebelum()
    {
        return $this->hasOne(Rak::class, 'id', 'rak_asal');
    }
    public function subRakSebelum()
    {
        return $this->hasOne(SubRak::class, 'id', 'sub_rak_asal');
    }
    public function gudangSesudah()
    {
        return $this->hasOne(Gudang::class, 'id', 'gudang_sesudah');
    }
    public function rakSesudah()
    {
        return $this->hasOne(Rak::class, 'id', 'rak_sesudah');
    }
    public function subRakSesudah()
    {
        return $this->hasOne(SubRak::class, 'id', 'sub_rak_sesudah');
    }

    public function history()
    {
        return $this->hasOne(HistoryStok::class, 'id', 'id_histori');
    }
}
