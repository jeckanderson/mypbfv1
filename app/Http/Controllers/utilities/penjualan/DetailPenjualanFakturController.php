<?php

namespace App\Http\Controllers\utilities\penjualan;

use Carbon\Carbon;
use App\Models\Sales;
use App\Models\Gudang;
use App\Models\Golongan;
use App\Models\Kelompok;
use App\Models\Produsen;
use App\Models\SubRayon;

use App\Models\AreaRayon;
use App\Models\Pelanggan;
use App\Models\Pembelian;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use App\Models\ReturPembelian;
use App\Models\ReturPenjualan;
use App\Models\ProdukPenjualan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class DetailPenjualanFakturController extends Controller
{
    public function index()
    {
    

    
        return view('utilities.laporan.penjualan.detail-penjualan-faktur.detail-penjualan-faktur', [
            'title' => 'utilities',
         
        ]);
        
    }

    public function cetak_pdf(Request $request)
    {
        $detail = ProdukPenjualan::when($request->search, function ($query) use ($request) {
            $query->whereHas('produk', function ($query) use ($request) {
                $query->where('nama_obat_barang', 'like', '%' . $request->search . '%');
            });
        })
        ->when($request->pelangganId, function ($query) use ($request) {
            $query->whereHas('penjualan', function ($query) use ($request) {
                $query->where('pelanggan', $request->pelangganId);
            });
        })
        ->when($request->salesId, function ($query) use ($request) {
            $query->whereHas('penjualan', function ($query) use ($request) {
                $query->where('sales', $request->salesId);
            });
        })
        ->when($request->pembayaranId, function ($query) use ($request) {
            $query->whereHas('penjualan', function ($query) use ($request) {
                $query->where('kredit', $request->pembayaranId);
            });
        })
        ->when($request->selesaiId && $request->mulaiId, function ($query) use ($request) {
            $finalEndDate = Carbon::createFromFormat('Y-m-d', $request->selesaiId)->endOfDay();
            $finalStartDate = Carbon::createFromFormat('Y-m-d', $request->mulaiId)->startOfDay();
            $query->whereHas('penjualan', function ($query) use ($finalStartDate, $finalEndDate) {
                $query->whereBetween('tgl_input', [$finalStartDate, $finalEndDate]);
            });
        })
        ->with('satuanProduk', 'profile')
        ->get(); 
    
        $pdf = PDF::loadView('pdf.utilities.penjualan.detail-penjualan-faktur.pdf', [
            'detail' => $detail,
            'mulaiId' => $request->mulaiId,
            'selesaiId' => $request->selesaiId,
        ]);
    
        return $pdf->stream('detail-penjualan-faktur.pdf');
    }
    
 
}