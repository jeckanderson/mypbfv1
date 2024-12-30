<?php

namespace App\Livewire\Pembelian\ReturPembelian;

use App\Models\Pembelian;
use App\Models\ProdukDiterima;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ModalDaftarPembelian extends Component
{
    public $selectedPembelian;

    public function render()
    {
        return view('livewire.pembelian.retur-pembelian.modal-daftar-pembelian', [
            'pembelians' => Pembelian::where('id_perusahaan', Auth::user()->id_perusahaan)
                ->whereIn('id', ProdukDiterima::where('id_perusahaan', Auth::user()->id_perusahaan)->pluck('id_pembelian'))
                ->get()
        ]);
    }

    public function pilihPembelian()
    {
        $this->dispatch('pembelianTerpilih', id_pembelian: $this->selectedPembelian);
    }
}