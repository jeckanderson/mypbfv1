<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class ObatBarang extends Model
{
    use HasFactory;

    protected $table = 'obat_barang';
    protected $guarded = ['id'];

    public function getByIdPerusahaan()
    {
        return $this->where('id_perusahaan', Auth::user()->id_perusahaan)->get();
    }

    public function stokAwal()
    {
        return $this->hasOne(StokAwal::class, 'id_obat_barang', 'id');
    }

    public function target()
    {
        return $this->hasOne(TargetProduk::class, 'id_produk', 'id');
    }

    public function kelompok()
    {
        return $this->hasOne(Golongan::class, 'id', 'golongan');
    }

    public function golonganProduk()
    {
        return $this->hasOne(SubGolongan::class, 'id', 'sub_golongan');
    }

    public function produsenProduk()
    {
        return $this->hasOne(Produsen::class, 'id', 'produsen');
    }

    public function satuanTerkecil()
    {
        return $this->hasOne(Satuan::class, 'id', 'satuan_jual_terkecil');
    }
    public function satuanDasar()
    {
        return $this->hasOne(Satuan::class, 'id', 'satuan_dasar_beli');
    }

    public function produkPenjualan()
    {
        return $this->hasMany(ProdukPenjualan::class, 'id_produk', 'id');
    }

    public function produkReturPenjualan()
    {
        return $this->hasMany(ProdukReturPenjualan::class, 'id_produk', 'id');
    }
    /**
     * Get all of the stocks for the ObatBarang
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stocks()
    {
        return $this->hasMany(HistoryStok::class, 'id_produk', 'id');
    }
    function stock()
    {
        return $this->hasOne(HistoryStok::class, 'id_produk', 'id')->orderBy('id', 'desc');
    }

    function getStockBatch($idProduk, $batch, $idGudang, $idRak, $idSubRak)
    {
        $histori = HistoryStok::where('id_produk', $idProduk)
            ->where('no_batch', $batch)
            ->where('id_gudang', $idGudang)
            ->where('id_rak', $idRak)
            ->where('id_sub_rak', $idSubRak);

        $sisa = $histori->sum('stok_masuk') - $histori->sum('stok_keluar');
        return $sisa;
    }
    function scopePrevSP()
    {
        $data = $this->produkPenjualan()->with('spPenjualan')->get();
        $last = null;
        foreach ($data as $key => $value) {
            if ($value->spPenjualan->kirim_cek_sp && $value->spPenjualan->status_cek) {
                $last[] = $value;
            }
        }
        $return = is_null($last) ? null : last($last);
        return $return;
    }
}