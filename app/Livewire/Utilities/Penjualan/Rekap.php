<?php

namespace App\Livewire\Utilities\Penjualan;

use Carbon\Carbon;
use App\Models\Sales;
use Livewire\Component;
use App\Models\SubRayon;
use App\Models\AreaRayon;
use App\Models\Pelanggan;
use App\Models\Penjualan;
use App\Models\Pembayaran;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;


class Rekap extends Component
{
    use WithPagination;
    public $salesId;
    public $mulaiId;
    public $selesaiId;
    public $arearayonId, $pembayaranId;
    public $subrayonId;
    public $supervisorId;
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
        $sales = Sales::where('id_perusahaan', Auth::user()->id_perusahaan)->groupBy('sales')->get();
        $spv = Sales::where('id_perusahaan', Auth::user()->id_perusahaan)->groupBy('supervisor')->get();
        $subrayon = SubRayon::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        $arearayon = AreaRayon::where('id_perusahaan', Auth::user()->id_perusahaan)->get();

        intval($this->pembayaranId);
        return view('livewire.utilities.penjualan.rekap', [
            'spv' => $spv,
            'arearayon' => $arearayon,
            'subrayon' => $subrayon,
            'sales' => $sales,
            'pelanggan' => $pelanggan,


            'penjualan' => Penjualan::when($this->search, function ($query) {
                $query->whereHas('getPelanggan', function ($query) {
                    $query->where('nama', 'like', '%' . $this->search . '%');
                });
            })
                ->when($this->pelangganId, function ($query) {
                    $query->where('pelanggan', $this->pelangganId);
                })
                ->when($this->salesId, function ($query) {
                    $query->where('sales', $this->salesId);
                })
                ->when($this->pembayaranId, function ($query) {
                    $this->pembayaranId = $this->pembayaranId == 2 ? 0 : $this->pembayaranId;
                    $query->where('kredit', $this->pembayaranId);
                })
                ->when($this->arearayonId, function ($query) {
                    $query->whereHas('getPelanggan', function ($query) {
                        $query->where('area_rayon', $this->arearayonId);
                    });
                })
                ->when($this->subrayonId, function ($query) {
                    $query->whereHas('getPelanggan', function ($query) {
                        $query->where('sub_rayon', $this->subrayonId);
                    });
                })
                ->when($this->supervisorId, function ($query) {
                    $query->whereHas('getPelanggan', function ($query) {
                        $query->where('supervisor', $this->supervisorId);
                    });
                })
                ->when($this->selesaiId && $this->mulaiId, function ($query) {
                    $query->whereBetween('tgl_input', [
                        \Carbon\Carbon::parse($this->mulaiId)->startOfDay(),
                        \Carbon\Carbon::parse($this->selesaiId)->endOfDay()
                    ]);
                })


                ->with('profile')
                ->paginate(10),
        ]);
    }
}
