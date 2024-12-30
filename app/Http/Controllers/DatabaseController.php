<?php

namespace App\Http\Controllers;

use App\Models\DetailSuratJalan;
// use App\Models\DiskonKelompok;
use App\Models\HistoryStok;
use App\Models\HutangAwal;
use App\Models\HutangPengguna;
use App\Models\Jurnal;
use App\Models\JurnalAkun;
use App\Models\JurnalTetap;
use App\Models\Kontrabon;
use App\Models\MutasiSaldoAkun;
use App\Models\MutasiStok;
use App\Models\NoSPPembelian;
use App\Models\Pajak;
use App\Models\PembayaranHutang;
use App\Models\PembayaranPiutang;
use App\Models\Pembelian;
use App\Models\Penjualan;
use App\Models\PiutangAwal;
use App\Models\PiutangPengguna;
use App\Models\ProdukDiterima;
use App\Models\ProdukPembelian;
use App\Models\ProdukPenjualan;
use App\Models\ProdukReturPembelian;
use App\Models\ProdukReturPenjualan;
use App\Models\RencanaOrder;
use App\Models\RencanaPengadaan;
use App\Models\ReturPembelian;
use App\Models\ReturPenjualan;
use App\Models\SetHarga;
use App\Models\SetNoFaktur;
use App\Models\SPPembelian;
use App\Models\SPPenjualan;
use App\Models\StokAwal;
use App\Models\StokOpname;
use App\Models\SuratJalan;
use App\Models\TagihanPelanggan;
use App\Models\TempSaldoAwal;
use App\Models\TerimaBarang;
use App\Models\DetailJurnalAkun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DatabaseController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:akses_reset'])->only('reset');
    }

    public function reset()
    {
        Pajak::where('id_perusahaan', Auth::user()->id_perusahaan)->delete();
        HutangAwal::where('id_perusahaan', Auth::user()->id_perusahaan)->delete();
        PiutangAwal::where('id_perusahaan', Auth::user()->id_perusahaan)->delete();
        StokAwal::where('id_perusahaan', Auth::user()->id_perusahaan)->delete();
        TempSaldoAwal::where('id_perusahaan', Auth::user()->id_perusahaan)->delete();
        Jurnal::where('id_perusahaan', Auth::user()->id_perusahaan)->delete();
        JurnalTetap::where('id_perusahaan', Auth::user()->id_perusahaan)->delete();
        HistoryStok::where('id_perusahaan', Auth::user()->id_perusahaan)->delete();
        StokOpname::where('id_perusahaan', Auth::user()->id_perusahaan)->delete();
        MutasiStok::where('id_perusahaan', Auth::user()->id_perusahaan)->delete();
        RencanaPengadaan::where('id_perusahaan', Auth::user()->id_perusahaan)->delete();
        SPPembelian::where('id_perusahaan', Auth::user()->id_perusahaan)->delete();
        SPPenjualan::where('id_perusahaan', Auth::user()->id_perusahaan)->delete();
        RencanaOrder::where('id_perusahaan', Auth::user()->id_perusahaan)->delete();
        Pembelian::where('id_perusahaan', Auth::user()->id_perusahaan)->delete();
        ProdukPembelian::where('id_perusahaan', Auth::user()->id_perusahaan)->delete();
        Penjualan::where('id_perusahaan', Auth::user()->id_perusahaan)->delete();
        ProdukPenjualan::where('id_perusahaan', Auth::user()->id_perusahaan)->delete();
        ReturPembelian::where('id_perusahaan', Auth::user()->id_perusahaan)->delete();
        ProdukReturPembelian::where('id_perusahaan', Auth::user()->id_perusahaan)->delete();
        ReturPenjualan::where('id_perusahaan', Auth::user()->id_perusahaan)->delete();
        ProdukReturPenjualan::where('id_perusahaan', Auth::user()->id_perusahaan)->delete();
        TerimaBarang::where('id_perusahaan', Auth::user()->id_perusahaan)->delete();
        ProdukDiterima::where('id_perusahaan', Auth::user()->id_perusahaan)->delete();
        NoSPPembelian::where('id_perusahaan', Auth::user()->id_perusahaan)->delete();
        SetNoFaktur::where('id_perusahaan', Auth::user()->id_perusahaan)->delete();
        SuratJalan::where('id_perusahaan', Auth::user()->id_perusahaan)->delete();
        MutasiSaldoAkun::where('id_perusahaan', Auth::user()->id_perusahaan)->delete();
        Kontrabon::where('id_perusahaan', Auth::user()->id_perusahaan)->delete();
        TagihanPelanggan::where('id_perusahaan', Auth::user()->id_perusahaan)->delete();
        PembayaranHutang::where('id_perusahaan', Auth::user()->id_perusahaan)->delete();
        PembayaranPiutang::where('id_perusahaan', Auth::user()->id_perusahaan)->delete();
        HutangPengguna::where('id_perusahaan', Auth::user()->id_perusahaan)->delete();
        JurnalAkun::where('id_perusahaan', Auth::user()->id_perusahaan)->delete();
        SetHarga::where('id_perusahaan', Auth::user()->id_perusahaan)->delete();
        PiutangPengguna::where('id_perusahaan', Auth::user()->id_perusahaan)->delete();
        DetailSuratJalan::where('id_perusahaan', Auth::user()->id_perusahaan)->delete();
        DetailJurnalAkun::where('id_perusahaan', Auth::user()->id_perusahaan)->delete();
        // DiskonKelompok::query()->delete();
        return redirect('/');
    }
}
