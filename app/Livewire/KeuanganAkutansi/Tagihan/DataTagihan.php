<?php

namespace App\Livewire\KeuanganAkutansi\Tagihan;

use App\Models\TagihanPelanggan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DataTagihan extends Component
{
    public $search;

    public function render()
    {
        $query = TagihanPelanggan::where('id_perusahaan', Auth::user()->id_perusahaan);

        if ($this->search) {
            $query->where('no_reff', 'like', '%' . $this->search . '%');
        }

        return view('livewire.keuangan-akutansi.tagihan.data-tagihan', [
            'dataTagihan' => $query->get()
        ]);
    }

    public function hapusTagihan($id)
    {
        $hapus = TagihanPelanggan::find($id)->delete();
        if ($hapus) {
            $this->render();
        }
    }
}
