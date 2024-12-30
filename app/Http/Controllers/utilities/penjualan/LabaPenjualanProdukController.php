<?php

namespace App\Http\Controllers\utilities\penjualan;

use Carbon\Carbon;
use App\Models\ProdukPenjualan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class LabaPenjualanProdukController extends Controller
{
    public $pelangganId;
    public $salesId;
    public $mulaiId;
    public $selesaiId;
    public $search = '';

    public function index()
    {
        return view('utilities.laporan.penjualan.laba-penjualan-produk.laba-penjualan-produk', [
            'title' => 'utilities',
        ]);
    }

    public function cetak_pdf(Request $request)
    {
        $defaultPelangganId = 1;
        $defaultSalesId = 1;
        $detail = ProdukPenjualan::when($request->search, function ($query) use ($request) {
                $query->whereHas('penjualan', function ($query) use ($request) {
                    $query->where('no_faktur', 'like', '%' . $request->search . '%');
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
            ->when($request->selesaiId && $request->mulaiId, function ($query) use ($request) {
                $finalEndDate = Carbon::createFromFormat('Y-m-d', $request->selesaiId)->endOfDay();
                $finalStartDate = Carbon::createFromFormat('Y-m-d', $request->mulaiId)->startOfDay();
                $query->whereHas('penjualan', function ($query) use ($finalStartDate, $finalEndDate) {
                    $query->whereBetween('tgl_input', [$finalStartDate, $finalEndDate]);
                });
            })
            ->when(!$request->pelangganId, function ($query) use ($defaultPelangganId) {
                $query->whereHas('penjualan', function ($query) use ($defaultPelangganId) {
                    $query->where('pelanggan', $defaultPelangganId);
                });
            })
            ->when(!$request->salesId, function ($query) use ($defaultSalesId) {
                $query->whereHas('penjualan', function ($query) use ($defaultSalesId) {
                    $query->where('sales', $defaultSalesId);
                });
            })
            ->with('penjualan.getPelanggan', 'penjualan.getSales', 'produk')
            ->get();
    
        $pdf = PDF::loadView('pdf.utilities.penjualan.laba-penjualan-produk.pdf', [
            'detail' => $detail,
            'mulaiId' => $request->mulaiId,
            'selesaiId' => $request->selesaiId,
        ]);
    
        return $pdf->stream('laba-penjualan-produk.pdf');
    }
    
}
