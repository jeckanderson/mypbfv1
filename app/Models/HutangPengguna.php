<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HutangPengguna extends Model
{
    use HasFactory;

    protected $table = 'hutang_pengguna';
    protected $guarded = ['id'];
    public $dates = [
        'created_at'
    ];
    public function pembelian()
    {
        return $this->hasOne(Pembelian::class, 'id', 'id_pembelian');
    }

    public function hutangAwal()
    {
        return $this->hasOne(HutangAwal::class, 'id', 'id_pembelian');
    }

    public function suplier()
    {
        return $this->hasOne(Suplier::class, 'id', 'id_suplier');
    }
    public function profile()
    {
        return $this->hasOne(Profile::class, 'id', 'id_perusahaan');
    }
    public function bayar()
    {
        return $this->hasOne(PembayaranHutang::class, 'id', 'id_bh');
    }
    public function bayars()
    {
        return $this->belongsTo(PembayaranHutang::class);
    }
    public function bayarss()
    {
        return $this->hasMany(PembayaranHutang::class, 'id', 'id_bh');
    }
    /**
     * Get all of the pembelians for the HutangPengguna
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pembelians()
    {
        return $this->hasMany(Pembelian::class, 'id', 'id_pembelian');
    }

    function retur_pembelian()
    {
        return $this->belongsTo(ReturPembelian::class, 'id_bh', 'id');
    }
    function scopePembelian($q)
    {
        return $q->where('sumber', 'pembelian');
    }
    function scopeSaldoAwal($q)
    {
        return $q->where('sumber', 'hutang awal');
    }

    function sourceable()
    {
        return $this->morphTo('sourceable');
    }
    function detailable()
    {
        return $this->morphTo('detailable');
    }
    /**
     * Get the akun that owns the HutangPengguna
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function akun()
    {
        return $this->belongsTo(AkunAkutansi::class);
    }
}
