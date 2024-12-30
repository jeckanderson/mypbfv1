<?php

namespace App\Http\Controllers;

use App\Models\SubRayon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubRayonController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:akses_sub_rayon']);
        $this->middleware(['permission:tambah_sub_rayon'])->only('tambahSubRayon');
        $this->middleware(['permission:aksi_sub_rayon'])->only('editSubRayon');
        $this->middleware(['permission:aksi_sub_rayon'])->only('deleteSubRayon');
    }

    public function index()
    {
        return view('pages.perusahaan.marketing.sub-rayon', [
            'title' => "perusahaan",
            'subRayons' => SubRayon::where('id_perusahaan', Auth::user()->id_perusahaan)->get()
        ]);
    }

    public function tambahSubRayon(Request $request)
    {
        $rayon = new SubRayon();
        $rayon->sub_rayon = $request->sub_rayon;
        $rayon->id_perusahaan = Auth::user()->id_perusahaan;
        $rayon->save();

        return back()->with('success', 'Sub Rayon added successfully');
    }

    public function editSubRayon(Request $request, $id)
    {
        $rayon = SubRayon::find($id);
        $rayon->sub_rayon = $request->sub_rayon;
        $rayon->save();

        return back()->with('success', 'Sub Rayon added successfully');
    }

    public function deleteSubRayon($id)
    {
        $rayon = SubRayon::find($id);
        $rayon->delete();

        return back()->with('success', 'Sub Rayon delete successfully');
    }
}