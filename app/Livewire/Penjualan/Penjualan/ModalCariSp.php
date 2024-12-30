<?php

namespace App\Livewire\Penjualan\Penjualan;

use App\Models\Penjualan;
use App\Models\SPPenjualan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ModalCariSp extends Component
{
    public $selectedSP;

    public function render()
    {
        return view('livewire.penjualan.penjualan.modal-cari-sp', [
            'spPenjualan' => SPPenjualan::where('id_perusahaan', Auth::user()->id_perusahaan)->where('kirim_penjualan', 1)->whereNotIn('id', Penjualan::pluck('id_sp'))->get()
        ]);
    }

    public function pilihSP()
    {
        $this->dispatch('getSP', id_sp: $this->selectedSP);
    }
}
