<?php

namespace App\Http\Controllers;

use App\Models\ObatBarang;
use App\Models\TargetProduk;
use App\Models\ProdukPenjualan;
use App\Models\ProdukReturPenjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Profile;

class TargetProdukController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:akses_target_produk']);
        $this->middleware(['permission:tambah_target_produk'])->only('tambahTargetProduk');
        $this->middleware(['permission:aksi_target_produk'])->only('editTargetProduk');
        $this->middleware(['permission:aksi_target_produk'])->only('deleteTargetProduk');
    }

    public function index()
    {
        return view('pages.perusahaan.marketing.target-produk', [
            'title' => 'master',
            'targetProduks' => TargetProduk::where('id_perusahaan', Auth::user()->id_perusahaan)->groupBy('tahun', 'bulan')
                ->get(),
            'obatBarangs' => ObatBarang::where('id_perusahaan', Auth::user()->id_perusahaan)->get(),
            'penjualans' => ProdukPenjualan::where('id_perusahaan', Auth::user()->id_perusahaan)->get(),
            'returPenjualan' => ProdukReturPenjualan::where('id_perusahaan', Auth::user()->id_perusahaan)->get(),
        ]);
    }

    public function export_target_produk_pdf($id)
    {
        dd('anjai');
        $targetProduk = TargetProduk::find($id);
        $profile = Profile::where('id', Auth::user()->id_perusahaan)->first();
        $obatBarangs = ObatBarang::get();
        $pdf = Pdf::loadView('pdf.target_produk', [
            'targetProduk' => $targetProduk,
            'obatBarangs' => $obatBarangs,
            'profile' => $profile
        ]);
        return $pdf->stream('download-data-target-produk');
    }

    public function tambahTargetProduk(Request $request)
    {
        $targets = $request->target;

        foreach ($targets as $target) {
            $existingTarget = TargetProduk::where('id_produk', $target['id_produk'])
                ->where('tahun', $request->tahun)
                ->where('bulan', $request->bulan)
                ->first();

            if ($existingTarget) {
                $existingTarget->update(['target' => $target['target_produk']]);
            } else {
                TargetProduk::create([
                    'id_perusahaan' => Auth::user()->id_perusahaan,
                    'id_produk' => $target['id_produk'],
                    'tahun' => $request->tahun,
                    'bulan' => $request->bulan,
                    'target' => $target['target_produk'],
                ]);
            }
        }

        return back()->with('success', 'Berhasil menambahkan atau mengedit target');
    }

    public function editTargetProduk(Request $request)
    {
        $targets = $request->target;

        foreach ($targets as $target) {
            $existingTarget = TargetProduk::where('id_produk', $target['id_produk'])
                ->where('tahun', $request->tahun)
                ->where('bulan', $request->bulan)
                ->first();

            if ($existingTarget) {
                $existingTarget->update(['target' => $target['target_produk']]);
            } else {
                $targetProduk = $target['target_produk'];

                if ($targetProduk == '') {
                    $targetProduk = 0;
                }

                TargetProduk::create([
                    'id_perusahaan' => Auth::user()->id_perusahaan,
                    'id_produk' => $target['id_produk'],
                    'tahun' => $request->tahun,
                    'bulan' => $request->bulan,
                    'target' => $targetProduk,
                ]);
            }
        }

        return back()->with('success', 'Berhasil mengedit target');
    }

    public function deleteTargetProduk(Request $request)
    {
        $targets = $request->target;

        foreach ($targets as $target) {
            TargetProduk::where('id_produk', $target['id_produk'])
                ->where('tahun', $request->tahun)
                ->where('bulan', $request->bulan)
                ->delete();
        }

        return back()->with('success', 'Berhasil menghapus target');
    }
}