<?php

namespace App\Http\Controllers\utilities\piutang;

use Carbon\Carbon;



use Illuminate\Http\Request;
use App\Models\PiutangPengguna;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Routing\Controller;


class RekapPiutangController extends Controller
{
    public function index()
    {
       
        return view('utilities.laporan.piutang.rekap-piutang.rekap-piutang', [
            'title' => 'utilities',
           
           
        ]);
        
    }

    public function cetak_pdf(Request $request)
    {
        $detail = PiutangPengguna::when($request->search, function ($query) use ($request) {
                $query->whereHas('getPelanggan', function ($query) use ($request) {
                    $query->where('nama', 'like', '%' . $request->search . '%');
                });
            })
            ->when($request->selesaiId && $request->mulaiId, function ($query) use ($request) {
                $finalEndDate = Carbon::createFromFormat('Y-m-d', $request->selesaiId)->endOfDay();
                $finalStartDate = Carbon::createFromFormat('Y-m-d', $request->mulaiId)->startOfDay();
                $query->whereHas('penjualan', function ($query) use ($finalStartDate, $finalEndDate) {
                    $query->whereBetween('tgl_input', [$finalStartDate, $finalEndDate]);
                });
            })
            ->with('getPelanggan','profile')
            ->paginate(10);
    
        $pdf = PDF::loadView('pdf.utilities.piutang.rekap-piutang.pdf', [
            'detail' => $detail,
            'mulaiId' => $request->mulaiId,
            'selesaiId' => $request->selesaiId,
        ]);
    
        return $pdf->stream('rekap-piutang.pdf');
    }
    
    

    
}