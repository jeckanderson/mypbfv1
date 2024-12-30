<?php

namespace App\Http\Controllers;

use App\Models\Golongan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GolonganController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:akses_kategori']);
        $this->middleware(['permission:tambah_kategori'])->only('tambahGolongan');
        $this->middleware(['permission:aksi_kategori'])->only('editGolongan');
        $this->middleware(['permission:aksi_kategori'])->only('deleteGolongan');
    }

    public function index()
    {
        $undeleted = [
            'Obat Obatan',
            'Alat Kesehatan',
            'Lainnya',
        ];
        return view('pages.master.produk.golongan', [
            'title' => 'master',
            'undeleted' => $undeleted,
            'golongans' => Golongan::where('id_perusahaan', Auth::user()->id_perusahaan)->get()
        ]);
    }

    public function tambahGolongan(Request $request)
    {
        $golongan = new Golongan();
        $golongan->id_perusahaan = Auth::user()->id_perusahaan;
        $golongan->golongan = $request->golongan;

        $golongan->save();

        return back()->with('success', 'Golongan added successfully');
    }

    public function editGolongan(Request $request, $id)
    {
        $golongan = Golongan::find($id);
        $golongan->golongan = $request->golongan;

        $golongan->save();

        return back()->with('success', 'Golongan edit successfully');
    }

    public function deleteGolongan($id)
    {
        $golongan = Golongan::find($id);
        $golongan->delete();

        return back()->with('success', 'Golongan delete successfully');
    }
}