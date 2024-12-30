<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class SalesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:akses_sales']);
        $this->middleware(['permission:tambah_sales'])->only('tambahSales');
        $this->middleware(['permission:aksi_sales'])->only('editSales');
        $this->middleware(['permission:aksi_sales'])->only('deleteSales');
    }

    public function index()
    {
        return view('pages.perusahaan.marketing.sales', [
            'title' => "perusahaan",
            'sales' => Sales::where('id_perusahaan', Auth::user()->id_perusahaan)->get(),
            'pegawais' => Pegawai::where('id_perusahaan', Auth::user()->id_perusahaan)->where('marketing', 'on')->get(),
        ]);
    }

    public function export_sales_pdf()
    {
        $sales = Sales::get();
        $pdf = Pdf::loadView('pdf.sales', [
            'sales' => $sales
        ]);
        return $pdf->stream('download-data-sales');
    }

    public function tambahSales(Request $request)
    {
        $sales = new Sales();
        $sales->id_perusahaan = Auth::user()->id_perusahaan;
        $sales->supervisor = $request->supervisor;
        $sales->sales = $request->sales;
        $sales->area_rayon = $request->area_rayon;
        $sales->sub_rayon = $request->sub_rayon;

        $sales->save();

        return back()->with('success', 'Sales added successfully');
    }

    public function editSales(Request $request, $id)
    {
        $sales = Sales::find($id);
        $sales->id_perusahaan = Auth::user()->id_perusahaan;
        $sales->supervisor = $request->supervisor;
        $sales->sales = $request->sales;
        $sales->area_rayon = $request->area_rayon;
        $sales->sub_rayon = $request->sub_rayon;

        $sales->save();

        return back()->with('success', 'Sales edit successfully');
    }

    public function deleteSales($id)
    {
        $sales = Sales::find($id);
        $sales->delete();
        return back()->with('success', 'Sales delete successfully');
    }
}