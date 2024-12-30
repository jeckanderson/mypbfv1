<?php

namespace App\Livewire\Utilities\Pembelian;

use Carbon\Carbon;
use App\Models\Suplier;
use Livewire\Component;
use App\Models\Golongan;
use App\Models\Produsen;
use App\Models\Pelanggan;
use App\Models\Pembelian;
use App\Models\ObatBarang;
use App\Models\SPPembelian;
use App\Models\SubGolongan;
use App\Models\JenisObatBarang;
use App\Models\ProdukPembelian;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class Produks extends Component
{
    use WithPagination;
    public $mulaiId;
    public $selesaiId;
    public $produsenId;
    public $jenisId;
    public $golonganId;
    public $kategoriId;
    public $suplierId;
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

        $kategori = Golongan::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        $golongan = SubGolongan::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        $jenis = JenisObatBarang::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        $suplier = Suplier::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        $produsen = Produsen::where('id_perusahaan', Auth::user()->id_perusahaan)->get();

        $pembelian = ProdukPembelian::when($this->search, function ($query) {
            $query->whereHas('produk', function ($query) {
                $query->where('nama_obat_barang', 'like', '%' . $this->search . '%');
            });
        })
            ->when($this->kategoriId, function ($query) {
                $query->whereHas('produk', function ($query) {
                    $query->where('golongan', $this->kategoriId);
                });
            })
            ->when($this->golonganId, function ($query) {
                $query->whereHas('produk', function ($query) {
                    $query->where('sub_golongan', $this->golonganId);
                });
            })
            ->when($this->jenisId, function ($query) {
                $query->whereHas('produk', function ($query) {
                    $query->where('jenis_obat_barang', $this->jenisId);
                });
            })
            ->when($this->produsenId, function ($query) {
                $query->whereHas('produk', function ($query) {
                    $query->where('produsen', $this->produsenId);
                });
            })
            ->when($this->suplierId, function ($query) {
                $query->whereHas('pembelian', function ($query) {
                    $query->where('suplier', $this->suplierId);
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

            ->with('profile')
            ->paginate(10);

        return view('livewire.utilities.pembelian.produks', [
            'kategori' => $kategori,
            'golongan' => $golongan,
            'jenis' => $jenis,
            'suplier' => $suplier,
            'produsen' => $produsen,
            'pembelian' => $pembelian,
        ]);
    }
}
