<?php

namespace App\Http\Controllers;

use App\Models\HistoryStok;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ProdukPenjualan;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;

class PengadaanController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:akses_analisis_pareto_abc'])->only('analisisPareto');
        $this->middleware(['permission:akses_analisis_ven'])->only('analisisOrder');
        $this->middleware(['permission:akses_defecta'])->only('defecta');
        $this->middleware(['permission:aksi_defecta'])->only('historiPembelian');
    }

    public function analisisPareto()
    {
        return view('pages.transaksi.pengadaan.analisis-pareto', [
            'title' => 'transaksi'
        ]);
    }

    public function export_analisis_pareto_pdf(Request $request)
    {
        $tanggalMulai = $request->query('tanggalMulai');
        $tanggalAkhir = $request->query('tanggalAkhir');

        $produkPenjualan = ProdukPenjualan::whereBetween('updated_at', [$tanggalMulai, $tanggalAkhir])->get();
        $data = [];

        $profile = Profile::get();

        $produkPenjualan = ProdukPenjualan::where('id_perusahaan', Auth::user()->id_perusahaan)->groupBy('id_produk')->get();

        $pdf = Pdf::loadView('pdf.analisis_pareto', compact('produkPenjualan', 'profile', 'tanggalMulai', 'tanggalAkhir'))->setPaper('a4', 'landscape');
        return $pdf->stream('download-data-analisis-pareto.pdf');
    }

    public function excel_analisis_pareto()
    {
        $produkPenjualan = ProdukPenjualan::all();
        $data = [];

        // Retrieve profile data
        $profile = Profile::get();

        foreach ($produkPenjualan as $prod) {
            $jumlahProduk = ProdukPenjualan::where('id_produk', $prod->id)->count();
            $totalHarga = ProdukPenjualan::where('id_produk', $prod->id)->sum('total');
            $hargaJual = $totalHarga != 0 ? $totalHarga / $jumlahProduk : 0;
            $persentase = round(($totalHarga / ProdukPenjualan::where('id_perusahaan', Auth::user()->id_perusahaan)->sum('total')) * 100);

            $data[] = [
                'produk' => $prod,
                'jumlahProduk' => $jumlahProduk,
                'totalHarga' => $totalHarga,
                'hargaJual' => $hargaJual,
                'persentase' => $persentase
            ];
        }

        // Pass profile data and analyzed data to the view
        return view('excel.analisis_pareto', compact('data', 'profile'));
    }



    public function export_analisis_order_pdf()
    {
        $produkPenjualan = ProdukPenjualan::all();
        $data = [];

        $profile = Profile::get();

        foreach ($produkPenjualan as $prod) {
            $jumlahProduk = ProdukPenjualan::where('id_produk', $prod->id)->count();
            $totalHarga = ProdukPenjualan::where('id_produk', $prod->id)->sum('total');
            $hargaJual = $totalHarga != 0 ? $totalHarga / $jumlahProduk : 0;
            $persentase = round(($totalHarga / ProdukPenjualan::where('id_perusahaan', Auth::user()->id_perusahaan)->sum('total')) * 100);

            $jumlah = HistoryStok::where('id_produk', $prod->id_produk)
                ->where('id_perusahaan', Auth::user()->id_perusahaan)
                ->sum('stok_masuk') -
                HistoryStok::where('id_produk', $prod->id_produk)
                ->where('id_perusahaan', Auth::user()->id_perusahaan)
                ->sum('stok_keluar');
            $analisis = 100; // Masukkan nilai analisis yang sesuai

            $stokIdeal = $jumlahProduk / $analisis;

            $data[] = [
                'produk' => $prod,
                'jumlahProduk' => $jumlahProduk,
                'totalHarga' => $totalHarga,
                'hargaJual' => $hargaJual,
                'persentase' => $persentase,
                'jumlah' => $jumlah,
                'stokIdeal' => $stokIdeal
            ];
        }

        $pdf = Pdf::loadView('pdf.analisis_order', compact('data', 'profile'));
        return $pdf->stream('download-data-analisis-order.pdf');
    }

    public function excel_analisis_order()
    {
        $produkPenjualan = ProdukPenjualan::all();
        $data = [];
        $profile = Profile::get();

        foreach ($produkPenjualan as $prod) {
            $jumlahProduk = ProdukPenjualan::where('id_produk', $prod->id)->count();
            $totalHarga = ProdukPenjualan::where('id_produk', $prod->id)->sum('total');
            $hargaJual = $totalHarga != 0 ? $totalHarga / $jumlahProduk : 0;
            $persentase = round(($totalHarga / ProdukPenjualan::where('id_perusahaan', Auth::user()->id_perusahaan)->sum('total')) * 100);

            $jumlah = HistoryStok::where('id_produk', $prod->id_produk)
                ->where('id_perusahaan', Auth::user()->id_perusahaan)
                ->sum('stok_masuk') -
                HistoryStok::where('id_produk', $prod->id_produk)
                ->where('id_perusahaan', Auth::user()->id_perusahaan)
                ->sum('stok_keluar');
            $analisis = 100; // Masukkan nilai analisis yang sesuai

            $stokIdeal = $jumlahProduk / $analisis;

            $data[] = [
                'produk' => $prod,
                'jumlahProduk' => $jumlahProduk,
                'totalHarga' => $totalHarga,
                'hargaJual' => $hargaJual,
                'persentase' => $persentase,
                'jumlah' => $jumlah,
                'stokIdeal' => $stokIdeal
            ];
        }

        // Mengembalikan view 'pdf.analisis_order' dengan data yang diperlukan
        return view('excel.analisis_order', compact('data', 'profile'));
    }




    public function analisisOrder()
    {
        return view('pages.transaksi.pengadaan.analisis-order', [
            'title' => 'transaksi'
        ]);
    }

    public function defecta()
    {
        return view('pages.transaksi.pengadaan.defecta.data-defecta', [
            'title' => 'transaksi'
        ]);
    }

    public function historiPembelian($id)
    {
        return view('pages.transaksi.pengadaan.defecta.histori-pembelian', [
            'title' => 'transaksi',
            'id' => $id
        ]);
    }

    public function cekRencanaOrder()
    {
        return view('pages.transaksi.pengadaan.sp.rencana-order', [
            'title' => 'transaksi'
        ]);
    }
}