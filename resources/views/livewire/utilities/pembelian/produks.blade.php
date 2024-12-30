<div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <!-- BEGIN: Data List -->
        <div class="col-span-6 md:col-span-3">
            <div class="flex items-center mb-3">
                <div class="relative w-56 text-slate-500">
                    <input type="text" class="w-56 pr-10 form-control cari box" placeholder="Search Nama Produk"
                        wire:model.live.debounce.300ms="search">
                    <i class="absolute inset-y-0 right-0 w-4 h-4 my-auto mr-3" data-feather="search"></i>
                </div>

                <div class="ml-3">
                    <input id="tanggal-dari" name="mulaiId" wire:model.lazy="mulaiId" type="date"
                        placeholder="Stok dari master" style="width: 150px;"
                        class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&[readonly]]:bg-slate-100 [&[readonly]]:cursor-not-allowed [&[readonly]]:dark:bg-darkmode-800 [&[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                </div>
                <label for="tanggal-sampai" class="inline-block mt-2 mb-2 ml-2 sm:w-20">s/d</label>
                <div class="ml-2">
                    <input id="tanggal-sampai" wire:model.lazy="selesaiId" name="selesaiId" type="date"
                        placeholder="Stok dari master" style="width: 150px;"
                        class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&[readonly]]:bg-slate-100 [&[readonly]]:cursor-not-allowed [&[readonly]]:dark:bg-darkmode-800 [&[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                </div>
            </div>
            <div class="flex items-center gap-2 mb-3">
                <select data-tw-merge id="kategori" name="kategori" wire:model.live="kategoriId"
                    aria-label="Default select example" class="w-auto form-control">
                    <option value="">- Pilih Golongan -</option>
                    @foreach ($kategori as $item)
                        <option value="{{ $item->id }}">{{ $item->golongan }}</option>
                    @endforeach
                </select>

                <select data-tw-merge id="golongan" name="golongan" wire:model.live="golonganId"
                    aria-label="Default select example" class="w-auto form-control">
                    <option value="">- Pilih Sub Golongan -</option>
                    @foreach ($golongan as $item)
                        <option value="{{ $item->id }}">{{ $item->sub_golongan }}</option>
                    @endforeach
                </select>

                <select data-tw-merge id="jenis" name="jenis" wire:model.live="jenisId"
                    aria-label="Default select example" class="w-auto form-control">
                    <option value="">- Pilih Jenis Produk -</option>
                    @foreach ($jenis as $item)
                        <option value="{{ $item->jenis }}">{{ $item->jenis }}</option>
                    @endforeach
                </select>

                <select data-tw-merge id="produsen" name="produsen" wire:model.live="produsenId"
                    aria-label="Default select example" class="w-auto form-control">
                    <option value="">- Pilih Produsen -</option>
                    @foreach ($produsen as $item)
                        <option value="{{ $item->id }}">{{ $item->produsen }}</option>
                    @endforeach
                </select>
                <select data-tw-merge id="suplier" name="suplier" wire:model.live="suplierId"
                    aria-label="Default select example" class="w-auto form-control">
                    <option value="">- Pilih Supplier -</option>
                    @foreach ($suplier as $item)
                        <option value="{{ $item->id }}">{{ $item->nama_suplier }}</option>
                    @endforeach
                </select>
            </div>

            {{-- <div class="col-span-6 md:col-span-3"style="position: absolute; top: 550px; right:50px;">
                <div class="flex gap-2">
                    <button class="btn btn-success">
                        <span wire:ignore><i data-feather="file-text" class="w-5 h-5 mr-1"></i>Excel</span>
                    </button>
                    <a href="{{ route('cetak_pdf_produk_beli', [
                        'search' => $search,
                        'mulaiId' => $mulaiId,
                        'selesaiId' => $selesaiId,
                        'produsenId' => $produsenId,
                        'jenisId' => $jenisId,
                        'golonganId' => $golonganId,
                        'kategoriId' => $kategoriId,
                        'suplierId' => $suplierId,
                    ]) }}"
                        target="_blank" class="btn btn-primary"><span wire:ignore><i data-feather="printer"
                                class="w-5 h-5 mr-1"></i>PDF</span></a>
                </div>
            </div>

            <div class="col-span-6 md:col-span-3" style="position: absolute; top: 565px; right: 180px;">
                <div class="flex items-center mb-3">
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

    <div class="box">
        <div class="overflow-auto">
            <table class="table mt-5">
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
                        <th rowspan="2" class="border border-slate-600">Supplier</th>
                        <th rowspan="2" class="border border-slate-600">Barcode</th>
                        <th rowspan="2" class="border border-slate-600">Nama Produk</th>
                        <th rowspan="2" class="border border-slate-600">Kategori</th>
                        <th rowspan="2" class="border border-slate-600">Golongan</th>
                        <th rowspan="2" class="border border-slate-600">Jenis Produk</th>
                        <th rowspan="2" class="border border-slate-600">Produsen</th>
                        <th rowspan="2" class="border border-slate-600">Satuan</th>
                        <th rowspan="2" class="border border-slate-600">Qty</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($pembelian as $obats)
                        <tr class="text-center intro-x">
                            <td class="border border-slate-600">{{ $loop->iteration }}</td>
                            <td class="border border-slate-600">{{ $obats->pembelian->getSuplier->nama_suplier }}</td>
                            <td class="border border-slate-600">{{ $obats->produk->barcode_produk }}</td>
                            <td class="border border-slate-600">{{ $obats->produk->nama_obat_barang }}</td>
                            <td class="border border-slate-600">{{ $obats->produk->kelompok->golongan }}</td>
                            <td class="border border-slate-600">
                                {{ $obats->produk->golonganProduk->sub_golongan }}</td>
                            <td class="border border-slate-600">{{ $obats->produk->jenis_obat_barang }}</td>
                            <td class="border border-slate-600">{{ $obats->produk->produsenProduk->produsen }}
                            </td>
                            <td class="border border-slate-600">{{ $obats->produk->satuanDasar->satuan }}
                            </td>
                            <td class="border border-slate-600">{{ $obats->qty_faktur }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="font-bold text-center text-pending border border-slate-600" colspan="10">
                                Belum ada
                                data
                                tersedia</td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>
</div>
<!-- END: Data List -->
</div>
</div>
