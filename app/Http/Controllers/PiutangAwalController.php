<?php

namespace App\Http\Controllers;

use App\Imports\PiutangAwalImport;
use App\Models\AkunAkutansi;
use App\Models\Jurnal;
use App\Models\JurnalTetap;
use App\Models\Pelanggan;
use App\Models\PiutangAwal;
use App\Models\PiutangPengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Profile;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class PiutangAwalController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:akses_piutang_awal']);
        $this->middleware(['permission:tambah_piutang_awal'])->only('create');
        $this->middleware(['permission:aksi_piutang_awal'])->only('edit');
        $this->middleware(['permission:aksi_piutang_awal'])->only('destroy');
    }

    public function index()
    {
        $lastOrder = PiutangAwal::latest()->first();

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
        return view('pages.set-awal.piutang-awal', [
            'title' => 'setting awal',
            'piutangAwals' => (new PiutangAwal())->getByIdPerusahaan(),
            'pelanggans' => (new Pelanggan())->getByIdPerusahaan(),
            'nofakturRand' => strval(rand(1, 99999999999)),
            'totalPiutang' => PiutangAwal::get()->sum('jmlh_piutang'),
            'urutan' => $urutan,
        ]);
    }

    public function export_piutangawal_pdf(Request $request)
    {
        $filter = $request->get('filter');

        if ($filter) {
            $piutangAwals = PiutangAwal::where('jns_piutang', $filter)->get();
        } else {
            $piutangAwals = PiutangAwal::get();
        }

        $profile = Profile::get();
        $pdf = Pdf::loadView('pdf.piutang_awal', [
            'piutangAwals' => $piutangAwals,
            'profile' => $profile
        ]);
        return $pdf->stream('download-data-piutang-awal.pdf');
    }

    public function excel_piutang()
    {
        $piutangAwals = PiutangAwal::get();
        $profile = Profile::get();
        return view('excel.piutang_awal', [
            'piutangAwals' => $piutangAwals,
            'profile' => $profile
        ]);
    }

    public function edit(Request $request, $id)
    {
        $piutangAwal = PiutangAwal::find($id);
        $request->validate([
            'jns_piutang' => 'required',
            'pelanggan' => 'required'
        ]);
        $request['jmlh_piutang'] = str_replace(".", "", $request->jmlh_piutang);
        //update jurnal teteap
        $jurnalPersediaanDagang = JurnalTetap::where('id_akun', 1)->where('id_perusahaan', Auth::user()->id_perusahaan)->first();
        $jurnalModal = JurnalTetap::where('id_akun', 8)->where('id_perusahaan', Auth::user()->id_perusahaan)->first();
        $jurnalPersediaanDagang->update([
            'saldo' => str_replace('.', '', $request->jmlh_piutang),
        ]);
        $jurnalModal->update([
            'saldo' => $jurnalModal->saldo - (str_replace('.', '', $piutangAwal->jmlh_piutang) - str_replace('.', '', $request->jmlh_piutang)),
        ]);

        //update jurnal kedua
        Jurnal::where('kode_akun', AkunAkutansi::find(1)->kode)
            ->where('id_perusahaan', Auth::user()->id_perusahaan)
            ->where('id_sumber', $piutangAwal->id)
            ->first()
            ->update(['debet' => str_replace('.', '', $request->jmlh_piutang)]);

        $jurnalModal2 = Jurnal::where('kode_akun', AkunAkutansi::find(8)->kode)
            ->where('id_perusahaan', Auth::user()->id_perusahaan)
            ->where('id_sumber', $piutangAwal->id)
            ->first();

        $jurnalModal2->update([
            'kredit' => $jurnalModal2->kredit - (str_replace('.', '', $piutangAwal->jmlh_piutang) - str_replace('.', '', $request->jmlh_piutang)),
        ]);
        $piutangAwal->update($request->all());
        return back()->with('success', 'Piutang Awal Update successfully');
    }

    public function create(Request $request)
    {
        $request->validate([
            'jns_piutang' => 'required',
            'pelanggan' => 'required'
        ]);
        $request->merge(['id_perusahaan' => Auth::user()->id_perusahaan]);
        $request['jmlh_piutang'] = str_replace(".", "", $request->jmlh_piutang);
        $tambah = PiutangAwal::create($request->all());
        if ($tambah) {
            $tambah->piutang_pengguna()->create(
                [
                    'id_perusahaan' => Auth::user()->id_perusahaan,
                    'id_penjualan' => $tambah->id,
                    'detailable_type' => PiutangAwal::class,
                    'detailable_id' => $tambah->id,
                    'sumber' => 'piutang awal',
                    'id_pelanggan' => $request['pelanggan'],
                    'nominal_bayar' => 0,
                    'total_hutang' => $request['jmlh_piutang'] ?? 0,
                    'sisa_hutang' => $request['jmlh_piutang'] ?? 0,
                ]
            );
            $jurnalPiutang = JurnalTetap::where('id_akun', 1)->where('id_perusahaan', Auth::user()->id_perusahaan)->first();
            $jurnalModal = JurnalTetap::where('id_akun', 8)->where('id_perusahaan', Auth::user()->id_perusahaan)->first();
            if ($jurnalPiutang) {
                $jurnalPiutang->update([
                    'saldo' => $jurnalPiutang->saldo + str_replace('.', '', $request->jmlh_piutang),
                ]);
            } else {
                JurnalTetap::create([
                    'id_perusahaan' => Auth::user()->id_perusahaan,
                    'id_akun' => 1,
                    'saldo' => str_replace('.', '', $request->jmlh_piutang)
                ]);
            }
            if ($jurnalModal) {
                $jurnalModal->update([
                    'saldo' => $jurnalModal->saldo + str_replace('.', '', $request->jmlh_piutang),
                ]);
            } else {
                JurnalTetap::create([
                    'id_perusahaan' => Auth::user()->id_perusahaan,
                    'id_akun' => 8,
                    'saldo' => str_replace('.', '', ($request->jmlh_piutang))
                ]);
            }

            Jurnal::create([
                'id_perusahaan' => Auth::user()->id_perusahaan,
                'no_reff' => $request->no_reff,
                'kode_akun' => AkunAkutansi::find(1)->kode,
                'id_sumber' => $tambah->id,
                'sumber' => 'Piutang Awal',
                'keterangan' => 'Piutang Awal',
                'debet' => $request->jmlh_piutang,
            ]);

            Jurnal::create([
                'id_perusahaan' => Auth::user()->id_perusahaan,
                'no_reff' => $request->no_reff,
                'kode_akun' => AkunAkutansi::find(8)->kode,
                'id_sumber' => $tambah->id,
                'sumber' => 'Piutang Awal',
                'keterangan' => 'Piutang Awal',
                'kredit' => $request->jmlh_piutang,
            ]);
        }
        return back()->with('success', 'Piutang Awal added successfully');
    }

    public function destroy($id)
    {
        $piutangAwal = PiutangAwal::find($id);
        $jurnalPiutang = JurnalTetap::where('id_akun', 1)->where('id_perusahaan', Auth::user()->id_perusahaan)->first();
        $jurnalModal = JurnalTetap::where('id_akun', 8)->where('id_perusahaan', Auth::user()->id_perusahaan)->first();
        $jurnalPiutang->update([
            'saldo' => $jurnalPiutang->saldo - $piutangAwal->jmlh_piutang,
        ]);
        $jurnalModal->update([
            'saldo' => $jurnalModal->saldo - $piutangAwal->jmlh_piutang,
        ]);
        Jurnal::where('id_sumber', $id)->delete();
        PiutangPengguna::where('sumber', 'piutang awal')->where('id_penjualan', $id)->delete();
        $piutangAwal->delete();
        return back()->with('success', 'Piutang Awal deleted successfully');
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
            Excel::import(new PiutangAwalImport, $request->file('file'));
            return redirect()->back()->with('success', 'Data berhasil diimpor dan penjurnalan telah dilakukan.');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            dd($failures);
            return redirect()->back()->withErrors($failures);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->with('error', 'Failed, ' . $e->getMessage());
        }
    }
}