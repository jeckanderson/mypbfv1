<?php

namespace App\Livewire\Pembelian;

use App\Models\HistoryStok;
use App\Models\HutangPengguna;
use App\Models\Jurnal;
use App\Models\Pembelian;
use App\Models\ProdukDiterima;
use App\Models\ProdukPembelian;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On;

class DataPembelian extends Component
{
    public $search = '', $statusKredit, $tanggalMulai, $tanggalAkhir;

    #[On('taxUpdated')]
    public function render()
    {
        $query = Pembelian::where('id_perusahaan', Auth::user()->id_perusahaan);

        if ($this->search) {
            $query->where('no_faktur', 'like', '%' . $this->search . '%');
        }

        if ($this->statusKredit !== null) {
            $query->where('kredit', $this->statusKredit);
        }

        if ($this->tanggalMulai) {
            $query->whereDate('tgl_faktur', '>=', $this->tanggalMulai);
        }

        if ($this->tanggalAkhir) {
            $query->whereDate('tgl_faktur', '<=', $this->tanggalAkhir);
        }

        $pembelians = $query->get();

        return view('livewire.pembelian.data-pembelian', [
            'pembelians' => $pembelians,
        ]);
    }

    public function hapusPembelian($id)
    {
        $pembelian = Pembelian::find($id);
        if ($pembelian) {
            ProdukPembelian::where('id_pembelian', $id)->delete();
            HutangPengguna::where('id_pembelian', $id)->delete();
            ProdukDiterima::where('id_pembelian', $id)->delete();
            HistoryStok::where('no_reff', $pembelian->no_reff)->where('id_perusahaan', Auth::user()->id_perusahaan)->delete();
            Jurnal::where('id_sumber', $id)->where('sumber', 'Pembelian')->where('id_perusahaan', Auth::user()->id_perusahaan)->delete();
            $pembelian->delete();
        }
        $this->render();
    }
}