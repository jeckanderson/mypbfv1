<?php

namespace App\Http\Controllers;

use App\Models\SubGolongan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubGolonganController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:akses_golongan']);
        $this->middleware(['permission:tambah_golongan'])->only('tambahSubGolongan');
        $this->middleware(['permission:aksi_golongan'])->only('editSubGolongan');
        $this->middleware(['permission:aksi_golongan'])->only('deleteSubGolongan');
    }

    public function index()
    {
        $undeleted = [
            'Obat Bebas',
            'Obat Bebas Terbatas',
            'Obat Keras',
            'Obat Fitofarmaka',
            'Obat Herbal Terstandar',
            'Obat Herbal Jamu',
            'Obat Narkotika',
        ];
        return view('pages.master.produk.sub-golongan', [
            'title' => 'master',
            'undeleted' => $undeleted,
            'subs' => SubGolongan::where('id_perusahaan', Auth::user()->id_perusahaan)->get()
        ]);
    }

    public function tambahSubGolongan(Request $request)
    {
        $golongan = new SubGolongan();
        $golongan->id_perusahaan = Auth::user()->id_perusahaan;
        $golongan->sub_golongan = $request->sub_golongan;

        $golongan->save();

        return back()->with('success', 'Sub Golongan added successfully');
    }

    public function editSubGolongan(Request $request, $id)
    {
        $golongan = SubGolongan::find($id);
        $golongan->sub_golongan = $request->sub_golongan;

        $golongan->save();

        return back()->with('success', 'Sub Golongan edit successfully');
    }

    public function deleteSubGolongan($id)
    {
        $golongan = SubGolongan::find($id);
        $golongan->delete();

        return back()->with('success', 'Sub Golongan delete successfully');
    }
}