<?php

namespace App\Http\Controllers\utilities\pembelian;

use Carbon\Carbon;


use Illuminate\Http\Request;
use App\Models\ProdukPembelian;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class DetailPembelianFakturController extends Controller
{
    public function index()
    {
       


        return view('utilities.laporan.pembelian.detail-pembelian-per-faktur.detail-pembelian-per-faktur', [
            'title' => 'utilities',
   
        ]);
        
    }
    public function cetak_pdf(Request $request)
    {
        $search = $request->search;
        $spId = $request->spId;
        $pembayaranId = $request->pembayaranId;
        $selesaiId = $request->selesaiId;
        $mulaiId = $request->mulaiId;
    
        $detail = ProdukPembelian::when($search, function ($query) use ($search) {
                $query->whereHas('produk', function ($query) use ($search) {
                    $query->where('nama_obat_barang', 'like', '%' . $search . '%');
                });
            })
            ->when($spId, function ($query) use ($spId) {
                $query->whereHas('sp', function ($query) use ($spId) {
                    $query->where('id_suplier', $spId);
                });
            })
            ->when($pembayaranId, function ($query) use ($pembayaranId) {
                $query->whereHas('pembelian', function ($query) use ($pembayaranId) {
                    $query->where('kredit', $pembayaranId);
                });
            })
            ->when($selesaiId && $mulaiId, function ($query) use ($selesaiId, $mulaiId) {
                $query->whereHas('sp', function ($query) use ($selesaiId, $mulaiId) {
                    $finalEndDate = Carbon::createFromFormat('Y-m-d', $selesaiId)->endOfDay();
                    $finalStartDate = Carbon::createFromFormat('Y-m-d', $mulaiId)->startOfDay();
                    $query->whereBetween('tgl_sp', [$finalStartDate, $finalEndDate]);
                });
            })
            ->with('profile')
            ->paginate(10);
    
        $pdf = PDF::loadView('pdf.utilities.pembelian.detail-pembelian-per-faktur.pdf', [
            'detail' => $detail,
            'mulaiId' => $mulaiId,
            'selesaiId' => $selesaiId,
        ]);
    
        return $pdf->stream('detail-pembelian-per-faktur.pdf');
    }
    
  
}