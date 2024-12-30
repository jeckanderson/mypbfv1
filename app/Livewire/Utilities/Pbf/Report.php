<?php

namespace App\Livewire\Utilities\Pbf;

use App\Exports\Pbf\ReportExport;
use Livewire\Component;
use App\Models\HistoryStok;
use App\Models\JenisObatBarang;
use App\Models\SubGolongan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Livewire\WithPagination;

class Report extends Component
{
    use WithPagination;
    public $mulaiId;
    public $sampaiId;

    public $jenisId;
    public $golonganId;
    public $search = '';

    protected $listeners = ['refreshTable' => '$refresh'];

    public function render()
    {
        $golongan = SubGolongan::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        $jenis = JenisObatBarang::all();


        $historys = HistoryStok::when($this->search, function ($query) {
            $query->whereHas('produk', function ($query) {
                $query->where('nama_obat_barang', 'like', '%' . $this->search . '%');
            });
        })
            ->when($this->jenisId, function ($query) {
                $query->whereHas('produk', function ($query) {
                    $query->where('jenis_obat_barang', $this->jenisId);
                });
            })
            ->when($this->golonganId, function ($query) {
                $query->whereHas('produk', function ($query) {
                    $query->where('sub_golongan', $this->golonganId);
                });
            })
            ->when($this->mulaiId && $this->sampaiId, function ($query) {
                $query->whereBetween('created_at', [
                    Carbon::parse($this->mulaiId . '-01')->startOfMonth(),
                    Carbon::parse($this->sampaiId . '-01')->endOfMonth(),
                ]);
            })
            ->paginate(20);

        return view('livewire.utilities.pbf.report', [
            'golongan' => $golongan,
            'jenis' => $jenis,
            'historys' => $historys
        ]);
    }

    public function export()
    {
        return Excel::download(new ReportExport(
            $this->search,
            $this->jenisId,
            $this->golonganId,
            $this->mulaiId,
            $this->sampaiId
        ), 'e-report.xlsx');
    }
}
