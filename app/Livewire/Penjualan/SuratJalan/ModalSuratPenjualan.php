<?php

namespace App\Livewire\Penjualan\SuratJalan;

use App\Models\DetailSuratJalan;
use App\Models\Penjualan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ModalSuratPenjualan extends Component
{
    public $selectedPenjualan = [], $id;

    public function render()
    {
        return view('livewire.penjualan.surat-jalan.modal-surat-penjualan', [
            'penjualans' => Penjualan::where('id_perusahaan', Auth::user()->id_perusahaan)->whereNotIn('id', DetailSuratJalan::where('status', 1)->pluck('id_penjualan'))->get()
        ]);
    }

    public function pilihPenjualan()
    {
        if ($this->id) {
            foreach ($this->selectedPenjualan as $key => $jual) {
                DetailSuratJalan::create([
                    'id_perusahaan' => Auth::user()->id_perusahaan,
                    'id_user' => Auth::id(),
                    'id_surat_jalan' => $this->id,
                    'id_penjualan' => $jual,
                ]);
            }
        } else {
            foreach ($this->selectedPenjualan as $key => $jual) {
                DetailSuratJalan::create([
                    'id_perusahaan' => Auth::user()->id_perusahaan,
                    'id_user' => Auth::id(),
                    'id_surat_jalan' => '-',
                    'id_penjualan' => $jual,
                ]);
            }
        }
        $this->dispatch('refreshTablePenjualan');
    }
}
