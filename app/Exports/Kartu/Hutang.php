<?php

namespace App\Exports\Kartu;

use Carbon\Carbon;
use App\Models\Suplier;
use App\Models\Pelanggan;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class Hutang implements FromView,WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    function  __construct(protected $mulaiId, protected $selesaiId, protected $spId)
    {
        $this->mulaiId = $mulaiId;
        $this->selesaiId = $selesaiId;
        $this->spId = $spId;
    }
    public function view() : View
    {
        if (!$this->mulaiId) {
            $this->mulaiId = Carbon::now()->format('Y-m-d');
        }

        if (!$this->selesaiId) {
            $this->selesaiId = Carbon::now()->format('Y-m-d');
        }
        // $this->total = 0;
        $hutang_pengguna = Suplier::where('id_perusahaan', Auth::user()->id_perusahaan)->has('hutangs')->with(['hutangs' => function($q){
            return $q->groupBy('sourceable_type')->groupBy('sourceable_id');
        },'hutangs.sourceable','hutangs.sourceable.hutang_pengguna' ,'hutangs.sourceable.hutang_pengguna.detailable'])->when($this->spId, function ($q) {
            $q->where('id', $this->spId);
        })
        ->when($this->selesaiId && $this->mulaiId, function ($query) {
            if ($this->mulaiId == $this->selesaiId) {
                $query->whereHas('hutangs.sourceable', function ($query) {
                    $query->whereDate('tgl_faktur', $this->mulaiId);
                });
            } else {
                $finalEndDate = Carbon::createFromFormat('Y-m-d', $this->selesaiId)->endOfDay();
                $finalStartDate = Carbon::createFromFormat('Y-m-d', $this->mulaiId)->startOfDay();
                $query->whereHas('hutangs.sourceable', function ($query) use ($finalStartDate, $finalEndDate) {
                    $query->whereBetween('tgl_faktur', [$finalStartDate, $finalEndDate]);
                });
            }
        })
        ->get();
        return view('excel.kartu_hutang', compact('hutang_pengguna'));
    }
    public function styles(Worksheet $sheet)
    {
        // Get the highest row and column to apply styles to the entire sheet
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        $range = 'A1:' . $highestColumn . $highestRow;

        // Apply border styles to the range
        $sheet->getStyle($range)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ]);

        return [];
    }
}