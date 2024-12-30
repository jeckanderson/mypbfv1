<?php

namespace App\Livewire\TerimaBarang;

use App\Livewire\Utilities\Hutang\KartuHutang;
use App\Models\HistoryStok;
use App\Models\HutangPengguna;
use App\Models\Jurnal;
use App\Models\MutasiStok;
use App\Models\Pembelian;
use App\Models\ProdukDiterima;
use App\Models\SetHarga;
use App\Models\StokOpname;
use App\Models\TerimaBarang;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DataTerimaBarang extends Component
{
    public $search = '', $startDate = '', $endDate = '';

    public function render()
    {
        $query = TerimaBarang::where('id_perusahaan', Auth::user()->id_perusahaan);

        if ($this->search) {
            $query->where('no_faktur', 'like', '%' . $this->search . '%');
        }

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('tanggal', [$this->startDate, $this->endDate]);
        }

        return view('livewire.terima-barang.data-terima-barang', [
            'terimaBarangs' => $query->get(),
        ]);
    }

    public function hapusTerimaBarang($id)
    {
        $terimaBarang = TerimaBarang::find($id);

        if ($terimaBarang) {
            HutangPengguna::where('sourceable_type', Pembelian::class)->where('sourceable_id', $terimaBarang->id_pembelian)->delete();
            HistoryStok::where('no_reff', $terimaBarang->no_reff)->delete();
            MutasiStok::where('sumber', 'Pembelian')->where('id_sumber', $id)->delete();
            StokOpname::where('sumber', 'Pembelian')->where('id_sumber', $id)->delete();

            $hapus = $terimaBarang->delete();
            if ($hapus) {
                $buang = ProdukDiterima::where('id_terima_barang', $id)->get();

                foreach ($buang as $delete) {
                    SetHarga::where('id_set_harga', $delete->id)->where('sumber', 'Pembelian')->delete();
                    $delete->delete();
                }

                Jurnal::where('sumber', 'Pembelian')->where('id_sumber', $id)->delete();
            }
        }

        $this->render();
    }
}
