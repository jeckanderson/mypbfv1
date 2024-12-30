<?php

namespace App\Livewire\Utilities\Produk;

use Carbon\Carbon;
use App\Models\Gudang;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Golongan;
use App\Models\Produsen;
use App\Models\HistoryStok;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Exp extends Component
{
    use WithPagination;
    public $search = '';
    public $kategoriId;
    public $gudangId;
    public $produsenId;
    public $mulaiId;
    public $selesaiId;


    protected $listeners = ['refreshTable' => '$refresh'];

    public function render()
    {
        if (!$this->mulaiId) {
            $this->mulaiId = now()->format('Y-m-d');
        }

        if (!$this->selesaiId) {
            $this->selesaiId = now()->format('Y-m-d');
        }
        $defaultCategoryId = 1;
        $kategori = Golongan::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        $gudang = Gudang::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        $produsen = Produsen::where('id_perusahaan', Auth::user()->id_perusahaan)->get();

        $stokTerbaru = HistoryStok::select('id', DB::raw('MAX(id) as max_id'))
            ->where('keterangan', '!=', 'Penjualan')
            ->where('keterangan', '!=', 'Retur Pembelian')
            ->groupBy('id_produk', 'id_gudang', 'id_rak', 'id_sub_rak', 'no_batch', 'no_reff')
            ->pluck('max_id');
        $historystok = HistoryStok::whereIn('id', $stokTerbaru)->where('sumber_set_harga', '!=', '')
            ->when($this->search, function ($query) {
                $query->whereHas('produk', function ($query) {
                    $query->where('nama_obat_barang', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->kategoriId, function ($query) {
                $query->whereHas('produk', function ($query) {
                    $query->where('golongan', $this->kategoriId);
                });
            })
            ->when($this->produsenId, function ($query) {
                $query->whereHas('produk', function ($query) {
                    $query->where('produsen', $this->produsenId);
                });
            })
            ->when($this->gudangId, function ($query) {
                $query->where('id_gudang', $this->gudangId);
            })

            ->when($this->selesaiId && $this->mulaiId, function ($query) {
                $query->whereBetween('exp_date', [$this->mulaiId, $this->selesaiId]);
            })

            ->when(!$this->kategoriId, function ($query) use ($defaultCategoryId) {
                $query->whereHas('produk', function ($query) use ($defaultCategoryId) {
                    $query->where('golongan', $defaultCategoryId);
                });
            })
            
            ->orderBy('id')
            // ->groupBy('id_gudang', 'id_rak', 'id_sub_rak', 'no_batch', 'exp_date')
            ->with('profile')
            ->paginate(10);

        return view('livewire.utilities.produk.exp', [
            'kategori' => $kategori,
            'gudang' => $gudang,
            'produsen' => $produsen,
            'mulaiId' => $this->mulaiId,
            'selesaiId' => $this->selesaiId,
            'historystok' => $historystok,
        ]);
    }


    public function updatingSearch()
    {

        $this->resetPage();
    }
}
