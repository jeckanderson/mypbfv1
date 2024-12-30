<?php

namespace App\Http\Controllers\utilities\pembelian;

use Carbon\Carbon;
use App\Models\Suplier;

use App\Models\Pelanggan;
use App\Models\Pembelian;
use App\Models\SPPembelian;
use Illuminate\Http\Request;
use App\Models\ProdukPembelian;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Routing\Controller;


class PembelianPerSupplierController extends Controller
{
    public function index()
    {
        


        return view('utilities.laporan.pembelian.pembelian-per-supplier.pembelian-per-supplier', [
            'title' => 'utilities',
           
        ]);
        
    }
    public function cetak_pdf(Request $request)
    {
        $detail = ProdukPembelian::when($request->search, function ($query) use ($request) {
            $query->whereHas('pembelian', function ($query) use ($request) {
                $query->where('no_faktur', 'like', '%' . $request->search . '%');
            });
        })
        ->when($request->pembayaranId, function ($query) use ($request) {
            $query->whereHas('pembelian', function ($query) use ($request) {
                $query->where('kredit', $request->pembayaranId);
            });
        })
        ->when($request->spId, function ($query) use ($request) {
            $query->whereHas('pembelian', function ($query) use ($request) {
                $query->where('suplier', $request->spId);
            });
        })
        ->when($request->selesaiId && $request->mulaiId, function ($query) use ($request) {
            $query->whereHas('pembelian', function ($query) use ($request) {
                $finalEndDate = Carbon::createFromFormat('Y-m-d', $request->selesaiId)->endOfDay();
                $finalStartDate = Carbon::createFromFormat('Y-m-d', $request->mulaiId)->startOfDay();
                $query->whereBetween('tgl_input', [$finalStartDate, $finalEndDate]);
            });
        })
        ->with('profile')
        ->paginate(10);
    
        $pdf = PDF::loadView('pdf.utilities.pembelian.pembelian-per-supplier.pdf', [
            'detail' => $detail,
            'mulaiId' => $request->mulaiId,
            'selesaiId' => $request->selesaiId,
        ]);
    
        return $pdf->stream('pembelian-per-supplier.pdf');
    }
    

    
}