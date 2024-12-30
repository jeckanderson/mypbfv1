<?php

namespace App\Http\Controllers;

use App\Imports\MasterData\SupplierImport;
use App\Models\Suplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Profile;
use Maatwebsite\Excel\Facades\Excel;

class SuplierController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:akses_supplier']);
        $this->middleware(['permission:tambah_supplier'])->only('tambahSuplier');
        $this->middleware(['permission:aksi_supplier'])->only('editSuplier');
        $this->middleware(['permission:aksi_supplier'])->only('deleteSuplier');
    }

    public function index(Request $request)
    {
        $suplier = Suplier::when($request->search,function($q) use($request) {
            $q->where('nama_suplier','LIKE','%'.$request->search.'%');
            $q->orWhere('kode','LIKE','%'.$request->search.'%');
            $q->orWhere('kode_e_report','LIKE','%'.$request->search.'%');
        })->where('id_perusahaan', Auth::user()->id_perusahaan)->paginate(10);
        return view('pages.master.produsen.suplier', [
            'title' => 'master',
            'suplier' => $suplier
        ]);
    }

    public function tambahSuplier(Request $request)
    {
        $request->merge(['id_perusahaan' => Auth::user()->id_perusahaan]);
        Suplier::create($request->all());

        return back()->with('success', 'Suplier add successfully');
    }

    public function export_suplier_pdf()
    {
        $sales = Suplier::get();
        $profile = Profile::get();
        $pdf = Pdf::loadView('pdf.suplier', [
            'suplier' => $sales,
            'profile' => $profile
        ]);
        return $pdf->stream('download-data-suplier');
    }

    public function excel_suplier()
    {
        $suplier = Suplier::get();
        $profile = Profile::get();
        return view('excel.suplier', [
            'suplier' => $suplier,
            'profile' => $profile
        ]);
    }

    public function editSuplier(Request $request, $id)
    {
        $suplier = Suplier::find($id);
        $suplier->update($request->all());

        return back()->with('success', 'Suplier edited successfully');
    }

    public function deleteSuplier($id)
    {
        $suplier = Suplier::find($id);
        $suplier->delete();

        return back()->with('success', 'Suplier deleted successfully');
    }
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        Excel::import(new SupplierImport, $request->file('file'));

        return to_route('suplier')->with('success', 'Data berhasil diimpor.');
    }
}