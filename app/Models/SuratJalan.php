<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratJalan extends Model
{
    use HasFactory;

    protected $table = 'surat_jalan';
    protected $guarded = ['id'];

    public function getSales()
    {
        return $this->hasOne(Pegawai::class, 'id', 'sales');
    }

    public function getEkspedisi()
    {
        return $this->hasOne(Ekspedisi::class, 'id', 'ekspedisi');
    }

    public function detailSuratJalan()
    {
        return $this->hasMany(DetailSuratJalan::class, 'id_surat_jalan', 'id');
    }
}
