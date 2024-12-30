<?php

namespace App\Livewire\Components;

use App\Models\JenisObatBarang;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class JenisObat extends Component
{
    public $barang, $open = false, $jenis;
    public function render()
    {
        return view('livewire.components.jenis-obat', [
            'jenis_obat' => JenisObatBarang::all()
        ]);
    }

    public function openDisplay()
    {
        $this->open = true;
    }

    public function simpanJenis()
    {
        if ($this->jenis) {
            $jenis = new JenisObatBarang();
            $jenis->id_perusahaan = Auth::user()->id_perusahaan;
            $jenis->jenis = $this->jenis;
            $jenis->save();
            $this->open = false;
        }
    }
}
