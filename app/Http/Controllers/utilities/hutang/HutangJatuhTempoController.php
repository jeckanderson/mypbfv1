<?php

namespace App\Http\Controllers\utilities\hutang;

use Carbon\Carbon;


use Illuminate\Http\Request;
use App\Models\HutangPengguna;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Routing\Controller;


class HutangJatuhTempoController extends Controller
{
    public function index()
    {
       
        return view('utilities.laporan.hutang.hutang-jatuh-tempo.hutang-jatuh-tempo', [
            'title' => 'utilities',
        
           
        ]);
        
    }

    public function cetak_pdf(Request $request)
    {
        $detail = HutangPengguna::when($request->search, function ($query) use ($request) {
            $query->whereHas('pembelian', function ($query) use ($request) {
                $query->where('no_faktur', 'like', '%' . $request->search . '%');
            });
        })
        ->when($request->spId, function ($query) use ($request) {
            $query->where('id_suplier', 'like', '%' . $request->spId . '%');
        })
        ->when($request->selesaiId && $request->mulaiId, function ($query) use ($request) {
            $finalEndDate = Carbon::createFromFormat('Y-m-d', $request->selesaiId)->endOfDay();
            $finalStartDate = Carbon::createFromFormat('Y-m-d', $request->mulaiId)->startOfDay();
            $query->whereHas('pembelian', function ($query) use ($finalStartDate, $finalEndDate) {
                $query->whereBetween('tgl_input', [$finalStartDate, $finalEndDate]);
            });
        })
        ->with('profile', 'bayar', 'pembelian')
        ->paginate(10);
    
        $pdf = PDF::loadView('pdf.utilities.hutang.hutang-jatuh-tempo.pdf', [
            'detail' => $detail,
            'mulaiId' => $request->mulaiId,
            'selesaiId' => $request->selesaiId,
        ]);
    
        return $pdf->stream('hutang-jatuh-tempo.pdf');
    }
    
    
}