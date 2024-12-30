<?php

namespace App\Livewire\KeuanganAkutansi\Akutansi;

use App\Models\AkunAkutansi;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NeracaLajur extends Component
{
    use WithPagination;
    public function render()
    {
        return view('livewire.keuangan-akutansi.akutansi.neraca-lajur', [
            'akuns' => AkunAkutansi::where('id_perusahaan', Auth::user()->id_perusahaan)->orderBy('kode', 'asc')->paginate(10),
        ]);
    }
}
