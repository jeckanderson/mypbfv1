<?php

namespace App\Http\Controllers\utilities\penjualan;

use Carbon\Carbon;
use App\Models\ProdukPenjualan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DetailSpPenjualanController extends Controller
{
    public $search = '';
    public $pelangganId;
    public $salesId;
    public $tipeId;
    public $sumberId;
    public $mulaiId;
    public $selesaiId;
    public function index()
    {
        return view('utilities.laporan.penjualan.detail-sp-penjualan.detail-sp-penjualan', [
            'title' => 'utilities',
        ]);
    }

    public function cetak_pdf(Request $request)
    {
        $defaultPelangganId = 1;
        $defaultSalesId = 1;
        $defaultTipeId = 1;
        $defaultSumberId = "";

        $detail = ProdukPenjualan::query()
        ->when($request->search, function ($query) use ($request) {
            $query->whereHas('produk', function ($query) use ($request) {
                $query->where('nama_obat_barang', 'like', '%' . $request->search . '%');
            });
        })
        ->when($request->pelangganId, function ($query) use ($request) {
            $query->whereHas('spPenjualan', function ($query) use ($request) {
                $query->where('pelanggan', $request->pelangganId);
            });
        })
        ->when($request->salesId, function ($query) use ($request) {
            $query->whereHas('spPenjualan', function ($query) use ($request) {
                $query->where('sales', $request->salesId);
            });
        })
        // ->when($request->spId, function ($query) use ($request) {
        //     $query->whereHas('spPenjualan', function ($query) use ($request) {
        //         $query->where('tipe_sp', $request->spId);
        //     });
        // })
        ->when($request->sumberId, function ($query) use ($request) {
            $query->where('sumber', $request->sumberId);
        })
        ->when($request->selesaiId && $request->mulaiId, function ($query) use ($request) {
            $finalEndDate = Carbon::createFromFormat('Y-m-d', $request->selesaiId)->endOfDay();
            $finalStartDate = Carbon::createFromFormat('Y-m-d', $request->mulaiId)->startOfDay();
            $query->whereHas('spPenjualan', function ($query) use ($finalStartDate, $finalEndDate) {
                $query->whereBetween('tgl_input', [$finalStartDate, $finalEndDate]);
            });
        })
        ->when(!$this->pelangganId, function ($query) use ($defaultPelangganId) {
            $query->whereHas('spPenjualan', function ($query) use ($defaultPelangganId) {
                $query->where('pelanggan', $defaultPelangganId);
            });
        })
        // ->when(!$this->salesId, function ($query) use ($defaultSalesId) {
        //     $query->whereHas('spPenjualan', function ($query) use ($defaultSalesId) {
        //         $query->where('sales', $defaultSalesId);
        //     });
        // })
        ->when(!$this->tipeId, function ($query) use ($defaultTipeId) {
            $query->whereHas('spPenjualan', function ($query) use ($defaultTipeId) {
                $query->where('tipe_sp', $defaultTipeId);
            });
        })
        ->when(!$this->sumberId, function ($query) use ($defaultSumberId) {
            $query->whereHas('spPenjualan', function ($query) use ($defaultSumberId) {
                $query->where('sumber', $defaultSumberId);
            });
        })
        ->with('spPenjualan', 'produk')
        ->get();
    
    $pdf = PDF::loadView('pdf.utilities.penjualan.detail-sp-penjualan.pdf', [
        'detail' => $detail,
        'mulaiId' => $request->mulaiId,
        'selesaiId' => $request->selesaiId,
    ]);
    

        return $pdf->stream('detail-sp-penjualan.pdf');
    }
}
