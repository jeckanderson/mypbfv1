<?php

namespace App\Models;

use App\Models\Pembelian;
use App\Models\Penjualan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jurnal extends Model
{
    use HasFactory;

    protected $table = 'jurnal';
    protected $guarded = ['id'];

    public function getByIdPerusahaan()
    {
        return $this->where('id_perusahaan', Auth::user()->id_perusahaan)->get();
    }

    public function akun()
    {
        if ($this->is_deleted == 1) {
            return $this->hasOne(AkunAkutansi::class, 'kode', 'kode_akun')
                ->where('id_perusahaan', Auth::user()->id_perusahaan);
        } else {
            return $this->hasOne(AkunAkutansi::class, 'kode', 'kode_akun');
        }
    }

    public function jurnalAkun()
    {
        return $this->belongsTo(JurnalAkun::class, 'no_reff', 'no_reff');
    }

    public function mutasiSaldo()
    {
        return $this->belongsTo(MutasiSaldoAkun::class, 'no_reff', 'no_reff');
    }

    /**
     * Get the pembelian that owns the Jurnal
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class,'id_sumber','id');
    }
    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class,'id_sumber','id');
    }
    public function retur_penjualan()
    {
        return $this->belongsTo(ReturPenjualan::class,'id_sumber','id');
    }
    public function jurnal_akun()
    {
        return $this->belongsTo(JurnalAkun::class,'id_sumber','id');
    }
}
