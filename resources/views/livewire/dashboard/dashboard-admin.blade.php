<?php
if (!function_exists('angkaKeBulanIndo')) {
    function angkaKeBulanIndo($angka)
    {
        $angkaBulanIndo = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        return $angkaBulanIndo[$angka] ?? null;
    }
}
?>
<div class="content">
    <div class="grid gap-6">
        <div class="col 2xl:col-span-9">
            <div class="grid gap-6">
                <!-- BEGIN: General Report -->
                <div class="col-span-12 mt-8">
                    <div class="flex items-center h-10 intro-y">
                        <h2 class="mr-5 text-lg font-medium truncate text-primary">
                            General Report
                        </h2>
                        <a href="" class="flex items-center ml-auto text-primary"> <i data-feather="refresh-ccw"
                                class="w-4 h-4 mr-3"></i> Reload Data </a>
                    </div>
                    <div class="grid grid-cols-12 gap-6 mt-5">
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                            {{-- <a href="{{ url('/penjualan') }}"> --}}
                            <div class="report-box zoom-in">
                                <div class="p-5 box">
                                    <div class="flex">
                                        <i data-feather="shopping-cart" class="report-box__icon text-primary"></i>
                                    </div>
                                    <div class="mt-6 text-3xl font-medium leading-8">
                                        {{ number_format($penjualan, 0, ',', '.') }}</div>
                                    <div class="mt-1 text-base text-slate-500">Penjualan</div>
                                </div>
                            </div>
                            </a>
                        </div>
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                            {{-- <a href="{{ url('/pembelian') }}"> --}}
                            <div class="report-box zoom-in">
                                <div class="p-5 box">
                                    <div class="flex">
                                        <i data-feather="credit-card" class="report-box__icon text-pending"></i>
                                        {{-- <div class="ml-auto">
                                            <div class="cursor-pointer report-box__indicator bg-danger tooltip"
                                                title="2% Lower than last month"> 2% <i data-feather="chevron-down"
                                                    class="w-4 h-4 ml-0.5"></i> </div>
                                        </div> --}}
                                    </div>
                                    <div class="mt-6 text-3xl font-medium leading-8">
                                        {{ number_format($pembelian, 0, ',', '.') }}</div>
                                    <div class="mt-1 text-base text-slate-500">Pembelian</div>
                                </div>
                            </div>
                            </a>
                        </div>
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                            {{-- <a href="{{ url('/kartu-hutang') }}"> --}}
                            <div class="report-box zoom-in">
                                <div class="p-5 box">
                                    <div class="flex">
                                        <i data-feather="pocket" class="report-box__icon text-danger"></i>
                                    </div>
                                    <div class="mt-6 text-3xl font-medium leading-8">
                                        {{ number_format($hutang, 0, ',', '.') }}
                                    </div>
                                    <div class="mt-1 text-base text-slate-500">Total Hutang</div>
                                </div>
                            </div>
                            </a>
                        </div>
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                            {{-- <a href="{{ url('/kartu-piutang') }}"> --}}
                            <div class="report-box zoom-in">
                                <div class="p-5 box">
                                    <div class="flex">
                                        <i data-feather="users" class="report-box__icon text-success"></i>
                                    </div>
                                    <div class="mt-6 text-3xl font-medium leading-8">
                                        {{ number_format($piutang, 0, ',', '.') }}
                                    </div>
                                    <div class="mt-1 text-base text-slate-500">Total Piutang</div>
                                </div>
                            </div>
                            </a>
                        </div>
                    </div>
                </div>


            </div>
            <div class="grid grid-cols-12 gap-6 mt-5 intro-y">
                <div class="col-span-12 lg:col-span-6">
                    <div class="col-span-12 mt-8 lg:col-span-6">
                        <div class="items-center block h-10 intro-y sm:flex">
                            <h2 class="mr-5 text-lg font-medium truncate text-primary">
                                Grafik Penjualan VS Pembelian
                            </h2>
                            <div class="relative mt-3 sm:ml-auto sm:mt-0 text-slate-500">
                                <select name="tahun1" id="tahun1">
                                    <option value="">Pilih Tahun</option>
                                    @for ($tahun = 2023; $tahun <= date('Y'); $tahun++)
                                        <option
                                            @if (isset($_GET['tahun1'])) @if ($_GET['tahun1'] == $tahun) selected @endif
                                            @endif value="{{ $tahun }}">{{ $tahun }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="p-5 mt-12 intro-y box sm:mt-5">
                            <div class="flex flex-col xl:flex-row xl:items-center">

                            </div>
                            <div class="report-chart">
                                <canvas id="chart-penjualan-pembelian" height="169" class="mt-6"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 lg:col-span-6">
                    <div class="col-span-12 mt-8 lg:col-span-6">
                        <div class="items-center block h-10 intro-y sm:flex">
                            <h2 class="mr-5 text-lg font-medium truncate text-primary">
                                Grafik Hutang VS Piutang
                            </h2>
                            <div class="relative mt-3 sm:ml-auto sm:mt-0 text-slate-500">
                                <select name="tahun2" id="tahun2">
                                    <option value="">Pilih Tahun</option>
                                    @for ($tahun = 2023; $tahun <= date('Y'); $tahun++)
                                        <option
                                            @if (isset($_GET['tahun2'])) @if ($_GET['tahun2'] == $tahun) selected @endif
                                            @endif
                                            value="{{ $tahun }}">{{ $tahun }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="p-5 mt-12 intro-y box sm:mt-5">
                            <div class="flex flex-col xl:flex-row xl:items-center">

                            </div>
                            <div class="report-chart">
                                <canvas id="chart-piutang-hutang" height="169" class="mt-6"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-12 gap-6 mt-5 intro-y">
                <div class="col-span-12 mt-6">
                    <div class="items-center block h-10 intro-y sm:flex">
                        <h2 class="mr-5 text-lg font-medium truncate text-primary">
                            Produk Penjualan Qty Terbaik
                        </h2>
                    </div>
                    <div class="mt-8 overflow-auto intro-y lg:overflow-visible sm:mt-0">
                        <table class="table table-report sm:mt-2">
                            <thead style="background-color: #d3d3d3;">
                                <tr>
                                    <th class="text-center whitespace-nowrap">Barcode</th>
                                    <th class="whitespace-nowrap">Nama Produk</th>
                                    <th class="text-center whitespace-nowrap">Kategori</th>
                                    <th class="text-center whitespace-nowrap">Golongan</th>
                                    <th class="text-center whitespace-nowrap">Jenis Produk</th>
                                    <th class="text-center whitespace-nowrap">Jumlah Penjualan</th>
                                    <th class="text-center whitespace-nowrap">Satuan</th>
                                    <th class="text-center whitespace-nowrap">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($produks as $produk)
                                    @if ($produk->qty != 0)
                                        <tr class="intro-x">
                                            <td width="150px" class="text-center">
                                                {{ $produk->produk->barcode_produk }}
                                            </td>
                                            <td>
                                                <a href=""
                                                    class="font-medium whitespace-nowrap">{{ Str::title($produk->produk->nama_obat_barang) }}</a>
                                            </td>
                                            <td class="text-center">{{ $produk->produk->kelompok->golongan }}</td>
                                            <td class="text-center">
                                                {{ $produk->produk->golonganProduk->sub_golongan }}</td>
                                            <td class="text-center">
                                                {{ $produk->produk->jenis_obat_barang }}</td>
                                            <td class="text-center">{{ $produk->qty }}</td>
                                            <td class="text-center">{{ $produk->satuanProduk->satuan }}</td>
                                            <td class="w-40">
                                                @if ($produk->produk->status == 1)
                                                    <div class="flex items-center justify-center text-success"> <i
                                                            data-feather="check-square" class="w-4 h-4 mr-2"></i>
                                                        Active
                                                    </div>
                                                @else
                                                    <div class="flex items-center justify-center text-danger">Non
                                                        Active
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="flex flex-wrap items-center mt-3 intro-y sm:flex-row sm:flex-nowrap">
                        {{-- <nav class="w-full sm:w-auto sm:mr-auto">
                            <ul class="pagination">
                                <!-- Tombol navigasi ke halaman sebelumnya -->
                                <li class="page-item {{ $produks->previousPageUrl() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $produks->previousPageUrl() }}"> <i
                                            class="w-4 h-4" data-feather="chevron-left"></i> </a>
                                </li>
                                <!-- Daftar halaman -->
                                @foreach ($produks->getUrlRange(1, $produks->lastPage()) as $page => $url)
                                    <li class="page-item {{ $page == $produks->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach
                                <!-- Tombol navigasi ke halaman berikutnya -->
                                <li class="page-item {{ $produks->nextPageUrl() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $produks->nextPageUrl() }}"> <i class="w-4 h-4"
                                            data-feather="chevron-right"></i> </a>
                                </li>
                            </ul>
                        </nav> --}}
                        <!-- Jumlah item per halaman -->
                        {{-- @if ($produks->count() > 10)
                            <select class="w-20 mt-3 form-select box sm:mt-0" wire:model.live='row'>
                                <option>10</option>
                                <option>25</option>
                                <option>35</option>
                                <option>50</option>
                            </select>
                        @endif --}}
                    </div>
                </div>
            </div>


            <div class="col-span-12 2xl:col-span-3">
                <div class="pb-10 -mb-10 2xl:border-l">
                    <div class="grid grid-cols-12 gap-6 2xl:pl-6">
                        <div class="col-span-12 mt-3 md:col-span-6 xl:col-span-6 2xl:col-span-6 2xl:mt-8">
                            <form action="#" method="get">

                                <div class="flex items-center h-10 intro-x">
                                    <h2 class="mr-5 text-lg font-medium truncate text-primary">
                                        Supervisor Terbaik
                                    </h2>
                                    <div class="relative mt-3 sm:ml-auto sm:mt-0 text-slate-500">
                                        <select name="bulanspv" id="bulanspv" required>
                                            <option value="">Bulan</option>
                                            <option @if ($bulanspv == 1) selected @endif value="1">
                                                Januari</option>
                                            <option @if ($bulanspv == 2) selected @endif value="2">
                                                Februari</option>
                                            <option @if ($bulanspv == 3) selected @endif value="3">
                                                Maret</option>
                                            <option @if ($bulanspv == 4) selected @endif value="4">
                                                April</option>
                                            <option @if ($bulanspv == 5) selected @endif value="5">
                                                Mei</option>
                                            <option @if ($bulanspv == 6) selected @endif value="6">
                                                Juni</option>
                                            <option @if ($bulanspv == 7) selected @endif value="7">
                                                Juli</option>
                                            <option @if ($bulanspv == 8) selected @endif value="8">
                                                Agustus</option>
                                            <option @if ($bulanspv == 9) selected @endif value="9">
                                                September</option>
                                            <option @if ($bulanspv == 10) selected @endif value="10">
                                                Oktober</option>
                                            <option @if ($bulanspv == 11) selected @endif value="11">
                                                November</option>
                                            <option @if ($bulanspv == 12) selected @endif value="12">
                                                Desember</option>
                                        </select>
                                    </div>
                                    <div class="relative mt-3 sm:ml-auto sm:mt-0 text-slate-500">
                                        <select name="tahunspv" id="tahunspv" required>
                                            <option value="">Pilih Tahun</option>
                                            @for ($tahun = 2023; $tahun <= date('Y'); $tahun++)
                                                <option @if ($tahunspv == $tahun) selected @endif
                                                    value="{{ $tahun }}">{{ $tahun }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="relative mt-3 sm:ml-auto sm:mt-0 text-slate-500">
                                        <button class="btn btn-facebook" type="submit">Filter</button>
                                        <a class="btn btn-pending" href="{{ url('/') }}">Reset</a>
                                    </div>
                                </div>
                            </form>
                            <div class="mt-5">
                                @foreach ($spvPenjualan as $spv)
                                    <?php
                                    $penjualan = $spvPenjualan
                                        ->where('supervisor', $spv->supervisor)
                                        ->filter(function ($item) use ($bulanspv, $tahunspv) {
                                            return $item->created_at->month === $bulanspv && $item->created_at->year == $tahunspv ?? '';
                                        })
                                        ->sum(function ($item) {
                                            $cleanedTotal = str_replace('.', '', $item->total);
                                            return (int) $cleanedTotal;
                                        });
                                    
                                    $retur = $spvReturPenjualan
                                        ->where('supervisor', $spv->supervisor)
                                        ->filter(function ($item) use ($bulanspv, $tahunspv) {
                                            return $item->created_at->month === $bulanspv && $item->created_at->year == $tahunspv ?? '';
                                        })
                                        ->sum('dpp');
                                    
                                    $hasil = $penjualan - $retur;
                                    $target = $spvTarget
                                        ->where('supervisor', $spv->supervisor)
                                        ->where('tahun', $tahunspv)
                                        ->first();
                                    $bulanIndo = angkaKeBulanIndo($bulanspv);
                                    $bulanTarget = str_replace('.', '', $target ? $target->{'target_' . strtolower($bulanIndo)} : '');
                                    
                                    ?>
                                    <div class="intro-x">
                                        <div class="flex items-center px-5 py-3 mb-3 box zoom-in">
                                            <div class="flex-none w-10 h-10 overflow-hidden rounded-full image-fit">
                                                <img alt="{{ $spv->nama_pegawai }}"
                                                    src="{{ url('storage/foto/' . $spv->foto) }}">
                                            </div>
                                            <div class="ml-4 mr-auto">
                                                <div class="font-medium">{{ $spv->nama_pegawai }}</div>
                                                <div class="text-slate-500 text-xs mt-0.5">
                                                    {{ $target->rayon->area_rayon ?? '' }}</div>
                                            </div>
                                            <div
                                                class="px-2 py-1 text-xs font-medium text-white rounded-full cursor-pointer bg-success">
                                                @if ($bulanTarget > 0)
                                                    {{ number_format(($hasil / $bulanTarget) * 100, 2, ',', '.') }}%
                                                @else
                                                    0%
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <a href="{{ url('/target-spv') }}"
                                    class="block w-full py-3 text-center border rounded-md text-pending border-primary intro-x border-slate-400 dark:border-darkmode-300 text-slate-500">Lihat
                                    Selengkapnya Disini</a>
                            </div>
                        </div>

                        <div class="col-span-12 mt-3 md:col-span-6 xl:col-span-6 2xl:col-span-6 2xl:mt-8">
                            <form action="#" method="get">

                                <div class="flex items-center h-10 intro-x">
                                    <h2 class="mr-5 text-lg font-medium truncate text-primary">
                                        Sales Terbaik
                                    </h2>
                                    <div class="relative mt-3 sm:ml-auto sm:mt-0 text-slate-500">
                                        <select name="bulansales" id="bulansales" required>
                                            <option value="">Bulan</option>
                                            <option @if ($bulansales == 1) selected @endif value="1">
                                                Januari</option>
                                            <option @if ($bulansales == 2) selected @endif value="2">
                                                Februari</option>
                                            <option @if ($bulansales == 3) selected @endif value="3">
                                                Maret</option>
                                            <option @if ($bulansales == 4) selected @endif value="4">
                                                April</option>
                                            <option @if ($bulansales == 5) selected @endif value="5">
                                                Mei</option>
                                            <option @if ($bulansales == 6) selected @endif value="6">
                                                Juni</option>
                                            <option @if ($bulansales == 7) selected @endif value="7">
                                                Juli</option>
                                            <option @if ($bulansales == 8) selected @endif value="8">
                                                Agustus</option>
                                            <option @if ($bulansales == 9) selected @endif value="9">
                                                September</option>
                                            <option @if ($bulansales == 10) selected @endif value="10">
                                                Oktober</option>
                                            <option @if ($bulansales == 11) selected @endif value="11">
                                                November</option>
                                            <option @if ($bulansales == 12) selected @endif value="12">
                                                Desember</option>
                                        </select>
                                    </div>
                                    <div class="relative mt-3 sm:ml-auto sm:mt-0 text-slate-500">
                                        <select name="tahunsales" id="tahunsales" required>
                                            <option value="">Pilih Tahun</option>
                                            @for ($tahun = 2023; $tahun <= date('Y'); $tahun++)
                                                <option @if ($tahunsales == $tahun) selected @endif
                                                    value="{{ $tahun }}">{{ $tahun }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="relative mt-3 sm:ml-auto sm:mt-0 text-slate-500">
                                        <button class="btn btn-facebook" type="submit">Filter</button>
                                        <a class="btn btn-pending" href="{{ url('/') }}">Reset</a>
                                    </div>
                                </div>
                            </form>
                            <div class="mt-5">
                                @foreach ($salesPenjualan as $sales)
                                    <?php
                                    $penjualan = $salesPenjualan
                                        ->where('sales', $sales->sales)
                                        ->filter(function ($item) use ($bulansales, $tahunsales) {
                                            return $item->created_at->month === $bulansales && $item->created_at->year == $tahunsales ?? '';
                                        })
                                        ->sum(function ($item) {
                                            $cleanedTotal = str_replace('.', '', $item->total);
                                            return (int) $cleanedTotal;
                                        });
                                    
                                    $retur = $salesReturPenjualan
                                        ->where('sales', $sales->sales)
                                        ->filter(function ($item) use ($bulansales, $tahunsales) {
                                            return $item->created_at->month === $bulansales && $item->created_at->year == $tahunsales ?? '';
                                        })
                                        ->sum('dpp');
                                    
                                    $hasil = $penjualan - $retur;
                                    $target = $salesTarget
                                        ->where('sales', $sales->sales)
                                        ->where('tahun', $tahunsales)
                                        ->first();
                                    $bulanIndo = angkaKeBulanIndo($bulansales);
                                    $bulanTarget = str_replace('.', '', $target ? $target->{'target_' . strtolower($bulanIndo)} : '');
                                    
                                    ?>
                                    <div class="intro-x">
                                        <div class="flex items-center px-5 py-3 mb-3 box zoom-in">
                                            <div class="flex-none w-10 h-10 overflow-hidden rounded-full image-fit">
                                                <img alt="{{ $sales->nama_pegawai }}"
                                                    src="{{ url('storage/foto/' . $sales->foto) }}">

                                            </div>
                                            <div class="ml-4 mr-auto">
                                                <div class="font-medium">{{ $sales->nama_pegawai }}</div>
                                                <div class="text-slate-500 text-xs mt-0.5">
                                                    {{ $target->subRayon->sub_rayon ?? '' }}</div>
                                            </div>
                                            <div
                                                class="px-2 py-1 text-xs font-medium text-white rounded-full cursor-pointer bg-success">
                                                @if ($bulanTarget > 0)
                                                    {{ number_format(($hasil / $bulanTarget) * 100, 2, ',', '.') }}%
                                                @else
                                                    0%
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <a href="{{ url('/target-sales') }}"
                                    class="block w-full py-3 text-center border rounded-md text-pending border-primary intro-x border-slate-400 dark:border-darkmode-300 text-slate-500">Lihat
                                    Selengkapnya Disini</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="grid grid-cols-12 gap-6 mt-5 intro-y">
                <div class="col-span-12 mt-6">
                    <div class="items-center block h-10 intro-y sm:flex">
                        <h2 class="mr-5 text-lg font-medium truncate text-primary">
                            Data Produk Berdasarkan Exp Date
                        </h2>
                        <div class="relative mt-3 sm:ml-auto sm:mt-0 text-slate-500">
                            <select name="kedaluwarsa" id="kedaluwarsa" required>
                                <option value="">Semua</option>
                                <option
                                    @if (isset($_GET['kedaluwarsa'])) @if ($_GET['kedaluwarsa'] == 'kedaluwarsa') selected @endif
                                    @endif value="kedaluwarsa">Exp Date</option>
                                <option
                                    @if (isset($_GET['kedaluwarsa'])) @if ($_GET['kedaluwarsa'] == 'mendekati-kedaluwarsa') selected @endif
                                    @endif value="mendekati-kedaluwarsa">Mendekati 3 Bulan
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-8 overflow-auto intro-y lg:overflow-visible sm:mt-0">
                        <table class="table table-report sm:mt-2">
                            <thead style="background-color: #d3d3d3;">
                                <tr>
                                    <th class="text-center whitespace-nowrap">Barcode</th>
                                    <th class="whitespace-nowrap">Nama Produk</th>
                                    <th class="text-center whitespace-nowrap">Kategori</th>
                                    <th class="text-center whitespace-nowrap">No Batch</th>
                                    <th class="text-center whitespace-nowrap">Exp Date</th>
                                    <th class="text-center whitespace-nowrap">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($produkExp as $produk)
                                    <tr class="intro-x">

                                        <td width="150px" class="text-center">{{ $produk->produk->barcode_produk }}
                                        </td>
                                        <td>
                                            <a href=""
                                                class="font-medium whitespace-nowrap">{{ Str::title($produk->produk->nama_obat_barang) }}</a>
                                        </td>
                                        <td class="text-center">{{ $produk->produk->kelompok->golongan }}</td>
                                        <td class="text-center">{{ $produk->no_batch }}</td>
                                        <td class="text-center">
                                            <?php
                                            if ($produk->exp_date < \Carbon\Carbon::today()) {
                                                echo "<label class='text-danger'>" . date('d-m-Y', strtotime($produk->exp_date)) . '</label>';
                                            } else {
                                                echo date('d-m-Y', strtotime($produk->exp_date));
                                            }
                                            ?>
                                        </td>
                                        <td class="text-center"><a class="text-white btn btn-sm btn-success"
                                                href="{{ url('/kartu-stok?id_produk=' . $produk->id_produk . '&id_gudang=' . $produk->id_gudang . '&id_rak=' . $produk->id_rak . '&id_sub_rak=' . $produk->id_sub_rak) }}">Lihat</a>
                                        </td>
                                    </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="flex flex-wrap items-center mt-3 intro-y sm:flex-row sm:flex-nowrap">
                        <nav class="w-full sm:w-auto sm:mr-auto">
                            <ul class="pagination">
                                <!-- Tombol navigasi ke halaman sebelumnya -->
                                <li class="page-item {{ $produkExp->previousPageUrl() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $produkExp->previousPageUrl() }}"> <i
                                            class="w-4 h-4" data-feather="chevron-left"></i> </a>
                                </li>
                                <!-- Daftar halaman -->
                                @foreach ($produkExp->getUrlRange(1, $produkExp->lastPage()) as $page => $url)
                                    <li class="page-item {{ $page == $produkExp->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach
                                <!-- Tombol navigasi ke halaman berikutnya -->
                                <li class="page-item {{ $produkExp->nextPageUrl() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $produkExp->nextPageUrl() }}"> <i class="w-4 h-4"
                                            data-feather="chevron-right"></i> </a>
                                </li>
                            </ul>
                        </nav>
                        <!-- Jumlah item per halaman -->
                        @if ($produkExp->count() > 10)
                            <select class="w-20 mt-3 form-select box sm:mt-0" wire:model.live='row'>
                                <option>10</option>
                                <option>25</option>
                                <option>35</option>
                                <option>50</option>
                            </select>
                        @endif
                    </div>
                </div>
            </div>



        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(document).ready(function() {
        $("body").on("change", "#tahun1", function() {
            var tahun = $(this).val();
            if (tahun == '') {
                return false;
            }
            window.location.href = "?tahun1=" + tahun;
        })

        $("body").on("change", "#tahun2", function() {
            var tahun = $(this).val();
            if (tahun == '') {
                return false;
            }
            window.location.href = "?tahun2=" + tahun;
        })

        $("body").on("change", "#kedaluwarsa", function() {
            var kedaluwarsa = $(this).val();
            if (kedaluwarsa == '') {
                window.location.href = "{{ url('/') }}";
            }
            window.location.href = "?kedaluwarsa=" + kedaluwarsa;
        })
    })
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('chart-penjualan-pembelian').getContext('2d');
        const reportLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($months),
                datasets: [{
                        label: 'Penjualan',
                        data: @json($chartSales),
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderWidth: 2,
                        fill: true
                    },
                    {
                        label: 'Pembelian',
                        data: @json($chartPurchases),
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderWidth: 2,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('chart-piutang-hutang').getContext('2d');
        const reportLineChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($months),
                datasets: [{
                        label: 'Piutang',
                        data: @json($chartSisaPiutang),
                        borderColor: 'rgba(109, 177, 5, 1)',
                        backgroundColor: 'rgba(109, 177, 5, 0.2)',
                        borderWidth: 2,
                        fill: true
                    },
                    {
                        label: 'Hutang',
                        data: @json($chartSisaHutang),
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderWidth: 2,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
