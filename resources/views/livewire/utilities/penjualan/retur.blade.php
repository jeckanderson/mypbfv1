<div>
    <div class="grid grid-cols-12 gap-2 mt-8">
        <div class="col-span-6 md:col-span-3">
            <div class="flex items-center">
                {{-- <div class="relative w-56 mr-auto text-slate-500">
                    <input type="text" class="w-56 pr-10 form-control box" placeholder="Search No. Faktur ..."
                        wire:model.live.debounce.300ms="search">
                    <i class="absolute inset-y-0 right-0 w-4 h-6 my-auto mr-3" data-feather="search"></i>
                </div> --}}
                <div class="ml-2">
                    <input id="tanggal-dari" name="mulaiId" wire:model.lazy="mulaiId" type="date"
                        placeholder="Stok dari master" style="width: 150px;"
                        class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&[readonly]]:bg-slate-100 [&[readonly]]:cursor-not-allowed [&[readonly]]:dark:bg-darkmode-800 [&[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                </div>
                <label for="tanggal-sampai" class="inline-block mt-2 mb-2 ml-2 sm:w-auto">s.d</label>
                <div class="ml-2">
                    <input id="tanggal-sampai" wire:model.lazy="selesaiId" name="selesaiId" type="date"
                        placeholder="Stok dari master" style="width: 150px;"
                        class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&[readonly]]:bg-slate-100 [&[readonly]]:cursor-not-allowed [&[readonly]]:dark:bg-darkmode-800 [&[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                </div>
                <select id="pelanggan" name="pelanggan" wire:model.live="pelangganId"
                    aria-label="Default select example" class="form-select ml-2 w-auto">
                    <option value=>- Pilih Pelanggan -</option>
                    @foreach ($pelanggan as $item)
                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                    @endforeach
                </select>
                <select id="sales" name="sales" wire:model.live="salesId" aria-label="Default select example"
                    class="ml-2 form-select w-auto">
                    <option value=>- Pilih Sales -</option>
                    @foreach ($sales as $item)
                        <option value="{{ $item->pegawai_sales->id }}">{{ $item->pegawai_sales->nama_pegawai }}</option>
                    @endforeach
                </select>
                <button onclick="location.reload()" class="ml-2 btn btn-md btn-secondary" wire:ignore>
                    <i data-feather="refresh-cw" class="w-4 h-4 mr-1"></i> Reload
                </button>
            </div>
            {{-- 
            <div class="flex items-center mb-3">
                <select id="pelanggan" name="pelanggan" wire:model.live="pelangganId"
                    aria-label="Default select example" class="form-select">
                    <option value=>- Pilih Pelanggan -</option>
                    @foreach ($pelanggan as $item)
                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                    @endforeach
                </select>
                <select id="sales" name="sales" wire:model.live="salesId" aria-label="Default select example"
                    class="ml-2 form-select">
                    <option value=>- Pilih Sales -</option>
                    @foreach ($sales as $item)
                        <option value="{{ $item->pegawai_sales->id }}">{{ $item->pegawai_sales->nama_pegawai }}</option>
                    @endforeach
                </select>
            </div> --}}

            {{-- <div class="col-span-6 md:col-span-3" style="position: absolute; top: 385px; right:55px;">
                <div class="flex gap-2">
                    <button wire:click="exportToExcel" class="btn btn-success">
                        <span wire:ignore><i data-feather="file-text" class="w-5 h-5 mr-1"></i>Excel</span>
                    </button>
                    <a id="print-pdf-button"
                        href="{{ route('cetak_pdf_retur', [
                            'search' => $search,
                            'salesId' => $salesId,
                            'mulaiId' => $mulaiId,
                            'selesaiId' => $selesaiId,
                            'pelangganId' => $pelangganId,
                        ]) }}"
                        target="_blank" class="btn btn-primary"><span wire:ignore><i data-feather="printer"
                                class="w-5 h-5 mr-1"></i>PDF</span></a>
                </div>
            </div>

            <div class="col-span-6 md:col-span-3" style="position: absolute; top: 395px; right: 220px;">
                <div class="flex items-center mb-3">
                    <label for="search" class="inline-block mt-2 mb-2 sm:w-20">Cari</label>
                    <input type="text" id="search" name="search" wire:model.live.debounce.300ms="search"
                        class="block w-full rounded-md shadow-sm form-input">
                </div>
            </div>

            <div class="text-center" wire:loading wire:target="print">
                Loading PDF...
            </div> --}}
            <hr>
        </div>
    </div>

    <div class="mt-2 overflow-auto box">
        @forelse ($retur as $returItem)
            <div class="grid grid-cols-12 gap-3 mt-2 ml-4">
                <div class="col-span-3 md:col-span-1">
                    <div class="flex items-center mb-1"> <!-- Mengurangi margin bawah -->
                        <p class="inline-block mt-1 mb-1 font-bold sm:w-20">Tgl. Retur:</p>
                        <!-- Mengurangi margin atas dan bawah -->
                        <h1>{{ $returItem->tgl_input->format('d-m-Y') }}</h1>
                    </div>
                    <div class="flex items-center mb-1">
                        <p class="inline-block mt-1 mb-1 font-bold sm:w-20">No. Reff: </p>
                        <h1>{{ $returItem->no_reff }}</h1>
                    </div>
                </div>

                <div class="col-span-3 md:col-span-1">
                    <div class="flex items-center mb-1">
                        <p class="inline-block mt-1 mb-1 font-bold sm:w-20">Pelanggan:</p>
                        <h1>{{ $returItem->getPelanggan->nama }}</h1>
                    </div>
                    <div class="flex items-center mb-1">
                        <p class="inline-block mt-1 mb-1 font-bold sm:w-20">Sales: </p>
                        <h1>{{ $returItem->getSales->nama_pegawai }}</h1>
                    </div>
                </div>

                <div class="col-span-3 md:col-span-1">
                    <div class="flex items-center mb-1">
                        <p class="inline-block mt-1 mb-1 font-bold sm:w-20">No. Faktur:</p>
                        <h1>{{ $returItem->no_faktur }}</h1>
                    </div>
                    <div class="flex items-center mb-1">
                        <p class="inline-block mt-1 mb-1 font-bold sm:w-20">No. Pajak: </p>
                        <h1>{{ $returItem->penjualan->no_seri_pajak }}</h1>
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
                        <th rowspan="2" class="border border-slate-600">Batch</th>
                        <th rowspan="2" class="border border-slate-600">Exp Date</th>
                        <th rowspan="2" class="border border-slate-600">Qty Retur</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($returItem->produk_retur_penjualan as $item)
                        <tr class="text-center intro-x">
                            <td class="border border-slate-600 text-center">{{ $loop->iteration }}</td>
                            <td class="border border-slate-600 text-center">
                                {{ $item->produk->barcode_produk }}</td>
                            <td class="border border-slate-600">
                                {{ $item->produk->nama_obat_barang }}</td>
                            <td class="border border-slate-600 text-center">
                                {{ $item->produk->satuanTerkecil->satuan }}</td>
                            <td class="border border-slate-600">{{ $item->produkPenjualan->batch }}</td>
                            <td class="border border-slate-600 text-center">
                                {{ date('d-m-Y', strtotime($item->produkPenjualan->exp_date)) }}</td>
                            <td class="border border-slate-600 text-center">{{ $item->qty_retur }}</td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
            <div class="grid grid-cols-12 gap-3 mt-2 ml-4">
                <div class="col-span-3 md:col-span-1 ">
                    <div class="flex items-center mb-3">
                        <p class="inline-block mt-2 mb-2 font-bold sm:w-20">DPP:</p>
                        <h1>{{ number_format($returItem->dpp, 0, '.', '.') }}</h1>
                    </div>

                </div>

                <div class="col-span-3 md:col-span-1 ">
                    <div class="flex items-center mb-3">
                        <p class="inline-block mt-2 mb-2 font-bold sm:w-20">PPN:</p>
                        <h1>{{ number_format($returItem->ppn, 0, '.', '.') }}</h1>
                    </div>

                </div>
                <div class="col-span-3 md:col-span-1 ">
                    <div class="flex items-center mb-3">
                        <p class="inline-block mt-2 mb-2 font-bold sm:w-20">Total:</p>
                        <h1>{{ number_format($returItem->total, 0, '.', '.') }}</h1>
                    </div>

                </div>
            </div>
        @empty
            <div class="p-5 box">
                <p class="font-bold text-center text-pending border-slate-600">Belum ada data tersedia</p>
            </div>
        @endforelse
    </div>
</div>
