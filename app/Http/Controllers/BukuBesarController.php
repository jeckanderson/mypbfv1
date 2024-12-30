<?php

namespace App\Http\Controllers;

use App\Models\AkunAkutansi;
use App\Models\PiutangAwal;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class BukuBesarController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:akses_buku_besar'])->only('index');
    }

    public function index()
    {
        return view('pages.keuangan-akuntansi.akuntansi.buku-besar', [
            'title' => 'keuangan & akuntansi',
            'akuns' => AkunAkutansi::where('id_perusahaan', Auth::user()->id_perusahaan)->orderBy('kode', 'asc')->get(),
            'piutangDagang' => PiutangAwal::where('jns_piutang', 'Piutang Dagang')->get(),
        ]);
    }

    public function cetakBukuBesar(Request $request)
    {
        $tanggalMulai = $request->query('tanggalMulai');
        $tanggalAkhir = $request->query('tanggalAkhir');

        $akuns =  AkunAkutansi::where('id_perusahaan', Auth::user()->id_perusahaan)
            ->orderBy('kode', 'asc')
            ->where('id', '!=', 30)
            ->get();

        $profile = Profile::where('id', Auth::user()->id_perusahaan)->first();

        $pdf = Pdf::loadView('pdf.laporan_buku_besar', [
            'akuns' => $akuns,
            'profile' => $profile,
            'dari' => $tanggalMulai,
            'sampai' => $tanggalAkhir
        ]);

        return $pdf->stream('download-buku-besar.pdf');
    }
}