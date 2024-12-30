<?php

namespace App\Livewire\Utilities\Pbf;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Golongan;
use App\Models\ObatBarang;
use Livewire\WithPagination;
use App\Models\JenisObatBarang;
use App\Models\ProdukPenjualan;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Pbf\DistribusiExport;
use App\Models\SubGolongan;

class Distribusi extends Component
{
    use WithPagination;
    public $mulaiId;

    public $jenisId;
    public $golonganId;
    public $search = '';

    protected $listeners = ['refreshTable' => '$refresh'];

    public function render()
    {
        // Set default mulaiId to the first day of the current month if not set
        if (!$this->mulaiId) {
            $this->mulaiId = Carbon::now()->format('Y-m-d');
        }

        $golongan = SubGolongan::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        $jenis = JenisObatBarang::all();

        // Build the query based on the filters
        $detail = ProdukPenjualan::where('id_penjualan', "!=", null)->when($this->search, function ($query) {
            $query->whereHas('produk', function ($query) {
                $query->where('nama_obat_barang', 'like', '%' . $this->search . '%');
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
            ->when($this->mulaiId, function ($query) {
                $bulan = \Carbon\Carbon::parse($this->mulaiId)->month;
                $tahun = \Carbon\Carbon::parse($this->mulaiId)->year;
                $query->whereHas('spPenjualan', function ($query) use ($bulan, $tahun) {
                    $query->whereMonth('tgl_sp', $bulan)
                        ->whereYear('tgl_sp', $tahun);
                });
            })

            ->with('penjualan', 'produk', 'profile', 'spPenjualan')
            ->paginate(10);

        // Return the view with the data
        return view('livewire.utilities.pbf.distribusi', [
            'golongan' => $golongan,
            'jenis' => $jenis,
            'detail' => $detail,
        ]);
    }

    public function exportExcel()
    {
        // Build the query for export based on the filters
        $query = ProdukPenjualan::when($this->search, function ($query) {
            $query->whereHas('produk', function ($query) {
                $query->where('nama_obat_barang', 'like', '%' . $this->search . '%');
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
            ->when($this->mulaiId, function ($query) {
                $bulan = \Carbon\Carbon::parse($this->mulaiId)->month;
                $tahun = \Carbon\Carbon::parse($this->mulaiId)->year;
                $query->whereHas('spPenjualan', function ($query) use ($bulan, $tahun) {
                    $query->whereMonth('tgl_sp', $bulan)
                        ->whereYear('tgl_sp', $tahun);
                });
            })
            ->with('penjualan', 'produk', 'profile', 'spPenjualan');

        // Export the data to Excel, passing both the query and mulaiId
        return Excel::download(new DistribusiExport($query, $this->mulaiId), 'Distribusi.xlsx');
    }
}
