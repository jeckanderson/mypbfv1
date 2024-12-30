<?php

namespace App\Livewire\Utilities\Penjualan;

use App\Models\Pegawai;
use Carbon\Carbon;
use App\Models\Sales;
use Livewire\Component;
use App\Models\Pelanggan;
use App\Models\ProdukPenjualan;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class LabaProduk extends Component
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

        return view('livewire..utilities.penjualan.laba-produk', [
            'sales' => Pegawai::where('id_perusahaan', Auth::user()->id_perusahaan)->where('jabatan', 'sales')->get(),
            'pelanggan' => Pelanggan::where('id_perusahaan', Auth::user()->id_perusahaan)->get(),
            'detail' => ProdukPenjualan::when($this->search, function ($query) {
                $query->whereHas('penjualan', function ($query) {
                    $query->where('no_faktur', 'like', '%' . $this->search . '%');
                });
            })
                ->when($this->pelangganId, function ($query) {
                    $query->whereHas('penjualan', function ($query) {
                        $query->where('pelanggan', $this->pelangganId);
                    });
                })
                ->when($this->salesId, function ($query) {
                    $query->whereHas('penjualan', function ($query) {
                        $query->where('sales', $this->salesId);
                    });
                })

                ->when($this->selesaiId && $this->mulaiId, function ($query) {
                    $query->whereHas('penjualan', function ($query) {
                        $query->whereBetween('tgl_input', [
                            \Carbon\Carbon::parse($this->mulaiId)->startOfDay(),
                            \Carbon\Carbon::parse($this->selesaiId)->endOfDay()
                        ]);
                    });
                })


                ->when($this->pelangganId, function ($query) use ($defaultPelangganId) {
                    $query->whereHas('penjualan', function ($query) use ($defaultPelangganId) {
                        $query->where('pelanggan', $defaultPelangganId);
                    });
                })

                ->whereNotNull('id_penjualan')
                ->with('penjualan.getPelanggan', 'penjualan.getSales', 'produk')
                ->paginate(10),
        ]);
    }
}
