<div>
    <div class="grid grid-cols-12 gap-2 mt-8">
        <div class="col-span-6 md:col-span-3">

            <div class="flex items-center mb-2">
                <div class="relative w-56 text-slate-500">
                    <input type="text" class="w-56 pr-10 form-control cari box" placeholder="Search No. Faktur"
                        wire:model.live.debounce.300ms="search">
                    <i class="absolute inset-y-0 right-0 w-4 h-4 my-auto mr-3" data-feather="search"></i>
                </div>
                <div class="ml-2">
                    <input id="tanggal-dari" name="mulaiId" wire:model.lazy="mulaiId" type="date"
                        placeholder="Stok dari master" style="width: 150px;"
                        class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&[readonly]]:bg-slate-100 [&[readonly]]:cursor-not-allowed [&[readonly]]:dark:bg-darkmode-800 [&[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                </div>
                <label for="tanggal-sampai" class="inline-block mt-2 mb-2 ml-2 sm:w-20">s.d</label>
                <div class="ml-2">
                    <input id="tanggal-sampai" wire:model.lazy="selesaiId" name="selesaiId" type="date"
                        placeholder="Stok dari master" style="width: 150px;"
                        class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&[readonly]]:bg-slate-100 [&[readonly]]:cursor-not-allowed [&[readonly]]:dark:bg-darkmode-800 [&[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                </div>
            </div>

            <div class="flex items-center mb-2">
                <select data-tw-merge id="sales" aria-label="Default select example" wire:model.live="spId"
                    class="form-control">
                    <option value="">- Pilih Supplier -</option>
                    @foreach ($suplier as $item)
                        <option value="{{ $item->id }}">{{ $item->nama_suplier }}</option>
                    @endforeach
                </select>
                <button onclick="location.reload()" class="ml-2 btn btn-md btn-secondary" wire:ignore>
                    <i data-feather="refresh-cw" class="w-4 h-4 mr-1"></i> Reload
                </button>
            </div>

            {{-- <div class="col-span-6 md:col-span-3" style="position: absolute; top: 330px; right:50px;">
                <div class="flex gap-2">
                    <button class="btn btn-success">
                        <span wire:ignore><i data-feather="file-text" class="w-5 h-5 mr-1"></i>Excel</span>
                    </button>
                    <a href="{{ route('cetak_pdf_terima_detail', [
                        'search' => $search,
                    
                        'spId' => $spId,
                        'mulaiId' => $mulaiId,
                        'selesaiId' => $selesaiId,
                    ]) }}"
                        target="_blank" class="btn btn-primary"><span wire:ignore><i data-feather="printer"
                                class="w-5 h-5 mr-1"></i>PDF</span></a>
                </div>

            </div> --}}


            {{-- <div class="col-span-6 md:col-span-3" style="position: absolute; top: 345px; right: 180px;">
                <div class="flex items-center mb-2">
                    <label for="search" class="inline-block mt-2 mb-2 sm:w-20">Cari</label>
                    <input type="text" id="search" name="search" wire:model.live.debounce.300ms="search"
                        class="block w-full rounded-md shadow-sm form-input">
                </div>
            </div> --}}
            <div class="text-center" wire:loading wire:target="print">
                Loading PDF...
            </div>
        </div>
    </div>

    @php
        $dataCount = count($terima);
    @endphp

    @if ($dataCount > 0)
        @foreach ($terima as $terima)
            <div class="p-3 mt-2 box">
                <div class="grid grid-cols-12 gap-3 mt-2 ml-4">
                    <div class="col-span-3 md:col-span-1 ">
                        <div class="flex items-center mb-2">
                            <p class="inline-block mt-2 mb-2 font-bold sm:w-20">Tgl. Terima :</p>
                            <h1>{{ $terima->tanggal->format('d-m-Y') }}</h1>
                        </div>
                        <div class="flex items-center mb-2">
                            <p class="inline-block mt-2 mb-2 font-bold sm:w-20">Tgl. Faktur: </p>
                            <h1>{{ $terima->pembelian->tgl_faktur->format('d-m-Y') }}</h1>
                        </div>
                    </div>

                    <div class="col-span-3 md:col-span-1 ">
                        <div class="flex items-center mb-2">
                            <p class="inline-block mt-2 mb-2 font-bold sm:w-20">No. Faktur:</p>
                            <h1> {{ $terima->pembelian->no_faktur }}</h1>
                        </div>
                        <div class="flex items-center mb-2">
                            <p class="inline-block mt-1 mb-2 font-bold sm:w-20">Supplier: </p>
                            <h1>{{ $terima->pembelian->getSuplier->nama_suplier }}</h1>
                        </div>
                    </div>

                    <div class="col-span-3 md:col-span-1 ">
                        <div class="flex items-center mb-2">
                            <p class="inline-block mt-2 mb-2 font-bold sm:w-20">No. SP:</p>
                            <h1> {{ $terima->pembelian->no_sp }}</h1>
                        </div>
                        <div class="flex items-center mb-2">
                            <p class="inline-block mt-2 mb-2 font-bold sm:w-20">Tgl. SP: </p>
                            <h1>{{ $terima->sp->tgl_sp->format('d-m-Y') }}</h1>
                        </div>
                    </div>
                </div>

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
                            <th rowspan="2" class="border border-slate-600">No</th>
                            <th rowspan="2" class="border border-slate-600">Barcode</th>
                            <th rowspan="2" class="border border-slate-600">Nama Produk</th>
                            <th rowspan="2" class="border border-slate-600">Satuan</th>
                            <th rowspan="2" class="border border-slate-600">Qty SP</th>
                            <th rowspan="2" class="border border-slate-600">Qty Faktur</th>
                            <th rowspan="2" class="border border-slate-600">Diterima</th>
                            <th rowspan="2" class="border border-slate-600">No. Batch</th>
                            <th rowspan="2" class="border border-slate-600">Exp Date</th>
                            <th rowspan="2" class="border border-slate-600">Gudang</th>
                            <th rowspan="2" class="border border-slate-600">Rak</th>
                            <th rowspan="2" class="border border-slate-600">Sub Rak</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($terima->produkDiterima as $item)
                            <tr class="text-center intro-x">
                                <td class="border border-slate-600">{{ $loop->iteration }}</td>
                                <td class="border border-slate-600">{{ $item->produk->barcode_produk }}</td>
                                <td class="border border-slate-600">{{ $item->produk->nama_obat_barang }}</td>
                                <td class="border border-slate-600">{{ $item->produk->satuanTerkecil->satuan }}</td>
                                <td class="border border-slate-600">{{ $item->order->jumlah_order }}</td>
                                <td class="border border-slate-600">{{ $item->diterimaToPembelian->qty_faktur }}</td>
                                <td class="border border-slate-600">{{ $item->diterima }}</td>
                                <td class="border border-slate-600">{{ $item->no_batch }}</td>
                                <td class="border border-slate-600">
                                    {{ $item->tgl_exp_date != '-' ? \Carbon\Carbon::parse($item->tgl_exp_date)->format('d-m-Y') : '-' }}
                                </td>
                                <td class="border border-slate-600">{{ $item->gudangStok->gudang }}</td>
                                <td class="border border-slate-600">{{ $item->rakStok->rak }}</td>
                                <td class="border border-slate-600">{{ $item->subRak->sub_rak }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach
    @else
        <div class="p-5 box">
            <p class="font-bold text-center text-pending border-slate-600">Belum ada data tersedia</p>
        </div>
    @endif
</div>
</div>
<!-- END: Data List -->
</div>
</div>
