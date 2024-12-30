<?php

namespace App\Livewire\Utilities\Pembelian;

use Carbon\Carbon;
use App\Models\Suplier;
use Livewire\Component;
use App\Models\SPPembelian;
use App\Models\ProdukPembelian;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class VsBeli extends Component
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


        return view('livewire..utilities.pembelian.vs-beli', [
            'suplier' => $suplier,
            'pembelian' => ProdukPembelian::when($this->search, function ($query) {
                $query->whereHas('pembelian', function ($query) {
                    $query->where('no_sp', 'like', '%' . $this->search . '%');
                });
            })
                ->when($this->spId, function ($query) {
                    $query->whereHas('sp', function ($query) {
                        $query->where('id_suplier', $this->spId);
                    });
                })
                ->when($this->tipeId, function ($query) {
                    $query->whereHas('sp', function ($query) {
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
                    });
                })
                ->when($this->selesaiId && $this->mulaiId, function ($query) {
                    $query->whereHas('sp', function ($query) {
                        $query->whereBetween('tgl_sp', [
                            \Carbon\Carbon::parse($this->mulaiId)->startOfDay(),
                            \Carbon\Carbon::parse($this->selesaiId)->endOfDay()
                        ]);
                    });
                })
                ->with('produk', 'sp')
                ->paginate(10),
        ]);
    }
}
