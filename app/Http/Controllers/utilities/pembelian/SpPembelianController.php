<?php

namespace App\Http\Controllers\utilities\pembelian;


use Carbon\Carbon;


use App\Models\SPPembelian;
use Illuminate\Http\Request;
use App\Models\ReturPembelian;
use App\Models\ReturPenjualan;
use App\Models\ProdukPembelian;
use App\Models\ProdukPenjualan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class SpPembelianController extends Controller
{
    public function index()
    {
       

        return view('utilities.laporan.pembelian.sp-pembelian.sp-pembelian', [
            'title' => 'utilities',
           
        ]);
        
    }

    public function cetak_pdf(Request $request)
    {
        $detail =  SPPembelian::when($request->search, function ($query) use ($request) {
                $query->whereHas('suplier', function ($query) use ($request) {
                    $query->where('nama_suplier', 'like', '%' . $request->search . '%');
                });
            })
            ->when($request->spId, function ($query) use ($request) {
                $query->where('id_suplier', $request->spId);
            })
            ->when($request->tipeId, function ($query) use ($request) {
                $query->where('tipe_sp', $request->tipeId);
            })
            ->when($request->selesaiId && $request->mulaiId, function ($query) use ($request) {
                $finalEndDate = Carbon::createFromFormat('Y-m-d', $request->selesaiId)->endOfDay();
                $finalStartDate = Carbon::createFromFormat('Y-m-d', $request->mulaiId)->startOfDay();
                $query->whereBetween('tgl_sp', [$finalStartDate, $finalEndDate]);
            })
            ->with('profile')
            ->paginate(10);
    
        $pdf = PDF::loadView('pdf.utilities.pembelian.sp-pembelian.pdf', [
            'detail' => $detail,
            'mulaiId' => $request->mulaiId,
            'selesaiId' => $request->selesaiId,
        ]);
    
        return $pdf->stream('sp-pembelian.pdf');
    }
    
  
}