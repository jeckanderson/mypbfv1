<?php

namespace App\Http\Controllers\utilities\hutang;

use Carbon\Carbon;



use Illuminate\Http\Request;
use App\Models\HutangPengguna;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Routing\Controller;


class RekapHutangController extends Controller
{
    public function index()
    {
       
        return view('utilities.laporan.hutang.rekap-hutang.rekap-hutang', [
            'title' => 'utilities',
           
           
        ]);
        
    }

    public function cetak_pdf(Request $request)
    {
        $detail = HutangPengguna::when($request->search, function ($query) use ($request) {
                $query->whereHas('suplier', function ($query) use ($request) {
                    $query->where('nama_suplier', 'like', '%' . $request->search . '%');
                });
            })
            ->when($request->selesaiId && $request->mulaiId, function ($query) use ($request) {
                $finalEndDate = Carbon::createFromFormat('Y-m-d', $request->selesaiId)->endOfDay();
                $finalStartDate = Carbon::createFromFormat('Y-m-d', $request->mulaiId)->startOfDay();
                $query->whereHas('pembelian', function ($query) use ($finalStartDate, $finalEndDate) {
                    $query->whereBetween('tgl_input', [$finalStartDate, $finalEndDate]);
                });
            })
            ->with('suplier', 'pembelian','profile')
            ->paginate(10);
    
        $pdf = PDF::loadView('pdf.utilities.hutang.rekap-hutang.pdf', [
            'detail' => $detail,
            'mulaiId' => $request->mulaiId,
            'selesaiId' => $request->selesaiId,
        ]);
    
        return $pdf->stream('rekap-hutang.pdf');
    }
    

    
}