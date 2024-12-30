<?php

namespace App\Livewire\Pembelian\ReturPembelian;

use App\Models\Pembelian;
use App\Models\ProdukDiterima;
use App\Models\ProdukReturPembelian;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On;

class ModalDaftarTerimaBarang extends Component
{
    public $produkTerimaBarang = [], $faktur = '', $selectedProduk = [], $id_pembelian;
    public function render()
    {
        return view('livewire.pembelian.retur-pembelian.modal-daftar-terima-barang');
    }

    #[On('sendDataProduk')]
    public function getProduk($id_pembelian)
    {
        $this->id_pembelian = $id_pembelian;
        $this->produkTerimaBarang = ProdukDiterima::where('id_pembelian', $id_pembelian)->get();
        $this->faktur = Pembelian::find($id_pembelian)->no_faktur;
    }

    public function pilihProduk()
    {
        foreach ($this->selectedProduk as $key => $prod) {
            ProdukReturPembelian::create([
                'id_perusahaan' => Auth::user()->id_perusahaan,
                'id_user' => Auth::id(),
                'id_pembelian' => $this->id_pembelian,
                'id_produk' => ProdukDiterima::find($prod)->produk->id,
                'id_terima_barang' => $prod,
            ]);
        }
        $this->dispatch('refreshTableRetur');
    }
}
