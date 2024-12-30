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
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class PenjualanPerPelangganController extends Controller
{
    public function index()
    {
       
        return view('utilities.laporan.penjualan.penjualan-per-pelanggan.penjualan-per-pelanggan', [
            'title' => 'utilities',
           
        ]);
        
    }

    public function cetak_pdf(Request $request)
    {
        $defaultPelangganId = 1;
        $defaultSalesId = 1;
    
        $penjualan = Penjualan::when($request->search, function ($query) use ($request) {
            $query->whereHas('getPelanggan', function ($query) use ($request) {
                $query->where('nama', 'like', '%' . $request->search . '%');
            });
        })
        ->when($request->pelangganId, function ($query) use ($request) {
            $query->where('pelanggan', $request->pelangganId);
        })
        ->when($request->salesId, function ($query) use ($request) {
            $query->where('sales', $request->salesId);
        })
        ->when($request->pembayaranId, function ($query) use ($request) {
            $query->where('kredit', $request->pembayaranId);
        })
        ->when($request->selesaiId && $request->mulaiId, function ($query) use ($request) {
            $finalEndDate = Carbon::createFromFormat('Y-m-d', $request->selesaiId)->endOfDay();
            $finalStartDate = Carbon::createFromFormat('Y-m-d', $request->mulaiId)->startOfDay();
            $query->whereBetween('tgl_input', [$finalStartDate, $finalEndDate]);
        })
        ->when(!$request->pelangganId, function ($query) use ($defaultPelangganId) {
            $query->where('pelanggan', $defaultPelangganId);
        })
        ->when(!$request->salesId, function ($query) use ($defaultSalesId) {
            $query->where('sales', $defaultSalesId);
        })
        ->with('profile')
        ->get();
    
        $pdf = PDF::loadView('pdf.utilities.penjualan.penjualan-per-pelanggan.pdf', [
            'penjualan' => $penjualan,
            'mulaiId' => $request->mulaiId,
            'selesaiId' => $request->selesaiId,
        ]);
    
        return $pdf->stream('penjualan-per-pelanggan.pdf');
    }
    
   
}