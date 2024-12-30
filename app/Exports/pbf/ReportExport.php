<?php

namespace App\Exports\Pbf;

use App\Models\Profile;
use Maatwebsite\Excel\Concerns\FromView;

class ReportExport implements FromView
{
    protected $search;
    protected $jenisId;
    protected $golonganId;
    protected $mulaiId;
    protected $sampaiId;

    public function __construct($search, $jenisId, $golonganId, $mulaiId, $sampaiId)
    {
        $this->search = $search;
        $this->jenisId = $jenisId;
        $this->golonganId = $golonganId;
        $this->mulaiId = $mulaiId;
        $this->sampaiId = $sampaiId;
    }

    public function view(): \Illuminate\Contracts\View\View
    {
        // Apply filters based on the parameters passed from the Livewire component
        $historys = \App\Models\HistoryStok::when($this->search, function ($query) {
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
                    \Carbon\Carbon::parse($this->mulaiId . '-01')->startOfMonth(),
                    \Carbon\Carbon::parse($this->sampaiId . '-01')->endOfMonth(),
                ]);
            })
            ->get();

        // Return the view with the filtered data
        return view('excel.pbf.report-pbf.excel', [
            'historys' => $historys,
            'mulaiId' =>     \Carbon\Carbon::parse($this->mulaiId . '-01')->startOfMonth(),
            'selesaiId' =>  \Carbon\Carbon::parse($this->sampaiId . '-01')->endOfMonth(),
            'profile' => Profile::first()
        ]);
    }
}
