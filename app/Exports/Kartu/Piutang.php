<?php

namespace App\Exports\Kartu;

use Carbon\Carbon;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\FromView;

class Piutang implements FromView,WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    function  __construct(protected $mulaiId, protected $selesaiId, protected $pelangganId)
    {
        $this->mulaiId = $mulaiId;
        $this->selesaiId = $selesaiId;
        $this->pelangganId = $pelangganId;
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
        $hutang_pengguna = Pelanggan::where('id_perusahaan', Auth::user()->id_perusahaan)->has('piutang')->with(['piutang' => function ($q) {
            return $q->groupBy('sourceable_type')->groupBy('sourceable_id');
        }, 'piutang.sourceable', 'piutang.sourceable.piutang_pengguna', 'piutang.sourceable.piutang_pengguna.detailable'])->when($this->pelangganId, function ($q) {
            $q->where('id', $this->pelangganId);
        })
            ->when($this->selesaiId && $this->mulaiId, function ($query) {
                if ($this->mulaiId == $this->selesaiId) {
                    $query->whereHas('piutang', function ($query) {
                        $query->whereDate('created_at', $this->mulaiId);
                    });
                } else {
                    $finalEndDate = Carbon::createFromFormat('Y-m-d', $this->selesaiId)->endOfDay();
                    $finalStartDate = Carbon::createFromFormat('Y-m-d', $this->mulaiId)->startOfDay();
                    $query->whereHas('piutang', function ($query) use ($finalStartDate, $finalEndDate) {
                        $query->whereBetween('created_at', [$finalStartDate, $finalEndDate]);
                    });
                }
            })
            ->get();
        return view('excel.kartu_piutang', compact('hutang_pengguna'));
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

