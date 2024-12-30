<?php

namespace App\Livewire\Utilities\Pembelian;

use Carbon\Carbon;
use App\Models\Suplier;
use Livewire\Component;
use App\Models\Pelanggan;
use App\Models\SPPembelian;
use Livewire\WithPagination;
use App\Models\ProdukPembelian;
use Illuminate\Support\Facades\Auth;

class SpPembelians extends Component
{
    use WithPagination;
    public $mulaiId;
    public $selesaiId;
    public $spId;

    public $search = '';
    public $tipeId;

    protected $listeners = ['refreshTable' => '$refresh'];
    public function render()
    {

        if (!$this->mulaiId) {
            $this->mulaiId = Carbon::now()->firstOfMonth()->format('Y-m-d');
        }

        if (!$this->selesaiId) {
            $this->selesaiId = Carbon::now()->endOfMonth()->format('Y-m-d');
        }

        $suplier = Suplier::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        $pembelian = ProdukPembelian::with('produk', 'sp', 'pembelian', 'order')->get();
        $sps = SPPembelian::select('tipe_sp')->distinct()->get();
        return view('livewire..utilities.pembelian.sp-pembelians', [
            'sps' => $sps,
            'pembelian' => $pembelian,
            'suplier' => $suplier,
            'sp' => SPPembelian::when($this->search, function ($query) {
                $query->where('no_sp', $this->search);
            })
                ->when($this->spId, function ($query) {
                    $query->where('id_suplier', $this->spId);
                })
                ->when($this->tipeId, function ($query) {
                    if ($this->tipeId === 'SP. Reguler') {
                        $query->where('tipe_sp', 'REG');
                    } elseif ($this->tipeId === 'SP. OOT') {
                        $query->where('tipe_sp', 'OOT');
                    } elseif ($this->tipeId === 'SP. Prekursor') {
                        $query->where('tipe_sp', 'Prek');
                    } elseif ($this->tipeId === 'SP. Psikotropika') {
                        $query->where('tipe_sp', 'Psiko');
                    } elseif ($this->tipeId === 'SP. Narkotika') {
                        $query->where('tipe_sp', 'Narko');
                    }
                })

                ->when($this->selesaiId && $this->mulaiId, function ($query) {
                    $query->whereBetween('tgl_sp', [
                        \Carbon\Carbon::parse($this->mulaiId)->startOfDay(),
                        \Carbon\Carbon::parse($this->selesaiId)->endOfDay()
                    ]);
                })

                ->paginate(10),


        ]);
    }
}
