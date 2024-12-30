<?php

namespace App\Http\Controllers;

use App\Models\AkunAkutansi;
use App\Models\HutangAwal;
use App\Models\HutangPengguna;
use App\Models\Profile;
use App\Models\Jurnal;
use App\Models\JurnalTetap;
use App\Models\Suplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Validator;
use App\Imports\HutangAwalImport;
use Maatwebsite\Excel\Facades\Excel;

class HutangAwalController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:akses_hutang_awal']);
        $this->middleware(['permission:tambah_hutang_awal'])->only('create');
        $this->middleware(['permission:aksi_hutang_awal'])->only('edit');
        $this->middleware(['permission:aksi_hutang_awal'])->only('destroy');
    }

    public function index()
    {
        $lastOrder = HutangAwal::latest()->first();

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
        return view('pages.set-awal.hutang-awal', [
            'title' => 'setting awal',
            'hutangAwals' => HutangAwal::where('id_perusahaan', Auth::user()->id_perusahaan)->get(),
            'suppliers' => Suplier::where('id_perusahaan', Auth::user()->id_perusahaan)->get(),
            'numberRandom' => strval(rand(1, 99999999999)),
            'totalHutang' => DB::table('hutang_awals')->get()->sum('jmlh_hutang'),
            'urutan' => $urutan,
        ]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'jns_hutang' => 'required',
            'supplier' => 'required'
        ]);

        $request->merge(['id_perusahaan' => Auth::user()->id_perusahaan]);
        $request['jmlh_hutang'] = str_replace(".", "", $request->jmlh_hutang);
        $tambah = HutangAwal::create($request->all());

        if ($tambah) {
            //agar muncul di pembayaran hutang
            $tambah->hutang_pengguna()->create([
                'id_perusahaan' => Auth::user()->id_perusahaan,
                'id_pembelian' => $tambah->id,
                'sumber' => 'hutang awal',
                'id_suplier' =>   $request['supplier'],
                'nominal_bayar' => 0,
                'detailable_type' => HutangAwal::class,
                'detailable_id' => $tambah->id,
                'total_hutang' =>   $request['jmlh_hutang'],
                'sisa_hutang' =>  $request['jmlh_hutang']
            ]);
            $jurnalHutang = JurnalTetap::where('id_akun', 6)->where('id_perusahaan', Auth::user()->id_perusahaan)->first();
            $jurnalModal = JurnalTetap::where('id_akun', 8)->where('id_perusahaan', Auth::user()->id_perusahaan)->first();
            if ($jurnalHutang) {
                $jurnalHutang->update([
                    'saldo' => $jurnalHutang->saldo + str_replace('.', '', $request->jmlh_hutang),
                ]);
            } else {
                JurnalTetap::create([
                    'id_perusahaan' => Auth::user()->id_perusahaan,
                    'id_akun' => 6,
                    'saldo' => str_replace('.', '', $request->jmlh_hutang)
                ]);
            }
            if ($jurnalModal) {
                $jurnalModal->update([
                    'saldo' => $jurnalModal->saldo - str_replace('.', '', $request->jmlh_hutang),
                ]);
            } else {
                JurnalTetap::create([
                    'id_perusahaan' => Auth::user()->id_perusahaan,
                    'id_akun' => 8,
                    'saldo' => str_replace('.', '', ('-' . $request->jmlh_hutang))
                ]);
            }

            Jurnal::create([
                'id_perusahaan' => Auth::user()->id_perusahaan,
                'no_reff' => $request->no_reff,
                'kode_akun' => AkunAkutansi::find(6)->kode,
                'id_sumber' => $tambah->id,
                'sumber' => 'Hutang Awal',
                'keterangan' => 'Hutang Awal',
                'kredit' => $request->jmlh_hutang,
            ]);
            Jurnal::create([
                'id_perusahaan' => Auth::user()->id_perusahaan,
                'no_reff' => $request->no_reff,
                'kode_akun' => AkunAkutansi::find(8)->kode,
                'id_sumber' => $tambah->id,
                'sumber' => 'Hutang Awal',
                'keterangan' => 'Hutang Awal',
                'debet' => $request->jmlh_hutang,
            ]);
        }
        return back()->with('success', 'Hutang Awal added successfully');
    }

    public function export_hutangawal_pdf(Request $request)
    {
        $filter = $request->get('filter');

        if ($filter) {
            $hutangAwals = HutangAwal::where('jns_hutang', $filter)->get();
        } else {
            $hutangAwals = HutangAwal::get();
        }

        $profile = Profile::get();
        $pdf = Pdf::loadView('pdf.hutang_awal', [
            'hutangAwals' => $hutangAwals,
            'profile' => $profile
        ]);
        return $pdf->stream('download-data-hutang-awal.pdf');
    }

    public function excel_hutang_awal(Request $request)
    {
        $filter = $request->get('filter');

        if ($filter) {
            $hutangAwals = HutangAwal::where('jns_hutang', $filter)->get();
        } else {
            $hutangAwals = HutangAwal::get();
        }

        $profile = Profile::get();
        return view('excel.hutang_awal', [
            'hutangAwals' => $hutangAwals,
            'profile' => $profile
        ]);
    }


    public function edit(Request $request, $id)
    {
        $hutangAwal = HutangAwal::find($id);
        $request['jmlh_hutang'] = str_replace(".", "", $request->jmlh_hutang);

        //update jurnal teteap
        $jurnalPersediaanDagang = JurnalTetap::where('id_akun', 6)->where('id_perusahaan', Auth::user()->id_perusahaan)->first();
        $jurnalModal = JurnalTetap::where('id_akun', 8)->where('id_perusahaan', Auth::user()->id_perusahaan)->first();
        $jurnalPersediaanDagang->update([
            'saldo' => str_replace('.', '', $request->jmlh_hutang),
        ]);
        $jurnalModal->update([
            'saldo' => $jurnalModal->saldo + (str_replace('.', '', $hutangAwal->jmlh_hutang) - str_replace('.', '', $request->jmlh_hutang)),
        ]);

        //update jurnal kedua
        Jurnal::where('kode_akun', AkunAkutansi::find(6)->kode)
            ->where('id_perusahaan', Auth::user()->id_perusahaan)
            ->where('id_sumber', $hutangAwal->id)
            ->first()
            ->update(['kredit' => str_replace('.', '', $request->jmlh_hutang)]);

        $jurnalModal2 = Jurnal::where('kode_akun', AkunAkutansi::find(8)->kode)
            ->where('id_perusahaan', Auth::user()->id_perusahaan)
            ->where('id_sumber', $hutangAwal->id)
            ->first();

        $jurnalModal2->update([
            'debet' => $jurnalModal2->debet - (str_replace('.', '', $hutangAwal->jmlh_hutang) - str_replace('.', '', $request->jmlh_hutang)),
        ]);
        $hutangAwal->update($request->all());
        return back()->with('success', 'Hutang Awal Update successfully');
    }

    public function destroy($id)
    {
        $hutangAwal = HutangAwal::find($id);
        $jurnalHutang = JurnalTetap::where('id_akun', 6)->where('id_perusahaan', Auth::user()->id_perusahaan)->first();
        $jurnalModal = JurnalTetap::where('id_akun', 8)->where('id_perusahaan', Auth::user()->id_perusahaan)->first();
        $jurnalHutang->update([
            'saldo' => $jurnalHutang->saldo - $hutangAwal->jmlh_hutang,
        ]);
        $jurnalModal->update([
            'saldo' => $jurnalModal->saldo + $hutangAwal->jmlh_hutang,
        ]);
        Jurnal::where('id_sumber', $id)->delete();

        HutangPengguna::where('sumber', 'hutang awal')->where('id_pembelian', $id)->delete();
        $hutangAwal->delete();
        return back()->with('success', 'Hutang deleted successfully');
    }

    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'Gagal, pastikan file excel yang anda masukan benar');
        }

        try {
            // Import data
            Excel::import(new HutangAwalImport, $request->file('file'));
            return redirect()->back()->with('success', 'Data berhasil diimpor dan penjurnalan telah dilakukan.');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            dd($failures);
            return redirect()->back()->withErrors($failures);
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->with('error', 'Failed, ' . $e->getMessage());
        }
    }
}