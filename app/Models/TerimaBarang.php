<?php

namespace App\Models;

use App\Models\Pembelian;

use App\Models\SPPembelian;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TerimaBarang extends Model
{
    use HasFactory;

    protected $table = 'terima_barang';
    protected $guarded = ['id'];
    public $casts = [
        'tanggal' => 'date',
    ];
    public function sp()
    {
        return $this->hasOne(SPPembelian::class, 'id', 'id_sp');
    }

    public function pembelian()
    {
        return $this->hasOne(Pembelian::class, 'id', 'id_pembelian');
    }

    public function produkDiterima()
    {
        return $this->hasMany(ProdukDiterima::class, 'id_terima_barang', 'id');
    }
}
