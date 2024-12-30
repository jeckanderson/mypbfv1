<?php

namespace App\Http\Controllers;

use App\Models\Jurnal;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class AkutansiController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:akses_jurnal_umum'])->only('jurnalUmum');
        $this->middleware(['permission:akses_laba_rugi'])->only('labaRugi');
    }

    public function jurnalUmum()
    {
        return view('pages.keuangan-akuntansi.akuntansi.jurnal-umum', [
            'title' => 'keuangan & akuntansi'
        ]);
    }

    public function labaRugi()
    {
        return view('pages.keuangan-akuntansi.akuntansi.laba-rugi', [
            'title' => 'keuangan & akuntansi'
        ]);
    }
    public function labaRugiPrint($filter)
    {
        $tanggalBulanTahun = $filter;

        if ($tanggalBulanTahun) {
            $explode = explode("-", $tanggalBulanTahun);
            $tahun = $explode[0];
            $bulan = $explode[1];
        }
        $pendapatanPenjualan = Jurnal::when($tanggalBulanTahun, function ($q) use ($tahun, $bulan) {
            $q->whereYear('created_at', $tahun);
            $q->whereMonth('created_at', $bulan);
        })->selectRaw('*,SUM(debet) as debet,SUM(kredit) as kredit')->where('kode_akun', 'LIKE', '%4-%')->where('kode_akun', '<>', '4-1002')->where('id_perusahaan', Auth::user()->id_perusahaan)->groupBy('kode_akun')->get();
        $returPenjualan = Jurnal::when($tanggalBulanTahun, function ($q) use ($tahun, $bulan) {
            $q->whereYear('created_at', $tahun);
            $q->whereMonth('created_at', $bulan);
        })->selectRaw('*,SUM(debet) as debet,SUM(kredit) as kredit')->where('kode_akun', '4-1002')->where('id_perusahaan', Auth::user()->id_perusahaan)->groupBy('kode_akun')->get();
        $hppPenjualan = Jurnal::when($tanggalBulanTahun, function ($q) use ($tahun, $bulan) {
            $q->whereYear('created_at', $tahun);
            $q->whereMonth('created_at', $bulan);
        })->selectRaw('*,SUM(debet) as debet,SUM(kredit) as kredit')->where('kode_akun', 'LIKE', '%5-%')->where('id_perusahaan', Auth::user()->id_perusahaan)->groupBy('kode_akun')->get();
        $biayaOperasional = Jurnal::when($tanggalBulanTahun, function ($q) use ($tahun, $bulan) {
            $q->whereYear('created_at', $tahun);
            $q->whereMonth('created_at', $bulan);
        })->selectRaw('*,SUM(debet) as debet,SUM(kredit) as kredit')->where('kode_akun', 'LIKE', '%6-%')->where('id_perusahaan', Auth::user()->id_perusahaan)->groupBy('kode_akun')->get();
        $pendapatanLain = Jurnal::when($tanggalBulanTahun, function ($q) use ($tahun, $bulan) {
            $q->whereYear('created_at', $tahun);
            $q->whereMonth('created_at', $bulan);
        })->selectRaw('*,SUM(debet) as debet,SUM(kredit) as kredit')->where('kode_akun', 'LIKE', '%7-%')->where('id_perusahaan', Auth::user()->id_perusahaan)->groupBy('kode_akun')->get();
        $biayaLain = Jurnal::when($tanggalBulanTahun, function ($q) use ($tahun, $bulan) {
            $q->whereYear('created_at', $tahun);
            $q->whereMonth('created_at', $bulan);
        })->selectRaw('*,SUM(debet) as debet,SUM(kredit) as kredit')->where('kode_akun', 'LIKE', '%8-%')->where('id_perusahaan', Auth::user()->id_perusahaan)->groupBy('kode_akun')->get();

        //menghitung total
        $totalPendapatanPenjualan = $pendapatanPenjualan->sum('kredit') - $pendapatanPenjualan->sum('debet');
        $totalReturPenjualan = $returPenjualan->sum('debet') - $returPenjualan->sum('kredit');
        $totalHppPenjualan =  $hppPenjualan->sum('debet') - $hppPenjualan->sum('kredit');
        $totalBiayaOperasional =  $biayaOperasional->sum('debet') - $biayaOperasional->sum('kredit');
        $totalPendapatanLain =  $pendapatanLain->sum('kredit') - $pendapatanLain->sum('debet');
        $totalBiayaLain =  $biayaLain->sum('debet') - $biayaLain->sum('kredit');

        $totalLabaRugiKotor = $totalPendapatanPenjualan - $totalReturPenjualan - $totalHppPenjualan;
        $labaRugiBersihOperasional = $totalLabaRugiKotor - $totalBiayaOperasional;
        $labaRugiBersih = $labaRugiBersihOperasional + $totalPendapatanLain - $totalBiayaLain;
        $profile = auth()->user()->profile;
        return view('print.laba_rugi', compact('profile', 'totalPendapatanPenjualan', 'totalReturPenjualan', 'totalHppPenjualan', 'totalBiayaOperasional', 'totalPendapatanLain', 'totalBiayaLain', 'totalLabaRugiKotor', 'labaRugiBersihOperasional', 'labaRugiBersih',
    'pendapatanPenjualan','returPenjualan','hppPenjualan','biayaOperasional','pendapatanLain','biayaLain'));
    }

    public function cetakJurnalUmum(Request $request)
    {
        $tanggalMulai = $request->query('tanggalMulai');
        $tanggalAkhir = $request->query('tanggalAkhir');

        $jurnal =  Jurnal::where('id_perusahaan', Auth::user()->id_perusahaan)
            ->where('no_reff', '!=', '-')->whereBetween('updated_at', [$tanggalMulai, $tanggalAkhir]);

        $profile = Profile::where('id', Auth::user()->id_perusahaan)->first();

        $pdf = Pdf::loadView('pdf.jurnal_umum', [
            'jurnals' => $jurnal,
            'profile' => $profile,
            'dari' => $tanggalMulai,
            'sampai' => $tanggalMulai
        ]);

        return $pdf->stream('download-jurnal-umum.pdf');
    }
}
