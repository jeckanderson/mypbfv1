<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagihanPelanggan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'tagihan_pelanggan';

    public function getPelanggan()
    {
        return $this->hasOne(Pelanggan::class, 'id', 'pelanggan');
    }

    public function getSales()
    {
        return $this->hasOne(Pegawai::class, 'id', 'sales');
    }

    public function areaRayon()
    {
        return $this->hasOne(AreaRayon::class, 'id', 'area_rayon');
    }

    public function getKolektor()
    {
        return $this->belongsTo(Pegawai::class, 'kolektor');
    }
}
