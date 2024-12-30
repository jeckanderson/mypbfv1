<?php

namespace App\Livewire\KeuanganAkutansi\Akutansi;

use App\Models\AkunAkutansi;
use App\Models\PiutangAwal;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class BukuBesar extends Component
{
    use WithPagination;

    protected $paginateTheme = 'tailwind';

    public $search = '', $perPage = '';

    public $tanggalMulai, $tanggalAkhir;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = AkunAkutansi::where('id_perusahaan', Auth::user()->id_perusahaan)
            ->orderBy('kode', 'asc')
            ->where('id', '!=', 30)
            ->where('nama_akun', 'like', '%' . $this->search . '%');

        return view('livewire.keuangan-akutansi.akutansi.buku-besar', [
            'akuns' => $query->paginate($this->perPage),
            'jurnal'
        ]);
    }

    public function mount()
    {
        $this->tanggalMulai = Carbon::now()->startOfMonth()->toDateString();
        $this->tanggalAkhir = Carbon::now()->endOfMonth()->toDateString();
    }
}
