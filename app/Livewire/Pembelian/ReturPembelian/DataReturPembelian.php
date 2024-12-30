<?php

namespace App\Livewire\Pembelian\ReturPembelian;

use App\Models\HistoryStok;
use App\Models\HutangPengguna;
use App\Models\Jurnal;
use App\Models\ProdukReturPembelian;
use App\Models\ReturPembelian;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DataReturPembelian extends Component
{
    public $search = '', $startDate = '', $endDate = '';

    public function render()
    {
        $query = ReturPembelian::where('id_perusahaan', Auth::user()->id_perusahaan);

        if ($this->search) {
            $query->where('no_faktur', 'like', '%' . $this->search . '%');
        }

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('tgl_input', [$this->startDate, $this->endDate]);
        }
        return view('livewire.pembelian.retur-pembelian.data-retur-pembelian', [
            'returPembelian' => $query->get()
        ]);
    }

    public function hapusReturPembelian($id)
    {
        $retur = ReturPembelian::find($id);
        if ($retur) {
            ProdukReturPembelian::where('id_user', Auth::id())->where('id_retur', null)->delete();
            ProdukReturPembelian::where('id_retur', $id)->delete();
            HistoryStok::whereIn('id', json_decode($retur->id_histori))->delete();
            HutangPengguna::where('id_bh', $id)->where('sumber', 'retur pembelian')->latest()->delete();
            Jurnal::where('id_sumber', $id)->where('sumber', 'Retur Pembelian')->delete();
            $retur->delete();
        }
    }
}
