<?php

namespace App\Livewire\Pembelian\TambahPembelian;

use App\Livewire\Pembelian\TambahPembelian;
use App\Models\Pembelian;
use App\Models\SPPembelian;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DariSp extends Component
{
    public $selectedSurat;

    public function render()
    {
        return view('livewire.pembelian.tambah-pembelian.dari-sp', [
            'surats' => SPPembelian::where('id_perusahaan', Auth::user()->id_perusahaan)
                ->whereNotIn('id', Pembelian::pluck('id_sp')->toArray())
                ->get()
        ]);
    }

    public function tambahProduk()
    {
        if ($this->selectedSurat) {
            return $this->dispatch('insertProduk', id_surat: $this->selectedSurat)->to(TambahPembelian::class);
        }
    }
}