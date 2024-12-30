@php
    use App\Models\SetHarga;
@endphp
<div>
    <div class="grid grid-cols-12 gap-2 mt-8">
        <div class="col-span-6 md:col-span-3">
            <div class="flex items-center">
                <div class="col-span-6 md:col-span-3">
                    <div class="relative w-56 text-slate-500">
                        <input type="text" class="w-56 pr-10 form-control cari box" placeholder="Search No. Faktur..."
                            wire:model.live.debounce.300ms="search">
                        <i class="absolute inset-y-0 right-0 w-4 h-4 my-auto mr-3" data-feather="search"></i>
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
                <div class="flex items-center mr-auto">
                    <select data-tw-merge id="pelanggan" name="pelanggan" wire:model.live="pelangganId"
                        aria-label="Default select example" class="w-auto ml-2 form-control">
                        <option value=>- Pilih Pelanggan -</option>
                        @foreach ($pelanggan as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center mr-auto">
                    <select data-tw-merge id="sales"name="sales" wire:model.live="salesId"
                        aria-label="Default select example" class="w-auto ml-2 form-control">
                        <option value=>- Pilih Sales -</option>
                        @foreach ($sales as $item)
                            <option value="{{ $item->id }}">{{ $item->nama_pegawai }}</option>
                        @endforeach
                    </select>
                    <button onclick="location.reload()" class="ml-2 btn btn-md btn-secondary" wire:ignore>
                        <i data-feather="refresh-cw" class="w-4 h-4 mr-1"></i> Reload
                    </button>
                </div>

                {{-- <div class="col-span-6 md:col-span-3" style="position: absolute; top: 290px; right:80px;">
                    <div class="flex gap-2">
                        <button class="text-white btn btn-success">
                            <i data-feather="file-text" class="w-4 h-4 mr-1"></i>Excel
                        </button>
                        <div class="flex gap-2">
                            <a id="print-pdf-button"
                                href="{{ route('cetak_pdf_faktur_detail', [
                                    'search' => $search,
                                    'pembayaranId' => $pembayaranId,
                                    'salesId' => $salesId,
                                    'mulaiId' => $mulaiId,
                                    'selesaiId' => $selesaiId,
                                
                                    'pelangganId' => $pelangganId,
                                ]) }}"
                                target="_blank" class="btn btn-facebook"><i data-feather="printer"
                                    class="w-4 h-4 mr-1"></i>Print</a>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>

    <div class="text-center" wire:loading wire:target="print">
        Loading PDF...
    </div>

    @forelse ($penjualan as $penjualans)
        <div class="mt-2 overflow-auto box">
            <table class="w-full mt-2 ml-4 divide-y divide-gray-200">
                <tbody class="text-center bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-4 py-2 whitespace-nowrap">
                            <div class="text-xs font-medium text-gray-900">Tgl. Faktur</div>
                            <div class="text-xs text-gray-500">{{ date('d-m-Y', strtotime($penjualans->tgl_faktur)) }}
                            </div>
                        </td>
                        <td class="px-4 py-2 whitespace-nowrap">
                            <div class="text-xs font-medium text-gray-900">No. Faktur</div>
                            <div class="text-xs text-gray-500">{{ $penjualans->no_faktur }}</div>
                        </td>
                        <td class="px-4 py-2 whitespace-nowrap">
                            <div class="text-xs font-medium text-gray-900">Pelanggan</div>
                            <div class="text-xs text-gray-500">{{ $penjualans->getPelanggan->nama }}</div>
                        </td>
                        <td class="px-4 py-2 whitespace-nowrap">
                            <div class="text-xs font-medium text-gray-900">Sales</div>
                            <div class="text-xs text-gray-500">{{ $penjualans->getSales->nama_pegawai }}</div>
                        </td>
                        <td class="px-4 py-2 whitespace-nowrap">
                            <div class="text-xs font-medium text-gray-900">Bayar</div>
                            <div class="text-xs text-gray-500">
                                @if ($penjualans->kredit == 0)
                                    Cash
                                @elseif($penjualans->kredit == 1)
                                    Kredit
                                @endif
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 whitespace-nowrap">
                            <div class="text-xs font-medium text-gray-900">Tgl. JT</div>
                            <div class="text-xs text-gray-500">{{ date('d-m-Y', strtotime($penjualans->tempo_kredit)) }}
                            </div>
                        </td>
                        <td class="px-4 py-2 whitespace-nowrap">
                            <div class="text-xs font-medium text-gray-900">No. SP</div>
                            <div class="text-xs text-gray-500">{{ $penjualans->no_sp }}</div>
                        </td>
                        <td class="px-4 py-2 whitespace-nowrap">
                            <div class="text-xs font-medium text-gray-900">Tgl. SP</div>
                            <div class="text-xs text-gray-500">{{ date('d-m-Y', strtotime($penjualans->sp->tgl_sp)) }}
                            </div>
                        </td>
                        <td class="px-4 py-2 whitespace-nowrap">
                            <div class="text-xs font-medium text-gray-900">No. Pajak</div>
                            <div class="text-xs text-gray-500">{{ $penjualans->no_seri_pajak }}</div>
                        </td>
                        <td class="px-4 py-2 whitespace-nowrap">
                            <div class="text-xs font-medium text-gray-900">Tgl. Pajak</div>
                            <div class="text-xs text-gray-500">{{ date('d-m-Y', strtotime($penjualans->tgl_input)) }}
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

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
                        <th rowspan="2" class="border border-slate-600">Qty SP</th>
                        <th rowspan="2" class="border border-slate-600">Satuan</th>
                        <th rowspan="2" class="border border-slate-600">Batch</th>
                        <th rowspan="2" class="border border-slate-600">Exp Date</th>
                        <th rowspan="2" class="border border-slate-600">Qty</th>
                        <th rowspan="2" class="border border-slate-600">Harga</th>
                        <th rowspan="2" class="border border-slate-600">Disc 1</th>
                        <th rowspan="2" class="border border-slate-600">Disc 2</th>
                        <th rowspan="2" class="border border-slate-600">Total</th>
                    </tr>
                </thead>
                <tbody>

                    @php
                        $hppFinal = 0;
                    @endphp
                    @foreach ($penjualans->produk_penjualan as $item)
                        @php
                            if ($item->histori) {
                                $hpp = $item->histori->hpp($item->histori);
                                $hppFinal += $item->qty * $hpp;
                            }
                        @endphp
                        <tr>
                            <td class="border border-slate-600">{{ $loop->iteration }}</td>
                            <td class="border border-slate-600">{{ $item->produk->barcode_produk }}</td>
                            <td class="border border-slate-600">{{ $item->produk->nama_obat_barang }}</td>
                            <td class="border border-slate-600">{{ $item->qty_sp }}</td>
                            <td class="border border-slate-600">{{ $item->satuanProduk->satuan }}</td>
                            <td class="border border-slate-600">{{ $item->batch }}</td>
                            <td class="border border-slate-600">
                                {{ $item->exp_date != '-' ? date('d-m-Y', strtotime($item->exp_date)) : '-' }}
                            </td>
                            <td class="border border-slate-600">{{ $item->qty }}</td>
                            <td class="border border-slate-600">{{ number_format($item->harga, 0, ',', '.') }}
                            </td>
                            <td class="border border-slate-600">{{ $item->disc_1 }}</td>
                            <td class="border border-slate-600">{{ $item->disc_2 }}</td>
                            <td class="border border-slate-600">{{ $item->total }}</td>
                        </tr>
                    @endforeach

                </tbody>

            </table>
            <div class="mt-2 ml-4">
                <table class="w-full">
                    <tbody class="text-center">
                        <tr>
                            <td class="px-6 py-2 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">Sub Total</div>
                                <div class="text-sm text-gray-500">
                                    {{ number_format($penjualans->subtotal, 0, ',', '.') }}
                                </div>
                            </td>
                            {{-- 
                <td class="px-6 py-2 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">Disc %</div>
                    <div class="text-sm text-gray-500">{{ $penjualans->diskon }}</div>
                </td> 
                --}}
                            <td class="px-6 py-2 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">Total Jual</div>
                                <div class="text-sm text-gray-500">
                                    @php
                                        $total_jual = $penjualans->diskon
                                            ? $penjualans->subtotal - $penjualans->diskon
                                            : $penjualans->subtotal;
                                    @endphp
                                    {{ number_format($total_jual, 0, ',', '.') }}
                                </div>
                            </td>
                            <td class="px-6 py-2 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">Total Modal</div>
                                <div class="text-sm text-gray-500">
                                    {{ number_format($hppFinal, 0, ',', '.') }}
                                </div>
                            </td>
                            <td class="px-6 py-2 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">Margin</div>
                                <div class="text-sm text-gray-500">
                                    @php
                                        $margin = $total_jual - $hppFinal;
                                    @endphp
                                    {{ number_format($margin, 0, ',', '.') }}
                                </div>
                            </td>
                            <td class="px-6 py-2 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">Margin %</div>
                                <div class="text-sm text-gray-500">
                                    @php
                                        $formattedPercentage = ($margin / $total_jual) * 100;
                                    @endphp
                                    {{ number_format($formattedPercentage, 2, '.', ',') }}
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @empty
        <div class="p-5 mt-4 text-center fond-bold text-pending box">
            <p>Belum ada data tersedia</p>
        </div>
    @endforelse
    <div class="mt-2">
        {{ $penjualan->links('pagination::tailwind') }} <!-- Tailwind pagination style -->
    </div>

</div>
