<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\Profile;
use App\Models\ReturPembelian;
use App\Models\TerimaBarang;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class CetakTransaksiController extends Controller
{
    public function cetakPembelian($id)
    {
        $pdf = PDF::loadView('pdf.pembelian', [
            'pembelian' => Pembelian::find($id),
            'profile' => Profile::where('id', Auth::user()->id_perusahaan)->first()
        ]);

        return $pdf->stream('download-pembelian.pdf');
    }

    public function cetakTerimaBarang($id)
    {
        $pdf = PDF::loadView('pdf.terima_barang', [
            'terima' => TerimaBarang::find($id),
            'profile' => Profile::where('id', Auth::user()->id_perusahaan)->first()
        ]);

        return $pdf->stream('download-terima-barang.pdf');
    }

    public function cetakReturPembelian($id)
    {
        $pdf = PDF::loadView('pdf.retur_pembelian', [
            'retur' => ReturPembelian::find($id),
            'profile' => Profile::where('id', Auth::user()->id_perusahaan)->first()
        ]);

        return $pdf->stream('download-retur-pembelian.pdf');
    }
}
