<?php

namespace App\Livewire\Pengadaan;

use App\Models\ProdukPenjualan;
use App\Models\RencanaPengadaan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AnalisisPareto extends Component
{
    public $produkPenjualan, $selectedProduk = [], $selectAll = false;
    public $tanggalMulai, $tanggalAkhir;

    public function render()
    {
        // Memanggil method untuk mendapatkan data produk penjualan dengan filter tanggal
        $this->getProdukPenjualan();

        return view('livewire.pengadaan.analisis-pareto');
    }

    public function mount()
    {
        // Inisialisasi produk penjualan tanpa filter
        $this->getProdukPenjualan();
    }

    public function getProdukPenjualan()
    {
        $query = ProdukPenjualan::where('id_perusahaan', Auth::user()->id_perusahaan);

        if ($this->tanggalMulai && $this->tanggalAkhir) {
            $query->whereBetween('updated_at', [$this->tanggalMulai, $this->tanggalAkhir]);
        }

        $this->produkPenjualan = $query->groupBy('id_produk')->get();
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
                    'sumber' => 'pareto',
                ]);
            }
            $this->reset('selectedProduk');
        } else {
            $this->js("alert('Pilih produk terlebih dahulu!')");
        }
    }
}
