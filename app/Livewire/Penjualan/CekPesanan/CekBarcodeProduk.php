<?php

namespace App\Livewire\Penjualan\CekPesanan;

use App\Models\ObatBarang;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class CekBarcodeProduk extends Component
{
    public  $kode, $nama_produk, $warning, $index, $modal_id;

    public function render()
    {
        return view('livewire.penjualan.cek-pesanan.cek-barcode-produk');
    }

    public function updatedKode()
    {
        $cekProduk = ObatBarang::where('id_perusahaan', Auth::user()->id_perusahaan)->where('barcode_produk', $this->kode)->first();

        if ($cekProduk) {
            $this->nama_produk = $cekProduk->nama_obat_barang;
            $this->warning = "";
        } else {
            $this->nama_produk = '';
            $this->warning = "Tidak ada produk ditemukan";
        }
    }

    public function masukan()
    {
        $this->dispatch('tambahQty', key: $this->index);
        $this->kode = '';
        $this->nama_produk = '';
    }
}
