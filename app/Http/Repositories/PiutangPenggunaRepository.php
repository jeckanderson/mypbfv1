<?php

namespace App\Http\Repositories;

use App\Models\PiutangPengguna;
use Illuminate\Support\Facades\DB;

class PiutangPenggunaRepository
{

    function getLatestPiutang($customer = null, $area = null, $search = null, $kolektor = null)
    {
        $subQuery = PiutangPengguna::select('id_penjualan', DB::raw('MAX(created_at) as max_created_at'))
            ->groupBy('id_penjualan');

        $latestData = PiutangPengguna::where('id_pelanggan', $customer)
            ->orWhereHas('getPelanggan', function ($qq) use ($area) {
                return $qq->where('area_rayon', $area);
            })
            ->whereHas('getPelanggan', function ($qq) use ($kolektor) {
                return $qq->where('kolektor', $kolektor);
            })
            ->when($search, function ($query, $search) {
                return $query->whereHas('penjualan', function ($q) use ($search) {
                    $q->where('no_faktur', 'like', '%' . $search . '%');
                });
            })
            ->joinSub($subQuery, 'latest', function ($join) {
                $join->on('piutang_pengguna.id_penjualan', '=', 'latest.id_penjualan')
                    ->on('piutang_pengguna.created_at', '=', 'latest.max_created_at');
            })
            ->orderBy('piutang_pengguna.created_at', 'desc')
            ->get();
        return $latestData;
    }
}
