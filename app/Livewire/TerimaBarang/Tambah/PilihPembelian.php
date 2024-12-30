<?php

namespace App\Livewire\TerimaBarang\Tambah;

use App\Models\Pembelian;
use App\Models\TerimaBarang;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PilihPembelian extends Component
{
    public $pembelians = [], $selected;
    public function render()
    {
        return view('livewire.terima-barang.tambah.pilih-pembelian');
    }

    public function mount()
    {
        $this->pembelians = Pembelian::where('id_perusahaan', Auth::user()->id_perusahaan)
            ->whereNotIn('id', TerimaBarang::pluck('id_pembelian')->toArray())
            ->get();
    }

    public function selectPembelian()
    {
        return $this->dispatch('sendToTable', id_pembelian: $this->selected);
    }
}
