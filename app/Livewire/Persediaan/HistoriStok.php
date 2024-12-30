<?php

namespace App\Livewire\Persediaan;

use App\Models\Gudang;
use App\Models\HistoryStok;
use App\Models\Rak;
use App\Models\SubRak;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class HistoriStok extends Component
{
    public $gudangs = [], $raks = [], $sub_rak = [];

    public $selectedGudang;
    public $selectedRak;
    public $selectedSubRak;
    public $cariProduk;

    public function render()
    {
        $historys = HistoryStok::query()
            ->where('id_perusahaan', Auth::user()->id_perusahaan)->groupBy('id_gudang', 'id_rak', 'id_sub_rak', 'id_produk')
            ->with('produk');;

        if ($this->cariProduk) {
            $historys->whereHas('produk', function ($query) {
                $query->where('nama_obat_barang', 'like', '%' . $this->cariProduk . '%');
            });
        }

        if ($this->selectedGudang) {
            $historys->where('id_gudang', $this->selectedGudang);
        }

        if ($this->selectedRak) {
            $historys->where('id_rak', $this->selectedRak);
        }

        if ($this->selectedSubRak) {
            $historys->where('id_sub_rak', $this->selectedSubRak);
        }

        $historys = $historys->get();

        return view('livewire.persediaan.histori-stok', [
            'historys' => $historys,
        ]);
    }

    public function mount()
    {
        $this->gudangs = Gudang::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        $this->raks = Rak::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        $this->sub_rak = SubRak::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
    }
}