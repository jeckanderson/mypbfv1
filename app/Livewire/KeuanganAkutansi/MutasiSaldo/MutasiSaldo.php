<?php

namespace App\Livewire\KeuanganAkutansi\MutasiSaldo;

use App\Models\MutasiSaldoAkun;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class MutasiSaldo extends Component
{
    public $search;

    #[On('dataMutasi')]
    public function render()
    {
        $query = MutasiSaldoAkun::where('id_perusahaan', Auth::user()->id_perusahaan);

        if ($this->search) {
            $query->where('no_reff', 'like', '%' . $this->search . '%');
        }
        return view('livewire.keuangan-akutansi.mutasi-saldo.mutasi-saldo', [
            'mutasiSaldo' => $query->get()
        ]);
    }

    public function hapusMutasiSaldo($id)
    {
        $hapus = MutasiSaldoAkun::find($id)->delete();
        if ($hapus) {
            $this->render();
            session()->flash('success', 'Data berhasil dihapus!');
            $this->dispatch('dataTerhapus');
        }
    }
}
