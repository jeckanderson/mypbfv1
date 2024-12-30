<?php

namespace App\Http\Controllers;

use App\Models\ObatBarang;
use App\Models\StokAwal;
use App\Models\TempPembelianProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\VarDumper\VarDumper;

class TambahPembelianController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:tambah_pembelian'])->only('index');
        $this->middleware(['permission:aksi_pembelian'])->only('editPembelian');
    }

    public function index()
    {
        return view('pages.transaksi.pembelian.pembelian.tambah-pembelian', [
            'title' => 'transaksi',
            'stoks' => StokAwal::where('id_perusahaan', Auth::user()->id_perusahaan)->get(),
            'barangs' => ObatBarang::where('id_perusahaan', Auth::user()->id_perusahaan)->get(),
            'id' => '',
            'akses' => 'tambah'
        ]);
    }

    public function editPembelian($id)
    {
        return view('pages.transaksi.pembelian.pembelian.tambah-pembelian', [
            'title' => 'transaksi',
            'id' => $id,
            'akses' => 'edit'
        ]);
    }

    public function lihatPembelian($id)
    {
        return view('pages.transaksi.pembelian.pembelian.tambah-pembelian', [
            'title' => 'transaksi',
            'id' => $id,
            'akses' => ''
        ]);
    }
}