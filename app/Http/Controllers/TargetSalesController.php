<?php

namespace App\Http\Controllers;

use App\Models\AreaRayon;
use App\Models\Pegawai;
use App\Models\ProdukPenjualan;
use App\Models\ProdukReturPenjualan;
use App\Models\Profile;
use App\Models\Sales;
use App\Models\SubRayon;
use App\Models\TargetSales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class TargetSalesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:akses_target_sales']);
        $this->middleware(['permission:tambah_target_sales'])->only('tambahTargetSales');
        $this->middleware(['permission:aksi_target_sales'])->only('editTargetSales');
        $this->middleware(['permission:aksi_target_sales'])->only('deleteTargetSales');
    }

    public function index()
    {
        return view('pages.perusahaan.marketing.target-sales', [
            'title' => "perusahaan",
            'pegawais' => Pegawai::where('id_perusahaan', Auth::user()->id_perusahaan)->where('marketing', 'on')->get(),
            'rayons' => AreaRayon::where('id_perusahaan', Auth::user()->id_perusahaan)->get(),
            'sub_rayon' => SubRayon::where('id_perusahaan', Auth::user()->id_perusahaan)->get(),
            'targets' => TargetSales::where('id_perusahaan', Auth::user()->id_perusahaan)->orderBy('tahun', 'desc')->get(),
            'penjualans' => ProdukPenjualan::select('produk_penjualan.*', 'penjualan.sales')->leftJoin('penjualan', 'penjualan.id', 'produk_penjualan.id_penjualan')->where('produk_penjualan.id_perusahaan', Auth::user()->id_perusahaan)->get(),
            'returPenjualan' => ProdukReturPenjualan::select('produk_retur_penjualan.*', 'retur_penjualan.sales', 'retur_penjualan.dpp')->leftJoin('retur_penjualan', 'retur_penjualan.id', 'produk_retur_penjualan.id_retur')->where('produk_retur_penjualan.id_perusahaan', Auth::user()->id_perusahaan)->get(),
        ]);
    }

    public function export_target_sales_pdf($id)
    {
        $target = TargetSales::find($id);
        $profile = Profile::get();
        $pdf = Pdf::loadView('pdf.target_sales', [
            'target' => $target,
            'profile' => $profile,
            'penjualans' => ProdukPenjualan::select('produk_penjualan.*', 'penjualan.sales')->leftJoin('penjualan', 'penjualan.id', 'produk_penjualan.id_penjualan')->where('produk_penjualan.id_perusahaan', Auth::user()->id_perusahaan)->get(),
            'returPenjualan' => ProdukReturPenjualan::select('produk_retur_penjualan.*', 'retur_penjualan.sales', 'retur_penjualan.dpp')->leftJoin('retur_penjualan', 'retur_penjualan.id', 'produk_retur_penjualan.id_retur')->where('produk_retur_penjualan.id_perusahaan', Auth::user()->id_perusahaan)->get(),
        ]);
        return $pdf->stream('download-data-target-sales');
    }

    public function excel_target_sales($id)
    {
        $target = TargetSales::find($id);
        $profile = Profile::get();
        return view('excel.target_sales', [
            'target' => $target,
            'profile' => $profile
        ]);
    }

    public function tambahTargetSales(Request $request)
    {
        $cekSales = Sales::where('sales', $request->sales)->first();
        $target = new TargetSales();
        $target->id_perusahaan = Auth::user()->id_perusahaan;
        $target->sales = $request->sales;
        $target->supervisor = $cekSales->supervisor;
        $target->area_rayon = $cekSales->area_rayon;
        $target->sub_rayon = $cekSales->sub_rayon;
        $target->tahun = $request->tahun;
        $target->target_januari = $request->target_januari;
        $target->target_februari = $request->target_februari;
        $target->target_maret = $request->target_maret;
        $target->target_april = $request->target_april;
        $target->target_mei = $request->target_mei;
        $target->target_juni = $request->target_juni;
        $target->target_juli = $request->target_juli;
        $target->target_agustus = $request->target_agustus;
        $target->target_september = $request->target_september;
        $target->target_oktober = $request->target_oktober;
        $target->target_november = $request->target_november;
        $target->target_desember = $request->target_desember;

        $target->save();

        return back()->with('success', 'Target added successfully');
    }

    public function editTargetSales(Request $request, $id)
    {
        $cekSales = Sales::where('sales', $request->sales)->first();
        $target = TargetSales::find($id);
        $target->id_perusahaan = Auth::user()->id_perusahaan;
        $target->sales = $request->sales;
        $target->supervisor = $cekSales->supervisor;
        $target->area_rayon = $cekSales->area_rayon;
        $target->sub_rayon = $cekSales->sub_rayon;
        $target->tahun = $request->tahun;
        $target->target_januari = $request->target_januari;
        $target->target_februari = $request->target_februari;
        $target->target_maret = $request->target_maret;
        $target->target_april = $request->target_april;
        $target->target_mei = $request->target_mei;
        $target->target_juni = $request->target_juni;
        $target->target_juli = $request->target_juli;
        $target->target_agustus = $request->target_agustus;
        $target->target_september = $request->target_september;
        $target->target_oktober = $request->target_oktober;
        $target->target_november = $request->target_november;
        $target->target_desember = $request->target_desember;

        $target->save();

        return back()->with('success', 'Target added successfully');
    }

    public function deleteTargetSales($id)
    {
        $target = TargetSales::find($id);
        $target->delete();

        return back()->with('success', 'Target delete successfully');
    }
}