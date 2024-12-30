<?php

namespace App\Livewire\Dashboard;

use App\Models\HistoryStok;
use Livewire\Component;
use App\Models\HutangPengguna;
use App\Models\ObatBarang;
use App\Models\PembayaranHutang;
use App\Models\PembayaranPiutang;
use App\Models\Pembelian;
use App\Models\Penjualan;
use App\Models\PiutangPengguna;
use App\Models\ProdukPembelian;
use App\Models\ProdukPenjualan;
use App\Models\ProdukReturPenjualan;
use App\Models\TargetSales;
use App\Models\TargetSPV;
use App\Models\Suplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardAdmin extends Component
{
    public $row = 10;
    public $search = '';

    public function render(Request $request)
    {
        /* $hasil = HutangPengguna::select('id_suplier', DB::raw('MAX(id) as max_id'))
            ->groupBy('id_suplier')
            ->get()
            ->pluck('max_id');

        $totalSisaHutang = HutangPengguna::whereIn('id', $hasil)
            ->sum('sisa_hutang'); */

        //******** modified by Nanang 9-9-2024********* */
        $this->total = 0;
        $hutang_pengguna = Suplier::where('id_perusahaan', Auth::user()->id_perusahaan)
            ->has('hutangs')
            ->with([
                'hutangs' => function ($q) {
                    return $q->groupBy('sourceable_type')->groupBy('sourceable_id');
                },
                'hutangs.sourceable' => function ($q) {
                    $q->when($this->search, function ($qq) {
                        $qq->where('no_faktur', 'LIKE', '%' . $this->search . '%');
                    });
                },
                'hutangs.sourceable.hutang_pengguna', 
                'hutangs.sourceable.hutang_pengguna.detailable'
            ])
        
            ->get();

        foreach ($hutang_pengguna as $pengguna) {
            foreach ($pengguna->hutangs as $c) {
                if (!is_null($c->sourceable)) {
                    $w = 0;
                    foreach ($c->sourceable->hutang_pengguna as $d) {
                        $w = str_replace('.', '', $d->sisa_hutang);
                    }
                    $this->total += $w;
                }
            }
        }

        $this->total = $this->total <= 0 ? 0 : $this->total;
        $totalSisaHutang = $this->total;
        //******** modified by Nanang 9-9-2024********* */
        
        $hasil2 = PiutangPengguna::select('id_pelanggan', DB::raw('MAX(id) as max_id'))
            ->groupBy('id_pelanggan')
            ->get()
            ->pluck('max_id');

        $totalSisaPiutang = PiutangPengguna::whereIn('id', $hasil2)
            ->sum('sisa_hutang');

        $produk = ProdukPenjualan::selectRaw('id_produk,satuan,sum(qty) as qty')->groupBy('satuan')->groupBy('id_produk')->orderBy('qty', 'desc')
            ->limit(10)->get();

        $salesData = Penjualan::selectRaw('MONTH(tgl_input) as month, SUM(dpp) as total');
        if ($request->tahun1) {
            $salesData = $salesData->whereYear('tgl_input', $request->tahun1);
        } else {
            $salesData = $salesData->whereYear('tgl_input', date('Y'));
        }
        $salesData = $salesData->groupBy('month')
            ->pluck('total', 'month')->all();

        $purchaseData = Pembelian::selectRaw('MONTH(tgl_input) as month, SUM(dpp) as total');
        if ($request->tahun1) {
            $purchaseData = $purchaseData->whereYear('tgl_input', $request->tahun1);
        } else {
            $purchaseData = $purchaseData->whereYear('tgl_input', date('Y'));
        }
        $purchaseData = $purchaseData->groupBy('month')
            ->pluck('total', 'month')->all();

        $months = ['Januari', 'Februari', 'Maret', 'April', 'Mai', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'Desember'];

        $sales = [];
        $purchases = [];

        foreach (range(1, 12) as $month) {
            $sales[] = $salesData[$month] ?? 0;
            $purchases[] = $purchaseData[$month] ?? 0;
        }

        $hasilHutang = HutangPengguna::select('id_suplier', DB::raw('MAX(id) as max_id'))
            ->groupBy('id_suplier')
            ->get()
            ->pluck('max_id');
            
        $chartSisaHutang = HutangPengguna::whereIn('hutang_pengguna.id', $hasilHutang)
            ->selectRaw('MONTH(created_at) as month, SUM(sisa_hutang) as total');
        if ($request->tahun2) {
            $chartSisaHutang = $chartSisaHutang->whereYear('created_at', $request->tahun2);
        } else {
            $chartSisaHutang = $chartSisaHutang->whereYear('created_at', date('Y'));
        }

        $chartSisaHutang = $chartSisaHutang->groupBy('month')
            ->pluck('total', 'month')->all();

        $hasilPiutang = PiutangPengguna::select('id_pelanggan', DB::raw('MAX(id) as max_id'))
            ->groupBy('id_pelanggan')
            ->get()
            ->pluck('max_id');

        $chartSisaPiutang = PiutangPengguna::whereIn('piutang_pengguna.id', $hasilPiutang)
            ->selectRaw('MONTH(created_at) as month, SUM(sisa_hutang) as total');
        if ($request->tahun2) {
            $chartSisaPiutang = $chartSisaPiutang->whereYear('created_at', $request->tahun2);
        } else {
            $chartSisaPiutang = $chartSisaPiutang->whereYear('created_at', date('Y'));
        }
        $chartSisaPiutang = $chartSisaPiutang->groupBy('month')
            ->pluck('total', 'month')->all();

        $sisaPiutang = [];
        $sisaHutang = [];

        foreach (range(1, 12) as $month) {
            $sisaPiutang[] = $chartSisaPiutang[$month] ?? 0;
            $sisaHutang[] = $chartSisaHutang[$month] ?? 0;
        }


        if (isset($_GET['bulanspv'])) {
            $bulanspv = $_GET['bulanspv'];
        } else {
            $bulanspv = (int)date('m');
        }

        if (isset($_GET['tahunspv'])) {
            $tahunspv = $_GET['tahunspv'];
        } else {
            $tahunspv = date('Y');
        }

        $spvPenjualan = ProdukPenjualan::selectRaw('sum(REPLACE(REPLACE(produk_penjualan.total, ".", ""), ",", "")) as total')->addSelect('produk_penjualan.created_at', 'sales.supervisor', 'sales.sales', 'pegawai.nama_pegawai', 'pegawai.foto')
            ->leftJoin('penjualan', 'penjualan.id', '=', 'produk_penjualan.id_penjualan')
            ->leftJoin('sales', 'sales.sales', '=', 'penjualan.sales')
            ->leftJoin('pegawai', 'pegawai.id', '=', 'sales.supervisor')
            ->where('produk_penjualan.id_perusahaan', Auth::user()->id_perusahaan)
            ->groupBy('sales.supervisor')
            ->orderBy('total', 'desc')
            ->limit('1')
            ->get();

        $spvReturPenjualan = ProdukReturPenjualan::selectRaw('sum(retur_penjualan.dpp) as dpp')->addSelect('produk_retur_penjualan.created_at', 'sales.supervisor', 'sales.sales', 'pegawai.nama_pegawai', 'pegawai.foto')
            ->leftJoin('retur_penjualan', 'retur_penjualan.id', '=', 'produk_retur_penjualan.id_retur')
            ->leftJoin('sales', 'sales.sales', '=', 'retur_penjualan.sales')
            ->leftJoin('pegawai', 'pegawai.id', '=', 'sales.supervisor')
            ->where('produk_retur_penjualan.id_perusahaan', Auth::user()->id_perusahaan)
            ->groupBy('sales.supervisor')
            ->orderBy('dpp', 'desc')
            ->limit('5')
            ->get();

        $spvTarget = TargetSPV::where('id_perusahaan', Auth::user()->id_perusahaan)->with('rayon')->orderBy('tahun', 'desc')->get();


        if (isset($_GET['bulansales'])) {
            $bulansales = $_GET['bulansales'];
        } else {
            $bulansales = (int)date('m');
        }

        if (isset($_GET['tahunsales'])) {
            $tahunsales = $_GET['tahunsales'];
        } else {
            $tahunsales = date('Y');
        }

        $salesPenjualan = ProdukPenjualan::selectRaw('sum(REPLACE(REPLACE(produk_penjualan.total, ".", ""), ",", "")) as total')->addSelect('produk_penjualan.created_at', 'sales.sales', 'pegawai.nama_pegawai', 'pegawai.foto')
            ->leftJoin('penjualan', 'penjualan.id', '=', 'produk_penjualan.id_penjualan')
            ->leftJoin('sales', 'sales.sales', '=', 'penjualan.sales')
            ->leftJoin('pegawai', 'pegawai.id', '=', 'sales.sales')
            ->where('produk_penjualan.id_perusahaan', Auth::user()->id_perusahaan)
            ->groupBy('sales.sales')
            ->orderBy('total', 'desc')
            ->limit('1')
            ->get();

        $salesReturPenjualan = ProdukReturPenjualan::selectRaw('sum(retur_penjualan.dpp) as dpp')->addSelect('produk_retur_penjualan.created_at', 'sales.sales', 'pegawai.nama_pegawai', 'pegawai.foto')
            ->leftJoin('retur_penjualan', 'retur_penjualan.id', '=', 'produk_retur_penjualan.id_retur')
            ->leftJoin('sales', 'sales.sales', '=', 'retur_penjualan.sales')
            ->leftJoin('pegawai', 'pegawai.id', '=', 'sales.sales')
            ->where('produk_retur_penjualan.id_perusahaan', Auth::user()->id_perusahaan)
            ->groupBy('sales.sales')
            ->orderBy('dpp', 'desc')
            ->limit('5')
            ->get();

        $salesTarget = TargetSales::where('id_perusahaan', Auth::user()->id_perusahaan)->with('rayon')->orderBy('tahun', 'desc')->get();


        $today = Carbon::today();
        $produkExp = collect();

        $threeMonthsBefore = $today->copy()->subMonths(3);
        $threeMonthsAfter = $today->copy()->addMonths(3);

        $filter = $request->kedaluwarsa ?? '';

        if ($filter === 'kedaluwarsa') {
            $produkExp = HistoryStok::whereBetween('exp_date', [$threeMonthsBefore, $today])
                ->groupBy('id_gudang', 'id_rak', 'id_sub_rak', 'no_batch', 'exp_date')
                ->orderBy('exp_date', 'asc')
                ->paginate($this->row);
        } elseif ($filter === 'mendekati-kedaluwarsa') {
            $produkExp = HistoryStok::whereBetween('exp_date', [$today, $threeMonthsAfter])
                ->groupBy('id_gudang', 'id_rak', 'id_sub_rak', 'no_batch', 'exp_date')
                ->orderBy('exp_date', 'asc')
                ->paginate($this->row);
        } else {
            $produkExp = HistoryStok::whereBetween('exp_date', [$threeMonthsBefore, $threeMonthsAfter])
                ->groupBy('id_gudang', 'id_rak', 'id_sub_rak', 'no_batch', 'exp_date')
                ->orderBy('exp_date', 'asc')
                ->paginate($this->row);
        }
        return view('livewire.dashboard.dashboard-admin', [
            'penjualan' => Penjualan::sum('dpp'),
            'pembelian' => Pembelian::sum('dpp'),
            'hutang' => $totalSisaHutang,
            'piutang' => $totalSisaPiutang,
            'produks' => $produk,
            'chartSales' => $sales,
            'chartPurchases' => $purchases,
            'months' => $months,
            'chartSisaHutang' => $sisaHutang,
            'chartSisaPiutang' => $sisaPiutang,
            'spvPenjualan' => $spvPenjualan,
            'spvReturPenjualan' => $spvReturPenjualan,
            'spvTarget' => $spvTarget,
            'tahunspv' => $tahunspv,
            'bulanspv' => $bulanspv,
            'salesPenjualan' => $salesPenjualan,
            'salesReturPenjualan' => $salesReturPenjualan,
            'salesTarget' => $salesTarget,
            'tahunsales' => $tahunsales,
            'bulansales' => $bulansales,
            'produkExp' => $produkExp
        ]);
    }
}
