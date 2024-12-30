<div>
    <div class="grid grid-cols-12 gap-2 mt-8">
        <!-- BEGIN: Data List -->
        <div class="col-span-6 md:col-span-3">
            <div class="flex gap-2">
                <div class="relative w-56 mr-auto text-slate-500">
                    <input type="text" class="w-56 pr-10 form-control box" placeholder="Search Nama Produk"
                        wire:model.live.debounce.300ms="search">
                    <i class="absolute inset-y-0 right-0 w-4 h-6 my-auto mr-3" data-feather="search"></i>
                </div>

                <div class="flex items-center gap-2">
                    <!-- Input Tanggal Mulai -->
                    <input id="tanggalMulai" type="date" wire:model.live="mulaiId"
                        class="w-full rounded-md shadow-sm border-slate-200 text-sm placeholder:text-slate-400/90
               focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40
               disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent
               [&[readonly]]:bg-slate-100 [&[readonly]]:cursor-not-allowed [&[readonly]]:dark:bg-darkmode-800/50 [&[readonly]]:dark:border-transparent
               transition duration-200 ease-in-out dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />

                    <!-- Separator Text -->
                    <p class="w-20 text-center">s.d</p>

                    <!-- Input Tanggal Akhir -->
                    <input id="tanggalAkhir" type="date" wire:model.live="selesaiId"
                        class="w-full rounded-md shadow-sm border-slate-200 text-sm placeholder:text-slate-400/90
               focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40
               disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent
               [&[readonly]]:bg-slate-100 [&[readonly]]:cursor-not-allowed [&[readonly]]:dark:bg-darkmode-800/50 [&[readonly]]:dark:border-transparent
               transition duration-200 ease-in-out dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                </div>

                <div class="flex items-center">
                    {{-- <label data-tw-merge for="kategori-produk" class="inline-block mt-2 mb-2 sm:w-32">Kategori
                        Produk</label> --}}
                    <select data-tw-merge id="kategori-produk" wire:model.live="kategoriId"
                        aria-label="Default select example" class="form-control" style="width: 150px;">
                        <option value=>- Kategori -</option>
                        @foreach ($kategori as $item)
                            <option value="{{ $item->id }}">{{ $item->golongan }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center">
                    {{-- <label data-tw-merge for="produsen" class="inline-block mt-2 mb-2 sm:w-20">Produsen</label> --}}
                    <select data-tw-merge wire:model.live="produsenId" id="produsen"
                        aria-label="Default select example" class="form-control" style="width: 150px;">
                        <option value=>- Pilih Produsen -</option>
                        @foreach ($produsen as $item)
                            <option value="{{ $item->id }}">{{ $item->produsen }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center">
                    {{-- <label data-tw-merge for="gudang" class="inline-block mt-2 mb-2 sm:w-20">Gudang</label> --}}
                    <select data-tw-merge id="gudang" aria-label="Default select example" class="form-control"
                        wire:model.live="gudangId" style="width: 150px;">
                        <option value=>- Pilih Gudang -</option>
                        @foreach ($gudang as $item)
                            <option value="{{ $item->id }}">{{ $item->gudang }}</option>
                        @endforeach
                    </select>
                    <button onclick="location.reload()" class="ml-2 btn btn-md btn-secondary" wire:ignore>
                        <i data-feather="refresh-cw" class="w-4 h-4 mr-1"></i> Reload
                    </button>
                </div>

                {{-- <div class="col-span-6 md:col-span-3" style="position: absolute; top: 245px; right:80px;">
                    <div class="flex gap-2">
                        <button class="text-white btn btn-success">
                            <i data-feather="file-text" class="w-4 mr-1"></i>Excel</span>
                        </button>

                        <a id="print-pdf-button"
                            href="{{ route('cetak_pdf_exp', ['search' => $search, 'kategoriId' => $kategoriId, 'gudangId' => $gudangId, 'produsenId' => $produsenId, 'mulaiId' => $mulaiId, 'selesaiId' => $selesaiId]) }}"
                            target="_blank" class="btn btn-dark"><i data-feather="printer"
                                class="w-4 mr-1"></i>Print</span></a>
                    </div>
                </div> --}}

                <div class="text-center" wire:loading wire:target="print">
                    Loading PDF...
                </div>
            </div>
        </div>
        <!-- END: Data List -->
    </div>

    <div class="mt-2 overflow-auto box">
        @if ($historystok && !$historystok->isEmpty())
            <table class="table mt-2">
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
                        {{-- <th rowspan="2" class="border border-slate-600">No</th> --}}
                        <th rowspan="2" class="border border-slate-600">Barcode</th>
                        <th rowspan="2" class="border border-slate-600">Nama Produk</th>
                        <th rowspan="2" class="border border-slate-600">Produsen</th>
                        <th rowspan="2" class="border border-slate-600">Kategori</th>
                        <th rowspan="2" class="border border-slate-600">Stok</th>
                        <th rowspan="2" class="border border-slate-600">Satuan</th>
                        <th rowspan="2" class="border border-slate-600">Batch</th>
                        <th rowspan="2" class="border border-slate-600">Exp Date</th>
                        <th rowspan="2" class="border border-slate-600">HPP</th>
                        <th rowspan="2" class="border border-slate-600">Total</th>
                        <th rowspan="2" class="border border-slate-600">Gudang</th>
                        <th rowspan="2" class="border border-slate-600">Rak</th>
                        <th rowspan="2" class="border border-slate-600">Sub Rak</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalHpp = 0;
                        $totalHppStok = 0;
                    @endphp

                    @forelse ($historystok as $history)
                        @php
                            $hpp = $history->hpp($history);

                            $stok = $history->sisaStokBatch(
                                $history->id_produk,
                                $history->no_batch,
                                $history->id_gudang,
                                $history->id_rak,
                                $history->id_sub_rak,
                                $history->no_reff
                            );

                            $totalHpp += $hpp;
                            $totalHppStok += $hpp * $stok;
                        @endphp
                        @if ($stok != 0)
                            <tr class="text-center intro-x">
                                {{-- <td class="border border-slate-600">{{ $loop->iteration }}</td> --}}
                                <td class="border border-slate-600">{{ $history->produk->barcode_produk }}</td>
                                <td class="border border-slate-600">{{ $history->produk->nama_obat_barang }}</td>
                                <td class="border border-slate-600">{{ $history->produk->produsenProduk->produsen }}
                                </td>
                                <td class="border border-slate-600">{{ $history->produk->kelompok->golongan }}</td>
                                <td class="border border-slate-600">{{ $stok }}</td>
                                <td class="border border-slate-600">{{ $history->produk->satuanTerkecil->satuan }}</td>
                                <td class="border border-slate-600">{{ $history->no_batch }}</td>
                                <td class="border border-slate-600">{{ date('d-m-Y', strtotime($history->exp_date)) }}
                                </td>
                                <td class="border border-slate-600">{{ number_format($hpp, 0, ',', '.') }}</td>
                                <td class="border border-slate-600">{{ number_format($hpp * $stok, 0, ',', '.') }}</td>
                                <td class="border border-slate-600">{{ $history->gudang->gudang }}</td>
                                <td class="border border-slate-600">{{ $history->rak->rak }}</td>
                                <td class="border border-slate-600">{{ $history->subRak->sub_rak }}</td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td class="font-bold text-center border text-pending border-slate-600" colspan="14">
                                Belum
                                ada data
                                tersedia</td>
                        </tr>
                    @endforelse
                    <tr class="font-bold text-center intro-x">
                        <td class="border text-center border-slate-600" colspan="9">Total</td>
                        {{-- <td class="border border-slate-600">{{ number_format($totalHpp, 0, ',', '.') }}</td> --}}
                        <td class="border border-slate-600">{{ number_format($totalHppStok, 0, ',', '.') }}</td>
                        <td class="border border-slate-600" colspan="3"></td>
                    </tr>
                </tbody>
                {{-- <tfoot>
                    <tr class="text-center">
                        <td colspan="10" class="border border-slate-600">Total</td>
                        <td class="border border-slate-600">?</td>
                        <td colspan="7" class="border border-slate-600"></td>
                    </tr>
                </tfoot> --}}
            </table>
            {{ $historystok->links() }}
        @else
            <p class="p-5 font-bold text-center text-pending">Belum ada data tersedia</p>
        @endif
    </div>

</div>
