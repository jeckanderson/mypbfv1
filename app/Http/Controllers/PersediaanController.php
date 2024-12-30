<?php

namespace App\Http\Controllers;

use App\Models\HistoryStok;
use App\Models\MutasiStok;
use App\Models\ProdukDiterima;
use App\Models\Profile;
use App\Models\StokAwal;
use App\Models\StokOpname;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class PersediaanController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:akses_histori_stok']);
        $this->middleware(['permission:akses_stok_opname'])->only('stokOpname');
        $this->middleware(['permission:tambah_stok_opname'])->only('tambahStokOpname');
        $this->middleware(['permission:akses_mutasi_stok'])->only('mutasiStok');
    }
    public function historiStok()
    {
        return view('pages.persediaan.histori-stok', [
            'title' => 'persediaan'
        ]);
    }

    public function kartuStok(Request $request)
    {
        $id_produk = $request->query('id_produk');
        $id_gudang = $request->query('id_gudang');
        $id_rak = $request->query('id_rak');
        $id_sub_rak = $request->query('id_sub_rak');

        return view('pages.persediaan.kartu-stok', [
            'title' => 'persediaan',
            'historys' => HistoryStok::where('id_perusahaan', Auth::user()->id_perusahaan)->where('id_produk', $id_produk)->where('id_gudang', $id_gudang)->where('id_rak', $id_rak)->where('id_sub_rak', $id_sub_rak)->get()
        ]);
    }

    public function export_cetak_kartu_pdf(Request $request)
    {
        // Mendapatkan parameter dari request
        $id_produk = $request->input('id_produk');
        $id_gudang = $request->input('id_gudang');
        $id_rak = $request->input('id_rak');
        $id_sub_rak = $request->input('id_sub_rak');

        // Mengambil data berdasarkan parameter yang diberikan
        $historys = HistoryStok::where('id_perusahaan', Auth::user()->id_perusahaan)
            ->where('id_produk', $id_produk)
            ->where('id_gudang', $id_gudang)
            ->where('id_rak', $id_rak)
            ->where('id_sub_rak', $id_sub_rak)
            ->get();
        $profile = Profile::get();
        // Memuat view PDF dengan data yang diperoleh
        $pdf = PDF::loadView('pdf.cetak_kartu', [
            'historys' => $historys,
            'profile' => $profile
        ]);

        // Mengunduh file PDF
        return $pdf->stream('download-data-cetak-kartu.pdf');
    }

    public function excel_cetak_kartu(Request $request)
    {
        // Mendapatkan parameter dari request
        $id_produk = $request->input('id_produk');
        $id_gudang = $request->input('id_gudang');
        $id_rak = $request->input('id_rak');
        $id_sub_rak = $request->input('id_sub_rak');

        // Mengambil data berdasarkan parameter yang diberikan
        $historys = HistoryStok::where('id_perusahaan', Auth::user()->id_perusahaan)
            ->where('id_produk', $id_produk)
            ->where('id_gudang', $id_gudang)
            ->where('id_rak', $id_rak)
            ->where('id_sub_rak', $id_sub_rak)
            ->get();
        $profile = Profile::get();
        return view('excel.kartu_stok', [
            'historys' => $historys,
            'profile' => $profile
        ]);
    }

    public function stokOpname()
    {
        return view('pages.persediaan.stok-opname.opname', [
            'title' => 'persediaan'
        ]);
    }

    public function export_stok_opname_pdf(Request $request)
    {
        $stoks = StokAwal::get();

        $query = ProdukDiterima::where(
            'id_perusahaan',
            Auth::user()->id_perusahaan
        );
        if ($request->gudang) {
            $query->where('gudang', $request->gudang);
        }
        if ($request->rak) {
            $query->where('rak', $request->rak);
        }
        if ($request->subRak) {
            $query->where('sub_rak', $request->subRak);
        }

        if ($request->tglSo) {
            $query->where('tgl_so', $request->tglSo);
        }

        $profile = Profile::get();
        $pdf = Pdf::loadView('pdf.stok_opname', [
            'stoks' => $stoks,
            'pembelians' => $query->get(),
            'profile' => $profile
        ]);
        return $pdf->stream('download-stok-opname.pdf');
    }

    public function excel_stok_opname()
    {
        $profile = Profile::first();
        return view('excel.stok_opname', [
            'profile' => $profile
        ]);
    }


    public function export_data_stok_opname_pdf(Request $request)
    {
        $stokOpname = StokOpname::where('id_perusahaan', Auth::user()->id_perusahaan);

        if ($request->gudang) {
            $stokOpname->where('gudang', $request->gudang);
        }
        if ($request->rak) {
            $stokOpname->where('rak', $request->rak);
        }
        if ($request->sub_rak) {
            $stokOpname->where('sub_rak', $request->sub_rak);
        }
        if ($request->tgl_so) {
            $stokOpname->where('tgl_so', $request->tgl_so);
        }
        $profile = Profile::first();
        $pdf = Pdf::loadView('pdf.data_stok_opname', [
            'stokOpname' => $stokOpname->get(),
            'profile' => $profile,
            'tgl_so' => $request->tgl_so
        ]);
        return $pdf->stream('download-data-stok-opname.pdf');
    }

    public function excel_data_stok_opname(Request $request)
    {
        $stokOpname = StokOpname::where('id_perusahaan', Auth::user()->id_perusahaan);

        if ($request->gudang) {
            $stokOpname->where('gudang', $request->gudang);
        }
        if ($request->rak) {
            $stokOpname->where('rak', $request->rak);
        }
        if ($request->sub_rak) {
            $stokOpname->where('sub_rak', $request->sub_rak);
        }
        if ($request->tgl_so) {
            $stokOpname->where('tgl_so', $request->tgl_so);
        }

        $profile = Profile::first();
        return view('excel.data_stok_opname', [
            'stokOpname' => $stokOpname->get(),
            'profile' => $profile,
            'tgl_so' => $request->tgl_so
        ]);
    }

    public function tambahStokOpname()
    {
        return view('pages.persediaan.stok-opname.tambah-stok', [
            'title' => 'persediaan'
        ]);
    }

    public function mutasiStok()
    {
        return view('pages.persediaan.mutasi-stok.mutasi', [
            'title' => 'persediaan'
        ]);
    }

    public function export_mutasi_stok_pdf(Request $request)
    {
        $tanggalMulai = $request->query('tanggalMulai');
        $tanggalAkhir = $request->query('tanggalAkhir');

        $mutasiStok = MutasiStok::whereBetween('created_at', [$tanggalMulai, $tanggalAkhir])->get();
        $profile = Profile::get();

        $pdf = Pdf::loadView('pdf.mutasi_stok', [
            'mutasiStok' => $mutasiStok,
            'profile' => $profile,
            'tanggalMulai' => $tanggalMulai,
            'tanggalAkhir' => $tanggalAkhir
        ])->setPaper('a4', 'landscape');

        return $pdf->stream('download-mutasi-stok.pdf');
    }


    public function excel_mutasi_stok()
    {
        $mutasiStok = MutasiStok::get();
        $profile = Profile::where('id', Auth::user()->id_perusahaan)->first();
        return view('excel.mutasi_stok', [
            'mutasiStok' => $mutasiStok,
            'profile' => $profile
        ]);
    }

    public function tambahMutasiStok()
    {
        return view('pages.persediaan.mutasi-stok.tambah-mutasi', [
            'title' => 'persediaan'
        ]);
    }
}