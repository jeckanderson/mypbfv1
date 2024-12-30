<?php

namespace App\Livewire\Persediaan\StockOpname\Tambah;

use App\Models\Gudang;
use App\Models\HistoryStok;
use App\Models\ObatBarang;
use App\Models\Rak;
use App\Models\SubRak;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class TambahStokOpname extends Component
{
    use WithPagination;

    public $produks = [], $gudangs = [], $raks = [], $subRak = [];

    //filter
    public $selectedGudang, $selectedRak, $selectedSubRak, $cari;

    #[On('opname-created')]
    public function render()
    {
        $stokTerbaru = HistoryStok::select('id', DB::raw('MAX(id) as max_id'))
            ->where('keterangan', '!=', 'Penjualan')
            ->groupBy('id_produk', 'id_gudang', 'id_rak', 'id_sub_rak', 'no_batch')
            ->pluck('max_id');

        $stok = HistoryStok::whereIn('id', $stokTerbaru)
            ->when($this->selectedGudang, function ($query) {
                $query->where('id_gudang', $this->selectedGudang);
            })
            ->when($this->selectedRak, function ($query) {
                $query->where('id_rak', $this->selectedRak);
            })
            ->when($this->selectedSubRak, function ($query) {
                $query->where('id_sub_rak', $this->selectedSubRak);
            })
            ->when($this->cari, function ($query) {
                $query->whereHas('produk', function ($subQuery) {
                    $subQuery->where('nama_obat_barang', 'like', '%' . $this->cari . '%');
                });
            });

        return view('livewire.persediaan.stock-opname.tambah.tambah-stok-opname', [
            'historyStok' => $stok->get(),
        ]);
    }

    public function mount()
    {

        $perusahaanId = Auth::user()->id_perusahaan;

        $this->produks = ObatBarang::where('id_perusahaan', $perusahaanId)->get();
        $this->gudangs = Gudang::where('id_perusahaan', $perusahaanId)->get();
        $this->raks = Rak::where('id_perusahaan', $perusahaanId)->get();
        $this->subRak = SubRak::where('id_perusahaan', $perusahaanId)->get();
    }
}