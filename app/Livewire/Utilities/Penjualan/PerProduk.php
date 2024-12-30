<?php

namespace App\Livewire\Utilities\Penjualan;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Golongan;
use App\Models\Produsen;
use App\Models\Penjualan;

use App\Models\SubGolongan;
use Livewire\WithPagination;
use App\Models\JenisObatBarang;
use App\Models\ProdukPenjualan;
use Illuminate\Support\Facades\Auth;

class PerProduk extends Component
{
    use WithPagination;
    public $mulaiId;
    public $selesaiId;
    public $produsenId;
    public $jenisId;
    public $golonganId;
    public $kategoriId;

    public $search = '';


    public function render()
    {

        if (!$this->mulaiId) {
            $this->mulaiId = Carbon::now()->startOfMonth()->format('Y-m-d');
        }

        if (!$this->selesaiId) {
            $this->selesaiId = Carbon::now()->endOfMonth()->format('Y-m-d');
        }
        $defaultKategoriId = 1;
        $defaultGolonganId = 1;
        $defaultJenisId = 1;
        $defaultProdusenId = 1;
        $kategori = Golongan::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        $golongan = SubGolongan::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        $jenis = JenisObatBarang::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        $produsen = Produsen::where('id_perusahaan', Auth::user()->id_perusahaan)->get();

        return view('livewire..utilities.penjualan.per-produk', [
            'kategori' => $kategori,
            'golongan' => $golongan,
            'produsen' => $produsen,
            'jenis' => $jenis,
            'detail' => ProdukPenjualan::when($this->search, function ($query) {
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

                ->when($this->selesaiId && $this->mulaiId, function ($query) {
                    $query->whereHas('penjualan', function ($query) {
                        $query->whereBetween(
                            'tgl_input',
                            [
                                \Carbon\Carbon::parse($this->mulaiId)->startOfDay(),
                                \Carbon\Carbon::parse($this->selesaiId)->endOfDay()
                            ]
                        );
                    });
                })

                ->with('produk.kelompok', 'produk.produsenProduk', 'produk.golonganProduk')
                ->paginate(10),
        ]);
    }
}
