<?php

namespace App\Livewire\Components;

use App\Models\Golongan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Kategori extends Component
{
    public $barang, $open = false, $kategori = '';

    public function render()
    {
        return view('livewire.components.kategori', [
            'golongans' => Golongan::all()
        ]);
    }
    public function openDisplay()
    {
        $this->open = true;
    }

    public function simpanKategori()
    {

        if ($this->kategori) {
            $golongan = new Golongan();
            $golongan->id_perusahaan = Auth::user()->id_perusahaan;
            $golongan->golongan = $this->kategori;
            $golongan->save();
            $this->open = false;
        }
    }
}
