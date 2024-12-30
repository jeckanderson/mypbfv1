<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PembelianController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:akses_pembelian'])->only('pembelian');
        $this->middleware(['permission:akses_retur_pembelian'])->only('returPembelian');
        $this->middleware(['permission:tambah_retur_pembelian'])->only('tambahReturPembelian');
    }

    public function pembelian()
    {
        return view('pages.transaksi.pembelian.pembelian.data-pembelian', [
            'title' => 'transaksi'
        ]);
    }

    public function returPembelian()
    {
        return view('pages.transaksi.pembelian.retur-pembelian.data-retur', [
            'title' => 'transaksi'
        ]);
    }

    public function tambahReturPembelian()
    {
        return view('pages.transaksi.pembelian.retur-pembelian.tambah-retur', [
            'title' => 'transaksi'
        ]);
    }
}