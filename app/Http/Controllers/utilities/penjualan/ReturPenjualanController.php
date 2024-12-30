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

class ReturPenjualanController extends Controller
{
    public $search = '';
    public $pelangganId;
    public $salesId;
  
    public $mulaiId;
    public $selesaiId;
    public function index()
    {
        
        return view('utilities.laporan.penjualan.retur-penjualan.retur-penjualan', [
            'title' => 'utilities', 
        ]);
        
    }
    public function cetak_pdf(Request $request)
    {
        $defaultPelangganId = 1;
        $defaultSalesId = 1;
      

        $detail = ReturPenjualan::when($request->search, function ($query) use ($request) {
                $query->whereHas('history.produk', function ($query) use ($request) {
                    $query->where('nama_obat_barang', 'like', '%' . $request->search . '%');
                });
            })
            ->when($request->pelangganId, function ($query) use ($request) {
                $query->where('pelanggan', $request->pelangganId);
            })
            ->when($request->salesId, function ($query) use ($request) {
                $query->where('sales', $request->salesId);
            })
            ->when($request->selesaiId && $request->mulaiId, function ($query) use ($request) {
                $finalEndDate = Carbon::createFromFormat('Y-m-d', $request->selesaiId)->endOfDay();
                $finalStartDate = Carbon::createFromFormat('Y-m-d', $request->mulaiId)->startOfDay();
                $query->whereBetween('tgl_input', [$finalStartDate, $finalEndDate]);
            })

            ->when(!$this->pelangganId, function ($query) use ($defaultPelangganId) {
                
                    $query->where('pelanggan', $defaultPelangganId);
              
            })
            ->when(!$this->salesId, function ($query) use ($defaultSalesId) {
               
                    $query->where('sales', $defaultSalesId);
               
            })
            ->with('getPelanggan', 'getSales')
            ->get(); 
    
        $pdf = PDF::loadView('pdf.utilities.penjualan.retur-penjualan.pdf', [
            'detail' => $detail,
            'mulaiId' => $request->mulaiId,
            'selesaiId' => $request->selesaiId,
        ]);
    
        return $pdf->stream('retur-penjualan.pdf');
    }
    
   
}