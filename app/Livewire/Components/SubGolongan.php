<?php

namespace App\Livewire\Components;

use App\Models\SubGolongan as ModelsSubGolongan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SubGolongan extends Component
{
    public $barang, $open = false, $golongan;

    public function render()
    {
        return view('livewire.components.sub-golongan', [
            'sub_golongans' => ModelsSubGolongan::all()
        ]);
    }

    public function openDisplay()
    {
        $this->open = true;
    }

    public function simpanGolongan()
    {
        if ($this->golongan) {
            $golongan = new ModelsSubGolongan();
            $golongan->id_perusahaan = Auth::user()->id_perusahaan;
            $golongan->sub_golongan = $this->golongan;
            $golongan->save();
            $this->open = false;
        }
    }
}
