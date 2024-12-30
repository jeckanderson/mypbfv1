<?php

namespace App\Livewire\Pengadaan\LihatHpp;

use App\Models\RencanaOrder;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ModalTambahOrder extends Component
{
    public $produk, $pembelian, $jumlah_order, $keterangan;

    public function render()
    {
        return view('livewire.pengadaan.lihat-hpp.modal-tambah-order');
    }

    public function simpanRencanaOrder()
    {
        $simpan =  RencanaOrder::create([
            'id_perusahaan' => Auth::user()->id_perusahaan,
            'id_suplier' => $this->pembelian->suplier,
            'id_produk' => $this->produk->id,
            'jumlah_order' => $this->jumlah_order,
            'keterangan' => $this->keterangan ?? '-',
            'status' => '0',
        ]);

        if ($simpan) {
            session()->flash('success', 'Rencana order berhasil disimpan!');
            $this->reset('jumlah_order', 'keterangan');
        }
    }
}
