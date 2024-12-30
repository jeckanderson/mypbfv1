<?php

namespace App\Http\Controllers;

use App\Imports\MasterData\PelangganImport;
use App\Jobs\MasterData\ImportPelangganJob;
use App\Models\AreaRayon;
use App\Models\Kelompok;
use App\Models\Pegawai;
use App\Models\Pelanggan;
use App\Models\SubRayon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Profile;
use Maatwebsite\Excel\Facades\Excel;

class PelangganController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:akses_pelanggan']);
        $this->middleware(['permission:tambah_pelanggan'])->only('tambahPelanggan');
        $this->middleware(['permission:aksi_pelanggan'])->only('editPelanggan');
        $this->middleware(['permission:aksi_pelanggan'])->only('deletePelanggan');
    }

    public function index(Request $request)
    {
        
        $pelanggans = Pelanggan::when($request->search,function($q) use($request) {
            $q->where('nama','LIKE','%'.$request->search.'%');
            $q->orWhere('kode','LIKE','%'.$request->search.'%');
            $q->orWhere('kode_e_report','LIKE','%'.$request->search.'%');
        })->where('id_perusahaan', Auth::user()->id_perusahaan)->paginate(10);
        return view('pages.master.customer.pelanggan', [
            'title' => 'master',
            'pegawais' => Pegawai::where('id_perusahaan', Auth::user()->id_perusahaan)->where('marketing', 'on')->get(),
            'kelompoks' => Kelompok::where('id_perusahaan', Auth::user()->id_perusahaan)->get(),
            'pelanggans' => $pelanggans,
            'rayons' => AreaRayon::where('id_perusahaan', Auth::user()->id_perusahaan)->get(),
            'sub_rayons' => SubRayon::where('id_perusahaan', Auth::user()->id_perusahaan)->get(),
        ]);
    }

    public function export_pelanggan_pdf()
    {
        $sales = Pelanggan::get();
        $profile = Profile::get();
        $pdf = Pdf::loadView('pdf.pelanggan', [
            'pelanggans' => $sales,
            'profile' => $profile
        ]);
        return $pdf->stream('download-data-pelanggan');
    }

    public function excel_pelanggan()
    {
        $pelanggans = Pelanggan::get();
        $profile = Profile::get();
        return view('excel.pelanggan', [
            'pelanggans' => $pelanggans,
            'profile' => $profile
        ]);
    }

    public function tambahPelanggan(Request $request)
    {
        $request->merge(['id_perusahaan' => Auth::user()->id_perusahaan]);
        $request->merge(['date_status_sipa' => $request->has('date_status_sipa') ? 1 : 0]);
        $request->merge(['date_status_sia' => $request->has('date_status_sia') ? 1 : 0]);

        Pelanggan::create($request->all());

        return back()->with('success', 'Pelanggan add successfully');
    }

    public function editPelanggan(Request $request, $id)
    {
        $pelanggan = Pelanggan::find($id);
        $request->merge(['date_status_sipa' => $request->has('date_status_sipa') ? 1 : 0]);
        $request->merge(['date_status_sia' => $request->has('date_status_sia') ? 1 : 0]);

        $pelanggan->update($request->all());

        return back()->with('success', 'Pelanggan edited successfully');
    }

    public function deletePelanggan(Request $request, $id)
    {
        $pelanggan = Pelanggan::find($id);
        $pelanggan->delete();

        return back()->with('success', 'Pelanggan deleted successfully');
    }
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);
        $file = $request->file('file');
        $filePath = $file->store('uploads');
        $id = auth()->user()->id_perusahaan;
        dispatch(new ImportPelangganJob($filePath,$id));


        

        return to_route('pelanggan')->with('success', 'Data berhasil diimpor.');
    }
}