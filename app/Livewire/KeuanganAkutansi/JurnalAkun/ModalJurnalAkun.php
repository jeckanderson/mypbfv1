<?php

namespace App\Livewire\KeuanganAkutansi\JurnalAkun;

use App\Models\AkunAkutansi;
use App\Models\DetailJurnalAkun;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ModalJurnalAkun extends Component
{
    public $akun, $debet, $kredit;

    public function render()
    {
        return view('livewire.keuangan-akutansi.jurnal-akun.modal-jurnal-akun', [
            'akuns' =>  AkunAkutansi::where('is_delete', 0)
                ->orderBy('kode', 'asc')
                ->get()->merge(
                    AkunAkutansi::where('id_perusahaan', Auth::user()->id_perusahaan)
                        ->where('is_delete', 1)
                        ->orderBy('kode', 'asc')
                        ->get()
                )
        ]);
    }

    public function simpanJurnal()
    {
        $simpan = DetailJurnalAkun::create([
            'id_perusahaan' => Auth::user()->id_perusahaan,
            'id_ja' => '-',
            'id_user' => Auth::id(),
            'id_akun' => $this->akun,
            'debet' => str_replace('.', '', $this->debet),
            'kredit' => str_replace('.', '', $this->kredit),
        ]);
        if ($simpan) {
            $this->dispatch('getJurnalAkun');
            $this->resetExcept('akun');
        }
    }
}
