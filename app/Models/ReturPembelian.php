<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ReturPembelian extends Model
{
    use HasFactory;

    protected $table = 'retur_pembelian';
    protected $guarded = ['id'];
    public $casts = [
        'tgl_input' => 'date'
    ];
    public function suplier()
    {
        return $this->hasOne(Suplier::class, 'id', 'id_suplier');
    }

    public function pembelian()
    {
        return $this->hasOne(Pembelian::class, 'id', 'id_pembelian');
    }

    function hutang_pengguna()
    {
        return $this->morphMany(HutangPengguna::class, 'detailable');
    }

    function produkRetur()
    {
        return $this->hasMany(ProdukReturPembelian::class, 'id_retur', 'id');
    }

    protected function akun(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => $value == '-' ? null : $value,
        );
    }
}
