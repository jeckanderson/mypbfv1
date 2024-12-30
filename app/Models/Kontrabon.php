<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kontrabon extends Model
{
    use HasFactory;

    protected $table = 'kontrabon';
    protected $guarded = ['id'];

    public function getPelanggan()
    {
        return $this->hasOne(Pelanggan::class, 'id', 'pelanggan');
    }

    public function getSales()
    {
        return $this->hasOne(Pegawai::class, 'id', 'sales');
    }
}