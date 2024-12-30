<?php

namespace App\Livewire\Utilities\Penjualan;

use App\Models\Pegawai;
use Carbon\Carbon;
use App\Models\Sales;
use Livewire\Component;
use App\Models\Pelanggan;
use App\Models\Penjualan;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class PerFaktur extends Component
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
        $pelanggan = Pelanggan::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        $sales = Pegawai::where('id_perusahaan', Auth::user()->id_perusahaan)->where('jabatan', 'sales')->get();
        $penjualan = Penjualan::when($this->search, function ($query) {

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
            ->when(
                $this->salesId,
                function ($query) {

                    $query->where('sales', $this->salesId);
                }
            )
            ->with('profile')
            ->groupBy('no_faktur')
            ->paginate(10);
        return view('livewire..utilities.penjualan.per-faktur', compact('sales', 'pelanggan', 'penjualan'));
    }
}
