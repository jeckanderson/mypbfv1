<?php

namespace App\Livewire\Utilities\Produk;

use Livewire\Component;
use App\Models\Golongan;
use App\Models\Kelompok;
use App\Models\PPN;
use App\Models\Produsen;
use App\Models\Profile;
use App\Models\SetHarga;

use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Price extends Component
{
    use WithPagination;

    public $search = '';
    public $kelompokId;
    public $golonganId;
    public $produsenId;
    public $order;

    protected $listeners = ['refreshTable' => '$refresh'];


    public function render()
    {
        $kelompok = Kelompok::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        $golongan = Golongan::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        $produsen = Produsen::where('id_perusahaan', Auth::user()->id_perusahaan)->get();

        $q = SetHarga::select('id_perusahaan', 'id_produk', 'id_kelompok', 'id_set', 'satuan', 'harga_jual', DB::raw('max(created_at) as created'))
            ->groupBy('harga_jual')
            ->groupBy('satuan')
            ->groupBy('id_set')
            ->groupBy('id_kelompok')
            ->groupBy('id_produk')
            ->groupBy('id_perusahaan');
        // dd($q);

        $setHargaQuery = SetHarga::when($this->search, function ($query) {
            $query->whereHas('produk', function ($query) {
                $query->where('nama_obat_barang', 'like', '%' . $this->search . '%');
            });
        })
            ->when($this->kelompokId, function ($query) {
                $query->where('set_harga.id_kelompok', $this->kelompokId);
            })
            ->when($this->produsenId, function ($query) {
                $query->whereHas('produk', function ($query) {
                    $query->where('produsen', $this->produsenId);
                });
            })
            ->when($this->golonganId, function ($query) {
                $query->whereHas('produk', function ($query) {
                    $query->where('golongan', $this->golonganId);
                });
            })
            ->whereNotNull('sumber')
            ->when($this->kelompokId, function ($query) {
                $query->where('set_harga.id_kelompok', $this->kelompokId);
            })
            ->when($this->golonganId, function ($query) {
                $query->whereHas('produk', function ($query) {
                    $query->where('golongan', $this->golonganId);
                });
            })
            ->when($this->produsenId, function ($query) {
                $query->whereHas('produk', function ($query) {
                    $query->where('produsen', $this->produsenId);
                });
            });
        if ($this->order == 3) {
        } elseif ($this->order == 2) {
            $setHargaQuery->joinSub($q, 'subquery', function ($join) {
                $join->on('set_harga.harga_jual', '=', 'subquery.harga_jual')
                    ->on('set_harga.satuan', '=', 'subquery.satuan')
                    ->on('set_harga.id_set', '=', 'subquery.id_set')
                    ->on('set_harga.id_kelompok', '=', 'subquery.id_kelompok')
                    ->on('set_harga.id_produk', '=', 'subquery.id_produk')
                    ->on('set_harga.id_perusahaan', '=', 'subquery.id_perusahaan')
                    ->on('set_harga.created_at', '=', 'subquery.created');
            })->groupBy('set_harga.harga_jual')->groupBy('set_harga.satuan')
                ->groupBy('set_harga.id_set')
                ->groupBy('set_harga.id_kelompok')
                ->groupBy('set_harga.id_produk')
                ->groupBy('set_harga.id_perusahaan');
        } elseif ($this->order == 1) {
            $setHargaQuery->groupBy('set_harga.harga_jual')->groupBy('set_harga.satuan')
                ->groupBy('set_harga.id_set')
                ->groupBy('set_harga.id_kelompok')
                ->groupBy('set_harga.id_produk')
                ->groupBy('set_harga.id_perusahaan');
        }
        if ($this->order == 2) {
            $setHargaQuery->latest();
        } elseif ($this->order == 1) {
            $setHargaQuery->orderBy('created_at', 'asc');
        }
        $setHargaQuery = $setHargaQuery->paginate(10);

        return view('livewire.utilities.produk.price', [
            'kelompok' => $kelompok,
            'golongan' => $golongan,
            'produsen' => $produsen,
            'setharga' => $setHargaQuery,
            'order' => $this->order,
            'profile' => Profile::first(),
            'ppn' => PPN::where('id_perusahaan', Auth::user()->id_perusahaan)->first()->ppn
        ]);
    }

    public function updatingSearch()
    {

        $this->resetPage();
    }

    public function alert()
    {
        $this->js("alert('Foto perusahaan belum di setting, tambahkan foto perusahaan di menu profile!')");
    }
}