<?php

namespace App\Livewire\KeuanganAkutansi\PembayaranHutang;

use App\Models\HutangPengguna;
use App\Models\Jurnal;
use App\Models\PembayaranHutang;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DataPembayaranHutang extends Component
{
    public $startDate, $endDate;

    public function render()
    {
        $query = PembayaranHutang::where('id_perusahaan', Auth::user()->id_perusahaan)->orderBy('created_at', 'desc');

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('tgl_input', [$this->startDate, $this->endDate]);
        }

        return view('livewire.keuangan-akutansi.pembayaran-hutang.data-pembayaran-hutang', [
            'pembayaranHutang' => $query->get()
        ]);
    }

    public function hapusHutang($id)
    {
        $hapus = PembayaranHutang::find($id)->delete();
        if ($hapus) {
            HutangPengguna::where('id_bh', $id)->delete();
            Jurnal::where('id_sumber', $id)->where('sumber', 'Pembayaran Hutang')->delete();
            $this->render();
        }
    }
}
