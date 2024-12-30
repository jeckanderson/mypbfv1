<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Pegawai;
use App\Models\Pelanggan;
use App\Models\Penjualan;
use App\Models\PiutangAwal;
use App\Models\AkunAkutansi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PiutangPengguna extends Model
{
    use HasFactory;

    protected $table = 'piutang_pengguna';
    protected $guarded = ['id'];

    public function getPelanggan()
    {
        return $this->hasOne(Pelanggan::class, 'id', 'id_pelanggan');
    }

    public function getSales()
    {
        return $this->hasOne(Pegawai::class, 'id', 'id_pelanggan');
    }

    public function penjualan()
    {
        return $this->hasOne(Penjualan::class, 'id', 'id_penjualan');
    }

    public function piutangAwal()
    {
        return $this->hasOne(PiutangAwal::class, 'id', 'id_penjualan');
    }
    public function profile()
    {
        return $this->hasOne(Profile::class, 'id', 'id_perusahaan');
    }
    public function bayar()
    {
        return $this->hasOne(PembayaranPiutang::class, 'id', 'id_bp');
    }
    function sourceable()
    {
        return $this->morphTo('sourceable')->groupBy('no_faktur');
    }
    function detailable()
    {
        return $this->morphTo('detailable');
    }
    function akun()
    {
        return $this->belongsTo(AkunAkutansi::class, 'akun_akutansi_id', 'id');
    }
}
