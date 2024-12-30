<div class="grid grid-cols-12 gap-6 mt-5">
    @php
        use App\Models\HistoryStok;
        use App\Models\ProdukPenjualan;
        use App\Models\RencanaPengadaan;
    @endphp
    <style>
        .border {
            border: 1px solid #bbb;
            /* Contoh warna abu-abu untuk border */
        }

        .header-gray {
            background-color: #e0e0e0;
            /* Contoh warna abu-abu */
            color: black;
            /* Warna teks hitam */
        }

        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th,
        td {
            padding: 3px;
            text-align: left;
        }

        .border {
            border: 1px solid #bbb;
            /* Contoh warna abu-abu untuk border */
        }

        .header-gray {
            background-color: #e0e0e0;
            /* Contoh warna abu-abu */
            color: black;
            /* Warna teks hitam */
        }

        th {
            font-weight: bold;
            text-align: center;
        }

        td {
            font-size: 1em;
        }
    </style>
    <!-- BEGIN: Data List -->
    <div class="col-span-12 overflow-auto intro-y lg:overflow-visible">
        <div class="flex justify-between gap-3 mb-3">
            <div class="flex gap-3 mr-auto">
                @include('components.search', [
                    'id_table' => 'myTable',
                ])
                {{-- <div class="flex gap-2 overflow-auto">
                    <input data-tw-merge id="horizontal-form-1" type="date" wire:model.live='tanggal'
                        class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                    <p class="mt-3">
                </div> --}}
            </div>
            {{-- <a href="/#" class="flex items-center text-white btn btn-facebook" wire:ignore
                style="position: fixed; right: 50px;"><i data-feather="printer" class="w-4 h-4 mr-1"></i>Print
            </a>
            <a href="/#" class="flex items-center text-white btn btn-success" wire:ignore
                style="position: fixed; right: 135px;"><i data-feather="file-text" class="w-4 h-4 mr-1"
                    value="Export Excel" onclick="window.open('laporan-excel.php')"></i>Excel
            </a> --}}
        </div>
        <div class="mt-5 intro-y box">
            <div class="overflow-auto">
                <table class="table" id="myTable">
                    <thead>
                        <tr class="header-gray">
                            <th rowspan="2" class="border border-slate-900">No</th>
                            <th rowspan="2" class="border border-slate-900">Nama Produk</th>
                            <th rowspan="2" class="border border-slate-900">Satuan Beli</th>
                            <th rowspan="2" class="border border-slate-900">Isi</th>
                            <th rowspan="2" class="border border-slate-900">Satuan Terkecil</th>
                            <th colspan="3" class="border border-slate-900">Stok </th>
                            <th rowspan="2" class="border border-slate-900">Status</th>
                            <th colspan="3" class="border border-slate-900">Sumber Data</th>
                            <th rowspan="2" class="border border-slate-900">Actions</th>
                        </tr>
                        <tr class="header-gray">
                            <th rowspan="3" class="border border-slate-900">Tersedia</th>
                            <th rowspan="3" class="border border-slate-900">Min</th>
                            <th rowspan="3" class="border border-slate-900">Max</th>
                            <th rowspan="3" class="border border-slate-900">Defecta</th>
                            <th rowspan="3" class="border sm:w-32 border-slate-900">Pareto ABC</th>
                            <th rowspan="3" class="border border-slate-900">Analisis VEN</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($produks as $produk)
                            @php
                                $jumlah =
                                    HistoryStok::where('id_produk', $produk->id)
                                        ->where('id_perusahaan', Auth::user()->id_perusahaan)
                                        ->sum('stok_masuk') -
                                    HistoryStok::where('id_produk', $produk->id)
                                        ->where('id_perusahaan', Auth::user()->id_perusahaan)
                                        ->sum('stok_keluar');
                                $defecta = '';

                            @endphp
                            <tr class="intro-x">
                                <td class="border whitespace-nowrap border-slate-600">{{ $loop->iteration }}</td>
                                <td class="border whitespace-nowrap border-slate-600">{{ $produk->nama_obat_barang }}
                                </td>
                                <td class="border text-center whitespace-nowrap border-slate-600">
                                    {{ $produk->satuanDasar->satuan }}
                                </td>
                                <td class="border text-center whitespace-nowrap border-slate-600">{{ $produk->isi }}
                                </td>
                                <td class="border text-center whitespace-nowrap border-slate-600">
                                    {{ $produk->satuanTerkecil->satuan }}
                                </td>
                                <td class="border text-center whitespace-nowrap border-slate-600">{{ $jumlah }}
                                </td>
                                <td class="border text-center whitespace-nowrap border-slate-600">
                                    {{ $produk->stok_minimal }}</td>
                                <td class="border text-center whitespace-nowrap border-slate-600">
                                    {{ $produk->stok_maksimal }}</td>
                                <td class="border text-center whitespace-nowrap border-slate-600">
                                    @if ($produk->stok_minimal <= $jumlah && $produk->stok_maksimal >= $jumlah)
                                        <p class="font-bold text-success">Ideal</p>
                                    @elseif($produk->stok_maksimal >= $jumlah)
                                        <p class="font-bold text-pending">Under</p>
                                        @php
                                            $defecta = 'tersedia';
                                        @endphp
                                    @elseif($produk->stok_maksimal < $jumlah)
                                        <p class="font-bold text-danger">Over</p>
                                    @endif
                                </td>
                                <td class="text-center border whitespace-nowrap border-slate-600 text-danger">
                                    @if ($defecta)
                                        Ya
                                    @endif
                                </td>
                                <td class="text-center border whitespace-nowrap border-slate-600 text-danger">
                                    @if (RencanaPengadaan::where('id_perusahaan', Auth::user()->id_perusahaan)->where('sumber', 'pareto')->where('tanggal', $tanggal)->where('id_produk', $produk->id)->first())
                                        Ya
                                    @endif
                                </td>
                                <td class="text-center border whitespace-nowrap border-slate-600 text-danger">
                                    @if (RencanaPengadaan::where('id_perusahaan', Auth::user()->id_perusahaan)->where('sumber', 'order')->where('tanggal', $tanggal)->where('id_produk', $produk->id)->first())
                                        Ya
                                    @endif
                                </td>
                                <td class="w-32 border border-slate-600 whitespace-nowrap">
                                    @can('aksi_defecta')
                                        <a href="/histori-pembelian/{{ $produk->id }}">
                                            <button class="btn btn-sm btn-outline-primary">Lihat HPP</button>
                                        </a>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr class="intro-x">
                                <td class="font-bold text-center border whitespace-nowrap border-slate-600"
                                    colspan="14">Belum ada data produk tersedia</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- END: Data List -->
</div>
