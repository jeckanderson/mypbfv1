<?php

namespace App\Livewire\KeuanganAkutansi\Akutansi;

use App\Models\Jurnal;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LabaRugi extends Component
{
    public $pendapatanPenjualan = [], $returPenjualan = [], $hppPenjualan = [], $biayaOperasional = [], $pendapatanLain = [], $biayaLain = [];

    public $totalPendapatanPenjualan, $totalReturPenjualan, $totalHppPenjualan, $totalBiayaOperasional, $totalPendapatanLain, $totalBiayaLain, $totalLabaRugiKotor, $labaRugiBersihOperasional, $labaRugiBersih;
    public $tanggalBulanTahun,$tahun,$bulan;
    public function render()
    {
        if ($this->tanggalBulanTahun) {
            $explode = explode("-", $this->tanggalBulanTahun);
            $this->tahun = $explode[0];
            $this->bulan = $explode[1];
        }
        $this->pendapatanPenjualan = Jurnal::when($this->tanggalBulanTahun, function ($q) {
            $q->whereYear('created_at', $this->tahun);
            $q->whereMonth('created_at', $this->bulan);
        })->selectRaw('*,SUM(debet) as debet,SUM(kredit) as kredit')->where('kode_akun', 'LIKE', '%4-%')->where('kode_akun','<>','4-1002')->where('id_perusahaan', Auth::user()->id_perusahaan)->groupBy('kode_akun')->get();
        $this->returPenjualan = Jurnal::when($this->tanggalBulanTahun, function ($q) {
            $q->whereYear('created_at', $this->tahun);
            $q->whereMonth('created_at', $this->bulan);
        })->selectRaw('*,SUM(debet) as debet,SUM(kredit) as kredit')->where('kode_akun', '4-1002')->where('id_perusahaan', Auth::user()->id_perusahaan)->groupBy('kode_akun')->get();
        $this->hppPenjualan = Jurnal::when($this->tanggalBulanTahun, function ($q) {
            $q->whereYear('created_at', $this->tahun);
            $q->whereMonth('created_at', $this->bulan);
        })->selectRaw('*,SUM(debet) as debet,SUM(kredit) as kredit')->where('kode_akun', 'LIKE', '%5-%')->where('id_perusahaan', Auth::user()->id_perusahaan)->groupBy('kode_akun')->get();
        $this->biayaOperasional = Jurnal::when($this->tanggalBulanTahun, function ($q) {
            $q->whereYear('created_at', $this->tahun);
            $q->whereMonth('created_at', $this->bulan);
        })->selectRaw('*,SUM(debet) as debet,SUM(kredit) as kredit')->where('kode_akun', 'LIKE', '%6-%')->where('id_perusahaan', Auth::user()->id_perusahaan)->groupBy('kode_akun')->get();
        $this->pendapatanLain = Jurnal::when($this->tanggalBulanTahun, function ($q) {
            $q->whereYear('created_at', $this->tahun);
            $q->whereMonth('created_at', $this->bulan);
        })->selectRaw('*,SUM(debet) as debet,SUM(kredit) as kredit')->where('kode_akun', 'LIKE', '%7-%')->where('id_perusahaan', Auth::user()->id_perusahaan)->groupBy('kode_akun')->get();
        $this->biayaLain = Jurnal::when($this->tanggalBulanTahun, function ($q) {
            $q->whereYear('created_at', $this->tahun);
            $q->whereMonth('created_at', $this->bulan);
        })->selectRaw('*,SUM(debet) as debet,SUM(kredit) as kredit')->where('kode_akun', 'LIKE', '%8-%')->where('id_perusahaan', Auth::user()->id_perusahaan)->groupBy('kode_akun')->get();

        //menghitung total
        $this->totalPendapatanPenjualan = $this->pendapatanPenjualan->sum('kredit') - $this->pendapatanPenjualan->sum('debet');
        $this->totalReturPenjualan = $this->returPenjualan->sum('debet') - $this->returPenjualan->sum('kredit');
        $this->totalHppPenjualan =  $this->hppPenjualan->sum('debet') - $this->hppPenjualan->sum('kredit');
        $this->totalBiayaOperasional =  $this->biayaOperasional->sum('debet') - $this->biayaOperasional->sum('kredit');
        $this->totalPendapatanLain =  $this->pendapatanLain->sum('kredit') - $this->pendapatanLain->sum('debet');
        $this->totalBiayaLain =  $this->biayaLain->sum('debet') - $this->biayaLain->sum('kredit');

        $this->totalLabaRugiKotor = $this->totalPendapatanPenjualan - $this->totalReturPenjualan - $this->totalHppPenjualan;
        $this->labaRugiBersihOperasional = $this->totalLabaRugiKotor - $this->totalBiayaOperasional;
        $this->labaRugiBersih = $this->labaRugiBersihOperasional + $this->totalPendapatanLain - $this->totalBiayaLain;
        return view('livewire.keuangan-akutansi.akutansi.laba-rugi', []);
    }

    public function mount()
    {
        $this->tanggalBulanTahun = now()->format('Y-m');
        
    }
}
