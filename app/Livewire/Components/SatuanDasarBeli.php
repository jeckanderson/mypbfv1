<?php

namespace App\Livewire\Components;

use App\Models\Satuan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SatuanDasarBeli extends Component
{
    public $barang, $open = false, $satuan, $id;


    public function render()
    {
        // $satuans = Satuan::all();
        // dd($satuans->isNotEmpty());
        // dd($this->barang);
        return view('livewire.components.satuan-dasar-beli', [
            'satuans' => Satuan::all(),
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