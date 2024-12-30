<?php

namespace App\Models;

use App\Models\Pegawai;
use App\Models\Pelanggan;
use App\Models\HistoryStok;
use App\Models\PiutangPengguna;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReturPenjualan extends Model
{
    use HasFactory;

    protected $table = 'retur_penjualan';
    protected $guarded = ['id'];
    public $casts = [
        'tgl_input' => 'date'
    ];
    public function getPelanggan()
    {
        return $this->hasOne(Pelanggan::class, 'id', 'pelanggan');
    }

    public function getSales()
    {
        return $this->hasOne(Pegawai::class, 'id', 'sales');
    }

    public function history()
    {
        return $this->hasOne(HistoryStok::class, 'id', 'id_histori');
    }
    public function penjualan()
    {
        return $this->hasOne(Penjualan::class, 'id', 'id_penjualan');
    }
    public function profile()
    {
        return $this->hasOne(Profile::class, 'id', 'id_perusahaan');
    }

    function produk_retur_penjualan()
    {
        return $this->hasMany(ProdukReturPenjualan::class, 'id_retur');
    }
    function piutang_pengguna(){
        return $this->morphMany(PiutangPengguna::class,'detailable');
    }
}
