<?php

namespace App\Livewire\Utilities\Penjualan;

use App\Models\Pegawai;
use Carbon\Carbon;
use App\Models\Sales;
use Livewire\Component;
use App\Models\Pelanggan;
use App\Models\Penjualan;
use App\Models\ProdukPenjualan;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class LabaFaktur extends Component
{
    use WithPagination;

    public $salesId;
    public $mulaiId;
    public $selesaiId;
    public $search = '';
    public $pelangganId;

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
        $defaultSalesId = 1;

        return view('livewire.utilities.penjualan.laba-faktur', [
            'sales' => Pegawai::where('id_perusahaan', Auth::user()->id_perusahaan)->where('jabatan', 'sales')->get(),
            'pelanggan' => Pelanggan::where('id_perusahaan', Auth::user()->id_perusahaan)->get(),
            'detail' => Penjualan::when($this->search, function ($query) {
                $query->where('no_faktur', 'like', '%' . $this->search . '%');
            })
                ->when($this->pelangganId, function ($query) {
                    $query->where('pelanggan', $this->pelangganId);
                })
                ->when($this->salesId, function ($query) {
                    $query->where('sales', $this->salesId);
                })
                ->when($this->selesaiId && $this->mulaiId, function ($query) {
                    $query->whereBetween('tgl_input', [
                        \Carbon\Carbon::parse($this->mulaiId)->startOfDay(),
                        \Carbon\Carbon::parse($this->selesaiId)->endOfDay()
                    ]);
                })
                ->with('getPelanggan', 'getSales', 'produk_penjualan', 'produk_penjualan.satuanProduk')
                ->groupBy('id')
                ->paginate(10),
        ]);
    }
}
