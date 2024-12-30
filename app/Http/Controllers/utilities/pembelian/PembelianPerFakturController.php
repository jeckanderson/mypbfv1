<?php

namespace App\Http\Controllers\utilities\pembelian;

use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\ProdukPembelian;
use Illuminate\Routing\Controller;



class PembelianPerFakturController extends Controller
{
    public function index()
    {
    
        

        return view('utilities.laporan.pembelian.pembelian-per-faktur.pembelian-per-faktur', [
            'title' => 'utilities',
           
         
        ]);
        
    }

    public function cetak_pdf(Request $request)
    {
        $detail = ProdukPembelian::when($request->search, function ($query) use ($request) {
                $query->whereHas('produk', function ($query) use ($request) {
                    $query->where('nama_obat_barang', 'like', '%' . $request->search . '%');
                });
            })
            ->when($request->spId, function ($query) use ($request) {
                $query->whereHas('sp', function ($query) use ($request) {
                    $query->where('id_suplier', $request->spId);
                });
            })
            ->when($request->pembayaranId, function ($query) use ($request) {
                $query->whereHas('pembelian', function ($query) use ($request) {
                    $query->where('kredit', $request->pembayaranId);
                });
            })
            ->when($request->selesaiId && $request->mulaiId, function ($query) use ($request) {
                $finalEndDate = Carbon::createFromFormat('Y-m-d', $request->selesaiId)->endOfDay();
                $finalStartDate = Carbon::createFromFormat('Y-m-d', $request->mulaiId)->startOfDay();
                $query->whereHas('sp', function ($query) use ($finalStartDate, $finalEndDate) {
                    $query->whereBetween('tgl_sp', [$finalStartDate, $finalEndDate]);
                });
            })
            ->with('profile')
            ->paginate(10);
    
        $pdf = PDF::loadView('pdf.utilities.pembelian.pembelian-per-faktur.pdf', [
            'detail' => $detail,
            'mulaiId' => $request->mulaiId,
            'selesaiId' => $request->selesaiId,
        ]);
    
        return $pdf->stream('pembelian-per-faktur.pdf');
    }
    

  
}