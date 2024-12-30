<?php

namespace App\Livewire\Utilities\Pembelian;

use App\Models\Pembelian;
use Carbon\Carbon;
use App\Models\Suplier;
use Livewire\Component;
use App\Models\Pembayaran;
use Livewire\WithPagination;
use App\Models\ProdukPembelian;
use Illuminate\Support\Facades\Auth;


class DetailFaktur extends Component
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
        $defaultSpId = 1;
        $suplier = Suplier::where('id_perusahaan', Auth::user()->id_perusahaan)->get();

        return view('livewire..utilities.pembelian.detail-faktur', [
            'suplier' => $suplier,
            'produk' => Pembelian::when($this->search, function ($query) {
                $query->where('no_faktur', 'like', '%' . $this->search . '%');
            })
                ->when($this->spId, function ($query) {
                    $query->where('suplier', $this->spId);
                })
                ->when($this->selesaiId && $this->mulaiId, function ($query) {
                    $query->whereBetween('tgl_input', [
                        \Carbon\Carbon::parse($this->mulaiId)->startOfDay(),
                        \Carbon\Carbon::parse($this->selesaiId)->endOfDay()
                    ]);
                })
                ->with('produkPembelian', 'produkPembelian.produk')
                ->paginate(10),
        ]);
    }
}
