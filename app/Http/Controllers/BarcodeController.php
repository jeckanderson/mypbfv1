<?php

namespace App\Http\Controllers;

use App\Models\ObatBarang;
use App\Models\Pelanggan;
use Picqer\Barcode\BarcodeGeneratorPNG;

class BarcodeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:akses_barcode_produk'])->only('indexProduk');
        $this->middleware(['permission:akses_barcode_pelanggan'])->only('indexPelanggan');
    }

    public function indexProduk()
    {
        return view('pages.master.barcode.barcode-produk', [
            'title' => 'master',
            'produks' => (new ObatBarang())->getByIdPerusahaan(),
        ]);
    }

    public function indexPelanggan()
    {
        return view('pages.master.barcode.barcode-pelanggan', [
            'title' => 'master',
            'pelanggans' => (new Pelanggan())->getByIdPerusahaan(),
        ]);
    }

    public function download($data)
    {
        $generatorPNG = new BarcodeGeneratorPNG();
        $barcodePNG = $generatorPNG->getBarcode($data, $generatorPNG::TYPE_CODE_128);

        $pngPath = public_path('barcode.png');
        file_put_contents($pngPath, $barcodePNG);

        return response()->download($pngPath, 'barcode.png');
    }
    public function printBarcode($data)
    {
        $generatorPNG = new BarcodeGeneratorPNG();
        $barcodePNG = $generatorPNG->getBarcode($data, $generatorPNG::TYPE_CODE_128);

        // Encode the barcode image as base64 for embedding in the print page
        $barcodeBase64 = base64_encode($barcodePNG);

        // Return a view to display the barcode and trigger the print dialog
        return view('barcode.print', ['barcodeBase64' => $barcodeBase64]);
    }
}
