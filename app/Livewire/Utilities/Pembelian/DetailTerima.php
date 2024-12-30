<?php

namespace App\Livewire\Utilities\Pembelian;

use Carbon\Carbon;
use App\Models\Suplier;
use Livewire\Component;
use App\Models\TerimaBarang;
use Illuminate\Support\Facades\Auth;



class DetailTerima extends Component
{
    public $mulaiId;
    public $selesaiId;
    public $spId;
    public $search = '';

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

        return view('livewire..utilities.pembelian.detail-terima', [
            'suplier' => $suplier,
            'terima' => TerimaBarang::when($this->search, function ($query) {
                $query->where('no_faktur', 'like', '%' . $this->search . '%');
            })
                ->when($this->spId, function ($query) {
                    $query->whereHas('pembelian', function ($query) {
                        $query->where('suplier', $this->spId);
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
                ->when($this->spId, function ($query) {
                    $query->whereHas('pembelian', function ($query) {
                        $query->where('suplier', $this->spId);
                    });
                })
                ->paginate(10),
        ]);
    }
}
