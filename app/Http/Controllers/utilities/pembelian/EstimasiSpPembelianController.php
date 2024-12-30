<?php

namespace App\Http\Controllers\utilities\pembelian;

use App\Models\Sales;
use App\Models\Gudang;
use App\Models\Suplier;
use App\Models\Golongan;
use App\Models\Kelompok;
use App\Models\Produsen;
use App\Models\SubRayon;
use App\Models\AreaRayon;
use App\Models\Pelanggan;
use App\Models\Pembelian;
use App\Models\Penjualan;
use App\Models\SPPembelian;
use Illuminate\Http\Request;
use App\Models\ReturPembelian;
use App\Models\ReturPenjualan;
use App\Models\ProdukPembelian;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class EstimasiSpPembelianController extends Controller
{
    public function index()
    {
        return view('utilities.laporan.pembelian.estimasi-sp-pembelian.estimasi-sp-pembelian', [
            'title' => 'utilities',
        ]);
    }
}
