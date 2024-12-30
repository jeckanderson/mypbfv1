<?php

namespace App\Http\Controllers\utilities\pembelian;

use Carbon\Carbon;


use App\Models\SPPembelian;
use Illuminate\Http\Request;
use App\Models\ProdukPembelian;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Routing\Controller;


class SpPembelianVsPembelianController extends Controller
{
    public function index()
    {
       

        return view('utilities.laporan.pembelian.sp-pembelian-vs-pembelian.sp-pembelian-vs-pembelian', [
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
            ->when($request->tipeId, function ($query) use ($request) {
                $query->whereHas('sp', function ($query) use ($request) {
                    $query->where('tipe_sp', $request->tipeId);
                });
            })
            ->when($request->selesaiId && $request->mulaiId, function ($query) use ($request) {
                $query->whereHas('sp', function ($query) use ($request) {
                    $finalEndDate = Carbon::createFromFormat('Y-m-d', $request->selesaiId)->endOfDay();
                    $finalStartDate = Carbon::createFromFormat('Y-m-d', $request->mulaiId)->startOfDay();
                    $query->whereBetween('tgl_sp', [$finalStartDate, $finalEndDate]);
                });
            })
            ->with('produk', 'sp')
            ->paginate(10);
    
        $pdf = PDF::loadView('pdf.utilities.pembelian.sp-pembelian-vs-pembelian.pdf', [
            'detail' => $detail,
            'mulaiId' => $request->mulaiId,
            'selesaiId' => $request->selesaiId,
            
        ]);
    
        return $pdf->stream('sp-pembelian-vs-pembelian.pdf');
    }
    

}