<?php

namespace App\Http\Controllers\utilities\produk;

use App\Models\Gudang;
use App\Models\Golongan;
use App\Models\Kelompok;
use App\Models\Produsen;
use App\Models\Pembelian;
use App\Models\Penjualan;
use App\Models\HistoryStok;
use Illuminate\Http\Request;
use App\Models\ReturPembelian;
use App\Models\ReturPenjualan;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class NilaiPersediaanController extends Controller
{
    public $search = '';
    public $kategoriId;
    public $gudangId;
    public $produsenId;
    public $mulaiId;
    public $selesaiId;
    public function index()
    {
        $historystok = HistoryStok::with('produk.produsenProduk','produk.satuanTerkecil')->get();
    

        return view('utilities.laporan.produk.nilai-persediaan.nilai-persediaan', [
            'title' => 'NILAI PERSEDIAAN',
           
        ]);
        
    }

    public function cetak_pdf(Request $request)
    {
        $defaultCategoryId = 1;
        $defaultGudangId = 1;
        $defaultProdusenId =1;
        $historystok = HistoryStok::when($request->search, function ($query) use ($request) {
            $query->whereHas('produk', function ($query) use ($request) {
                $query->where('nama_obat_barang', 'like', '%' . $request->search . '%');
            });
        })
            ->when($request->kategoriId, function ($query) use ($request) {
                $query->whereHas('produk', function ($query) use ($request) {
                    $query->where('golongan', $request->kategoriId);
                });
            })
            ->when($request->produsenId, function ($query) use ($request) {
                $query->whereHas('produk', function ($query) use ($request) {
                    $query->where('produsen', $request->produsenId);
                });
            })
            ->when($request->gudangId, function ($query) use ($request) {
                $query->where('id_gudang', $request->gudangId);
            })
            ->when($request->selesaiId && $request->mulaiId, function ($query) use ($request) {
                $finalEndDate = Carbon::createFromFormat('Y-m-d', $request->selesaiId)->endOfDay();
                $finalStartDate = Carbon::createFromFormat('Y-m-d', $request->mulaiId)->startOfDay();
                $query->whereBetween('exp_date', [$finalStartDate, $finalEndDate]);
            })
            ->when(!$this->kategoriId, function ($query) use ($defaultCategoryId) {
                $query->whereHas('produk', function ($query) use ($defaultCategoryId) {
                    $query->where('golongan', $defaultCategoryId);
                });
            })
            ->when(!$this->produsenId, function ($query) use ($defaultProdusenId) {
                $query->whereHas('produk', function ($query) use ($defaultProdusenId) {
                    $query->where('produsen', $defaultProdusenId);
                });
            })
            ->when(!$this->gudangId, function ($query) use ($defaultGudangId) {
                
                    $query->where('id_gudang', $defaultGudangId);
               
            })
            ->orderBy('id')
            ->groupBy('id_gudang','id_rak','id_sub_rak','no_batch','exp_date')
            ->with('profile')
            ->paginate(10);
            $pdf = PDF::loadView('pdf.utilities.produk.nilai-persediaan.pdf', [
                'historystok' => $historystok,
                'mulaiId' => $request->mulaiId,
                'selesaiId' => $request->selesaiId,
            ]);
            

        return $pdf->stream('nilai-persediaan.pdf');
    }

   
}