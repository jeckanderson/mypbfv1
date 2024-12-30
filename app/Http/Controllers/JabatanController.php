<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JabatanController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:akses_jabatan']);
        $this->middleware(['permission:tambah_jabatan'])->only('createJabatan');
        $this->middleware(['permission:aksi_jabatan'])->only('editJabatan');
        $this->middleware(['permission:aksi_jabatan'])->only('deleteJabatan');
    }

    public function index()
    {
        $undeleted = [
            'Direktur',
            'Supervisor',
            'Sales',
            'Apoteker',
            'Kolektor',
            'Ka. Gudang',
            'Ka. Keuangan',
            'Pengirim'
        ];

        return view('pages.perusahaan.pegawai.jabatan', [
            'title' => "perusahaan",
            'undeleted' => $undeleted,
            'jabatans' => Jabatan::where('id_perusahaan', Auth::user()->id_perusahaan)->get()
        ]);
    }

    public function createJabatan(Request $request)
    {
        $jabatan = new Jabatan();
        $jabatan->jabatan = $request->jabatan;
        $jabatan->id_perusahaan = Auth::user()->id_perusahaan;

        $jabatan->save();

        return back()->with('success', 'Jabatan updated successfully');
    }

    public function editJabatan(Request $request, $id)
    {
        $jabatan = Jabatan::find($id);
        $jabatan->jabatan = $request->jabatan;
        $jabatan->save();

        return back()->with('success', 'Jabatan updated successfully');
    }

    public function deleteJabatan($id)
    {
        $jabatan = Jabatan::find($id);
        $jabatan->delete();

        return back()->with('success', 'Jabatan updated successfully');
    }
}