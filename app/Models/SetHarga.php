<?php

namespace App\Models;

use App\Models\Satuan;
use App\Models\Profile;
use App\Models\Kelompok;
use App\Models\SetHarga as Sets;
use App\Models\ObatBarang;
use App\Models\DiskonKelompok;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SetHarga extends Model
{
    use HasFactory;

    protected $table = 'set_harga';
    protected $guarded = ['id'];

    public function kelompok()
    {
        return $this->hasOne(Kelompok::class, 'id', 'id_kelompok');
    }

    public function satuanJual()
    {
        return $this->hasOne(Satuan::class, 'id', 'satuan');
    }

    public function diskonKelompok($id_kelompok, $id_set)
    {
        return DiskonKelompok::where('id_kelompok', $id_kelompok)->where('id_set_harga', $id_set)->first();
    }

    public function getItem($id_kelompok, $id_set, $id_jumlah)
    {
        return Sets::where('id_kelompok', $id_kelompok)->where('id_set', $id_set)->where('id_jumlah', $id_jumlah)->first();
    }
    public function produk()
    {
        return $this->hasOne(ObatBarang::class, 'id', 'id_produk');
    }
    public function profile()
    {
        return $this->hasOne(Profile::class, 'id', 'id_perusahaan');
    }

    public function satuanProduk()
    {
        return $this->hasOne(Satuan::class, 'id', 'satuan');
    }
}
