<?php

namespace App\Livewire\Penjualan\ReturPenjualan;

use App\Models\Penjualan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ModalDaftarPenjualan extends Component
{
    public $selectedPenjualan;

    public function render()
    {
        return view('livewire.penjualan.retur-penjualan.modal-daftar-penjualan', [
            'penjualans' => Penjualan::where('id_perusahaan', Auth::user()->id_perusahaan)->get()
        ]);
    }

    public function pilihPenjualan()
    {
        $this->dispatch('dataPenjualan', penjualan: $this->selectedPenjualan);
    }
}
