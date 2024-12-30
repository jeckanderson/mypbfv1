<?php

namespace App\Models;

use App\Models\Sales;
use App\Models\Pegawai;
use App\Models\Profile;
use App\Models\Pelanggan;
use App\Models\SPPenjualan;
use App\Models\PiutangPengguna;
use App\Models\ProdukPenjualan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualan';
    protected $guarded = ['id'];
    public $casts = [
        'tgl_faktur' => 'date',
        'tgl_input' => 'date',
        'tempo_kredit' => 'date',
    ];
    public function getByIdPerusahaan()
    {
        return $this->where('id_perusahaan', Auth::user()->id_perusahaan)->get();
    }

    public function getPelanggan()
    {
        return $this->hasOne(Pelanggan::class, 'id', 'pelanggan');
    }

    public function getSales()
    {
        return $this->hasOne(Pegawai::class, 'id', 'sales');
    }
    public function profile()
    {
        return $this->hasOne(Profile::class, 'id', 'id_perusahaan');
    }
    public function sp()
    {
        return $this->hasOne(SPPenjualan::class, 'id', 'id_sp');
    }
    /**
     * Get all of the produk_penjualan for the Penjualan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function produk_penjualan()
    {
        return $this->hasMany(ProdukPenjualan::class, 'id_penjualan');
    }
    /**
     * Get the pelanggan that owns the Penjualan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan');
    }
    /**
     * Get the pelanggan that owns the Penjualan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function get_sales()
    {
        return $this->belongsTo(Sales::class, 'sales');
    }
    /**
     * Get the sp that owns the Penjualan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function retur()
    {
        return $this->hasMany(ReturPenjualan::class, 'id_penjualan');
    }
    public function hutangs()
    {
        return $this->hasMany(PiutangPengguna::class, 'id_penjualan', 'id');
    }
    function piutang_pengguna()
    {
        return $this->morphMany(PiutangPengguna::class, 'sourceable');
    }
}
