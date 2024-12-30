<div>
    <div class="flex justify-between mt-8">
        <div class="flex flex-wrap items-center col-span-12 mt-2 mr-auto intro-y sm:flex-nowrap">
            <a href="/tambah-mutasi-stok"><button class="mr-2 shadow-md btn btn-primary" wire:ignore><i
                        data-feather="edit-3" class="w-4 h-4 mr-3"></i> Tambah</button></a>
            <div class="flex flex-wrap items-center col-span-12 mt-0 mr-2 intro-y sm:flex-nowrap">
                <div class="relative w-56 mt-0 text-slate-500">
                    @include('components.search', [
                        'id_table' => 'myTable',
                    ])
                </div>
            </div>
            <!-- END: Modal Content -->
            <div data-tw-merge class="items-center block gap-1 sm:flex">
                <label data-tw-merge for="tanggalMulai">
                </label>
                <div class="flex gap-2">
                    <input wire:model.live="tanggalMulai" id="tanggalMulai" type="date"
                        class="w-full text-sm rounded-md shadow-sm border-slate-200" />
                    <p class="w-full mt-3">s.d</p>
                    <input wire:model.live="tanggalAkhir" id="tanggalAkhir" type="date"
                        class="w-full text-sm rounded-md shadow-sm border-slate-200" />
                </div>
                <button onclick="location.reload()" class="ml-2 btn btn-md btn-secondary" wire:ignore>
                    <i data-feather="refresh-cw" class="w-4 h-4 mr-1"></i> Reload
                </button>
            </div>
        </div>
        <div class="flex items-center mt-2 intro-y gap-2">
            <a href="/mutasi-download-excel" class="flex items-center text-white shadow-md btn btn-success"
                wire:ignore><i data-feather="file-text" class="w-4 h-4 mr-1" value="Export Excel"
                    onclick="window.open('laporan-excel.php')"></i>Excel
            </a>
            <a href="{{ route('export_mutasi_stok_pdf', ['tanggalMulai' => $tanggalMulai, 'tanggalAkhir' => $tanggalAkhir]) }}"
                class="flex items-center text-white shadow-md btn btn-facebook" wire:ignore><i data-feather="printer"
                    class="w-4 h-4 mr-1"></i>Print
            </a>
        </div>
    </div>

    <!-- BEGIN: Data List -->
    <div class="col-span-12 overflow-auto intro-y lg:overflow-visible">
        <div class="mt-2 intro-y box">
            <div class="overflow-x-auto">
                <table class="table" id="myTable">
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
                    </style>
                    <style>
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
                        }

                        .header-orange {
                            background-color: #e6920b;
                            /* Contoh warna hijau */
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
                    <thead>
                        <tr class="header-gray">
                            <th rowspan="2" class="border border-slate-600">No Reff</th>
                            <th rowspan="2" class="border border-slate-600">Tanggal</th>
                            <th rowspan="2" class="border border-slate-600">Nama Produk</th>
                            <th rowspan="2" class="border border-slate-600">No Batch</th>
                            <th rowspan="2" class="border border-slate-600">Exp Date</th>
                            <th rowspan="2" class="border border-slate-600">Satuan</th>
                            <th rowspan="2" class="border border-slate-600">Ket. Satuan</th>
                            <th rowspan="2" class="border border-slate-600">Jumlah</th>
                            <th colspan="3" class="text-center border border-slate-600">Lokasi Sebelum</th>
                            <th colspan="3" class="text-center border border-slate-600">Lokasi Sesudah</th>
                            <th rowspan="2" class="border border-slate-600">Keterangan</th>
                        </tr>
                        <tr class="header-gray">
                            <th class="border border-slate-600">Gudang</th>
                            <th class="border border-slate-600">Rak</th>
                            <th class="border border-slate-600">Sub Rak</th>
                            <th class="border border-slate-600">Gudang</th>
                            <th class="border border-slate-600">Rak</th>
                            <th class="border border-slate-600">Sub Rak</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($mutasiStok as $mutasi)
                            <tr class="intro-x whitespace-nowrap">
                                <td class="text-center border border-slate-600 whitespace-nowrap">
                                    {{ $mutasi->history->no_reff }}</td>
                                <td class="text-center border border-slate-600 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($mutasi->created_at)->format('d-m-Y') }}</td>
                                <td class="border border-slate-600 whitespace-nowrap">
                                    {{ $mutasi->produk->nama_obat_barang }}</td>
                                <td class="border border-slate-600 whitespace-nowrap">
                                    {{ $mutasi->history->no_batch }}
                                </td>
                                <td class="text-center border border-slate-600 whitespace-nowrap">
                                    {{ date('d-m-Y', strtotime($mutasi->history->exp_date)) }}</td>
                                </td>
                                <td class="text-center border border-slate-600 whitespace-nowrap">
                                    {{ $mutasi->produk->satuanTerkecil->satuan }}</td>
                                <td class="border border-slate-600 whitespace-nowrap">
                                    {{ $mutasi->produk->ket_satuan }}</td>
                                <td class="text-center border border-slate-600 whitespace-nowrap">
                                    {{ $mutasi->jumlah_mutasi }} </td>
                                <td class="text-center border border-slate-600 whitespace-nowrap text-danger">
                                    {{ $mutasi->gudangSebelum->gudang }}</td>
                                <td class="text-center border border-slate-600 whitespace-nowrap text-danger">
                                    {{ $mutasi->rakSebelum->rak }}</td>
                                <td class="text-center border border-slate-600 whitespace-nowrap text-danger">
                                    {{ $mutasi->subRakSebelum->sub_rak }}</td>
                                <td class="text-center border border-slate-600 whitespace-nowrap text-success">
                                    {{ $mutasi->gudangSesudah->gudang }}</td>
                                <td class="text-center border border-slate-600 whitespace-nowrap text-success">
                                    {{ $mutasi->rakSesudah->rak }}</td>
                                <td class="text-center border border-slate-600 whitespace-nowrap text-success">
                                    {{ $mutasi->subRakSesudah->sub_rak }}</td>
                                <td class="text-center border border-slate-600 whitespace-nowrap">
                                    {{ $mutasi->keterangan }}</td>
                            </tr>
                        @empty
                            <tr class="intro-x">
                                <td class="font-bold text-center text-pending border border-slate-600" colspan="15">
                                    Belum ada data
                                    tersedia</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
