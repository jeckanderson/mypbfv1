<?php

namespace App\Livewire\Produk\SetHarga;

use App\Models\Kelompok;
use App\Models\ProdukDiterima;
use App\Models\StokAwal;
use Livewire\Attributes\On;
use Livewire\Component;

class DataSetKelompok extends Component
{
    public $stok, $id, $sumber, $pembelian, $hppFinalPembelian;

    #[On('updateStok')]
    public function sendStok($stok_id)
    {
        $this->stok = StokAwal::find($stok_id);
        $this->sumber = 'Stok Awal';
        $this->pembelian = null;
    }

    #[On('updatePembelian')]
    public function sendPembelian($id_pembelian, $hppFinal)
    {
        $this->pembelian = ProdukDiterima::find($id_pembelian);
        $this->sumber = 'Pembelian';
        $this->stok = null;
        $this->hppFinalPembelian = $hppFinal;
    }

    public function render()
    {
        return view('livewire.produk.set-harga.data-set-kelompok', [
            'kelompoks' => (new Kelompok())->getByIdPerusahaan()
        ]);
    }
}
