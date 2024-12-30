<?php

namespace App\Models;

use App\Models\Pembelian;
use App\Models\ObatBarang;
use App\Models\SPPembelian;
use App\Models\RencanaOrder;
use App\Models\ProdukDiterima;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProdukPembelian extends Model
{
    use HasFactory;

    protected $table = 'produk_pembelian';
    protected $guarded = ['id'];

    public function order()
    {
        return $this->hasOne(RencanaOrder::class, 'id', 'id_order');
    }
    public function sp()
    {
        return $this->hasOne(SPPembelian::class, 'id', 'id_sp');
    }

    public function pembelian()
    {
        return $this->hasOne(Pembelian::class, 'id', 'id_pembelian');
    }

    public function produk()
    {
        return $this->hasOne(ObatBarang::class, 'id', 'id_produk');
    }

    public function ProdukDiterima()
    {
        return $this->hasOne(ProdukDiterima::class, 'id_pembelian', 'id_pembelian');
    }

    public function rencanaOrders()
    {
        return $this->hasMany(RencanaOrder::class, 'id', 'id_order');
    }
    public function profile()
    {
        return $this->hasOne(Profile::class, 'id', 'id_perusahaan');
    }
  
}
