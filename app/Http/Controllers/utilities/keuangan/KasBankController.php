<?php

namespace App\Http\Controllers\utilities\keuangan;

use Carbon\Carbon;




use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\DetailJurnalAkun;
use Illuminate\Routing\Controller;


class KasBankController extends Controller
{
    public function index()
    {
  
       
        return view('utilities.laporan.keuangan.kas-dan-bank.kas-dan-bank', [
            'title' => 'utilities',
        
   
           
        ]);
        
    }

    public function cetak_pdf(Request $request)
    {
        $detail = DetailJurnalAkun::when($request->search, function ($query) use ($request) {
                $query->where('no_reff', 'like', '%' . $request->search . '%');
            })
          
            ->when($request->selesaiId && $request->mulaiId, function ($query) use ($request) {
                $finalEndDate = Carbon::createFromFormat('Y-m-d', $request->selesaiId)->endOfDay();
                $finalStartDate = Carbon::createFromFormat('Y-m-d', $request->mulaiId)->startOfDay();
               
                    $query->whereBetween('created_at', [$finalStartDate, $finalEndDate]);
            
            })
        
            ->paginate(10);
    
        $pdf = PDF::loadView('pdf.utilities.keuangan.kas-dan-bank.pdf', [
            'detail' => $detail,
            'mulaiId' => $request->mulaiId,
            'selesaiId' => $request->selesaiId,
        ]);
    
        return $pdf->stream('kas-dan-bank.pdf');
    }
    

   
}