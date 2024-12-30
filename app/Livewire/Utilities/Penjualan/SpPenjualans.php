<?php

namespace App\Livewire\Utilities\Penjualan;

use Carbon\Carbon;
use App\Models\Sales;
use Livewire\Component;
use App\Models\Pelanggan;
use App\Models\SPPenjualan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class SpPenjualans extends Component
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
            $this->mulaiId = Carbon::now()->firstOfMonth()->format('Y-m-d');
        }

        if (!$this->selesaiId) {
            $this->selesaiId = Carbon::now()->endOfMonth()->format('Y-m-d');
        }
        $pelanggan = Pelanggan::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        $sales = Sales::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        $sp = SPPenjualan::where('id_perusahaan', Auth::user()->id_perusahaan)->get();

        $defaultSalesId = 1;
        $defaultTipeId = "SP. Regular";
        $defaultSumberId = "Website";

        $sppenjualan = SPPenjualan::query()
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
                if ($this->spId === 'SP. Reguler') {
                    $query->where('tipe_sp', 'SP. Reguler');
                } elseif ($this->spId === 'SP. OOT') {
                    $query->where('tipe_sp', 'SP. OOT');
                } elseif ($this->spId === 'SP. Prekursor') {
                    $query->where('tipe_sp', 'SP. Prekursor');
                } elseif ($this->spId === 'SP. Psikotropika') {
                    $query->where('tipe_sp', 'SP. Psikotropika');
                } elseif ($this->spId === 'SP. Narkotika') {
                    $query->where('tipe_sp', 'SP. Narkotika');
                }
            })
            ->when($this->sumberId, function ($query) {
                if ($this->sumberId === 'Website') {
                    $query->where('sumber', 'Website');
                } elseif ($this->sumberId === 'Mobile') {
                    $query->where('sumber', 'Mobile');
                }
            })
            ->when($this->selesaiId && $this->mulaiId, function ($query) {
                $query->whereBetween(DB::raw('DATE(tgl_sp)'), [$this->mulaiId, $this->selesaiId]);
            })

            ->when($this->pelangganId, function ($query) {

                $query->where('pelanggan', $this->pelangganId);
            })
            //     ->when(!$this->salesId, function ($query) use ($defaultSalesId) {

            //         $query->where('sales', $defaultSalesId);

            // })
            //     ->when(!$this->spId, function ($query) use ($defaultTipeId) {

            //         $query->where('tipe_sp', $defaultTipeId);

            // })
            // ->when(!$this->sumberId, function ($query) use ($defaultSumberId) {

            //     $query->where('sumber', $defaultSumberId);

            // })
            ->with('pelangganPenjualan', 'salesPenjualan')
            ->get();

        return view('livewire.utilities.penjualan.sp-penjualans', [
            'sales' => $sales,
            'pelanggan' => $pelanggan,
            'sppenjualan' => $sppenjualan,
            'sp' => $sp,
        ]);
    }
    public function updatingSearch()
    {

        $this->resetPage();
    }
}
