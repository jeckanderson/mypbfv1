<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Penjualan;
use App\Models\SuratJalan;
use App\Models\SetNoFaktur;
use App\Models\SPPenjualan;
use Illuminate\Http\Request;
use App\Models\ReturPenjualan;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\Penjualan\ExportCSV;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class PenjualanController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:akses_sp_penjualan'])->only('spPenjualan');
        $this->middleware(['permission:tambah_sp_penjualan'])->only('tambahSPPenjualan');
        $this->middleware(['permission:akses_cek_sp_penjualan'])->only('cekSPPenjualan');
        $this->middleware(['permission:aksi_cek_sp_penjualan'])->only('editPesananPenjualan');
        $this->middleware(['permission:akses_setting_no_faktur'])->only('settingNoFaktur');
        $this->middleware(['permission:akses_penjualan'])->only('penjualan');
        $this->middleware(['permission:tambah_penjualan'])->only('tambahPenjualan');
        $this->middleware(['permission:akses_retur_penjualan'])->only('returPenjualan');
        $this->middleware(['permission:tambah_retur_penjualan'])->only('tambahReturPenjualan');
        $this->middleware(['permission:akses_surat_jalan'])->only('suratJalan');
        $this->middleware(['permission:tambah_surat_jalan'])->only('tambahSuratJalan');
    }

    public function exportCSV(Request $request)
    {
        $filePath = 'pajak_penjualan_' . date('d_m_Y_H_i_s') . '.csv';
        Excel::store(new ExportCSV($request->start, $request->end, $request->pelanggan), $filePath, 'local');

        $csvContent = Storage::disk('local')->get($filePath);

        $csvContent = str_replace('"', '', $csvContent);

        Storage::disk('local')->put($filePath, $csvContent);

        return response()->download(storage_path('app/' . $filePath))->deleteFileAfterSend(true);
    }

    public function cetakSPPenjualan($id)
    {
        $sp = SPPenjualan::find($id);
        $profile = Profile::where('id', Auth::user()->id_perusahaan)->first();

        $pdf = Pdf::loadView('pdf.data_surat_pesanan_jual', [
            'sp' => $sp,
            'profile' => $profile,
        ]);

        return $pdf->stream('download-retur-penjualan.pdf');
    }

    public function cetakPerReturPenjualan($id)
    {
        $retur = ReturPenjualan::find($id);
        $profile = Profile::where('id', Auth::user()->id_perusahaan)->first();

        $pdf = Pdf::loadView('pdf.retur_penjualan', [
            'retur' => $retur,
            'profile' => $profile,
        ]);

        return $pdf->stream('download-sp-penjualan.pdf');
    }

    public function cetakSuratJalan($id)
    {
        $surat = SuratJalan::find($id);
        $profile = Profile::where('id', Auth::user()->id_perusahaan)->first();

        $pdf = Pdf::loadView('pdf.surat_jalan', [
            'surat' => $surat,
            'profile' => $profile,
        ]);

        return $pdf->stream('download-surat-jalan.pdf');
    }

    public function spPenjualan()
    {
        return view('pages.transaksi.penjualan.sp-penjualan.daftar-sp', [
            'title' => 'transaksi'
        ]);
    }

    public function tambahSPPenjualan()
    {
        return view('pages.transaksi.penjualan.sp-penjualan.detail-sp-penjualan', [
            'title' => 'transaksi'
        ]);
    }

    public function cekSPPenjualan()
    {
        return view('pages.transaksi.penjualan.cek-pesanan.cek-pesanan', [
            'title' => 'transaksi'
        ]);
    }

    public function editPesananPenjualan($id)
    {
        return view('pages.transaksi.penjualan.cek-pesanan.pesanan-penjualan', [
            'title' => 'transaksi',
            'id' => $id
        ]);
    }
    function printSP(SPPenjualan $sPPenjualan)
    {
        return view('pages.transaksi.penjualan.cek-pesanan.print', compact('sPPenjualan'));
    }
    public function penjualan()
    {
        return view('pages.transaksi.penjualan.penjualan.data-penjualan', [
            'title' => 'transaksi'
        ]);
    }

    public function tambahPenjualan()
    {
        return view('pages.transaksi.penjualan.penjualan.tambah-penjualan', [
            'title' => 'transaksi'
        ]);
    }

    public function returPenjualan()
    {
        return view('pages.transaksi.penjualan.retur.retur-penjualan', [
            'title' => 'transaksi'
        ]);
    }

    public function tambahReturPenjualan()
    {
        return view('pages.transaksi.penjualan.retur.tambah-retur', [
            'title' => 'transaksi'
        ]);
    }

    public function suratJalan()
    {
        return view('pages.transaksi.penjualan.surat-jalan.surat', [
            'title' => 'transaksi'
        ]);
    }

    public function settingNoFaktur()
    {
        return view('pages.transaksi.penjualan.setting-nomor-faktur', [
            'title' => 'transaksi'
        ]);
    }

    public function tambahSuratJalan()
    {
        return view('pages.transaksi.penjualan.surat-jalan.tambah-surat', [
            'title' => 'transaksi',
            'id' => '',
            'isChangeStatus' => false
        ]);
    }

    public function editSuratJalan($id)
    {
        return view('pages.transaksi.penjualan.surat-jalan.tambah-surat', [
            'title' => 'transaksi',
            'id' => $id,
            'isChangeStatus' => false
        ]);
    }

    public function statusSuratJalan($id)
    {
        return view('pages.transaksi.penjualan.surat-jalan.tambah-surat', [
            'title' => 'transaksi',
            'id' => $id,
            'isChangeStatus' => true
        ]);
    }
    public function printPenjualan(Penjualan $sale)
    {
        $profile = Profile::first();
        $bayar = str_replace('.', '', $sale->jumah_bayar);
        $terbilang = $this->terbilang(doubleval($sale->total_hutang));
        $limit = 0;
        $page = 9;
        $count = ceil($sale->produk_penjualan->count() / $page);
        $details = [];
        $halaman = $count;
        for ($key = 0; $key < $count; $key++) {
            $details[$key] = $sale->produk_penjualan()->skip($limit)->take($page)->get();
            $limit += $page; // Increment limit by the page size
        }
        $footer = SetNoFaktur::where('id_perusahaan', Auth::user()->id_perusahaan)->first()->footer;
        return view('pages.transaksi.penjualan.penjualan.print-penjualan', compact('sale', 'terbilang', 'profile', 'details', 'halaman', 'footer'));
    }

    function terbilang($nilai)
    {
        $nilai = abs($nilai);
        $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " " . $huruf[$nilai];
        } else if ($nilai < 20) {
            $temp = $this->terbilang($nilai - 10) . " belas";
        } else if ($nilai < 100) {
            $temp = $this->terbilang($nilai / 10) . " puluh" . $this->terbilang($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " seratus" . $this->terbilang($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = $this->terbilang($nilai / 100) . " ratus" . $this->terbilang($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " seribu" . $this->terbilang($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = $this->terbilang($nilai / 1000) . " ribu" . $this->terbilang($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = $this->terbilang($nilai / 1000000) . " juta" . $this->terbilang($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = $this->terbilang($nilai / 1000000000) . " milyar" . $this->terbilang(fmod($nilai, 1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = $this->terbilang($nilai / 1000000000000) . " trilyun" . $this->terbilang(fmod($nilai, 1000000000000));
        }
        return ucwords($temp);
    }
}
