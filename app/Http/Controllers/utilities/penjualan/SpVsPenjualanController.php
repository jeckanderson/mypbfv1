<?php

namespace App\Http\Controllers\utilities\penjualan;

use Carbon\Carbon;
use App\Models\ProdukPenjualan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SpVsPenjualanController extends Controller
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
        return view('utilities.laporan.penjualan.sp-vs-penjualan.sp-vs-penjualan', [
            'title' => 'utilities',
        ]);
    }

    public function cetak_pdf(Request $request)
    {
        $defaultPelangganId = 1;
        $defaultSalesId = 1;
        $defaultTipeId = 1;
        $defaultSumberId = '';


        $detail = ProdukPenjualan::query()
            ->when($request->search, function ($query) use ($request) {
                $query->whereHas('produk', function ($query) use ($request) {
                    $query->where('nama_obat_barang', 'like', '%' . $request->search . '%');
                });
            })
            // ->when($request->pelangganId, function ($query) use ($request) {
            //     $query->whereHas('spPenjualan', function ($query) use ($request) {
            //         $query->where('pelanggan', $this->pelangganId);
            //     });
            // })
            // ->when($request->salesId, function ($query) use ($request) {
            //     $query->whereHas('spPenjualan', function ($query) {
            //         $query->where('sales', $this->salesId);
            //     });
            // })
            // ->when($request->spId, function ($query) use ($request) {
            //     $query->whereHas('spPenjualan', function ($query) use ($request) {
            //         $query->where('tipe_sp', $this->spId);
            //     });
            // })
            // ->when($request->sumberId, function ($query) use ($request) {
            //     $query->whereHas('spPenjualan', function ($query) use ($request) {
            //         $query->where('sumber', $this->sumberId);
            //     });
            // })
            ->when($request->selesaiId && $request->mulaiId, function ($query) use ($request) {
                $query->whereHas('spPenjualan', function ($query) use ($request) {
                $finalEndDate = Carbon::createFromFormat('Y-m-d', $request->selesaiId)->endOfDay();
                $finalStartDate = Carbon::createFromFormat('Y-m-d', $request->mulaiId)->startOfDay();
                $query->whereBetween('tgl_input', [$finalStartDate, $finalEndDate]);
                });
            })
           
         

        // ->when(!$this->pelangganId, function ($query) use ($defaultPelangganId) {
        //     $query->whereHas('spPenjualan', function ($query) use ($defaultPelangganId) {
        //         $query->where('pelanggan', $defaultPelangganId);
        //     });
        // })
        // ->when(!$this->salesId, function ($query) use ($defaultSalesId) {
        //     $query->whereHas('spPenjualan', function ($query) use ($defaultSalesId) {
        //         $query->where('salesId', $defaultSalesId);
        //     });
        // })
        // ->when(!$this->tipeId, function ($query) use ($defaultTipeId) {
        //     $query->whereHas('spPenjualan', function ($query) use ($defaultTipeId) {
        //         $query->where('tipe_sp', $defaultTipeId);
        //     });
        // })
        // ->when(!$this->sumberId, function ($query) use ($defaultSumberId) {
        //     $query->whereHas('spPenjualan', function ($query) use ($defaultSumberId) {
        //         $query->where('sumber', $defaultSumberId);
        //     });
        // })
        
    
     
    
            ->with('spPenjualan')
            ->get();

        $pdf = PDF::loadView('pdf.utilities.penjualan.sp-penjualan-vs-penjualan.pdf', [
            'detail' => $detail,
            'mulaiId' => $request->mulaiId,
            'selesaiId' => $request->selesaiId,
        ]);

        return $pdf->stream('sp-penjualan-vs-penjualan.pdf');
    }
}