<?php

namespace App\Livewire\KeuanganAkutansi\Kontrabon;

use App\Models\Kontrabon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DataKontrabon extends Component
{
    public $search = '';

    public function render()
    {
        $query = Kontrabon::where('id_perusahaan', Auth::user()->id_perusahaan);

        if ($this->search) {
            $query->where('no_reff', 'like', '%' . $this->search . '%');
        }

        return view('livewire.keuangan-akutansi.kontrabon.data-kontrabon', [
            'kontrabons' => $query->get()
        ]);
    }

    public function hapusKontrabon($id)
    {
        $hapus = Kontrabon::find($id)->delete();
        if ($hapus) {
            $this->render();
        }
    }
}
