<?php

namespace App\Livewire\Produk\SetHarga;

use App\Models\ProdukDiterima;
use App\Models\StokAwal;
use App\Models\SetHarga as SetHargaModel;
use App\Models\StokOpname;
use Livewire\Attributes\On;
use Livewire\Component;

class SetHarga extends Component
{
    public $id, $sumber, $hpp_final, $stok, $pembelian, $opname;

    public function render()
    {
        return view('livewire.produk.set-harga.set-harga');
    }

    #[On('updateStok')]
    public function sendStok($stok_id)
    {
        $this->sumber = 'Stok Awal';
        $this->stok = StokAwal::find($stok_id);
        $this->pembelian = null;
        $this->opname = null;
    }

    #[On('updatePembelian')]
    public function sendPembelian($id_pembelian, $hppFinal)
    {
        $this->sumber = 'Pembelian';
        $this->hpp_final = $hppFinal;
        $this->pembelian = ProdukDiterima::find($id_pembelian);
        $this->stok = null;
        $this->opname = null;
    }

    #[On('updateOpname')]
    public function sendOpname($opname_id)
    {
        $this->sumber = 'Stok Masuk';
        $this->opname = StokOpname::find($opname_id);
        $this->stok = null;
        $this->pembelian = null;
    }
    #[On('updateSetHarga')]
    public function updateSetHarga($sumber,$id_sumber,$hpp)
    {
        $setHarga = SetHargaModel::where('sumber',$sumber)->where('id_set_harga',$id_sumber)->get()->each(function($row) use ($hpp){
            $row->update(['hpp_final' => $hpp * $row->isi]);
        });
    }
}