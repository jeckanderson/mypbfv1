<?php

namespace App\Livewire\Pengadaan;

use App\Models\ObatBarang;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Defecta extends Component
{
    public $tanggal;

    public function render()
    {
        return view('livewire.pengadaan.defecta', [
            'produks' => ObatBarang::where('id_perusahaan', Auth::user()->id_perusahaan)->get()
        ]);
    }

    public function mount()
    {
        $this->tanggal = now()->toDateString();
    }
}
