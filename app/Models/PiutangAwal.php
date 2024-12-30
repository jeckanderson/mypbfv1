<?php

namespace App\Models;

use App\Models\PiutangPengguna;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PiutangAwal extends Model
{
    use HasFactory;
    protected $table = 'piutang_awal';
    protected $guarded = ['id'];
    public $casts = [
        'tgl_faktur' => 'date',
    ];
    public $appends = [
        'tempo_kredit', 'total_tagihan'
    ];
    public function getByIdPerusahaan()
    {
        return $this->where('id_perusahaan', Auth::user()->id_perusahaan)->get();
    }

    public function getPelanggan()
    {
        return $this->hasOne(Pelanggan::class, 'id', 'pelanggan');
    }
    function piutang_pengguna()
    {
        return $this->morphMany(PiutangPengguna::class, 'sourceable');
    }
    public function getTempoKreditAttribute()
    {
        return Carbon::parse($this->tgl_jth_tempo);
    }
    public function getTotalTagihanAttribute()
    {
        return $this->jmlh_piutang;
    }
    public function getAkunAttribute()
    {
        return null;
    }
}
