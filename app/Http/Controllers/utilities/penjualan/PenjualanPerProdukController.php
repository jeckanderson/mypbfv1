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
use App\Models\ObatBarang;
use Illuminate\Http\Request;
use App\Models\ReturPembelian;
use App\Models\ReturPenjualan;
use App\Models\ProdukPenjualan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class PenjualanPerProdukController extends Controller
{
    public $mulaiId;
    public $selesaiId;
    public $produsenId;
    public $jenisId;
    public $golonganId;
    public $kategoriId;

    public function index()
    {
        return view('utilities.laporan.penjualan.penjualan-per-produk.penjualan-per-produk', [
            'title' => 'utilities',
        ]);
    }

    public function cetak_pdf(Request $request)
    {
        $defaultKategoriId = 1;
        $defaultGolonganId = 1;
        $defaultJenisId = 1;
        $defaultProdusenId = 1;

        $detail = ProdukPenjualan::when($request->search, function ($query) use ($request) {
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
            ->when($request->selesaiId && $request->mulaiId, function ($query) use ($request) {
                $finalEndDate = Carbon::createFromFormat('Y-m-d', $request->selesaiId)->endOfDay();
                $finalStartDate = Carbon::createFromFormat('Y-m-d', $request->mulaiId)->startOfDay();
                $query->whereHas('penjualan', function ($query) use ($finalStartDate, $finalEndDate) {
                    $query->whereBetween('tgl_input', [$finalStartDate, $finalEndDate]);
                });
            })
            ->when(!$this->kategoriId, function ($query) use ($defaultKategoriId) {
                $query->whereHas('produk', function ($query) use ($defaultKategoriId) {
                    $query->where('golongan', $defaultKategoriId);
                });
            })
            ->when(!$this->golonganId, function ($query) use ($defaultGolonganId) {
                $query->whereHas('produk', function ($query) use ($defaultGolonganId) {
                    $query->where('sub_golongan', $defaultGolonganId);
                });
            })
            // ->when(!$this->jenisId, function ($query) use ($defaultJenisId) {
            //     $query->whereHas('produk', function ($query) use ($defaultJenisId) {
            //         $query->where('jenis_obat_barang', $defaultJenisId);
            //     });
            // })
            ->when(!$this->produsenId, function ($query) use ($defaultProdusenId) {
                $query->whereHas('produk', function ($query) use ($defaultProdusenId) {
                    $query->where('produsen', $defaultProdusenId);
                });
            })
            ->with('produk.kelompok', 'produk.produsenProduk', 'produk.golonganProduk', 'produk.satuanTerkecil')
            ->paginate(10);

        $pdf = PDF::loadView('pdf.utilities.penjualan.penjualan-per-produk.pdf', [
            'detail' => $detail,
            'mulaiId' => $request->mulaiId,
            'selesaiId' => $request->selesaiId,
        ]);

        return $pdf->stream('penjualan-per-produk.pdf');
    }
}
