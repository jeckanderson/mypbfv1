<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RencanaPengadaan extends Model
{
    use HasFactory;

    protected $table = 'rencana_pengadaan';
    protected $guarded = ['id'];

    public function produk()
    {
        return $this->hasOne(ObatBarang::class, 'id', 'id_produk');
    }
}