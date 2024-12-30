<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TerimaBarangController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:akses_terima_barang'])->only('index');
        $this->middleware(['permission:tambah_terima_barang'])->only('tambahTerimaBarang');
        $this->middleware(['permission:aksi_terima_barang'])->only('editTerimaBarang');
    }

    public function index()
    {
        return view('pages.transaksi.pembelian.terima-barang.terima-barang', [
            'title' => 'transaksi'
        ]);
    }

    public function tambahTerimaBarang()
    {
        return view('pages.transaksi.pembelian.terima-barang.tambah-terima-barang', [
            'title' => 'transaksi',
            'id' => ''
        ]);
    }

    public function editTerimaBarang($id)
    {
        return view('pages.transaksi.pembelian.terima-barang.tambah-terima-barang', [
            'title' => 'transaksi',
            'id' => $id
        ]);
    }
}