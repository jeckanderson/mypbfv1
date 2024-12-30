<?php

namespace App\Http\Controllers\utilities\pbf;

use Carbon\Carbon;




use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\DetailJurnalAkun;
use Illuminate\Routing\Controller;


class ReportPBFController extends Controller
{
    public function index()
    {
  
       
        return view('utilities.laporan.pbf.report-pbf.report-pbf', [
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
               
                    $query->whereBetween('tgl_input', [$finalStartDate, $finalEndDate]);
            
            })
        
            ->paginate(10);
    
        $pdf = PDF::loadView('pdf.utilities.pbf.report-pbf.pdf', [
            'detail' => $detail,
            'mulaiId' => $request->mulaiId,
            'selesaiId' => $request->selesaiId,
        ]);
    
        return $pdf->stream('report-pbf.pdf');
    }
    

   
}