<?php

namespace App\Http\Controllers\utilities\pembelian;

use Carbon\Carbon;
use App\Models\Sales;
use App\Models\Gudang;
use App\Models\Suplier;
use App\Models\Golongan;
use App\Models\Kelompok;
use App\Models\Produsen;
use App\Models\SubRayon;
use App\Models\AreaRayon;
use App\Models\Pelanggan;
use App\Models\Pembelian;
use App\Models\Penjualan;
use App\Models\SPPembelian;
use App\Models\TerimaBarang;
use Illuminate\Http\Request;
use App\Models\ProdukDiterima;
use App\Models\ProdukPembelian;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class DetailTerimaBarangController extends Controller
{
    public function index()
    {
    
    return view('utilities.laporan.pembelian.detail-terima-barang.detail-terima-barang', [
            'title' => 'utilities',
          
        ]);
    }
   

    public function cetak_pdf(Request $request)
    {
        $detail = ProdukPembelian::when($request->search, function ($query) use ($request) {
            $query->whereHas('produk', function ($query) use ($request) {
                $query->where('nama_obat_barang', 'like', '%' . $request->search . '%');
            });
        })
        ->when($request->spId, function ($query) use ($request) {
            $query->whereHas('pembelian', function ($query) use ($request) {
                $query->where('suplier', $request->spId);
            });
        })
        ->when($request->selesaiId && $request->mulaiId, function ($query) use ($request) {
            if ($request->mulaiId == $request->selesaiId) {
                $query->whereHas('sp', function ($query) use ($request) {
                    $query->where('tgl_sp', $request->mulaiId);
                });
            } else {
                $finalEndDate = Carbon::createFromFormat('Y-m-d', $request->selesaiId)->endOfDay();
                $finalStartDate = Carbon::createFromFormat('Y-m-d', $request->mulaiId)->startOfDay();
                $query->whereHas('sp', function ($query) use ($finalStartDate, $finalEndDate) {
                    $query->whereBetween('tgl_sp', [$finalStartDate, $finalEndDate]);
                });
            }
        })
        ->with('profile')
        ->paginate(10);

        $pdf = PDF::loadView('pdf.utilities.pembelian.detail-terima-barang.pdf', [
            'detail' => $detail,
            'mulaiId' => $request->mulaiId,
            'selesaiId' => $request->selesaiId,
        ]);

        return $pdf->stream('detail-terima-barang.pdf');
    }

  
}