<?php

namespace App\Livewire\KeuanganAkutansi\Akutansi;

use App\Models\Jurnal;
use App\Models\Profile;
use Livewire\Component;
use App\Models\AkunAkutansi;
use Illuminate\Http\Request;
use App\Models\ReturPenjualan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Neraca extends Component
{

    public $tanggalBulanTahun, $tgl_awal;
    public $tahun;
    public $bulan;
    public $totalSaldoAkunAktiva, $totalSaldoAkunKewajiban, $totalSaldoAkunModal;
    public $dataActiva, $dataPasiva, $dataModal;

    public function render()
    {
        $this->dataActiva = [];
        $this->dataPasiva = [];
        $this->dataModal = [];
        $this->totalSaldoAkunAktiva = 0;
        $this->totalSaldoAkunKewajiban = 0;
        $this->totalSaldoAkunModal = 0;
        if ($this->tanggalBulanTahun) {
            $explode = explode("-", $this->tanggalBulanTahun);
            $this->tahun = $explode[0];
            $this->bulan = $explode[1];
        }
        $pendapatanPenjualan = Jurnal::with('penjualan')->where('kode_akun', 'LIKE', '%4-%')->where('id_perusahaan', Auth::user()->id_perusahaan)->where('sumber', 'Penjualan')->when($this->tanggalBulanTahun, function ($q) {
            $q->whereYear('created_at', '>=', $this->tgl_awal->format('Y'));
            $q->whereMonth('created_at', '>=', $this->tgl_awal->format('m'));
            $q->whereYear('created_at', '<=', $this->tahun);
            $q->whereMonth('created_at', '<=', $this->bulan);
        })->get();
        $returPenjualan = Jurnal::where('kode_akun', '4-1002')->where('id_perusahaan', Auth::user()->id_perusahaan)->when($this->tanggalBulanTahun, function ($q) {
            $q->whereYear('created_at', '>=', $this->tgl_awal->format('Y'));
            $q->whereMonth('created_at', '>=', $this->tgl_awal->format('m'));
            $q->whereYear('created_at', '<=', $this->tahun);
            $q->whereMonth('created_at', '<=', $this->bulan);
        })->get();
        $hppPenjualan = Jurnal::where('kode_akun', 'LIKE', '%5-%')->where('id_perusahaan', Auth::user()->id_perusahaan)->when($this->tanggalBulanTahun, function ($q) {
            $q->whereYear('created_at', '>=', $this->tgl_awal->format('Y'));
            $q->whereMonth('created_at', '>=', $this->tgl_awal->format('m'));
            $q->whereYear('created_at', '<=', $this->tahun);
            $q->whereMonth('created_at', '<=', $this->bulan);
        })->get();
        $biayaOperasional = Jurnal::where('kode_akun', 'LIKE', '%6-%')->where('id_perusahaan', Auth::user()->id_perusahaan)->when($this->tanggalBulanTahun, function ($q) {
            $q->whereYear('created_at', '>=', $this->tgl_awal->format('Y'));
            $q->whereMonth('created_at', '>=', $this->tgl_awal->format('m'));
            $q->whereYear('created_at', '<=', $this->tahun);
            $q->whereMonth('created_at', '<=', $this->bulan);
        })->get();
        $pendapatanLain = Jurnal::where('kode_akun', 'LIKE', '%7-%')->where('id_perusahaan', Auth::user()->id_perusahaan)->when($this->tanggalBulanTahun, function ($q) {
            $q->whereYear('created_at', '>=', $this->tgl_awal->format('Y'));
            $q->whereMonth('created_at', '>=', $this->tgl_awal->format('m'));
            $q->whereYear('created_at', '<=', $this->tahun);
            $q->whereMonth('created_at', '<=', $this->bulan);
        })->get();
        $biayaLain = Jurnal::where('kode_akun', 'LIKE', '%8-%')->where('id_perusahaan', Auth::user()->id_perusahaan)->when($this->tanggalBulanTahun, function ($q) {
            $q->whereYear('created_at', '>=', $this->tgl_awal->format('Y'));
            $q->whereMonth('created_at', '>=', $this->tgl_awal->format('m'));
            $q->whereYear('created_at', '<=', $this->tahun);
            $q->whereMonth('created_at', '<=', $this->bulan);
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
        $labaRugiBersih = $labaRugiBersihOperasional + $totalPendapatanLain - $totalBiayaLain;

        $akunAktiva = AkunAkutansi::where('jenis_akun', 'Aktiva')->where('id_perusahaan', Auth::user()->id_perusahaan)->orderBy('kode', 'asc')->get();
        foreach ($akunAktiva as $key => $akun) {
            $aktiva = [];
            $aktiva['kode'] = $akun->kode;
            $aktiva['nama_akun'] = $akun->nama_akun;
            $saldoAkunAktiva = $this->getModel($akun)->sum('debet') - $this->getModel($akun)->sum('kredit');
            $this->totalSaldoAkunAktiva += $saldoAkunAktiva;
            $aktiva['total'] = $saldoAkunAktiva;
            $this->dataActiva[] = $aktiva;
        }
        $akunKewajiban = AkunAkutansi::where('jenis_akun', 'Kewajiban')
            ->where('id_perusahaan', Auth::user()->id_perusahaan)->orderBy('kode', 'asc')
            ->get();
        foreach ($akunKewajiban as $key => $akun) {
            $pasiva = [];
            $pasiva['kode'] = $akun->kode;
            $pasiva['nama_akun'] = $akun->nama_akun;

            $saldoAkunKewajiban = $this->getModel($akun)->sum('kredit') - $this->getModel($akun)->sum('debet');
            $this->totalSaldoAkunKewajiban += $saldoAkunKewajiban;
            $pasiva['total'] = $saldoAkunKewajiban;
            $this->dataPasiva[] = $pasiva;
        }
        $akunModal = AkunAkutansi::where('jenis_akun', 'Modal')
            ->where('id_perusahaan', Auth::user()->id_perusahaan)->orderBy('kode', 'asc')
            ->get();
        foreach ($akunModal as $key => $akun) {
            $modal = [];
            $modal['kode'] = $akun->kode;
            $modal['nama_akun'] = $akun->nama_akun;

            $saldoAkunModal = $this->getModel($akun)->sum('kredit') - $this->getModel($akun)->sum('debet');
            $this->totalSaldoAkunModal += $saldoAkunModal;
            $modal['total'] = $saldoAkunModal;
            $this->dataModal[] = $modal;
        }
        // dd($this->data);
        return view('livewire.keuangan-akutansi.akutansi.neraca', [
            'labaRugi' => $labaRugiBersih,
        ]);
    }
    function getModel(AkunAkutansi $akun)
    {
        return Jurnal::where('id_perusahaan', Auth::user()->id_perusahaan)
            ->where('kode_akun', $akun->kode)
            ->when($this->tanggalBulanTahun, function ($q) {
                $q->whereYear('created_at', '>=', $this->tgl_awal->format('Y'));
                $q->whereMonth('created_at', '>=', $this->tgl_awal->format('m'));
                $q->whereYear('created_at', '<=', $this->tahun);
                $q->whereMonth('created_at', '<=', $this->bulan);
            });
    }
    function mount()
    {
        $this->tgl_awal = Carbon::createFromFormat('j M, Y', auth()->user()->profile->tgl_neraca_awal);
        $this->tanggalBulanTahun = now()->format('Y-m');
    }
}
