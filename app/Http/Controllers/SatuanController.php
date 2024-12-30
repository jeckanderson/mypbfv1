<?php

namespace App\Http\Controllers;

use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SatuanController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:akses_satuan']);
        $this->middleware(['permission:tambah_satuan'])->only('tambahSatuan');
        $this->middleware(['permission:aksi_satuan'])->only('editSatuan');
        $this->middleware(['permission:aksi_satuan'])->only('deleteSatuan');
    }

    public function index()
    {
        $undeleted = [
            'Karton',
            'Box',
            'Botol',
            'Pcs',
            'Tube',
            'Flash',
            'Pack',
            'Vial',
            'Ampul',
            'Sachet'
        ];
        return view('pages.master.produk.satuan', [
            'title' => 'master',
            'undeleted' => $undeleted,
            'satuans' => Satuan::where('id_perusahaan', Auth::user()->id_perusahaan)->get()
        ]);
    }

    public function tambahSatuan(Request $request)
    {
        $satuan = new Satuan();
        $satuan->id_perusahaan = Auth::user()->id_perusahaan;
        $satuan->satuan = $request->satuan;

        $satuan->save();

        return back()->with('success', 'Satuan added successfully');
    }

    public function editSatuan(Request $request, $id)
    {
        $satuan = Satuan::find($id);
        $satuan->satuan = $request->satuan;

        $satuan->save();

        return back()->with('success', 'Satuan edit successfully');
    }

    public function deleteSatuan($id)
    {
        $satuan = Satuan::find($id);
        $satuan->delete();

        return back()->with('success', 'Satuan delete successfully');
    }
}