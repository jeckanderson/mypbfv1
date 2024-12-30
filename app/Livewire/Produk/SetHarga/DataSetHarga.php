<?php

namespace App\Livewire\Produk\SetHarga;

use App\Models\ProdukDiterima;
use App\Models\StokAwal;
use App\Models\StokOpname;
use Livewire\Attributes\On;
use Livewire\Component;

class DataSetHarga extends Component
{
    public $id, $set, $stok, $pembelian, $sumber, $hppFinalPembelian, $opname;

    #[On('updateStok')]
    public function sendStok($stok_id)
    {
        $this->stok = StokAwal::find($stok_id);
        $this->pembelian = null;
        $this->opname = null;
    }

    #[On('updatePembelian')]
    public function sendPembelian($id_pembelian)
    {
        $this->pembelian = ProdukDiterima::find($id_pembelian);
        $this->stok = null;
        $this->opname = null;
    }

    #[On('updateOpname')]
    public function sendOpname($opname_id)
    {
        $this->opname = StokOpname::find($opname_id);
        $this->stok = null;
        $this->pembelian = null;
    }

    public function render()
    {
        return view('livewire.produk.set-harga.data-set-harga');
    }
}