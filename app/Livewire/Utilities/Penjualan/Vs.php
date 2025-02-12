<?php

namespace App\Livewire\Utilities\Penjualan;

use Carbon\Carbon;
use App\Models\Sales;
use App\Models\Pegawai;
use Livewire\Component;
use App\Models\Pelanggan;
use App\Models\SPPenjualan;
use App\Models\ProdukPenjualan;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class Vs extends Component
{
    use WithPagination;
    public $salesId;
    public $mulaiId;
    public $selesaiId;
    public $search = '';
    public $pelangganId;
    public $spId;
    public $sumberId;
    protected $listeners = ['refreshTable' => '$refresh'];

    public function render()
    {
        if (!$this->mulaiId) {
            $this->mulaiId = Carbon::now()->startOfMonth()->format('Y-m-d');
        }

        if (!$this->selesaiId) {
            $this->selesaiId = Carbon::now()->endOfMonth()->format('Y-m-d');
        }

        $defaultPelangganId = 1;

        $pelanggan = Pelanggan::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        $sales = Pegawai::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        $produkpenjualan = SPPenjualan::with('produkPenjualan', 'produkPenjualan.produk', 'produkPenjualan.satuanProduk')
            ->when($this->search, function ($query) {
                $query->where('no_sp', $this->search);
            })
            ->when($this->pelangganId, function ($query) {
                $query->where('pelanggan', $this->pelangganId);
            })
            ->when($this->salesId, function ($query) {
                $query->where('sales', $this->salesId);
            })
            ->when($this->spId, function ($query) {
                $query->where('tipe_sp', $this->spId);
            })
            ->when($this->sumberId, function ($query) {
                $query->where('sumber', $this->sumberId);
            })
            ->when($this->selesaiId && $this->mulaiId, function ($query) {
                $query->whereBetween('tgl_sp', [
                    $this->mulaiId,
                    $this->selesaiId
                ]);
            })
            ->when($this->pelangganId, function ($query) {
                $query->where('pelanggan', $this->pelangganId);
            })
            ->get();
        return view('livewire.utilities.penjualan.vs', [
            'sales' => $sales,
            'pelanggan' => $pelanggan,
            'produkpenjualan' => $produkpenjualan,
        ]);
    }
}
