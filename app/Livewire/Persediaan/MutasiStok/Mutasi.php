<?php

namespace App\Livewire\Persediaan\MutasiStok;

use App\Models\MutasiStok;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Mutasi extends Component
{
    public $tanggalMulai, $tanggalAkhir;

    public function render()
    {
        $query = MutasiStok::where('id_perusahaan', Auth::user()->id_perusahaan);

        if ($this->tanggalMulai && $this->tanggalAkhir) {
            $query->whereBetween('created_at', [$this->tanggalMulai, $this->tanggalAkhir]);
        }

        return view('livewire.persediaan.mutasi-stok.mutasi', [
            'mutasiStok' => $query->get()
        ]);
    }
}
