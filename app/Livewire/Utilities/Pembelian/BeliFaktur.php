<?php

namespace App\Livewire\Utilities\Pembelian;

use Carbon\Carbon;
use App\Models\Suplier;
use Livewire\Component;
use App\Models\Pembelian;
use App\Models\Pembayaran;
use App\Models\SPPembelian;
use Livewire\WithPagination;
use App\Models\ProdukPembelian;
use Illuminate\Support\Facades\Auth;

class BeliFaktur extends Component
{
    use WithPagination;
    public $mulaiId;
    public $selesaiId;
    public $spId;


    public $search = '';
    public $pembayaranId;

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


        return view('livewire..utilities.pembelian.beli-faktur', [

            'suplier' => $suplier,

            'pembelians' => Pembelian::when($this->search, function ($query) {
                $query->where('no_faktur', 'like', '%' . $this->search . '%');
            })->when($this->spId, function ($query) {
                $query->where('suplier', $this->spId);
            })->when($this->pembayaranId, function ($query) {
                $query->where('kredit', $this->pembayaranId);
            })->when($this->mulaiId && $this->selesaiId, function ($query) {
                $query->whereBetween('tgl_input', [
                    \Carbon\Carbon::parse($this->mulaiId)->startOfDay(),
                    \Carbon\Carbon::parse($this->selesaiId)->endOfDay()
                ]);
            })->paginate(10),
        ]);
    }
}
