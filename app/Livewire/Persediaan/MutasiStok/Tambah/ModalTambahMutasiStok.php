<?php

namespace App\Livewire\Persediaan\MutasiStok\Tambah;

use App\Models\Gudang;
use App\Models\HistoryStok;
use App\Models\MutasiStok;
use App\Models\Rak;
use App\Models\SubRak;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ModalTambahMutasiStok extends Component
{
    public function render()
    {
        return view('livewire.persediaan.mutasi-stok.tambah.modal-tambah-mutasi-stok');
    }

    public $sumber, $stok, $pembelian, $gudangs = [], $raks = [], $subRaks = [], $tercatat, $history;

    //masuk form
    public $produk, $tipe, $no_batch, $exp_date, $jumlah_stok, $satuan_terkecil, $gudang_asal, $rak_asal, $subrak_asal, $gudang_baru, $rak_baru, $sub_rak_baru, $keterangan, $jumlah_mutasi;

    public function mount()
    {
        $this->gudangs = Gudang::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        $this->raks = Rak::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        $this->subRaks = SubRak::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        $this->produk = $this->history->produk->nama_obat_barang;
        $this->tipe = $this->history->produk->tipe;
        $this->no_batch = $this->history->no_batch;
        $this->exp_date = $this->history->exp_date;
        $this->satuan_terkecil = $this->history->produk->satuanTerkecil->satuan;
        $this->jumlah_stok = $this->tercatat;
        $this->gudang_asal = $this->history->gudang->gudang;
        $this->rak_asal = $this->history->rak->rak;
        $this->subrak_asal = $this->history->subRak->sub_rak;
    }

    public function simpanMutasiStok()
    {
        $sisaStok = HistoryStok::where('id_perusahaan', Auth::user()->id_perusahaan)
            ->where('id_produk', $this->history->id_produk)
            ->where('id_gudang', $this->history->id_gudang)
            ->where('id_rak', $this->history->id_rak)
            ->where('id_sub_rak', $this->history->id_sub_rak)
            ->latest()
            ->first()->stok_akhir ?? 0;

        $sisaStokPindahan = HistoryStok::where('id_perusahaan', Auth::user()->id_perusahaan)
            ->where('id_produk', $this->history->id_produk)
            ->where('id_gudang', $this->history->id_gudang)
            ->where('id_rak', $this->history->id_rak)
            ->where('id_sub_rak', $this->history->id_sub_rak)
            ->latest()
            ->first()->stok_akhir ?? 0;

        $histori = HistoryStok::create([
            'id_perusahaan' => Auth::user()->id_perusahaan,
            'id_produk' => $this->history->id_produk,
            'no_reff' => $this->history->no_reff,
            'no_faktur' => '-',
            'no_batch' => $this->history->no_batch,
            'exp_date' => ($this->history->exp_date ?? '-'),
            'suplier_pelanggan' => '-',
            'id_gudang' => $this->gudang_baru,
            'id_rak' => $this->rak_baru,
            'id_sub_rak' => $this->sub_rak_baru,
            'sumber_set_harga' => $this->history->sumber_set_harga,
            'id_set_harga' => $this->history->id_set_harga,
            'stok_masuk' => $this->jumlah_mutasi,
            'stok_keluar' => 0,
            'stok_akhir' => $sisaStokPindahan + $this->jumlah_mutasi,
            'keterangan' => 'Mutasi Stok'
        ]);

        HistoryStok::create([
            'id_perusahaan' => Auth::user()->id_perusahaan,
            'id_produk' => $this->history->id_produk,
            'no_reff' => $this->history->no_reff,
            'no_faktur' => '-',
            'no_batch' => $this->history->no_batch,
            'exp_date' => ($this->history->exp_date ?? '-'),
            'suplier_pelanggan' => '-',
            'id_gudang' => $this->history->id_gudang,
            'id_rak' => $this->history->id_rak,
            'id_sub_rak' => $this->history->id_sub_rak,
            'sumber_set_harga' => $this->history->sumber_set_harga,
            'id_set_harga' => $this->history->id_set_harga,
            'stok_masuk' => 0,
            'stok_keluar' => $this->jumlah_mutasi,
            'stok_akhir' => $sisaStok - $this->jumlah_mutasi,
            'keterangan' => 'Mutasi Stok'
        ]);

        $id = '';
        if ($this->history->keterangan == "Stok Awal") {
            $id = $this->history->stokAwal->id;
        } elseif ($this->history->keterangan == "Stok Masuk") {
            $id = $this->history->opname->id;
        } elseif ($this->history->keterangan == "Stok Opname" || $this->history->keterangan == "Mutasi Stok") {
            if ($this->history->sumber_set_harga == 'Pembelian') {
                $id = $this->history->id_set_harga;
            } elseif ($this->history->sumber_set_harga == 'Stok Awal') {
                $id = $this->history->id_set_harga;
            } else {
                $id = $this->history->id_set_harga;
            }
        } elseif ($this->history->keterangan == "Pembelian") {
            $id = $this->history->pembelian->diterimaToPembelian->id;
        } elseif ($this->history->keterangan == "Penjualan") {
            $id = $this->history->pembelian->diterimaToPembelian->id;
        }

        MutasiStok::create([
            'id_perusahaan' => Auth::user()->id_perusahaan,
            'id_histori' => $histori->id,
            'id_produk' =>  $this->history->id_produk,
            'sumber' => $this->history->keterangan,
            'id_sumber' =>  $id,
            'gudang_asal' =>  $this->history->id_gudang,
            'rak_asal' =>  $this->history->id_rak,
            'sub_rak_asal' =>  $this->history->id_sub_rak,
            'jumlah_mutasi' => $this->jumlah_mutasi,
            'gudang_sesudah' => $this->gudang_baru,
            'rak_sesudah' => $this->rak_baru,
            'sub_rak_sesudah' => $this->sub_rak_baru,
            'keterangan' => $this->keterangan,
        ]);

        $this->reset(['gudang_baru', 'rak_baru', 'sub_rak_baru', 'keterangan', 'jumlah_mutasi']);
        session()->flash('success', 'Berhasil!, Mutasi stok berhasil ditambahkan');
        $this->dispatch('mutasi-created');
    }
}