<?php

namespace App\Http\Controllers\utilities\penjualan;

use Carbon\Carbon;
use App\Models\Pelanggan;
use App\Models\Penjualan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PenjualanPerFakturController extends Controller
{
    public $search = '';
    public $kategoriId;
    public $gudangId;
    public $produsenId;
    public $mulaiId;
    public $selesaiId;

    public function index()
    {
        return view('utilities.laporan.penjualan.penjualan-per-faktur.penjualan-per-faktur', [
            'title' => 'utilities',
        ]);
    }

    public function cetak_pdf(Request $request)
    {
        $defaultPelangganId = 1;
        $defaultSalesId = 1;
        $penjualan = Penjualan::when($request->search, function ($query) use ($request) {
            $query->where('no_faktur', 'like', '%' . $request->search . '%');
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
        ->when(!$request->pelangganId, function ($query) use ($defaultPelangganId) {
            $query->where('pelanggan', $defaultPelangganId);
        })
        // ->when(!$request->salesId, function ($query) use ($defaultSalesId) {
        //     $query->where('sales', $defaultSalesId);
        // })
        ->with('profile')
        ->get(); 
    
        $pdf = PDF::loadView('pdf.utilities.penjualan.penjualan-per-faktur.pdf', [
            'penjualan' => $penjualan,
            'mulaiId' => $request->mulaiId,
            'selesaiId' => $request->selesaiId,
        ]);
    
        return $pdf->stream('penjualan-per-faktur.pdf');
    }
}
