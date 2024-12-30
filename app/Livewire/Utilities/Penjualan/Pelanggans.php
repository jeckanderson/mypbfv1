<?php

namespace App\Livewire\Utilities\Penjualan;

use App\Models\Pegawai;
use Carbon\Carbon;
use App\Models\Sales;
use Livewire\Component;
use App\Models\Pelanggan;
use App\Models\Penjualan;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class Pelanggans extends Component
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
        $defaultPelangganId = 1;
        $defaultSalesId = 1;

        $pelanggan = Pelanggan::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        $sales = Sales::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        $penjualan = Pelanggan::has('penjualan')->whereHas('penjualan', function ($q) {
            $q->whereBetween(DB::raw('DATE(tgl_faktur)'), [$this->mulaiId, $this->selesaiId]);
        })->paginate(10);
        return view('livewire..utilities.penjualan.pelanggans', [
            'sales' => $sales,
            'pelanggan' => $pelanggan,

            'penjualan' => $penjualan,
        ]);
    }
}
