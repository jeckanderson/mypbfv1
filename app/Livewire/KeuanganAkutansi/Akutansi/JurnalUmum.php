<?php

namespace App\Livewire\KeuanganAkutansi\Akutansi;

use App\Models\Jurnal;
use App\Models\Profile;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class JurnalUmum extends Component
{
    use WithPagination;

    public $tanggalMulai, $tanggalAkhir;

    public $cariNoReff;

    public function render()
    {
        $startDate = Profile::where('id', Auth::user()->id_perusahaan)->first()->tgl_neraca_awal;
        $formattedDate = DateTime::createFromFormat('j M, Y', $startDate)->format('j-m-Y');

        $query = Jurnal::where('id_perusahaan', Auth::user()->id_perusahaan)
            ->where('no_reff', '!=', '-');

        if ($this->cariNoReff) {
            $query->where('no_reff', 'like', '%' . $this->cariNoReff . '%');
        }

        if ($this->tanggalMulai && $this->tanggalAkhir) {
            $query->whereBetween('updated_at', [$this->tanggalMulai, $this->tanggalAkhir]);
        }

        return view('livewire.keuangan-akutansi.akutansi.jurnal-umum', [
            'jurnals' => $query,
            'tglNeraca' => $formattedDate
        ]);
    }
}
