<?php

namespace App\Livewire\Utilities\Pembelian;

use Carbon\Carbon;
use App\Models\Suplier;
use Livewire\Component;
use App\Models\Pelanggan;
use App\Models\Pembelian;
use App\Models\Pembayaran;
use App\Models\SPPembelian;
use Livewire\WithPagination;
use App\Models\ProdukPembelian;
use Illuminate\Support\Facades\Auth;

class Supliers extends Component
{
    use WithPagination;

    public $mulaiId;
    public $selesaiId;
    public $spId;
    public $pembayaranId;
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
        $pelanggan = Pelanggan::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        $sp = Suplier::where('id_perusahaan', Auth::user()->id_perusahaan)->get();

        $pembelian = Pembelian::groupBy('suplier')->when($this->search, function ($query) {
            $query->where('no_faktur', 'like', '%' . $this->search . '%');
        })->when($this->spId, function ($query) {
            $query->where('suplier', $this->spId);
        })->when($this->selesaiId && $this->mulaiId, function ($query) {
            $query->whereBetween('tgl_input', [
                \Carbon\Carbon::parse($this->mulaiId)->startOfDay(),
                \Carbon\Carbon::parse($this->selesaiId)->endOfDay()
            ]);
        })->with('profile')->paginate(10);

        return view('livewire..utilities.pembelian.supliers', [
            'sp' => $sp,
            'pembelians' => $pembelian,
            'pelanggan' => $pelanggan,

        ]);
    }
}
