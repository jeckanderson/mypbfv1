<?php

namespace App\Http\Controllers;

use App\Imports\ObatBarangImport;
use App\Jobs\MasterData\ImportProductJob;
use App\Models\DaftarObat;
use App\Models\DiskonKelompok;
use App\Models\Golongan;
use App\Models\JenisObatBarang;
use App\Models\Kelompok;
use App\Models\ObatBarang;
use App\Models\Produsen;
use App\Models\Satuan;
use App\Models\SubGolongan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Profile;
use Maatwebsite\Excel\Facades\Excel;

class ObatBarangController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:akses_produk']);
        $this->middleware(['permission:tambah_produk'])->only('tambahObat');
        $this->middleware(['permission:aksi_produk'])->only('editObat');
        $this->middleware(['permission:aksi_produk'])->only('deleteObat');
    }

    public function index()
    {
        return view('pages.master.produk.obat-barang', [
            'title' => 'master',
        ]);
    }

    public function export_produk_pdf()
    {
        $sales = ObatBarang::get();
        $profile = Profile::get();
        $pdf = Pdf::loadView('pdf.produk', [
            'obat_barang' => $sales,
            'profile' => $profile
        ]);
        return $pdf->stream('download-data-obat-dan-barang');
    }

    public function excel_produk()
    {
        $obat_barang = ObatBarang::get();
        $profile = Profile::get();
        return view('excel.produk', [
            'obat_barang' => $obat_barang,
            'profile' => $profile
        ]);
    }

    public function tambahObat(Request $request)
    {
        $request->merge(['id_perusahaan' => Auth::user()->id_perusahaan]);
        $request->merge(['exp_date' => $request->has('exp_date') ? 1 : 0]);
        $request->merge(['status' => $request->has('status') ? 1 : 0]);

        $obatBarang = ObatBarang::create($request->all());

        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $unique = uniqid() . '.' . $gambar->getClientOriginalExtension();
            $gambar->storeAs('public/obat-barang', $unique);

            $obatBarang->gambar = $unique;
            $obatBarang->save();
        }

        $kelompoks = $request->input('kelompoks');

        foreach ($kelompoks as $kelompok) {
            DiskonKelompok::create([
                'id_obat_barang' => $obatBarang['id'],
                'id_kelompok' => $kelompok['id_kelompok'],
                'id_set_harga' => $kelompok['id_set_harga'] ?? 1,
                'isi' => $kelompok['isi'],
                'satuan_dasar_beli' => $kelompok['satuan_dasar_beli'],
                'persentase' => str_replace(',', '.', $kelompok['persentase']) ?? 0,
                'disc_1' => str_replace(',', '.', $kelompok['disc_1']) ?? 0,
                'disc_2' => str_replace(',', '.', $kelompok['disc_2']) ?? 0,
            ]);
        }
        return redirect()->route('obat-barang')->with('success', 'Produk added successfully');
    }

    public function editObat(Request $request, $id)
    {
        $obatBarang = ObatBarang::find($id);
        $request->merge(['exp_date' => $request->has('exp_date') ? 1 : 0]);
        $request->merge(['status' => $request->has('status') ? 1 : 0]);

        if (!$obatBarang) {
            return back()->with('error', 'Produk not found');
        }

        // Update the existing record with the new data
        $obatBarang->update($request->all());

        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $unique = uniqid() . '.' . $gambar->getClientOriginalExtension();
            $gambar->storeAs('public/obat-barang', $unique);

            $obatBarang->gambar = $unique;
            $obatBarang->save();
        }

        // Delete existing DiskonKelompok records for the given obat_barang
        DiskonKelompok::where('id_obat_barang', $id)->delete();

        // Insert updated Kelompok records
        $kelompoks = $request->input('kelompoks');

        foreach ($kelompoks as $kelompok) {
            DiskonKelompok::create([
                'id_obat_barang' => $obatBarang['id'],
                'id_kelompok' => $kelompok['id_kelompok'],
                'id_set_harga' => $kelompok['id_set_harga'] ?? 1,
                'isi' => $kelompok['isi'],
                'satuan_dasar_beli' => $kelompok['satuan_dasar_beli'],
                'persentase' => str_replace(',', '.', $kelompok['persentase']) ?? 0,
                'disc_1' => str_replace(',', '.', $kelompok['disc_1']) ?? 0,
                'disc_2' => str_replace(',', '.', $kelompok['disc_2']) ?? 0,
            ]);
        }
        return redirect()->route('obat-barang')->with('success', 'Produk updated successfully');
    }


    public function deleteObat($id)
    {
        $barang = ObatBarang::find($id);

        if (!$barang) {
            return back()->with('error', 'Produk not found');
        }

        if ($barang->gambar) {
            $path = 'obat-barang/' . $barang->gambar;

            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }

        if ($barang->stokAwal) {
            $barang->stokAwal->delete();
        }

        DiskonKelompok::where('id_obat_barang', $id)->delete();

        $barang->delete();

        return back()->with('success', 'Produk berhasil dihapus');
    }


    public function ProdukEReport()
    {
        return view('pages.master.produk.cari-produk', [
            'title' => 'master',
            'produks' => [],
            'allProduk' => DaftarObat::paginate(100)
        ]);
    }
    public function cariProdukEReport(Request $request)
    {
        return view('pages.master.produk.cari-produk', [
            'title' => 'master',
            'produks' => DaftarObat::where('nama_obat', 'like', "%" . $request->cari . "%")->paginate(100)
        ]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);
        $file = $request->file('file');
        $filePath = $file->store('uploads');
        $id = auth()->user()->id_perusahaan;
        dispatch(new ImportProductJob($filePath, $id));
        // Excel::import(new ObatBarangImport, $request->file('file'));

        return redirect()->route('obat-barang')->with('success', 'Data berhasil diimpor.');
    }
}
