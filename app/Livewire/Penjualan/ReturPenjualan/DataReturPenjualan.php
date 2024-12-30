<?php

namespace App\Livewire\Penjualan\ReturPenjualan;

use App\Models\HistoryStok;
use App\Models\Jurnal;
use App\Models\PiutangPengguna;
use App\Models\ProdukReturPenjualan;
use App\Models\ReturPenjualan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DataReturPenjualan extends Component
{
    public $search = '', $startDate = '', $endDate = '';

    public function render()
    {
        $query = ReturPenjualan::where('id_perusahaan', Auth::user()->id_perusahaan);

        if ($this->search) {
            $query->where('no_faktur', 'like', '%' . $this->search . '%')
                ->orWhere('no_reff', 'like', '%' . $this->search . '%');
        }

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('tgl_input', [$this->startDate, $this->endDate]);
        }

        return view('livewire.penjualan.retur-penjualan.data-retur-penjualan', [
            'returPenjualan' => $query->get()
        ]);
    }

    public function hapusReturPenjualan($id)
    {
        $retur = ReturPenjualan::find($id);
        if ($retur) {
            Jurnal::where('id_sumber', $id)->where('sumber', 'Retur Penjualan')->delete();
            HistoryStok::whereIn('id', json_decode($retur->id_histori))->delete();
            ProdukReturPenjualan::where('id_retur', $id)->delete();
            PiutangPengguna::where('sumber', 'retur penjualan')->where('id_bp', $id)->where('id_perusahaan', Auth::user()->id_perusahaan)->delete();
            $retur->delete();
        }
    }
}
