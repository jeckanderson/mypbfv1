<?php

namespace App\Http\Controllers;

use App\Imports\StokAwalImport;
use App\Models\AkunAkutansi;
use App\Models\DiskonKelompok;
use App\Models\Gudang;
use App\Models\HistoryStok;
use App\Models\JenisObatBarang;
use App\Models\Jurnal;
use App\Models\JurnalTetap;
use App\Models\Kelompok;
use App\Models\ObatBarang;
use App\Models\Rak;
use App\Models\Satuan;
use App\Models\SetHarga;
use App\Models\StokAwal;
use App\Models\SubRak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Profile;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class StokAwalController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:akses_stok_awal']);
        $this->middleware(['permission:tambah_stok_awal'])->only('tambahStok');
        $this->middleware(['permission:aksi_stok_awal'])->only('editStok');
        $this->middleware(['permission:aksi_stok_awal'])->only('deleteStok');
    }

    public function index()
    {
        $lastOrder = StokAwal::latest()->first();

        if ($lastOrder) {
            // Jika ada data terakhir, ambil nomor urutan dari referensi dan tambahkan 1
            $lastOrderNumber = explode('/', $lastOrder->no_reff)[0];
            $nextOrderNumber = intval($lastOrderNumber) + 1;
        } else {
            // Jika tidak ada data sebelumnya, mulai dengan nomor 1
            $nextOrderNumber = 1;
        }

        // Format nomor urutan dengan str_pad
        $urutan = str_pad($nextOrderNumber, 6, '0', STR_PAD_LEFT);

        return view('pages.set-awal.stok-awal', [
            'title' => 'setting awal',
            'stoks' => StokAwal::where('id_perusahaan', Auth::user()->id_perusahaan)->get(),
            'barangs' => ObatBarang::where('id_perusahaan', Auth::user()->id_perusahaan)->get(),
            'gudangs' => Gudang::where('id_perusahaan', Auth::user()->id_perusahaan)->get(),
            'raks' => Rak::where('id_perusahaan', Auth::user()->id_perusahaan)->get(),
            'sub_rak' => SubRak::where('id_perusahaan', Auth::user()->id_perusahaan)->get(),
            'jenis_obat' => JenisObatBarang::where('id_perusahaan', Auth::user()->id_perusahaan)->get(),
            'urutan' => $urutan
        ]);
    }

    public function export_stokawal_pdf()
    {
        $stok = StokAwal::get();
        $profile = Profile::get();
        $pdf = Pdf::loadView('pdf.stok_awal', [
            'stoks' => $stok,
            'profile' => $profile
        ]);
        return $pdf->stream('download-data-stok-awal.pdf');
    }

    public function excel_stok_awal()
    {
        $stok = StokAwal::get();
        $profile = Profile::get();
        return view('excel.stok_awal', [
            'stoks' => $stok,
            'profile' => $profile
        ]);
    }

    public function tambahStok(Request $request)
    {
        $request->merge(['id_perusahaan' => Auth::user()->id_perusahaan]);
        $stok = StokAwal::create($request->all());
        if ($stok) {
            $isi = DiskonKelompok::where('id_obat_barang', $request->id_obat_barang)
                ->where('satuan_dasar_beli', $request->satuan)
                ->first()->isi;
            $stok_masuk = $isi * $request->jumlah;
            $history = HistoryStok::create([
                'id_perusahaan' => Auth::user()->id_perusahaan,
                'id_produk' => $request->id_obat_barang,
                'no_reff' => $request->no_reff,
                'no_faktur' => '-',
                'no_batch' => $request->no_batch ?? '-',
                'exp_date' => $request->exp_date ?? '-',
                'suplier_pelanggan' => '-',
                'id_gudang' => $request->gudang,
                'id_rak' => $request->rak,
                'id_sub_rak' => $request->sub_rak,
                'sumber_set_harga' => 'Stok Awal',
                'id_set_harga' => $stok->id,
                'stok_masuk' => $stok_masuk,
                'stok_keluar' => 0,
                'stok_akhir' => (HistoryStok::where('id_perusahaan', Auth::user()->id_perusahaan)->where('id_produk', $request->id_obat_barang)->where('id_gudang', $request->gudang)->where('id_rak', $request->rak)->where('id_sub_rak', $request->sub_rak)->latest()->first()->stok_akhir ?? 0) + $stok_masuk,
                'keterangan' => 'Stok Awal'
            ]);

            $stok->update(['id_histori' => $history->id]);

            //menambahkan ke Jurnal akun Persediaan dagang dan konsi
            Jurnal::create([
                'id_perusahaan' => Auth::user()->id_perusahaan,
                'no_reff' => $request->no_reff,
                'kode_akun' => AkunAkutansi::find(3)->kode,
                'id_sumber' => $stok->id,
                'sumber' => 'Stok Awal',
                'keterangan' => 'Stok Awal',
                'debet' => (str_replace('.', '', $request->hpp) * str_replace('.', '', $request->jumlah)),
            ]);

            //meanmbahkan ke jurnal tetap akun persediaan dagang dan konsi
            $jurnalTetap =  JurnalTetap::where('id_akun', 3)->where('id_perusahaan', Auth::user()->id_perusahaan)->first();
            if ($jurnalTetap) {
                $jurnalTetap->update([
                    'saldo' => $jurnalTetap->saldo + (str_replace('.', '', $request->hpp) * str_replace('.', '', $request->jumlah)),
                ]);
            } else {
                JurnalTetap::create([
                    'id_perusahaan' => Auth::user()->id_perusahaan,
                    'id_akun' => 3,
                    'saldo' => (str_replace('.', '', $request->hpp) * str_replace('.', '', $request->jumlah))
                ]);
            }

            //menambahkan ke junal akun modal
            Jurnal::create([
                'id_perusahaan' => Auth::user()->id_perusahaan,
                'no_reff' => $request->no_reff,
                'kode_akun' => AkunAkutansi::find(8)->kode,
                'id_sumber' => $stok->id,
                'sumber' => 'Stok Awal',
                'keterangan' => 'Stok Awal',
                'kredit' => (str_replace('.', '', $request->hpp) * str_replace('.', '', $request->jumlah)),
            ]);

            //menambahkan ke jurnal tetap akun modal
            $jurnalTetap =  JurnalTetap::where('id_akun', 8)->where('id_perusahaan', Auth::user()->id_perusahaan)->first();
            if ($jurnalTetap) {
                $jurnalTetap->update([
                    'saldo' => $jurnalTetap->saldo + (str_replace('.', '', $request->hpp) * str_replace('.', '', $request->jumlah)),
                ]);
            } else {
                JurnalTetap::create([
                    'id_perusahaan' => Auth::user()->id_perusahaan,
                    'id_akun' => 8,
                    'saldo' => (str_replace('.', '', $request->hpp) * str_replace('.', '', $request->jumlah))
                ]);
            }

            //tambah sert harga
            foreach (Kelompok::where('id_perusahaan', Auth::user()->id_perusahaan)->get() as $kelompok) {
                foreach (DiskonKelompok::where('id_kelompok', $kelompok->id)->where('satuan_dasar_beli', '!=', null)->where('id_obat_barang', $stok->id_obat_barang)->get() as $disc) {
                    $hpp_final =
                        (str_replace('.', '', $stok->hpp) / $request->isi_satuan) *
                        $disc->isi;

                    $persentase = $disc->persentase;
                    $disc_1 = $disc->disc_1;
                    $disc_2 = $disc->disc_2;
                    $hasil_laba = round($hpp_final * (1 + $persentase / 100));
                    $harga1 = $hasil_laba - ($hasil_laba * $disc_1) / 100;
                    $harga_jual = round($harga1 - ($harga1 * $disc_2) / 100);
                    SetHarga::create([
                        'id_perusahaan' => Auth::user()->id_perusahaan,
                        'id_set_harga' => $stok->id,
                        'sumber' => 'Stok Awal',
                        'id_produk' => $stok->id_obat_barang,
                        'id_kelompok' => $kelompok->id,
                        'id_set' => $disc->id_set_harga,
                        'id_jumlah' => 1,
                        'satuan' => $disc->satuan_dasar_beli,
                        'jumlah' =>  '-',
                        'sampai' => '-',
                        'isi' => $disc->isi,
                        'hpp_final' => $hpp_final,
                        'laba' => $persentase,
                        'hasil_laba' =>  $hasil_laba,
                        'disc_1' => $disc_1,
                        'disc_2' => $disc_2,
                        'harga_jual' => $harga_jual,
                    ]);
                }
            }
        }

        return back()->with('success', 'Stok Awal added successfully');
    }

    public function editStok(Request $request, $id)
    {
        $stokawal = StokAwal::find($id);

        if (!$stokawal) {
            return back()->with('error', 'Stok not found');
        }

        $isi = DiskonKelompok::where('id_obat_barang', $request->id_obat_barang)
            ->where('satuan_dasar_beli', $request->satuan)
            ->first()->isi;
        $stok_masuk = $isi * $request->jumlah;
        HistoryStok::where('no_reff', $stokawal->no_reff)->where('id_perusahaan', Auth::user()->id_perusahaan)->first()->update([
            'id_produk' => $request->id_obat_barang,
            'no_reff' => $request->no_reff,
            'no_batch' => $request->no_batch ?? '-',
            'exp_date' => $request->exp_date ?? '-',
            'id_gudang' => $request->gudang,
            'id_rak' => $request->rak,
            'id_sub_rak' => $request->sub_rak,
            'stok_masuk' => $stok_masuk,
            'stok_akhir' => (HistoryStok::where('id_perusahaan', Auth::user()->id_perusahaan)->where('id_produk', $request->id_obat_barang)->where('id_gudang', $request->gudang)->where('id_rak', $request->rak)->where('id_sub_rak', $request->sub_rak)->latest()->first()->stok_akhir ?? 0) + $stok_masuk,
            'keterangan' => 'Stok Awal'
        ]);

        //update jurnal tetap
        $jurnalPersediaanDagang = JurnalTetap::where('id_akun', 3)->where('id_perusahaan', Auth::user()->id_perusahaan)->first();
        $jurnalModal = JurnalTetap::where('id_akun', 8)->where('id_perusahaan', Auth::user()->id_perusahaan)->first();
        $jurnalPersediaanDagang->update([
            'saldo' => (str_replace('.', '', $request->hpp) * str_replace('.', '', $request->jumlah)),
        ]);
        $jurnalModal->update([
            'saldo' => $jurnalModal->saldo - (str_replace('.', '', $stokawal->hpp) - (str_replace('.', '', $request->hpp) * str_replace('.', '', $request->jumlah))),
        ]);

        //update jurnal kedua
        Jurnal::where('kode_akun', AkunAkutansi::find(3)->kode)
            ->where('id_perusahaan', Auth::user()->id_perusahaan)
            ->where('id_sumber', $stokawal->id)
            ->first()
            ->update(['debet' => (str_replace('.', '', $request->hpp) * str_replace('.', '', $request->jumlah))]);

        $jurnalModal2 = Jurnal::where('kode_akun', AkunAkutansi::find(8)->kode)
            ->where('id_perusahaan', Auth::user()->id_perusahaan)
            ->where('id_sumber', $stokawal->id)
            ->first();

        $jurnalModal2->update([
            'kredit' => $jurnalModal2->kredit - (str_replace('.', '', $stokawal->hpp) - (str_replace('.', '', $request->hpp) * str_replace('.', '', $request->jumlah))),
        ]);

        SetHarga::where('id_set_harga', $stokawal->id)->where('sumber', 'Stok Awal')->delete();

        foreach (Kelompok::where('id_perusahaan', Auth::user()->id_perusahaan)->get() as $kelompok) {
            foreach (DiskonKelompok::where('id_kelompok', $kelompok->id)->where('satuan_dasar_beli', '!=', null)->where('id_obat_barang', $stokawal->id_obat_barang)->get() as $disc) {
                $hpp_final =
                    (str_replace('.', '', $stokawal->hpp) / $request->isi_satuan) *
                    $disc->isi;

                $persentase = $disc->persentase;
                $disc_1 = $disc->disc_1;
                $disc_2 = $disc->disc_2;
                $hasil_laba = round($hpp_final * (1 + $persentase / 100));
                $harga1 = $hasil_laba - ($hasil_laba * $disc_1) / 100;
                $harga_jual = round($harga1 - ($harga1 * $disc_2) / 100);
                SetHarga::create([
                    'id_perusahaan' => Auth::user()->id_perusahaan,
                    'id_set_harga' => $stokawal->id,
                    'sumber' => 'Stok Awal',
                    'id_produk' => $stokawal->id_obat_barang,
                    'id_kelompok' => $kelompok->id,
                    'id_set' => $disc->id_set_harga,
                    'id_jumlah' => 1,
                    'satuan' => $disc->satuan_dasar_beli,
                    'jumlah' =>  '-',
                    'sampai' => '-',
                    'isi' => $disc->isi,
                    'hpp_final' => $hpp_final,
                    'laba' => $persentase,
                    'hasil_laba' =>  $hasil_laba,
                    'disc_1' => $disc_1,
                    'disc_2' => $disc_2,
                    'harga_jual' => $harga_jual,
                ]);
            }
        }
        $stokawal->update($request->all());

        return back()->with('success', 'Stok Awal edited successfully');
    }

    public function deleteStok($id)
    {
        $stokawal = StokAwal::find($id);

        if (!$stokawal) {
            return back()->with('error', 'Stok not found');
        }

        HistoryStok::where('no_reff', $stokawal->no_reff)->where('id_perusahaan', Auth::user()->id_perusahaan)->delete();
        $jurnalPersediaanDagang = JurnalTetap::where('id_akun', 3)->where('id_perusahaan', Auth::user()->id_perusahaan)->first();
        $jurnalModal = JurnalTetap::where('id_akun', 8)->where('id_perusahaan', Auth::user()->id_perusahaan)->first();
        $jurnalPersediaanDagang->update([
            'saldo' => $jurnalPersediaanDagang->saldo - (str_replace('.', '', $stokawal->hpp) * str_replace('.', '', $stokawal->jumlah)),
        ]);
        $jurnalModal->update([
            'saldo' => $jurnalModal->saldo - (str_replace('.', '', $stokawal->hpp) * str_replace('.', '', $stokawal->jumlah)),
        ]);
        Jurnal::where('id_sumber', $id)->delete();
        $stokawal->delete();
        SetHarga::where('id_set_harga', $id)->where('sumber', 'stok-awal')->delete();

        return back()->with('success', 'Stok Awal delete successfully');
    }

    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx,xls',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'Gagal, pastikan file excel yang anda masukkan benar.');
        }

        try {
            Excel::import(new StokAwalImport, $request->file('file'));
            return redirect()->back()->with('success', 'Data berhasil diimpor dan penjurnalan telah dilakukan.');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            // Tangani jika terjadi exception saat validasi
            $failures = $e->failures();
            dd($failures);
            return redirect()->back()->withErrors($failures);
        } catch (\Exception $e) {
            // Tangani jika terjadi exception lainnya
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->with('error', 'Gagal, ' . $e->getMessage());
        }
    }

    public function getNamaBarang($id)
    {
        $items = DiskonKelompok::where('id_obat_barang', $id)->pluck('satuan_dasar_beli')->toArray();

        $filteredItems = array_filter($items, function ($value) {
            return $value !== null;
        });

        $diskon = array_values(array_unique($filteredItems));

        $satuanData = Satuan::whereIn('id', $diskon)->pluck('satuan', 'id');

        // Susun ulang array hasil sesuai dengan urutan dari $diskon
        $orderedSatuan = collect($diskon)->map(function ($id) use ($satuanData) {
            return $satuanData[$id];
        });

        $barang = ObatBarang::find($id);

        return response()->json([
            'satuan_dasar' => $barang->satuanDasar->satuan,
            'satuan_terkecil' => $barang->satuanTerkecil->satuan,
            'satuan' => $diskon,
            'nama_satuan' => $orderedSatuan,
            'isi' => $barang->isi,
            'tipe' => $barang->tipe,
            'exp_date' => $barang->exp_date,
        ]);
    }

    public function getIsiBarang($id, $satuan)
    {
        $isi = DiskonKelompok::where('id_obat_barang', $id)->where('satuan_dasar_beli', $satuan)->pluck('isi')->first();
        return response()->json([
            'isi' => $isi,
        ]);
    }
}