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
use Illuminate\Http\Request;
use App\Models\ReturPembelian;
use App\Models\ReturPenjualan;
use App\Models\ProdukPembelian;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class PembelianPerProdukController extends Controller
{
    public function index()
    {
     


        return view('utilities.laporan.pembelian.pembelian-per-produk.pembelian-per-produk', [
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
            ->when($request->kategoriId, function ($query) use ($request) {
                $query->whereHas('produk', function ($query) use ($request) {
                    $query->where('golongan', $request->kategoriId);
                });
            })
            ->when($request->golonganId, function ($query) use ($request) {
                $query->whereHas('produk', function ($query) use ($request) {
                    $query->where('sub_golongan', $request->golonganId);
                });
            })
            ->when($request->jenisId, function ($query) use ($request) {
                $query->whereHas('produk', function ($query) use ($request) {
                    $query->where('jenis_obat_barang', $request->jenisId);
                });
            })
            ->when($request->produsenId, function ($query) use ($request) {
                $query->whereHas('produk', function ($query) use ($request) {
                    $query->where('produsen', $request->produsenId);
                });
            })
            ->when($request->suplierId, function ($query) use ($request) {
                $query->whereHas('pembelian', function ($query) use ($request) {
                    $query->where('suplier', $request->suplierId);
                });
            })
            ->when($request->selesaiId && $request->mulaiId, function ($query) use ($request) {
                $finalEndDate = Carbon::createFromFormat('Y-m-d', $request->selesaiId)->endOfDay();
                $finalStartDate = Carbon::createFromFormat('Y-m-d', $request->mulaiId)->startOfDay();
                $query->whereHas('sp', function ($query) use ($finalStartDate, $finalEndDate) {
                    $query->whereBetween('tgl_sp', [$finalStartDate, $finalEndDate]);
                });
            })
            ->with('profile')
            ->paginate(10);
    
        $pdf = PDF::loadView('pdf.utilities.pembelian.pembelian-per-produk.pdf', [
            'detail' => $detail,
            'mulaiId' => $request->mulaiId,
            'selesaiId' => $request->selesaiId,
        ]);
    
        return $pdf->stream('pembelian-per-produk.pdf');
    }
    
}