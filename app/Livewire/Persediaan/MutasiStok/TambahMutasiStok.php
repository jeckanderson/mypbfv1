<?php

namespace App\Livewire\Persediaan\MutasiStok;

use App\Models\Gudang;
use App\Models\HistoryStok;
use App\Models\ObatBarang;
use App\Models\ProdukDiterima;
use App\Models\Rak;
use App\Models\StokAwal;
use App\Models\SubRak;
use App\Models\TerimaBarang;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\On;

class TambahMutasiStok extends Component
{
    use WithPagination;

    public $produks = [], $gudangs = [], $raks = [], $subRak = [], $stokAwal = [], $pembelians = [];

    //filter
    public $selectedGudang, $selectedRak, $selectedSubRak;

    #[On('mutasi-created')]
    public function render()
    {
        $stokTerbaru = HistoryStok::select('id', DB::raw('MAX(id) as max_id'))
            ->where('keterangan', '!=', 'Penjualan')
            ->groupBy('id_produk', 'id_gudang', 'id_rak', 'id_sub_rak', 'no_batch')
            ->pluck('max_id');

        $stok = HistoryStok::whereIn('id', $stokTerbaru);

        if ($this->selectedGudang) {
            $stok->where('id_gudang', $this->selectedGudang);
        }
        if ($this->selectedRak) {
            $stok->where('id_rak', $this->selectedRak);
        }
        if ($this->selectedSubRak) {
            $stok->where('id_sub_rak', $this->selectedSubRak);
        }

        return view('livewire.persediaan.mutasi-stok.tambah-mutasi-stok', [
            'historyStok' => $stok->get(),
        ]);
    }

    public function mount()
    {
        $this->produks = ObatBarang::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        $this->gudangs = Gudang::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        $this->raks = Rak::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        $this->subRak = SubRak::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        $this->stokAwal = StokAwal::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        $this->pembelians = ProdukDiterima::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
    }
}
