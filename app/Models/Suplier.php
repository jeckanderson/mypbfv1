<?php

namespace App\Models;

use App\Models\HutangPengguna;
use App\Models\Pembelian;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Suplier extends Model
{
    use HasFactory;

    protected $table = 'suplier';
    protected $guarded = ['id'];

    public function hutang()
    {
        return $this->hasOne(HutangPengguna::class, 'id', 'id_hutang');
    }
    /**
     * Get all of the hutangs for the Suplier
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hutangs()
    {
        return $this->hasMany(HutangPengguna::class,'id_suplier');
    }
    /**
     * Get all of the pembelians for the Suplier
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pembelians()
    {
        return $this->hasMany(Pembelian::class,'suplier');
    }
}