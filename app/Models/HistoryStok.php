<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryStok extends Model
{
    use HasFactory;

    protected $table = 'histori_stok';
    protected $guarded = ['id'];

    public function gudang()
    {
        return $this->hasOne(Gudang::class, 'id', 'id_gudang');
    }

    public function rak()
    {
        return $this->hasOne(Rak::class, 'id', 'id_rak');
    }
    public function subRak()
    {
        return $this->hasOne(SubRak::class, 'id', 'id_sub_rak');
    }

    public function produk()
    {
        return $this->hasOne(ObatBarang::class, 'id', 'id_produk');
    }

    public function suplier()
    {
        return $this->hasOne(Suplier::class, 'id', 'suplier_pelanggan');
    }

    public function pelanggan()
    {
        return $this->hasOne(Pelanggan::class, 'id', 'suplier_pelanggan');
    }

    public function profile()
    {
        return $this->hasOne(Profile::class, 'id', 'id_perusahaan');
    }

    public function stokMasuk()
    {
        return $this->belongsTo(StokOpname::class, 'id_set_harga');
    }

    public function pembelian()
    {
        return $this->belongsTo(ProdukDiterima::class, 'id_set_harga');
    }

    public function produkDiterima()
    {
        return $this->hasOne(ProdukDiterima::class, 'id_histori', 'id');
    }

    public function stokAwal()
    {
        return $this->belongsTo(StokAwal::class, 'id_set_harga');
    }

    public function opname()
    {
        return $this->hasOne(StokOpname::class, 'id_histori', 'id');
    }

    public function retur()
    {
        return $this->hasOne(ProdukReturPenjualan::class, 'id_histori', 'id');
    }

    public function returPembelian()
    {
        return $this->hasOne(ProdukReturPembelian::class, 'id_histori', 'id');
    }

    public function produkPenjualan()
    {
        return $this->hasOne(ProdukPenjualan::class, 'id_histori', 'id');
    }
    /**
     * Get the set_harga_stok_awal that owns the HistoryStok
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function set_harga_stok_awal()
    {
        return $this->belongsTo(SetHarga::class, 'id_set_harga', 'id_set_harga')->where('Sumber','Stok Awal')->latest();
    }
    public function set_harga_stok_pembelian()
    {
        return $this->belongsTo(SetHarga::class, 'id_set_harga', 'id_set_harga')->where('Sumber','Pembelian')->latest();
    }

    public function sisaStok($idProduk, $idGudang, $idRak, $idSubRak)
    {
        $histori = HistoryStok::where('id_produk', $idProduk)
            ->where('id_gudang', $idGudang)
            ->where('id_rak', $idRak)
            ->where('id_sub_rak', $idSubRak);

        $sisa = $histori->sum('stok_masuk') - $histori->sum('stok_keluar');
        return $sisa;
    }

    public function sisaStokBatch($idProduk, $batch, $idGudang, $idRak, $idSubRak, $no_reff = null)
    {
        $histori = HistoryStok::where('id_produk', $idProduk)
            ->where('no_batch', $batch)
            ->where('id_gudang', $idGudang)
            ->where('id_rak', $idRak)
            ->when($no_reff, function ($q) use ($no_reff) {
                $q->where('no_reff', $no_reff);
            })
            ->where('id_sub_rak', $idSubRak);

        $sisa = $histori->sum('stok_masuk') - $histori->sum('stok_keluar');
        return $sisa;
    }

    public function hpp($history)
    {
        if ($history->keterangan == 'Stok Awal') {

            $hpp = $this->set_harga_stok_awal->hpp_final;
            // $sa = StokAwal::where('no_batch',$history->no_batch)->where('no_reff',$history->no_reff)->first();
            // $isi_satuan = floatval($history->stokAwal->isi_satuan);
            // $hpp = str_replace('.', '', $this->set_harga_stok_awal->hpp_final);
            // if ($isi_satuan != 0) {
            //     $hpp = str_replace('.', '', $this->set_harga_stok_awal->hpp_final) / $isi_satuan;
            // } else {
            //     $hpp = 0;
            // }

        } elseif ($history->keterangan == 'Stok Masuk') {
            $isi = floatval($history->produk->isi);
            if ($isi != 0) {
                $hpp = str_replace('.', '', $history->stokMasuk->hpp) / $isi;
            } else {
                $hpp = 0;
            }
        } elseif ($history->keterangan == 'Stok Opname' || $history->keterangan == 'Mutasi Stok') {
            if ($history->sumber_set_harga == 'Pembelian') {
                $hpp = round($this->set_harga_stok_pembelian->hpp_final);
            } elseif ($history->sumber_set_harga == 'Stok Awal') {
                $isi = floatval($history->produk->isi);
                if ($isi != 0) {
                    $hpp = str_replace('.', '', $history->stokAwal->hpp) / $isi;
                } else {
                    $hpp = 0;
                }
            } else {
                $isi = floatval($history->produk->isi);
                if ($isi != 0) {
                    $hpp = str_replace('.', '', $history->stokMasuk->hpp) / $isi;
                } else {
                    $hpp = 0;
                }
            }
        } elseif ($history->keterangan == 'Pembelian') {
            $hpp = round($this->set_harga_stok_pembelian->hpp_final);
            // $hpp = round($history->pembelian->diterimaToPembelian->hpp_final);
        } elseif ($history->keterangan == 'Retur Penjualan') {
            $isi = floatval($history->produk->isi);
            if ($isi != 0) {
                $hpp = str_replace('.', '', $history->retur->hpp) / $isi;
            } else {
                $hpp = 0;
            }
        } elseif ($history->keterangan == 'Penjualan') {
            $isi = floatval($history->produk->isi);
            if ($isi != 0) {
                $hpp = $history->pembelian->diterimaToPembelian->total / $isi;
            } else {
                $hpp = 0;
            }
        }

        return $hpp;
    }
}
