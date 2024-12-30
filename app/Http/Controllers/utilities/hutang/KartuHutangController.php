<?php

namespace App\Http\Controllers\utilities\hutang;

use App\Models\Profile;
use Carbon\Carbon;

use App\Models\Suplier;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use App\Models\ReturPembelian;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;


class KartuHutangController extends Controller
{
    public function index()
    {
        return view('utilities.laporan.hutang.kartu-hutang.kartu-hutang', [
            'title' => 'utilities',
        ]);
    }

    public function cetak_pdf(Request $request)
    {
        $detail = ReturPembelian::when($request->search, function ($query) use ($request) {
            $query->where('no_faktur', 'like', '%' . $request->search . '%');
        })
            ->when($request->spId, function ($query) use ($request) {
                $query->where('id_suplier', 'like', '%' . $request->spId . '%');
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

        $pdf = PDF::loadView('pdf.utilities.hutang.kartu-hutang.pdf', [
            'detail' => $detail,
            'mulaiId' => $request->mulaiId,
            'selesaiId' => $request->selesaiId,
        ]);

        return $pdf->stream('kartu-hutang.pdf');
    }
    function print(Request $request)
    {
        $defaultSpId = 1;
        if (!$request->mulaiId) {
            $request->mulaiId = Carbon::now()->format('Y-m-d');
        }
        if (!$request->selesaiId) {
            $request->selesaiId = Carbon::now()->format('Y-m-d');
        }
        $request->total = 0;
        $hutang_pengguna = Suplier::where('id_perusahaan', Auth::user()->id_perusahaan)->has('hutangs')->with(['hutangs' => function ($q) use ($request) {
            return $q->groupBy('sourceable_type')->groupBy('sourceable_id');
        }, 'hutangs.sourceable' => function ($q) use ($request) {
            $q->when($request->search, function ($qq) use ($request) {
                $qq->where('no_faktur', 'LIKE', '%' . $request->search . '%');
            });
        }, 'hutangs.sourceable.hutang_pengguna', 'hutangs.sourceable.hutang_pengguna.detailable'])->when($request->spId, function ($q) use ($request) {
            $q->where('id', $request->spId);
        })
            ->when($request->selesaiId && $request->mulaiId, function ($query) use ($request) {
                if ($request->mulaiId == $request->selesaiId) {
                    $query->whereHas('hutangs.sourceable', function ($query)  use ($request) {
                        $query->whereDate('tgl_faktur', $request->mulaiId);
                    });
                } else {
                    $finalEndDate = Carbon::createFromFormat('Y-m-d', $request->selesaiId)->endOfDay();
                    $finalStartDate = Carbon::createFromFormat('Y-m-d', $request->mulaiId)->startOfDay();
                    $query->whereHas('hutangs.sourceable', function ($query) use ($finalStartDate, $finalEndDate) {
                        $query->whereBetween('tgl_faktur', [$finalStartDate, $finalEndDate]);
                    });
                }
            })
            ->get();
        $profile = Profile::first();
        return view('print.kartu_hutang', compact('hutang_pengguna', 'profile'));
    }
}