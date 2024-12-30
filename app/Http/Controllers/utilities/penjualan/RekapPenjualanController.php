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

class RekapPenjualanController extends Controller
{
    public $search = '';
    public $pelangganId;
    public $salesId;
    public $pembayaranId;
    public $arearayonId;
    public $subrayonId;
    public $supervisorId;
    public $mulaiId;
    public $selesaiId;
    public function index()
    {
       
        return view('utilities.laporan.penjualan.rekap-penjualan.rekap-penjualan', [
            'title' => 'utilities',
           
           
        ]);
        
    }

    public function cetak_pdf(Request $request)
    {
        $defaultPelangganId = 1;
        $defaultSalesId = 1;
        $defaultPembayaranId = 1;
        $defaultArearayonId = 1;
        $defaultSubrayonId = 1;
        $defaultSupervisorId = 1;

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
            ->when($request->pembayaranId, function ($query) use ($request) {  // Fixed typo here
                $query->where('kredit', $request->pembayaranId);
            })
            ->when($request->arearayonId, function ($query) use ($request) {
                $query->whereHas('getPelanggan', function ($query) use ($request) {
                    $query->where('area_rayon', $request->arearayonId);
                });
            })
            ->when($request->subrayonId, function ($query) use ($request) {
                $query->whereHas('getPelanggan', function ($query) use ($request) {
                    $query->where('sub_rayon', $request->subrayonId);
                });
            })
            ->when($request->supervisorId, function ($query) use ($request) {
                $query->whereHas('getPelanggan', function ($query) use ($request) {
                    $query->where('supervisor', $request->supervisorId);
                });
            })
            ->when($request->selesaiId && $request->mulaiId, function ($query) use ($request) {
                $finalEndDate = Carbon::createFromFormat('Y-m-d', $request->selesaiId)->endOfDay();
                $finalStartDate = Carbon::createFromFormat('Y-m-d', $request->mulaiId)->startOfDay();
                $query->whereBetween('tgl_input', [$finalStartDate, $finalEndDate]);
            })
            ->when(!$request->pelangganId, function ($query) use ($defaultPelangganId) {
                $query->where('pelanggan', $defaultPelangganId);
            })
            // ->when(!$request->salesId, function ($query) use ($defaultSalesId) {
            //     $query->where('sales', $defaultSalesId);
            // })
            // ->when(!$request->pembayaranId, function ($query) use ($defaultPembayaranId) {
            //     $query->where('kredit', $defaultPembayaranId);
            // })
            ->when(!$this->arearayonId, function ($query) use ($defaultArearayonId) {
                $query->whereHas('getPelanggan', function ($query) use ($defaultArearayonId) {
                    $query->where('area_rayon', $defaultArearayonId);
                });
            })
            ->when(!$this->subrayonId, function ($query) use ($defaultSubrayonId) {
                $query->whereHas('getPelanggan', function ($query) use ($defaultSubrayonId) {
                    $query->where('sub_rayon', $defaultSubrayonId);
                });
            })
            // ->when(!$this->supervisorId, function ($query) use ($defaultSupervisorId) {
            //     $query->whereHas('getPelanggan', function ($query) use ($defaultSupervisorId) {
            //         $query->where('supervisor', $defaultSupervisorId);
            //     });
            // })
            ->with('profile')
            ->get();
    
        $pdf = PDF::loadView('pdf.utilities.penjualan.rekap-penjualan.pdf', [
            'penjualan' => $penjualan,
            'mulaiId' => $request->mulaiId,
            'selesaiId' => $request->selesaiId,
        ]);
    
        return $pdf->stream('rekap-penjualan.pdf');
    }

  
    
    
    
}