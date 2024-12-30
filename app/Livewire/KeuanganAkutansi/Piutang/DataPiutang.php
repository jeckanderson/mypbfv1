<?php

namespace App\Livewire\KeuanganAkutansi\Piutang;

use App\Models\Jurnal;
use Livewire\Component;
use App\Models\PiutangPengguna;
use App\Models\PembayaranPiutang;
use Illuminate\Support\Facades\Auth;

class DataPiutang extends Component
{
    public $startDate, $endDate;

    public function render()
    {
        $query = PembayaranPiutang::where('id_perusahaan', Auth::user()->id_perusahaan)->orderBy('created_at', 'desc');

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('tgl_input', [$this->startDate, $this->endDate]);
        }

        return view('livewire.keuangan-akutansi.piutang.data-piutang', [
            'piutangPengguna' => $query->get()
        ]);
    }

    public function hapusPembayaranPiutang($id)
    {
        Jurnal::where('id_sumber', $id)->where('sumber', 'Pembayaran Piutang')->delete();
        $hapus = PembayaranPiutang::find($id)->delete();
        if ($hapus) {
            PiutangPengguna::where('id_bp', $id)->delete();
            $this->render();
        }
    }
}
