<div>
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
    <div class="grid grid-cols-12 gap-2 mt-8">
        <div class="col-span-6 md:col-span-3">
            <div class="flex items-center mb-2">
                <div class="col-span-6 mt-0 md:col-span-3">
                    <div class="col-span-6 md:col-span-3">
                        <div class="relative w-56 text-slate-500">
                            <input type="text" class="w-56 pr-10 form-control cari box" placeholder="Search No. SP ..."
                                wire:model.live.debounce.300ms="search">
                            <i class="absolute inset-y-0 right-0 w-4 h-4 my-auto mr-3" data-feather="search"></i>
                        </div>
                    </div>
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
            <div class="flex flex-col items-center gap-2 mb-2 sm:flex-row">
                <select id="pelanggan" name="pelanggan" wire:model.live="pelangganId"
                    aria-label="Default select example" class="w-auto form-select">
                    <option value="">- Pilih Pelanggan -</option>
                    @foreach ($pelanggan as $item)
                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                    @endforeach
                </select>

                <select id="tipe-sp" wire:model.live="spId" aria-label="Default select example"
                    class="w-auto form-control">
                    <option value="">- Pilih SP -</option>
                    <option value="SP. Reguler">SP.Reguler</option>
                    <option value="SP. OOT">SP. OOT</option>
                    <option value="SP. Prekursor">SP. Prekursor</option>
                    <option value="SP. Psikotropika">SP. Psikotropika</option>
                    <option value="SP. Narkotika">SP. Narkotika</option>
                </select>

                <select id="sumber" wire:model="sumberId" aria-label="Default select example"
                    class="w-auto form-control">
                    <option value="">- Pilih Sumber -</option>
                    <option value="Website">Website</option>
                    <option value="Mobile">Mobile</option>
                </select>

                <select id="sales" name="sales" wire:model.live="salesId" aria-label="Default select example"
                    class="w-auto form-select">
                    <option value="">- Pilih Sales -</option>
                    @foreach ($sales as $s)
                        <option value="{{ $s->id }}">{{ $s->nama_pegawai }}</option>
                    @endforeach
                </select>
                <button onclick="location.reload()" class="ml-0 btn btn-md btn-secondary" wire:ignore>
                    <i data-feather="refresh-cw" class="w-4 h-4 mr-1"></i> Reload
                </button>
            </div>

            {{-- <div class="col-span-6 md:col-span-3" style="position: absolute; top: 300px; right:80px;">
                <div class="flex gap-2">
                    <button class="text-white btn btn-success" wire:ignore><i data-feather="file-text"
                            class="w-4 h-4 mr-1"></i>Excel
                    </button>
                    <a id="print-pdf-button"
                        href="{{ route('cetak_pdf_vs', [
                            'search' => $search,
                            'spId' => $spId,
                            'salesId' => $salesId,
                            'mulaiId' => $mulaiId,
                            'selesaiId' => $selesaiId,
                            'pelangganId' => $pelangganId,
                            'sumberId' => $sumberId,
                            'spId' => $spId,
                        ]) }}"
                        target="_blank" class="btn btn-facebook"wire:ignore><i data-feather="printer"
                            class="w-4 h-4 mr-1"></i>Print</a>
                </div>
            </div>

            <div class="text-center" wire:loading wire:target="print">
                Loading PDF...
            </div> --}}

        </div>
    </div>

    <div class="mt-2 overflow-auto box">
        @forelse ($produkpenjualan as $produkpenjualans)
            <div class="grid grid-cols-12 gap-3 mt-2 ml-4">
                <div class="col-span-3 md:col-span-1">
                    <div class="flex items-center mb-1">
                        <p class="inline-block sm:w-20">No. Sp:</p>
                        <h1 class="ml-2">{{ $produkpenjualans->no_sp }}</h1>
                    </div>
                    <div class="flex items-center mb-2 sm:mb-1">
                        <p class="inline-block sm:w-20">Tgl. Sp:</p>
                        <h1 class="ml-2">
                            {{ \Carbon\Carbon::parse($produkpenjualans->tgl_sp)->format('d-m-Y') }}</h1>
                    </div>

                </div>

                <div class="col-span-3 md:col-span-1">
                    <div class="flex items-center mb-1">
                        <p class="inline-block sm:w-20">Pelanggan:</p>
                        <h1 class="ml-2">{{ $produkpenjualans->pelangganPenjualan->nama }}</h1>
                    </div>
                    <div class="flex items-center mb-1">
                        <p class="inline-block sm:w-20">Sales:</p>
                        <h1 class="ml-2">{{ $produkpenjualans->salesPenjualan->nama_pegawai }}</h1>
                    </div>
                </div>

                <div class="col-span-3 md:col-span-1">
                    <div class="flex items-center mb-1">
                        <p class="inline-block sm:w-20">Tipe. Sp:</p>
                        <h1 class="ml-2">{{ $produkpenjualans->tipe_sp }}</h1>
                    </div>
                    <div class="flex items-center mb-1">
                        <p class="inline-block sm:w-20">Sumber:</p>
                        <h1 class="ml-2">{{ $produkpenjualans->sumber }}</h1>
                    </div>
                </div>

                <div class="col-span-3 md:col-span-1">
                    <div class="flex items-center mb-1">
                        <p class="inline-block sm:w-20">Tgl. Faktur:</p>
                        <h1 class="ml-2">
                            {{ \Carbon\Carbon::parse($produkpenjualans->tgl_faktur)->format('d-m-Y') }}</h1>
                    </div>
                    <div class="flex items-center mb-1">
                        <p class="inline-block sm:w-20">No. Faktur:</p>
                        <h1 class="ml-2">{{ $produkpenjualans->penjualan->no_faktur ?? '-' }}</h1>
                    </div>
                </div>

            </div>
            <div class="overflow-auto box">
                <table class="table mt-2">
                    <thead>
                        <tr class="header-gray">
                            <th class="border border-slate-600" width="15%">No</th>
                            <th class="border border-slate-600">Nama Produk</th>
                            <th class="border border-slate-600">Satuan</th>
                            <th class="border border-slate-600">Qty SP</th>
                            <th class="border border-slate-600">Qty Jual</th>
                            <th class="border border-slate-600">Harga</th>
                            <th class="border border-slate-600">Qty Potensi Loss</th>
                            <th class="border border-slate-600">Omset Loss</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $total_loss = 0;
                        @endphp
                        @forelse ($produkpenjualans->produkPenjualan()
                    ->join('obat_barang','obat_barang.id','=','produk_penjualan.id_produk')
                    ->join('satuan','satuan.id','=','produk_penjualan.satuan')
                    ->selectRaw('SUM(qty) as qty,obat_barang.nama_obat_barang,satuan.satuan,produk_penjualan.qty_sp,produk_penjualan.harga')
                    ->groupBy('id_produk')->get() as $item)
                        @php
                            $total_loss += $item->qty_sp - $item->qty;
                        @endphp
                            <tr class="text-center intro-x">
                                <td class="border border-slate-600 text-center">{{ $loop->iteration }}</td>
                                <td class="border border-slate-600">{{ $item->nama_obat_barang }}</td>
                                <td class="border border-slate-600 text-center">{{ $item->satuan }}</td>
                                <td class="border border-slate-600 text-center">{{ $item->qty_sp }}</td>
                                <td class="border border-slate-600 text-center">{{ $item->qty }}</td>
                                {{-- harga jual --}}
                                <td class="border border-slate-600 text-right">
                                    {{ number_format($item->harga, 0, ',', '.') }}
                                    <!-- Note the change here -->
                                <td class="border border-slate-600 text-center">{{ $item->qty_sp - $item->qty }}</td>
                                {{-- omset loss rumus potensi loss x harga --}}
                                <td class="border border-slate-600 text-right">{{ $item->qty_sp - $item->qty }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td class="font-bold text-center border text-pending border-slate-600" colspan="9">
                                    Belum ada data tersedia</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr class="header-gray">
                            <th  colspan="7" class="border border-slate-600">Total</th>
                            <th class="border border-slate-600">{{ $total_loss }}</th>
                        </tr>
                    </tfoot>
                </table>
            @empty
                <div class="p-5 box">
                    <h4>Belum ada
                        data
                        tersedia</h4>
                </div>
        @endforelse
    </div>
</div>
