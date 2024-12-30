<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailSuratJalan extends Model
{
    use HasFactory;

    protected $table = 'detail_surat_jalan';
    protected $guarded = ['id'];

    public function penjualan()
    {
        return $this->hasOne(Penjualan::class, 'id', 'id_penjualan');
    }
}
