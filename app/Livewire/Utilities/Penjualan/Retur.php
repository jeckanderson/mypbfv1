<?php

namespace App\Livewire\Utilities\Penjualan;

use Carbon\Carbon;
use App\Models\Sales;
use Livewire\Component;
use App\Models\Pelanggan;
use App\Models\ReturPenjualan;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class Retur extends Component
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
        $pelanggan = Pelanggan::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        $sales = Sales::where('id_perusahaan', Auth::user()->id_perusahaan)->get();

        $retur = ReturPenjualan::when($this->search, function ($query) {
            $query->whereHas('history.produk', function ($query) {
                $query->where('nama_obat_barang', 'like', '%' . $this->search . '%');
            });
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
            ->with('getPelanggan', 'getSales', 'history')
            ->get();
        return view('livewire.utilities.penjualan.retur', [
            'sales' => $sales,
            'pelanggan' => $pelanggan,
            'retur' => $retur,
        ]);
    }
}
