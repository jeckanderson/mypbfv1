<?php

namespace App\Livewire\TerimaBarang\Tambah;

use App\Models\ProdukDiterima;
use App\Models\ProdukPembelian;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class PilihProduk extends Component
{
    public $selectedProduk = [], $produks = [], $jumlah = 0, $id_produk = 0, $id_pembelian = 0, $mengurang = [], $hasil = [], $id, $selectAll = false;

    #[On('refresh')]
    public function render()
    {
        return view('livewire.terima-barang.tambah.pilih-produk');
    }

    public function updatedSelectAll($value)
    {
        dd('dsjhfhdgv');
        if ($value) {
            $this->selectedProduk = ProdukPembelian::where('id_pembelian', $this->id_pembelian)->pluck('id');
        } else {
            $this->selectedProduk = [];
        }
    }

    public function selectProduk()
    {
        if (!empty(array_filter($this->mengurang))) {
            $produks = ProdukPembelian::whereIn('id_order', $this->selectedProduk)->get();
            $diterima = array_values(array_filter($this->mengurang, function ($value) {
                return $value !== "";
            }));
            foreach ($produks as $index => $produk) {
                if (isset($diterima[$index])) {
                    ProdukDiterima::create([
                        'id_perusahaan' => Auth::user()->id_perusahaan,
                        'id_produk' => $produk->order->produk->id,
                        'id_sp' => $produk->id_sp,
                        'id_pembelian' => $this->id_pembelian,
                        'id_order' => $produk->order->id,
                        'diterima' => $diterima[$index],
                    ]);
                }
            }
            $this->dispatch('sendToTable', id_pembelian: $this->id_pembelian);
            $this->mengurang = [];
            $this->selectedProduk = [];
        }
    }

    #[On('sendToTable')]
    public function getProduk($id_pembelian)
    {
        $this->id_pembelian = $id_pembelian;
        $this->produks =  ProdukPembelian::where('id_pembelian', $this->id_pembelian)->get();
    }

    public function mount()
    {
        if ($this->id) {
            $this->id_pembelian = ProdukDiterima::where('id_terima_barang', $this->id)->first()->id_pembelian;
            $this->produks =  ProdukPembelian::where('id_pembelian', $this->id_pembelian)->get();
        }
    }
}
