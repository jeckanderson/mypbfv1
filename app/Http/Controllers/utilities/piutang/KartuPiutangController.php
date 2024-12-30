<?php

namespace App\Http\Controllers\utilities\piutang;

use Carbon\Carbon;


use App\Models\Profile;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use App\Models\ReturPembelian;
use App\Models\ReturPenjualan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;


class KartuPiutangController extends Controller
{
    public function index()
    {


        return view('utilities.laporan.piutang.kartu-piutang.kartu-piutang', [
            'title' => 'utilities',



        ]);

    }

    public function cetak_pdf(Request $request)
    {
        $detail = ReturPenjualan::when($request->search, function ($query) use ($request) {
                $query->where('no_faktur', 'like', '%' . $request->search . '%');
            })
            ->when($request->pelangganId, function ($query) use ($request) {
                $query->where('id_pelanggan', 'like', '%' . $request->pelangganId . '%');
            })
            ->when($request->selesaiId && $request->mulaiId, function ($query) use ($request) {
                $finalEndDate = Carbon::createFromFormat('Y-m-d', $request->selesaiId)->endOfDay();
                $finalStartDate = Carbon::createFromFormat('Y-m-d', $request->mulaiId)->startOfDay();
                $query->whereHas('pembelian', function ($query) use ($finalStartDate, $finalEndDate) {
                    $query->whereBetween('tgl_input', [$finalStartDate, $finalEndDate]);
                });
            })
            ->with('profile', 'suplier', 'pembelian')
            ->paginate(10);

        $pdf = PDF::loadView('pdf.utilities.piutang.kartu-piutang.pdf', [
            'detail' => $detail,
            'mulaiId' => $request->mulaiId,
            'selesaiId' => $request->selesaiId,
        ]);

        return $pdf->stream('kartu-piutang.pdf');
    }
    function print(Request $request){
        $hutang_pengguna = Pelanggan::where('id_perusahaan', Auth::user()->id_perusahaan)->has('piutang')->with(['piutang' => function($q){
            return $q->groupBy('sourceable_type')->groupBy('sourceable_id');
        },'piutang.sourceable' => function($q) use ($request){
            $q->when($request->search,function($qq) use ($request){
                $qq->where('no_faktur','LIKE','%'.$request->search.'%');
            });
        },'piutang.sourceable.piutang_pengguna' ,'piutang.sourceable.piutang_pengguna.detailable'])->when($request->pelangganId, function ($q) use ($request) {
            $q->where('id', $request->pelangganId);
        })
        ->when($request->selesaiId && $request->mulaiId, function ($query) use ($request) {
            if ($request->mulaiId == $request->selesaiId) {
                $query->whereHas('piutang', function ($query) use ($request) {
                    $query->whereDate('created_at', $request->mulaiId);
                });
            } else {
                $finalEndDate = Carbon::createFromFormat('Y-m-d', $request->selesaiId)->endOfDay();
                $finalStartDate = Carbon::createFromFormat('Y-m-d', $request->mulaiId)->startOfDay();
                $query->whereHas('piutang', function ($query) use ($finalStartDate, $finalEndDate) {
                    $query->whereBetween('created_at', [$finalStartDate, $finalEndDate]);
                });
            }
        })
        ->get();
        $profile = Profile::first();
        return view('print.kartu_piutang', compact('hutang_pengguna','profile'));
    }


}
