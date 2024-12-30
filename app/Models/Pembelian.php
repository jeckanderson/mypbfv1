<?php

namespace App\Models;

use App\Models\AkunAkutansi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pembelian extends Model
{
    use HasFactory;

    protected $table = 'pembelian';
    protected $guarded = ['id'];
    public $casts = [
        'tgl_input' => 'date',
        'tgl_faktur' => 'date',
        'tempo_kredit' => 'date',
    ];
    public function sp()
    {
        return $this->hasOne(SPPembelian::class, 'id', 'id_sp');
    }

    public function getSuplier()
    {
        return $this->hasOne(Suplier::class, 'id', 'suplier');
    }

    public function profile()
    {
        return $this->hasOne(Profile::class, 'id', 'id_perusahaan');
    }

    public function produkPembelian()
    {
        return $this->hasMany(ProdukPembelian::class, 'id_pembelian', 'id');
    }

    /**
     * Get all of the hutangs for the Pembelian
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hutangs()
    {
        return $this->hasMany(HutangPengguna::class, 'id_pembelian');
    }
    function hutang_pengguna()
    {
        return $this->morphMany(HutangPengguna::class, 'sourceable');
    }
    function akun()
    {
        return $this->belongsTo(AkunAkutansi::class, 'akun_bayar', 'kode');
    }
}
