<?php

namespace App\Livewire\PembuatanSp\RencanaOrder;

use App\Models\AnalisaSP;
use App\Models\ObatBarang;
use App\Models\RencanaOrder;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ModalTambahProduk extends Component
{
    public $id, $nama_suplier, $nama_produk, $obatBarangDetail, $keterangan, $jumlah_order, $sup;
    protected $listeners = ['refreshChildComponents' => '$refresh'];
    public function render()
    {
        return view('livewire.pembuatan-sp.rencana-order.modal-tambah-produk', [
            'produks' => ObatBarang::where('id_perusahaan', Auth::user()->id_perusahaan)->where('status', 1)->get(),
        ]);
    }

    public function mount()
    {
        $this->obatBarangDetail = new ObatBarang();
    }

    public function updatedNamaProduk($value)
    {
        if (!is_null($value)) {
            $this->obatBarangDetail = ObatBarang::find($value) ?? '';
        }
    }

    public function tambahProduk()
    {
        RencanaOrder::create([
            'id_perusahaan' => Auth::user()->id_perusahaan,
            'id_suplier' => $this->id,
            'id_produk' => $this->nama_produk,
            'jumlah_order' => $this->jumlah_order,
            'keterangan' => $this->keterangan ?? '-',
            'status' => '0',
        ]);

        session()->flash('success', 'Data berhasil disimpan!');
        $this->dispatch('refresh');
        $this->obatBarangDetail = new ObatBarang();
        $this->reset('nama_suplier', 'jumlah_order', 'keterangan');
    }
}
