<?php

namespace App\Livewire\Utilities\Penjualan;

use App\Models\Pegawai;
use Carbon\Carbon;
use App\Models\Sales;
use Livewire\Component;
use App\Models\Pelanggan;
use App\Models\Penjualan;
use App\Models\Pembayaran;
use App\Models\ProdukPenjualan;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class DetailPerFaktur extends Component
{
    use WithPagination;
    public $pembayaranId;
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

        $pelanggan = Pelanggan::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        $sales = Pegawai::where('id_perusahaan', Auth::user()->id_perusahaan)->where('jabatan', 'sales')->get();
        $defaultPelangganId = 1;
        $defaultSalesId = 1;
        intval($this->pembayaranId);
        return view('livewire.utilities.penjualan.detail-per-faktur', [

            'sales' => $sales,
            'pelanggan' => $pelanggan,
            'penjualan' => Penjualan::when($this->search, function ($query) {
                $query->where('no_faktur', 'like', '%' . $this->search . '%');
            })
                ->when($this->pelangganId, function ($query) {
                    $query->where('pelanggan', $this->pelangganId);
                })
                ->when($this->salesId, function ($query) {
                    $query->where('sales', $this->salesId);
                })
                ->when($this->pembayaranId, function ($query) {
                    $this->pembayaranId == 2 ? 0 : $this->pembayaranId;
                    $query->where('kredit', $this->pembayaranId);
                })

                ->when($this->selesaiId && $this->mulaiId, function ($query) {
                    $query->whereBetween('tgl_input', [
                        \Carbon\Carbon::parse($this->mulaiId)->startOfDay(),
                        \Carbon\Carbon::parse($this->selesaiId)->endOfDay()
                    ]);
                })->with('getPelanggan', 'getSales', 'produk_penjualan.produk', 'produk_penjualan', 'produk_penjualan.satuanProduk', 'profile')

                ->groupBy('no_faktur')
                ->paginate(10),
        ]);
    }
}
