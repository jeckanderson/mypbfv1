<?php

namespace App\Livewire\Pengadaan;

use App\Models\ObatBarang;
use App\Models\ProdukPenjualan;
use App\Models\RencanaPengadaan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AnalisisOrder extends Component
{
    public $produkPenjualan, $produks, $analisis = 1, $selectedProduk = [], $selectAll = false;

    public function render()
    {
        return view('livewire.pengadaan.analisis-order');
    }

    public function mount()
    {
        $this->produkPenjualan = ProdukPenjualan::where('id_perusahaan', Auth::user()->id_perusahaan)->groupBy('id_produk')->get();
        $this->produks = ObatBarang::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedProduk = $this->produkPenjualan->pluck('id_produk')->map(fn ($id) => (string)$id)->toArray();
        } else {
            $this->selectedProduk = [];
        }
    }

    public function sendDefecta()
    {
        if ($this->selectedProduk) {
            foreach ($this->selectedProduk as $produk) {
                RencanaPengadaan::create([
                    'id_perusahaan' => Auth::user()->id_perusahaan,
                    'tanggal' => now()->toDateString(),
                    'id_produk' => $produk,
                    'sumber' => 'order',
                ]);
            }
            $this->reset('selectedProduk');
        } else {
            $this->js("alert('Pilih produk terlebih dahulu!')");
        }
    }
}
