<?php

namespace App\Livewire\KeuanganAkutansi\JurnalAkun;

use App\Models\DetailJurnalAkun;
use App\Models\Jurnal;
use App\Models\JurnalAkun;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DataJurnalAkun extends Component
{
    public $search;
    public function render()
    {
        $query = JurnalAkun::where('id_perusahaan', Auth::user()->id_perusahaan);

        if ($this->search) {
            $query->where('no_reff', 'like', '%' . $this->search . '%');
        }

        return view('livewire.keuangan-akutansi.jurnal-akun.data-jurnal-akun', [
            'jurnalAkun' => $query->get()
        ]);
    }

    public function hapusJurnal($id)
    {
        $hapus = JurnalAkun::find($id);
        if ($hapus) {
            $jurnal = Jurnal::where('no_reff', $hapus->no_reff)->delete();
            if ($jurnal) {
                $hapus->delete();
                DetailJurnalAkun::where('id_ja', $id)->delete();
            }
            $this->render();
        }
    }
}
