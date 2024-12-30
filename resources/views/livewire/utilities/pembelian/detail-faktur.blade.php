<div class="">
    <div class="grid grid-cols-12 gap-2 mt-8">
        <div class="col-span-12 md:col-span-6 lg:col-span-3">
            <div class="flex items-center mb-2">
                <div class="relative w-56 text-slate-500">
                    <input type="text" class="w-56 pr-10 form-control cari box" placeholder="Search No. Faktur..."
                        wire:model.live.debounce.300ms="search">
                    <i class="absolute inset-y-0 right-0 w-4 h-4 my-auto mr-3" data-feather="search"></i>
                </div>
                <div class="ml-2">
                    <input id="tanggal-dari" name="mulaiId" wire:model.lazy="mulaiId" type="date"
                        class="rounded-md shadow-sm w-36 form-input" />
                </div>
                <label for="tanggal-sampai" class="inline-block mt-2 mb-2 ml-2 sm:w-20">s.d</label>
                <div class="ml-2">
                    <input id="tanggal-sampai" name="selesaiId" wire:model.lazy="selesaiId" type="date"
                        class="rounded-md shadow-sm w-36 form-input" />
                </div>
            </div>

            <!-- Supplier -->
            <div class="flex items-center mb-2">
                <select id="sales" wire:model.live="spId" class="w-full rounded-md shadow-sm form-control">
                    <option value="">- Pilih Supplier -</option>
                    @foreach ($suplier as $item)
                        <option value="{{ $item->id }}">{{ $item->nama_suplier }}</option>
                    @endforeach
                </select>
                <button onclick="location.reload()" class="ml-2 btn btn-md btn-secondary" wire:ignore>
                    <i data-feather="refresh-cw" class="w-4 h-4 mr-1"></i> Reload
                </button>
            </div>

            <!-- Buttons -->
            <!-- <div class="flex justify-end gap-2 mb-3">
                <button class="btn btn-success">
                    <span wire:ignore><i data-feather="file-text" class="w-5 h-5 mr-1"></i>Excel</span>
                </button>
                <a href="{{ route('cetak_pdf_detail_beli', ['search' => $search, 'pembayaranId' => $pembayaranId, 'spId' => $spId, 'mulaiId' => $mulaiId, 'selesaiId' => $selesaiId]) }}"
                    target="_blank" class="btn btn-primary">
                    <span wire:ignore><i data-feather="printer" class="w-5 h-5 mr-1"></i>PDF</span>
                </a>
            </div> -->

            <!-- Search -->
            {{-- <div class="flex items-center mb-3">
                <label for="search" class="inline-block mt-2 mb-2 sm:w-20">Cari</label>
                <input type="text" id="search" name="search" wire:model.live.debounce.300ms="search"
                    class="block w-full rounded-md shadow-sm form-input" />
            </div> --}}

            <!-- Loading -->
            <div class="text-center" wire:loading wire:target="print">
                Loading PDF...
            </div>
        </div>
    </div>

    @php
        $dataCount = count($produk);
    @endphp

    @if ($dataCount > 0)
        @foreach ($produk as $produks)
            <div class="overflow-auto box">
                <table class="w-full mt-2 ml-4 divide-y divide-gray-200">
                    <tr>
                        <td class="px-4 py-2 whitespace-nowrap">
                            <div class="font-medium text-gray-900 text-md">Tgl. Input</div>
                            <div class="text-gray-500 text-md">{{ date('d-m-Y', strtotime($produks->tgl_input)) }}
                            </div>
                        </td>
                        <td class="px-4 py-2 whitespace-nowrap">
                            <div class="font-medium text-gray-900 text-md">Tgl. Faktur</div>
                            <div class="text-gray-500 text-md">{{ date('d-m-Y', strtotime($produks->tgl_faktur)) }}
                            </div>
                        </td>
                        <td class="px-4 py-2 whitespace-nowrap">
                            <div class="font-medium text-gray-900 text-md">No. Faktur</div>
                            <div class="text-gray-500 text-md">{{ $produks->no_faktur }}
                            </div>
                        </td>
                        <td class="px-4 py-2 whitespace-nowrap">
                            <div class="font-medium text-gray-900 text-md">Supplier</div>
                            <div class="text-gray-500 text-md">{{ $produks->getSuplier->nama_suplier }}
                            </div>
                        </td>
                        <td class="px-4 py-2 whitespace-nowrap">
                            <div class="font-medium text-gray-900 text-md">J Tempo</div>
                            <div class="text-gray-500 text-md">{{ date('d-m-Y', strtotime($produks->tempo_kredit)) }}
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td class="px-4 py-2 whitespace-nowrap">
                            <div class="font-medium text-gray-900 text-md">No. SP</div>
                            <div class="text-gray-500 text-md">{{ $produks->sp->no_sp }}
                            </div>
                        </td>

                        <td class="px-4 py-2 whitespace-nowrap">
                            <div class="font-medium text-gray-900 text-md">Tgl. SP</div>
                            <div class="text-gray-500 text-md">{{ date('d-m-Y', strtotime($produks->sp->tgl_sp)) }}
                            </div>
                        </td>

                        <td class="px-4 py-2 whitespace-nowrap">
                            <div class="font-medium text-gray-900 text-md">No. Pajak</div>
                            <div class="text-gray-500 text-md">{{ $produks->no_faktur_pajak }}
                            </div>
                        </td>

                        <td class="px-4 py-2 whitespace-nowrap">
                            <div class="font-medium text-gray-900 text-md">Tgl. Pajak</div>
                            <div class="text-gray-500 text-md">
                                {{ date('d-m-Y', strtotime($produks->sp->tgl_faktur_pajak)) }}
                            </div>
                        </td>

                        <td class="px-4 py-2 whitespace-nowrap">
                            <div class="font-medium text-gray-900 text-md">Kompensasi Pajak</div>
                            <div class="text-gray-500 text-md">
                                {{ date('d-m-Y', strtotime($produks->kompensasi_pajak)) }}
                            </div>
                        </td>
            </div>

            <table class="table w-full mt-2 border-collapse">
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
                        <th class="border border-slate-600">No</th>
                        <th class="border border-slate-600">Barcode</th>
                        <th class="border border-slate-600">Nama Produk</th>
                        <th class="border border-slate-600">Qty SP</th>
                        <th class="border border-slate-600">Qty Faktur</th>
                        <th class="border border-slate-600">Satuan</th>
                        <th class="border border-slate-600">Harga</th>
                        <th class="border border-slate-600">Disc 1</th>
                        <th class="border border-slate-600">Disc 2</th>
                        <th class="border border-slate-600">Total</th>
                    </tr>
                </thead>
                <tbody class="text-left">
                    @php
                        $total = 0;
                    @endphp
                    @foreach ($produks->produkPembelian as $item)
                        @php
                            $tot = $item->total;
                            $total += $tot;
                        @endphp
                        <tr>
                            <td class="border border-slate-600">{{ $loop->iteration }}</td>
                            <td class="border border-slate-600">{{ $item->produk->barcode_produk }}
                            </td>
                            <td class="border border-slate-600">{{ $item->produk->nama_obat_barang }}
                            </td>
                            <td class="border border-slate-600">
                                {{ $item->rencanaOrders[0]->jumlah_order }}
                            </td>
                            <td class="border border-slate-600">{{ $item->qty_faktur }}</td>
                            <td class="border border-slate-600">
                                {{ $item->produk->satuanDasar->satuan }}</td>
                            <td class="border border-slate-600">{{ $item->harga }}</td>
                            <td class="border border-slate-600">{{ $item->disc_1 }}</td>
                            <td class="border border-slate-600">{{ $item->disc_2 }}</td>
                            <td class="border border-slate-600">{{ number_format($tot, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach

                </tbody>
                <tfoot>
                    <tr class="text-center">
                        <td colspan="9" class="font-bold border border-slate-600">Sub total</td>
                        <td class="font-bold border border-slate-600">{{ number_format($total, 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
</div>
</table>
<hr class="mt-5 border-gray-400 border-t-1">
</div>
@endforeach
@else
<div class="p-5 box">
    <p class="font-bold text-center text-pending border-slate-600">Belum ada data tersedia</p>
</div>
@endif

</div>
