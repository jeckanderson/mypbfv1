<?php

namespace App\Livewire\Penjualan\SpPenjualan;

use App\Models\ObatBarang;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ModalDaftarProduk extends Component
{
    public $search = '', $selectedProduk = [];

    public function render()
    {
        return view('livewire.penjualan.sp-penjualan.modal-daftar-produk', [
            'produks' => ObatBarang::where('id_perusahaan', Auth::user()->id_perusahaan)->where('nama_obat_barang', 'like', '%' . $this->search . '%')->get()
        ]);
    }

    public function tambahProduk()
    {
        $this->dispatch('insertProduk', produks: $this->selectedProduk);
    }
}
