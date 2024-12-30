<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranHutang extends Model
{
    use HasFactory;

    protected $table = 'pembayaran_hutang';
    protected $guarded = ['id'];

    public function getSuplier()
    {
        return $this->hasOne(Suplier::class, 'id', 'suplier');
    }

    public function profile()
    {
        return $this->hasOne(Profile::class, 'id', 'id_perusahaan');
    }
    public function akun()
    {
        return $this->hasOne(AkunAkutansi::class, 'id', 'akun_bayar');
    }

    public function detailHutang()
    {
        return $this->hasMany(HutangPengguna::class, 'id_bh');
    }
    function hutang_pengguna(){
        return $this->morphMany(HutangPengguna::class,'detailable');
    }
}
