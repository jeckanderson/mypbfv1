<?php

namespace App\Livewire\Persediaan\StockOpname;

use App\Models\Gudang;
use App\Models\HistoryStok;
use App\Models\Jurnal;
use App\Models\ObatBarang;
use App\Models\Rak;
use App\Models\StokOpname;
use App\Models\SubRak;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Opname extends Component
{
    public $produks = [], $gudangs = [], $raks = [], $subRak = [];

    protected $listeners = ['refresh' => 'render'];

    //filter
    public $selectedGudang, $selectedRak, $selectedSubRak, $selectedSO, $cari;

    public function render()
    {
        $stok = StokOpname::where('id_perusahaan', Auth::user()->id_perusahaan);

        if ($this->cari) {
            $stok->whereHas('produk', function ($query) {
                $query->where('nama_obat_barang', 'like', '%' . $this->cari . '%');
            });
        }

        if ($this->selectedGudang) {
            $stok->where('gudang', $this->selectedGudang);
        }
        if ($this->selectedRak) {
            $stok->where('rak', $this->selectedRak);
        }
        if ($this->selectedSubRak) {
            $stok->where('sub_rak', $this->selectedSubRak);
        }

        if ($this->selectedSO) {
            $stok->where('tgl_so', $this->selectedSO);
        }

        return view('livewire.persediaan.stock-opname.opname', [
            'stokOpname' => $stok->paginate(10)
        ]);
    }

    public function mount()
    {
        $this->produks = ObatBarang::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        $this->gudangs = Gudang::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        $this->raks = Rak::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        $this->subRak = SubRak::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
    }

    public function hapusOpname($id)
    {
        $hapus = StokOpname::find($id);
        if ($hapus) {
            HistoryStok::where('id_perusahaan', Auth::user()->id_perusahaan)->where('id', $hapus->id_histori)->delete();
            Jurnal::where('sumber', 'Stok Opname')->where('id_sumber', $id)->where('id_perusahaan', Auth::user()->id_perusahaan)->delete();
            $hapus->delete();
            $this->render();
        }
    }
}
