<?php

namespace App\Livewire\Dashboard;

use App\Models\PembayaranHutang;
use App\Models\PembayaranPiutang;
use Illuminate\Support\Facades\DB;
use App\Models\PiutangPengguna;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DashboardKeuangan extends Component
{
    public $row, $row2;
    public function render()
    {
        // Step 1: Get the latest `id` for each `id_pelanggan`
        $latestIds = PiutangPengguna::select('id_pelanggan', DB::raw('MAX(id) as max_id'))
            ->groupBy('id_pelanggan')
            ->get()
            ->pluck('max_id');

        // Step 2 and 3: Join Pelanggan table and filter records using the `max_id`s and check date conditions
        $currentDate = Carbon::now();
        $count = PiutangPengguna::whereIn('piutang_pengguna.id', $latestIds)
            ->join('pelanggan', 'piutang_pengguna.id_pelanggan', '=', 'pelanggan.id')
            ->whereRaw("DATE_ADD(piutang_pengguna.created_at, INTERVAL pelanggan.batas_jt DAY) < ?", [$currentDate])
            ->count();

        // Step 1: Get the latest `id` for each `id_pelanggan`
        $latestIds = PiutangPengguna::select('id_pelanggan', DB::raw('MAX(id) as max_id'))
            ->groupBy('id_pelanggan')
            ->get()
            ->pluck('max_id');

        // Step 2 and 3: Join Pelanggan table and filter records using the `max_id`s and check date conditions
        $currentDate = Carbon::now();
        $count = PiutangPengguna::whereIn('piutang_pengguna.id', $latestIds)
            ->join('pelanggan', 'piutang_pengguna.id_pelanggan', '=', 'pelanggan.id')
            ->whereRaw("DATE_ADD(piutang_pengguna.created_at, INTERVAL pelanggan.batas_jt DAY) < ?", [$currentDate])
            ->count();

        return view('livewire.dashboard.dashboard-keuangan', [
            'piutangJT' => $count,
            'hutang' => PembayaranHutang::sum('total_bayar'),
            'piutang' => PembayaranPiutang::sum('total_bayar'),
            'daftarHutang' => PembayaranHutang::where('id_perusahaan', Auth::user()->id_perusahaan)->paginate($this->row),
            'daftarPiutang' => PembayaranPiutang::where('id_perusahaan', Auth::user()->id_perusahaan)->paginate($this->row2)
        ]);
    }
}
