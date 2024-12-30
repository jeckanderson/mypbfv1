<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SPPembelian extends Model
{
    use HasFactory;

    protected $table = 'sp_pembelian';
    protected $guarded = ['id'];
    public $casts = [
        'tgl_sp' => 'date'
    ];

    public function produk()
    {
        return $this->hasOne(ObatBarang::class, 'id', 'id_produk');
    }

    public function suplier()
    {
        return $this->hasOne(Suplier::class, 'id', 'id_suplier');
    }

    public function order()
    {
        return $this->hasOne(RencanaOrder::class, 'id', 'id_order');
    }

    public function profile()
    {
        return $this->hasOne(Profile::class, 'id', 'id_perusahaan');
    }
    function produk_pembelian(){
        return $this->hasMany(ProdukPembelian::class,'id_sp','id');
    }
}
