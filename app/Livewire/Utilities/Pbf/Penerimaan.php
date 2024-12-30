<?php

namespace App\Livewire\Utilities\Pbf;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Golongan;
use App\Models\ObatBarang;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\JenisObatBarang;
use App\Models\ProdukPembelian;
use App\Exports\pbf\PenerimaanExport;
use App\Models\SubGolongan;
use Illuminate\Support\Facades\Auth;

class Penerimaan extends Component
{
    use WithPagination;
    public $mulaiId;
    public $jenisId;
    public $golonganId;
    public $search = '';
    protected $listeners = ['refreshTable' => '$refresh'];

    public function render()
    {
        if (!$this->mulaiId) {
            $this->mulaiId = Carbon::now()->format('Y-m-d');
        }

        $golongan = SubGolongan::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        $jenis = JenisObatBarang::all();

        return view('livewire.utilities.pbf.penerimaan', [
            'golongan' => $golongan,
            'jenis' => $jenis,
            'kas' => ProdukPembelian::where('id_pembelian', "!=", null)->when($this->search, function ($query) {
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
                    $query->whereHas('Pembelian', function ($query) use ($bulan, $tahun) {
                        $query->whereMonth('tgl_input', $bulan)
                            ->whereYear('tgl_input', $tahun);
                    });
                })
                ->with('Pembelian')
                ->paginate(10),
        ]);
    }

    public function exportExcel()
    {
        // Build the query for export based on the filters
        $query =  ProdukPembelian::when($this->search, function ($query) {
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
                $query->whereHas('Pembelian', function ($query) use ($bulan, $tahun) {
                    $query->whereMonth('tgl_input', $bulan)
                        ->whereYear('tgl_input', $tahun);
                });
            })
            ->with('Pembelian');

        // Export the data to Excel, passing both the query and mulaiId
        return Excel::download(new PenerimaanExport($query, $this->mulaiId), 'Penerimaan.xlsx');
    }
}
