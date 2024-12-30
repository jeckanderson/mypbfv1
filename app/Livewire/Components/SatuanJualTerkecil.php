<?php

namespace App\Livewire\Components;

use App\Models\Satuan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SatuanJualTerkecil extends Component
{
    public $barang, $open = false, $satuan, $id;
    public function render()
    {
        return view('livewire.components.satuan-jual-terkecil', [
            'satuans' => Satuan::all()
        ]);
    }

    public function openDisplay()
    {
        $this->open = true;
    }

    public function simpanSatuan()
    {
        if ($this->satuan) {
            Satuan::create([
                'id_perusahaan' => Auth::user()->id_perusahaan,
                'satuan' => $this->satuan
            ]);
            $this->open = false;
        }
    }
}