<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SPPembelian;
use App\Models\RencanaOrder;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;

class PembuatanSPController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:akses_pembuatan_sp'])->only('index');
    }

    public function index()
    {
        return view('pages.transaksi.pengadaan.sp.surat-pesanan', [
            'title' => 'transaksi'
        ]);
    }

    public function export_pemesanan_suplier_pdf($id)
    {
        // Menemukan SPPembelian berdasarkan ID
        $surat = SPPembelian::findOrFail($id);

        // Memuat data RencanaOrder yang terkait dengan SPPembelian
        $rencanaOrder = RencanaOrder::whereIn('id', json_decode($surat->id_order))->get();

        // Mendapatkan data profil
        $profile = Profile::where('id', Auth::user()->id_perusahaan)->first();

        // Memuat tampilan PDF dengan data yang diperlukan
        if ($surat->tipe_sp == 'REG') {
            $pdf = PDF::loadView('pdf.pemesanan_suplier', [
                'surat' => $surat,
                'rencanaOrder' => $rencanaOrder,
                'profile' => $profile
            ]);
        } elseif ($surat->tipe_sp == 'OOT') {
            $pdf = PDF::loadView('pdf.sp_oot', [
                'surat' => $surat,
                'rencanaOrder' => $rencanaOrder,
                'profile' => $profile
            ]);
        } elseif ($surat->tipe_sp == 'Prek') {
            $pdf = PDF::loadView('pdf.sp_prekursor', [
                'surat' => $surat,
                'rencanaOrder' => $rencanaOrder,
                'profile' => $profile
            ]);
        } elseif ($surat->tipe_sp == 'Psiko') {
            $pdf = PDF::loadView('pdf.sp_ psikotropika', [
                'surat' => $surat,
                'rencanaOrder' => $rencanaOrder,
                'profile' => $profile
            ]);
        } elseif ($surat->tipe_sp == 'Narko') {
            $pdf = PDF::loadView('pdf.sp_narkotika', [
                'surat' => $surat,
                'rencanaOrder' => $rencanaOrder,
                'profile' => $profile
            ]);
        }
        return $pdf->stream('download-data-pemesanan-suplier.pdf');
    }
}