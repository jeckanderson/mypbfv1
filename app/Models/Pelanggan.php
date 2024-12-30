<?php

namespace App\Models;

use App\Models\Penjualan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggan';
    protected $guarded = ['id'];

    public function getByIdPerusahaan()
    {
        return $this->where('id_perusahaan', Auth::user()->id_perusahaan)->get();
    }

    public function salesPelanggan()
    {
        return $this->hasOne(Pegawai::class, 'id', 'sales');
    }

    public function kelompokPelanggan()
    {
        return $this->hasOne(Kelompok::class, 'id', 'kelompok');
    }

    public function areaRayon()
    {
        return $this->hasOne(AreaRayon::class, 'id', 'area_rayon');
    }

    public function piutang()
    {
        return $this->hasMany(PiutangPengguna::class, 'id_pelanggan');
    }
    /**
     * Get all of the penjualan for the Pelanggan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function penjualan()
    {
        return $this->hasMany(Penjualan::class,'pelanggan','id');
    }
    
}
