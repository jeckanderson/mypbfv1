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
use App\Models\SPPenjualan;
use Illuminate\Http\Request;
use App\Models\ReturPembelian;
use App\Models\ReturPenjualan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class SpPenjualansController extends Controller
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

        return view('utilities.laporan.penjualan.sp-penjualan.sp-penjualan', [
            'title' => 'utilities',
        ]);
    }


    public function cetak_pdf(Request $request)
    {
        $defaultPelangganId = 1;
        $defaultSalesId = 1;
        $defaultTipeId = 1;
        $defaultSumberId = "";
        $detail = SPPenjualan::query()
            ->when($request->search, function ($query) use ($request) {
                $query->whereHas('pelangganPenjualan', function ($query) use ($request) {
                    $query->where('nama', 'like', '%' . $request->search . '%');
                });
            })
            ->when($request->pelangganId, function ($query) use ($request) {
                $query->where('pelanggan', $request->pelangganId);
            })
            ->when($request->salesId, function ($query) use ($request) {
                $query->where('sales', $request->salesId);
            })
            ->when($request->spId, function ($query) use ($request) {
                $query->where('tipe_sp', $request->spId);
            })
            ->when($request->sumberId, function ($query) use ($request) {
                $query->where('sumber', $request->sumberId);
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
            // ->when(!$request->spId, function ($query) use ($defaultTipeId) {
            //     $query->where('tipe_sp', $defaultTipeId);
            // })
            // ->when(!$request->sumberId, function ($query) use ($defaultSumberId) {
            //     $query->where('sumber', $defaultSumberId);
            // })
            ->with('pelangganPenjualan', 'salesPenjualan')
            ->get();

        $pdf = PDF::loadView('pdf.utilities.penjualan.sp-penjualan.pdf', [
            'detail' => $detail,
            'mulaiId' => $request->mulaiId,
            'selesaiId' => $request->selesaiId,
        ]);

        return $pdf->stream('sp-penjualan.pdf');
    }
}
