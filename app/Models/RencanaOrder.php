<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RencanaOrder extends Model
{
    use HasFactory;

    protected $table = 'rencana_order';
    protected $guarded = ['id'];

    public function produk()
    {
        return $this->hasOne(ObatBarang::class, 'id', 'id_produk');
    }

    public function suplier()
    {
        return $this->belongsTo(Suplier::class,  'id_suplier');
    }
}
