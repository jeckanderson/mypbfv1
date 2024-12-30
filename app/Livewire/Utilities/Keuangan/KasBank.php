<?php

namespace App\Livewire\Utilities\Keuangan;

use App\Models\AkunAkutansi;
use Carbon\Carbon;
use Livewire\Component;
use App\Models\DetailJurnalAkun;
use App\Models\Jurnal;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class KasBank extends Component
{
    use WithPagination;
    public $mulaiId;
    public $selesaiId;
    public $search = '';


    protected $listeners = ['refreshTable' => '$refresh'];

    public function render()
    {
        if (!$this->mulaiId) {
            $this->mulaiId = Carbon::now()->firstOfMonth()->format('Y-m-d');
        }

        if (!$this->selesaiId) {
            $this->selesaiId = Carbon::now()->endOfMonth()->format('Y-m-d');
        }

        $query = AkunAkutansi::where('id_perusahaan', Auth::user()->id_perusahaan)
            ->where('kas_bank', 1)
            ->orderBy('kode', 'asc')
            ->where('id', '!=', 30)
            ->where('nama_akun', 'like', '%' . $this->search . '%');

        return view('livewire.utilities.keuangan.kas-bank', ['akuns' => $query->paginate(10)]);
    }
}
