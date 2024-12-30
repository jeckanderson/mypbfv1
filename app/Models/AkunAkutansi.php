<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AkunAkutansi extends Model
{
    use HasFactory;

    protected $table = 'akun_akutansi';
    protected $guarded = ['id'];

    public function getByIdPerusahaan()
    {
        return $this->where('id_perusahaan', Auth::user()->id_perusahaan)->get();
    }

    public function saldoAwal()
    {
        return $this->hasOne(JurnalTetap::class, 'id_akun', 'id');
    }
}
