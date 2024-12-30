<div class="p-5 mt-5 box">
    <div class="flex justify-end modal-header">
        <a href="{{ route('excel_cetak_kartu', ['id_produk' => $historys->first()->id_produk, 'id_gudang' => $historys->first()->gudang, 'id_rak' => $historys->first()->id_rak, 'id_sub_rak' => $historys->first()->id_sub_rak]) }}"
            class="mr-4 text-white btn btn-success"><i data-feather="file-text" class="w-4 h-4 mr-1"
                value="Export Excel"onclick="window.open('laporan-excel.php')"></i>Excel
        </a>
        <a href="{{ route('export_cetak_kartu_pdf', ['id_produk' => $historys->first()->id_produk, 'id_gudang' => $historys->first()->gudang, 'id_rak' => $historys->first()->id_rak, 'id_sub_rak' => $historys->first()->id_sub_rak]) }}"
            class="mr-4 text-white btn btn-facebook"><i data-feather="printer" class="w-4 h-4 mr-1"></i>Print</a>
    </div>
    <div class="p-5 modal-body">
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
                margin: 20px 0;
            }

            td {
                padding: 10px;
                border: 1px solid #ddd;
                vertical-align: top;
            }

            .label {
                font-weight: bold;
                width: 10%;
            }

            .value {
                width: 50%;
            }
        </style>
        </head>

        <body>

            <table>
                <tr>
                    <td class="label">Nama Produk</td>
                    <td class="value">{{ $historys->first()->produk->nama_obat_barang }}</td>
                </tr>
                <tr>
                    <td class="label">Jenis Produk</td>
                    <td class="value">{{ $historys->first()->produk->jenis_obat_barang }}</td>
                </tr>
                <tr>
                    <td class="label">Gudang</td>
                    <td class="value">{{ $historys->first()->gudang->gudang }}</td>
                </tr>
                <tr>
                    <td class="label">Rak</td>
                    <td class="value">{{ $historys->first()->rak->rak }}</td>
                </tr>
                <tr>
                    <td class="label">Sub Rak</td>
                    <td class="value">{{ $historys->first()->subRak->sub_rak }}</td>
                </tr>
                <tr>
                    <td class="label">Tipe</td>
                    <td class="value">{{ $historys->first()->produk->tipe }}</td>
                </tr>
                <tr>
                    <td class="label">Satuan</td>
                    <td class="value">{{ $historys->first()->produk->satuanTerkecil->satuan }}</td>
                </tr>
                <tr>
                    <td class="label">Ket. Satuan</td>
                    <td class="value">{{ $historys->first()->produk->ket_satuan }}</td>
                </tr>
            </table>

        </body>


        <div class="flex justify-start">
            <div class="border relative w-60 text-slate-500">
                <input type="text" class="w-56 pr-10 form-control cari box" placeholder="Search No. Batch..."
                    wire:model.live.debounce.250='searchTerm'>
                <i class="absolute inset-y-0 right-0 w-4 h-4 my-auto mr-3" data-feather="search"></i>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="table mt-5 border border-slate-600" id="tableSearch">
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
                        /* text-align: center; */
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
                        text-align: left;
                    }

                    td {
                        font-size: 1em;
                    }
                </style>
                <thead>
                    <tr class="header-gray text-center">
                        <td class="border border-slate-600">No</td>
                        <td class="border border-slate-600">Tanggal</td>
                        <td class="border border-slate-600">No. Reff</td>
                        <td class="border border-slate-600">No. Faktur</td>
                        <td class="border border-slate-600">
                            Supplier/Pelanggan
                        </td>
                        <td class="border border-slate-600">No Batch</td>
                        <td class="border border-slate-600">Exp. Date</td>
                        <td class="border border-slate-600">Stok Masuk</td>
                        <td class="border border-slate-600">Stok Keluar</td>
                        <td class="border border-slate-600">Keterangan</td>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dataHistory as $histori)
                        <tr>
                            <td class="border border-slate-600 text-center">{{ $loop->iteration }}</td>
                            <td class="border border-slate-600 text-center">{{ $histori->created_at->format('d-m-Y') }}
                            </td>
                            <td class="border border-slate-600">{{ $histori->no_reff }}</td>
                            <td class="border border-slate-600">{{ $histori->no_faktur }}</td>
                            <td class="border border-slate-600">
                                @if ($histori->keterangan == 'Pembelian')
                                    {{ $histori->suplier->nama_suplier }}
                                @elseif($histori->keterangan == 'Penjualan')
                                    {{ $histori->pelanggan->nama }}
                                @elseif($histori->keterangan == 'Retur Pembelian')
                                    {{ $histori->suplier->nama_suplier }}
                                @elseif($histori->keterangan == 'Retur Penjualan')
                                    {{ $histori->pelanggan->nama }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="border border-slate-600">{{ $histori->no_batch }}</td>
                            <td class="border border-slate-600 text-center">
                                {{ strtotime($histori->exp_date) ? date('d-m-Y', strtotime($histori->exp_date)) : $histori->exp_date }}
                            </td>
                            <td class="border border-slate-600 stok-masuk text-center">{{ $histori->stok_masuk }}</td>
                            <td class="border border-slate-600 stok-keluar text-center">{{ $histori->stok_keluar }}
                            </td>
                            <td class="border border-slate-600">{{ $histori->keterangan }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="font-bold text-center border text-pending border-slate-600" colspan="10">Tidak
                                ditemukan No. Batch yang diinginkan</td>
                        </tr>
                    @endforelse
                    <tr class="font-bold text-center">
                        <td class="border border-slate-600" colspan="7">Total</td>
                        <td class="border border-slate-600 total-stok-masuk text-center">
                            {{ $dataHistory->sum('stok_masuk') }}</td>
                        <td class="border border-slate-600 total-stok-masuk text-center">
                            {{ $dataHistory->sum('stok_keluar') }}
                        </td>
                        <td class="border border-slate-600"></td>
                    </tr>
                    <tr class="font-bold text-center">
                        <td class="border border-slate-600" colspan="7">Sisa Stok Tersedia</td>
                        <td class="border border-slate-600 text-center" colspan="2">
                            {{ $dataHistory->sum('stok_masuk') - $dataHistory->sum('stok_keluar') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>
