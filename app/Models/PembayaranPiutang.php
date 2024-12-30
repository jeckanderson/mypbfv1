<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\PiutangPengguna;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PembayaranPiutang extends Model
{
    use HasFactory;

    protected $table = 'pembayaran_piutang';
    protected $guarded = ['id'];
    public $appends = ['tgl_faktur', 'tempo_kredit'];
    public function akun()
    {
        return $this->hasOne(AkunAkutansi::class, 'id', 'akun_bayar');
    }

    public function getPelanggan()
    {
        return $this->hasOne(Pelanggan::class, 'id_pilihan');
    }

    public function tagihan()
    {
        return $this->belongsTo(TagihanPelanggan::class, 'id_pilihan');
    }

    function piutang_pengguna()
    {
        return $this->morphMany(PiutangPengguna::class, 'detailable');
    }

    public function getTglFakturAttribute()
    {
        return Carbon::parse($this->tgl_input);
    }
    public function getTempoKreditAttribute()
    {
        return Carbon::parse($this->tgl_input);
    }
    public function getTotalTagihanAttribute()
    {
        return $this->total_bayar;
    }
}
