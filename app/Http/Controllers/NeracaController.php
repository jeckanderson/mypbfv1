<?php

namespace App\Http\Controllers;

use App\Models\AkunAkutansi;
use App\Models\Jurnal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NeracaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:akses_neraca'])->only('index');
    }

    public function index()
    {
        return view('pages.keuangan-akuntansi.akuntansi.neraca', [
            'title' => 'keuangan & akuntansi',
        ]);
    }
    function print($filter)
    {
        $totalSaldoAkunAktiva = 0;
        $totalSaldoAkunKewajiban = 0;
        $totalSaldoAkunModal = 0;
        $profile = auth()->user()->profile;
        $tgl_awal = Carbon::createFromFormat('j M, Y', $profile->tgl_neraca_awal);
        $tahun = null;
        $bulan = null;
        if (!is_null($filter)) {
            $explode = explode("-", $filter);
            $tahun = $explode[0];
            $bulan = $explode[1];
        }
        $tanggalBulanTahun = $filter;
        $pendapatanPenjualan = Jurnal::with('penjualan')->where('kode_akun', 'LIKE', '%4-%')->where('id_perusahaan', Auth::user()->id_perusahaan)->where('sumber', 'Penjualan')->when($tanggalBulanTahun, function ($q) use ($tahun, $bulan, $tgl_awal) {
            $q->whereYear('created_at', '>=', $tgl_awal->format('Y'));
            $q->whereMonth('created_at', '>=', $tgl_awal->format('m'));
            $q->whereYear('created_at', '<=', $tahun);
            $q->whereMonth('created_at', '<=', $bulan);
        })->get();
        $returPenjualan = Jurnal::where('kode_akun', '4-1002')->where('id_perusahaan', Auth::user()->id_perusahaan)->when($tanggalBulanTahun, function ($q) use ($tahun, $bulan, $tgl_awal) {
            $q->whereYear('created_at', '>=', $tgl_awal->format('Y'));
            $q->whereMonth('created_at', '>=', $tgl_awal->format('m'));
            $q->whereYear('created_at', '<=', $tahun);
            $q->whereMonth('created_at', '<=', $bulan);
        })->get();
        $hppPenjualan = Jurnal::where('kode_akun', 'LIKE', '%5-%')->where('id_perusahaan', Auth::user()->id_perusahaan)->when($tanggalBulanTahun, function ($q) use ($tahun, $bulan, $tgl_awal) {
            $q->whereYear('created_at', '>=', $tgl_awal->format('Y'));
            $q->whereMonth('created_at', '>=', $tgl_awal->format('m'));
            $q->whereYear('created_at', '<=', $tahun);
            $q->whereMonth('created_at', '<=', $bulan);
        })->get();
        $biayaOperasional = Jurnal::where('kode_akun', 'LIKE', '%6-%')->where('id_perusahaan', Auth::user()->id_perusahaan)->when($tanggalBulanTahun, function ($q) use ($tahun, $bulan, $tgl_awal) {
            $q->whereYear('created_at', '>=', $tgl_awal->format('Y'));
            $q->whereMonth('created_at', '>=', $tgl_awal->format('m'));
            $q->whereYear('created_at', '<=', $tahun);
            $q->whereMonth('created_at', '<=', $bulan);
        })->get();
        $pendapatanLain = Jurnal::where('kode_akun', 'LIKE', '%7-%')->where('id_perusahaan', Auth::user()->id_perusahaan)->when($tanggalBulanTahun, function ($q) use ($tahun, $bulan, $tgl_awal) {
            $q->whereYear('created_at', '>=', $tgl_awal->format('Y'));
            $q->whereMonth('created_at', '>=', $tgl_awal->format('m'));
            $q->whereYear('created_at', '<=', $tahun);
            $q->whereMonth('created_at', '<=', $bulan);
        })->get();
        $biayaLain = Jurnal::where('kode_akun', 'LIKE', '%8-%')->where('id_perusahaan', Auth::user()->id_perusahaan)->when($tanggalBulanTahun, function ($q) use ($tahun, $bulan, $tgl_awal) {
            $q->whereYear('created_at', '>=', $tgl_awal->format('Y'));
            $q->whereMonth('created_at', '>=', $tgl_awal->format('m'));
            $q->whereYear('created_at', '<=', $tahun);
            $q->whereMonth('created_at', '<=', $bulan);
        })->get();

        //menghitung total

        $totalPendapatanPenjualan = $pendapatanPenjualan->sum('kredit') - $pendapatanPenjualan->sum('debet');
        $totalReturPenjualan = $returPenjualan->sum('debet') + $returPenjualan->sum('kredit');
        $totalHppPenjualan = $hppPenjualan->sum('debet') - $hppPenjualan->sum('kredit');
        $totalBiayaOperasional = $biayaOperasional->sum('debet') + $biayaOperasional->sum('kredit');
        $totalPendapatanLain = $pendapatanLain->sum('debet') + $pendapatanLain->sum('kredit');
        $totalBiayaLain = $biayaLain->sum('debet') + $biayaLain->sum('kredit');

        $totalLabaRugiKotor = $totalPendapatanPenjualan - $totalReturPenjualan - $totalHppPenjualan;
        $labaRugiBersihOperasional = $totalLabaRugiKotor - $totalBiayaOperasional;
        $labaRugi = $labaRugiBersihOperasional + $totalPendapatanLain - $totalBiayaLain;

        $akunAktiva = AkunAkutansi::where('jenis_akun', 'Aktiva')->where('id_perusahaan', Auth::user()->id_perusahaan)->orderBy('kode', 'asc')->get();
        foreach ($akunAktiva as $key => $akun) {
            $aktiva = [];
            $aktiva['kode'] = $akun->kode;
            $aktiva['nama_akun'] = $akun->nama_akun;
            $saldoAkunAktiva = $this->getModel($akun)->sum('debet') - $this->getModel($akun)->sum('kredit');
            $totalSaldoAkunAktiva += $saldoAkunAktiva;
            $aktiva['total'] = $saldoAkunAktiva;
            $dataActiva[] = $aktiva;
        }

        $akunKewajiban = AkunAkutansi::where('jenis_akun', 'Kewajiban')
            ->where('id_perusahaan', Auth::user()->id_perusahaan)->orderBy('kode', 'asc')
            ->get();
        foreach ($akunKewajiban as $key => $akun) {
            $pasiva = [];
            $pasiva['kode'] = $akun->kode;
            $pasiva['nama_akun'] = $akun->nama_akun;

            $saldoAkunKewajiban = $this->getModel($akun)->sum('kredit') - $this->getModel($akun)->sum('debet');
            $totalSaldoAkunKewajiban += $saldoAkunKewajiban;
            $pasiva['total'] = $saldoAkunKewajiban;
            $dataPasiva[] = $pasiva;
        }
        $akunModal = AkunAkutansi::where('jenis_akun', 'Modal')
            ->where('id_perusahaan', Auth::user()->id_perusahaan)->orderBy('kode', 'asc')
            ->get();
        foreach ($akunModal as $key => $akun) {
            $modal = [];
            $modal['kode'] = $akun->kode;
            $modal['nama_akun'] = $akun->nama_akun;

            $saldoAkunModal = $this->getModel($akun)->sum('kredit') - $this->getModel($akun)->sum('debet');
            $totalSaldoAkunModal += $saldoAkunModal;
            $modal['total'] = $saldoAkunModal;
            $dataModal[] = $modal;
        }
        return view('print.neraca', compact('dataModal','dataPasiva','dataActiva','totalSaldoAkunModal','totalSaldoAkunKewajiban','totalSaldoAkunAktiva','labaRugi','profile'));
    }
    function getModel(AkunAkutansi $akun, $tanggalBulanTahun = null)
    {
        $tgl_awal = Carbon::createFromFormat('j M, Y', auth()->user()->profile->tgl_neraca_awal);
        $tahun = null;
        $bulan = null;
        if (!is_null($tanggalBulanTahun)) {
            $explode = explode("-", $tanggalBulanTahun);
            $tahun = $explode[0];
            $bulan = $explode[1];
        }

        return Jurnal::where('id_perusahaan', Auth::user()->id_perusahaan)
            ->where('kode_akun', $akun->kode)
            ->when($tanggalBulanTahun, function ($q) use ($tahun, $bulan, $tgl_awal) {
                $q->whereYear('created_at', '>=', $tgl_awal->format('Y'));
                $q->whereMonth('created_at', '>=', $tgl_awal->format('m'));
                $q->whereYear('created_at', '<=', $tahun);
                $q->whereMonth('created_at', '<=', $bulan);
            });
    }
}
