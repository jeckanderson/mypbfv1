<?php

namespace App\Livewire\Components;

use App\Models\Produsen as ModelsProdusen;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Produsen extends Component
{
    public $barang, $open = false, $produsen;

    public function render()
    {
        return view('livewire.components.produsen', [
            'produsens' => ModelsProdusen::all()
        ]);
    }

    public function openDisplay()
    {
        $this->open = true;
    }

    public function simpanJenis()
    {
        if ($this->produsen) {
            $produsen = new ModelsProdusen();
            $produsen->id_perusahaan = Auth::user()->id_perusahaan;
            $produsen->produsen = $this->produsen;
            $produsen->save();
            $this->open = false;
        }
    }
}