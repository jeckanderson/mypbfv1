<?php

namespace App\Http\Controllers;

use App\Models\AreaRayon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AreaRayonController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:akses_area_rayon']);
        $this->middleware(['permission:tambah_area_rayon'])->only('tambahAreaRayon');
        $this->middleware(['permission:aksi_area_rayon'])->only('editAreaRayon');
        $this->middleware(['permission:aksi_area_rayon'])->only('deleteAreaRayon');
    }

    public function index()
    {
        return view('pages.perusahaan.marketing.area-rayon', [
            'title' => "perusahaan",
            'rayons' => AreaRayon::where('id_perusahaan', Auth::user()->id_perusahaan)->get()
        ]);
    }

    public function tambahAreaRayon(Request $request)
    {
        $rayon = new AreaRayon();
        $rayon->area_rayon = $request->area_rayon;
        $rayon->id_perusahaan = Auth::user()->id_perusahaan;
        $rayon->save();

        return back()->with('success', 'Rayon added successfully');
    }

    public function editAreaRayon(Request $request, $id)
    {
        $rayon = AreaRayon::find($id);
        $rayon->area_rayon = $request->area_rayon;
        $rayon->save();

        return back()->with('success', 'Rayon added successfully');
    }

    public function deleteAreaRayon($id)
    {
        $rayon = AreaRayon::find($id);
        $rayon->delete();

        return back()->with('success', 'Rayon delete successfully');
    }
}