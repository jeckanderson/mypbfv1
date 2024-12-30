<?php

namespace App\Livewire\Penjualan\SuratJalan;

use App\Models\DetailSuratJalan;
use App\Models\SuratJalan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DataSuratJalan extends Component
{
    public $search = '', $startDate = '', $endDate = '';

    public function render()
    {
        $query = SuratJalan::where('id_perusahaan', Auth::user()->id_perusahaan);

        if ($this->search) {
            $query->where('no_reff', 'like', '%' . $this->search . '%');
        }

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('tanggal', [$this->startDate, $this->endDate]);
        }

        return view('livewire.penjualan.surat-jalan.data-surat-jalan', [
            'suratJalan' => $query->get()
        ]);
    }

    public function hapusSurat($id)
    {
        $hapus = SuratJalan::find($id)->delete();
        if ($hapus) {
            DetailSuratJalan::where('id_surat_jalan', $id)->delete();
            $this->render();
        }
    }
}
