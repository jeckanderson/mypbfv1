<?php

namespace App\Http\Controllers;

use App\Models\AkunAkutansi;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Profile;

class SaldoAwalController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:akses_saldo_awal']);
    }
    public function index()
    {
        $akunAktiva = AkunAkutansi::where('jenis_akun', 'Aktiva')->where('id_perusahaan', Auth::user()->id_perusahaan)->orderBy('kode', 'asc')->get();
        $akunPasiva = AkunAkutansi::whereIn('jenis_akun', ['Kewajiban', 'Modal'])->where('id_perusahaan', Auth::user()->id_perusahaan)->orderBy('kode', 'asc')->get();
        return view('pages.set-awal.saldo-awal.saldo-awal', [
            'title' => 'setting awal',
            'akunAktiva' => $akunAktiva,
            'akunPasiva' => $akunPasiva
        ]);
    }

    public function export_saldoawal_pdf()
    {
        $akunAktiva = AkunAkutansi::get();
        $akunPasiva = AkunAkutansi::get();
        $profile = Profile::get();
        $pdf = Pdf::loadView('pdf.saldo_awal', [
            'akunAktiva' => $akunAktiva,
            'akunPasiva' => $akunPasiva,
            'profile' => $profile
        ]);
        return $pdf->stream('download-data-saldo-awal.pdf');
    }

    public function excel_saldo_awal()
    {
        $akunAktiva = AkunAkutansi::get();
        $akunPasiva = AkunAkutansi::get();
        $profile = Profile::get();
        return view('excel.saldo_awal', [
            'akunAktiva' => $akunAktiva,
            'akunPasiva' => $akunPasiva,
            'profile' => $profile
        ]);
    }
}