<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\Penjualan;
use App\Models\ReturPembelian;
use App\Models\ReturPenjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanPajakController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:akses_pajak_masukan'])->only('pajakMasukan');
        $this->middleware(['permission:akses_retur_pajak_masukan'])->only('returPajakMasukan');
        $this->middleware(['permission:akses_pajak_keluaran'])->only('pajakKeluaran');
        $this->middleware(['permission:akses_retur_pajak_keluaran'])->only('returPajakKeluaran');
    }

    public function pajakMasukan()
    {
        return view('pages.utilities.pajak.pajak-masukan', [
            'title' => 'utilities',
            'pembelians' => Pembelian::where('id_perusahaan', Auth::user()->id_perusahaan)->get()
        ]);
    }

    public function returPajakMasukan()
    {
        return view('pages.utilities.pajak.retur-pajak-masukan', [
            'title' => 'utilities',
            'returPembelian' => ReturPembelian::where('id_perusahaan', Auth::user()->id_perusahaan)->get()
        ]);
    }

    public function pajakKeluaran()
    {
        return view('pages.utilities.pajak.pajak-keluaran', [
            'title' => 'utilities',
            'penjualans' => Penjualan::where('id_perusahaan', Auth::user()->id_perusahaan)->get()
        ]);
    }

    public function returPajakKeluaran()
    {
        return view('pages.utilities.pajak.retur-pajak-keluaran', [
            'title' => 'utilities',
            'returPenjualan' => ReturPenjualan::where('id_perusahaan', Auth::user()->id_perusahaan)->get()
        ]);
    }
}