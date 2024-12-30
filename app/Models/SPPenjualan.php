<?php

namespace App\Models;

use App\Models\Satuan;
use App\Models\Pegawai;
use App\Models\Pelanggan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SPPenjualan extends Model
{
    use HasFactory;

    protected $table = 'sp_penjualan';
    protected $guarded = ['id'];

    public function pelangganPenjualan()
    {
        return $this->hasOne(Pelanggan::class, 'id', 'pelanggan');
    }

    public function salesPenjualan()
    {
        return $this->hasOne(Pegawai::class, 'id', 'sales');
    }

    public function satuanPenjualan()
    {
        return $this->belongsTo(Satuan::class, 'satuan');
    }

    public function profile()
    {
        return $this->hasOne(Profile::class, 'id', 'id_perusahaan');
    }



    public function produkPenjualan()
    {
        return $this->hasMany(ProdukPenjualan::class, 'id_sp_penjualan', 'id');
    }

    public function produk()
    {
        return $this->belongsTo(ObatBarang::class, 'id_produk');
    }
    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'id','id_sp');
    }

    public function ketSales()
    {
        return $this->belongsTo(Sales::class, 'sales', 'sales');
    }
}
