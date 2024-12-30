<?php

namespace App\Livewire\Utilities\Pembelian;

use Carbon\Carbon;
use App\Models\Suplier;
use Livewire\Component;
use App\Models\Pelanggan;
use App\Models\Pembelian;
use App\Models\SPPembelian;
use Livewire\WithPagination;
use App\Models\ProdukPembelian;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Estimasi extends Component
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


        $defaultSalesId = 1;
        $defaultTipeId = "SP. Regular";
        $defaultSumberId = "Website";
        $suplier = Suplier::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        // $pembelian = ProdukPembelian::with('produk', 'sp')->get();


        $pembelians = SPPembelian::has('produk_pembelian')->when($this->search, function ($query) {
            $query->whereHas('produk_pembelian.produk', function ($query) {
                $query->where('nama_obat_barang', 'like', '%' . $this->search . '%');
            });
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
                $query->whereBetween(DB::raw('DATE(tgl_sp)'), [$this->mulaiId, $this->selesaiId]);
            })
            ->groupBy()
            ->paginate(10);

        return view('livewire..utilities.pembelian.estimasi', [
            'suplier' => $suplier,
            'pembelians' => $pembelians
        ]);
    }
}
