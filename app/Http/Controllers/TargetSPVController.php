<?php

namespace App\Http\Controllers;

use App\Models\AreaRayon;
use App\Models\Pegawai;
use App\Models\Penjualan;
use App\Models\ProdukPenjualan;
use App\Models\ProdukReturPenjualan;
use App\Models\TargetSPV;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Profile;
use App\Models\ReturPenjualan;
use App\Models\Sales;

class TargetSPVController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:akses_target_spv']);
        $this->middleware(['permission:tambah_target_spv'])->only('tambahTargetSpv');
        $this->middleware(['permission:aksi_target_spv'])->only('editTargetSpv');
        $this->middleware(['permission:aksi_target_spv'])->only('deleteTargetSpv');
    }

    public function index()
    {
        return view('pages.perusahaan.marketing.target-spv', [
            'title' => "perusahaan",
            'pegawais' => Pegawai::where('id_perusahaan', Auth::user()->id_perusahaan)->where('marketing', 'on')->get(),
            'rayons' => AreaRayon::where('id_perusahaan', Auth::user()->id_perusahaan)->get(),
            'targets' => TargetSPV::where('id_perusahaan', Auth::user()->id_perusahaan)->with('rayon')->orderBy('tahun', 'desc')->get(),
            'penjualans' => ProdukPenjualan::select('produk_penjualan.*', 'sales.supervisor', 'sales.sales')->leftJoin('penjualan', 'penjualan.id', 'produk_penjualan.id_penjualan')->leftJoin('sales', 'sales.sales', 'penjualan.sales')->where('produk_penjualan.id_perusahaan', Auth::user()->id_perusahaan)->get(),
            'returPenjualan' => ProdukReturPenjualan::select('produk_retur_penjualan.*', 'sales.supervisor', 'sales.sales', 'retur_penjualan.dpp')->leftJoin('retur_penjualan', 'retur_penjualan.id', 'produk_retur_penjualan.id_retur')->leftJoin('sales', 'sales.sales', 'retur_penjualan.sales')->where('produk_retur_penjualan.id_perusahaan', Auth::user()->id_perusahaan)->get(),

        ]);
    }

    public function export_target_spv_pdf($id)
    {
        $target = TargetSPV::find($id);
        $profile = Profile::get();
        $pdf = Pdf::loadView('pdf.target_spv', [
            'target' => $target,
            'profile' => $profile,
            'penjualans' => ProdukPenjualan::select('produk_penjualan.*', 'sales.supervisor', 'sales.sales')->leftJoin('penjualan', 'penjualan.id', 'produk_penjualan.id_penjualan')->leftJoin('sales', 'sales.sales', 'penjualan.sales')->where('produk_penjualan.id_perusahaan', Auth::user()->id_perusahaan)->get(),
            'returPenjualan' => ProdukReturPenjualan::select('produk_retur_penjualan.*', 'sales.supervisor', 'sales.sales', 'retur_penjualan.dpp')->leftJoin('retur_penjualan', 'retur_penjualan.id', 'produk_retur_penjualan.id_retur')->leftJoin('sales', 'sales.sales', 'retur_penjualan.sales')->where('produk_retur_penjualan.id_perusahaan', Auth::user()->id_perusahaan)->get(),
            'supervisor_id' => $id
        ]);
        return $pdf->stream('download-data-target-spv');
    }

    public function excel_target_spv($id)
    {
        $target = TargetSPV::find($id);
        $profile = Profile::get();
        return view('excel.target_spv', [
            'target' => $target,
            'profile' => $profile
        ]);
    }

    public function tambahTargetSpv(Request $request)
    {
        $cekSpv = Sales::where('supervisor', $request->supervisor)->first();
        $target = new TargetSPV();
        $target->id_perusahaan = Auth::user()->id_perusahaan;
        $target->supervisor = $request->supervisor;
        $target->area_rayon = $cekSpv->area_rayon;
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

    public function editTargetSpv(Request $request, $id)
    {
        $cekSpv = Sales::where('supervisor', $request->supervisor)->first();
        $target = TargetSPV::find($id);
        $target->id_perusahaan = Auth::user()->id_perusahaan;
        $target->supervisor = $request->supervisor;
        $target->area_rayon = $cekSpv->area_rayon;
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

        return back()->with('success', 'Target edit successfully');
    }

    public function deleteTargetSpv($id)
    {
        $target = TargetSPV::find($id);
        $target->delete();

        return back()->with('success', 'Target delete successfully');
    }
}