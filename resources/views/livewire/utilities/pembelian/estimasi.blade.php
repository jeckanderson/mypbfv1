<div>
    <div class="grid grid-cols-12 gap-2 mt-8">
        <div class="col-span-6 md:col-span-3">
            <div class="flex items-center mb-2">
                <div class="relative w-56 text-slate-500">
                    <input type="text" class="w-56 pr-10 form-control cari box" placeholder="Search Nama Produk"
                        wire:model.live.debounce.300ms="search">
                    <i class="absolute inset-y-0 right-0 w-4 h-4 my-auto mr-3" data-feather="search"></i>
                </div>
                {{-- <label for="tanggal-dari" class="inline-block mt-2 mb-2 sm:w-20">Tanggal</label> --}}
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
            </div>

            <div class="flex items-center mb-2">
                <select data-tw-merge id="supplier" aria-label="Default select example" wire:model.live="spId"
                    class="ml-0 form-control">
                    <option value="">- Pilih Supplier -</option>
                    @foreach ($suplier as $item)
                        <option value="{{ $item->id }}">{{ $item->nama_suplier }}</option>
                    @endforeach
                </select>

                <select id="tipe-sp" wire:model.live="tipeId" aria-label="Default select example"
                    class="ml-2 form-control">
                    <option value="">- Pilih Tipe SP -</option>
                    <option value="SP. Reguler">SP.Reguler</option>
                    <option value="SP. OOT">SP. OOT</option>
                    <option value="SP. Prekursor">SP. Prekursor</option>
                    <option value="SP. Psikotropika">SP. Psikotropika</option>
                    <option value="SP. Narkotika">SP. Narkotika</option>
                </select>
                <button onclick="location.reload()" class="ml-2 btn btn-md btn-secondary" wire:ignore>
                    <i data-feather="refresh-cw" class="w-4 h-4 mr-1"></i> Reload
                </button>
            </div>


            <div class="col-span-6 md:col-span-3" style="position: absolute; top: 380px; right:50px;">
                <div class="flex gap-2">
                    {{-- <button class="btn btn-success">
                        <span wire:ignore><i data-feather="file-text" class="w-5 h-5 mr-1"></i>Excel</span>
                    </button> --}}
                    {{-- <a href="{{ route('cetak_pdf_estimasi', [
                        'search' => $search,
                        'tipeId' => $tipeId,
                        'spId' => $spId,
                        'mulaiId' => $mulaiId,
                        'selesaiId' => $selesaiId,
                    ]) }}"
                        target="_blank" class="btn btn-primary"><span wire:ignore><i data-feather="printer"
                                class="w-5 h-5 mr-1"></i>PDF</span></a> --}}
                </div>
            </div>
            <div class="text-center" wire:loading wire:target="print">
                Loading PDF...
            </div>
        </div>
    </div>

    @if (!is_null($pembelians) > 0)

        <div class="overflow-auto box">
            @foreach ($pembelians as $pembelian)
                <div class="grid grid-cols-12 gap-3 mt-1 ml-4">
                    <div class="col-span-3 md:col-span-1 ">
                        <div class="flex items-center mb-2">
                            <p class="inline-block mt-1 mb-1 sm:w-20">No. Sp :</p>
                            <h1>{{ $pembelian->no_sp }}</h1>
                        </div>
                        <div class="flex items-center mb-2">
                            <p class="inline-block mt-1 mb-1 sm:w-20">Tgl. Sp: </p>
                            <h1>{{ $pembelian->tgl_sp->format('d-m-Y') }}</h1>
                        </div>
                    </div>

                    <div class="col-span-3 md:col-span-1 ">
                        <div class="flex items-center mb-2">
                            <p class="inline-block mt-1 mb-1 sm:w-20">Supplier:</p>
                            <h1> {{ $pembelian->suplier->nama_suplier }}</h1>
                        </div>
                        <div class="flex items-center mb-2">
                            <p class="inline-block mt-1 mb-1 sm:w-20">Tipe SP: </p>
                            @php
                                $tipe_sp = [
                                    'REG' => 'Reguler',
                                    'OOT' => 'OOT',
                                    'Prek' => 'Prekursor',
                                    'Psiko' => 'Psikotropika',
                                    'Narko' => 'Narkotika',
                                ];
                            @endphp
                            <h1>{{ isset($tipe_sp[$pembelian->tipe_sp]) ? $tipe_sp[$pembelian->tipe_sp] : '' }}
                            </h1>
                        </div>

                    </div>
                </div>
                <div class="mt-2 overflow-auto box">
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
                                <th rowspan="2" class="border border-slate-600">Nama Produk</th>
                                <th rowspan="2" class="border border-slate-600">Satuan</th>
                                <th rowspan="2" class="border border-slate-600">Qty</th>
                                <th rowspan="2" class="border border-slate-600">Harga </th>
                                <th rowspan="2" class="border border-slate-600">Disc 1</th>
                                <th rowspan="2" class="border border-slate-600">Disc 2</th>
                                <th rowspan="2" class="border border-slate-600">Total</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $total = 0;
                            @endphp
                            @foreach ($pembelian->produk_pembelian as $item)
                            @php
                                $total += $item->total;
                            @endphp
                                <tr class="text-left intro-x">
                                    <td class="border border-slate-600 text-center">{{ $loop->iteration }}</td>
                                    <td class="border border-slate-600">{{ $item->produk->nama_obat_barang }}</td>
                                    <td class="border border-slate-600 text-center">
                                        {{ $item->produk->satuanTerkecil->satuan }}
                                    </td>
                                    <td class="border border-slate-600 text-center">{{ $item->qty_faktur }}</td>
                                    <td class="border border-slate-600 text-center">{{ $item->harga }}</td>
                                    <td class="border border-slate-600 text-center">{{ $item->disc_1 }}</td>
                                    <td class="border border-slate-600 text-center">{{ $item->disc_2 }}</td>
                                    <td class="border border-slate-600 text-right">
                                        {{ number_format($item->total, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach

                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7" class="text-center border border-slate-600">Total</td>
                                <td class="text-left border border-slate-600 text-right">
                                    {{ number_format($total, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                    <hr style="border-top: 1px solid black; mt-2">
                </div>
            @endforeach
        </div>
</div>
@else
<div class="p-5 box">
    <p class="font-bold text-center text-pending border-slate-600">Belum ada data tersedia</p>
</div>
@endif


</div>
