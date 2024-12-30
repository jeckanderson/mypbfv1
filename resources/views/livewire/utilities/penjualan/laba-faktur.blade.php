@php
    use App\Models\SetHarga;
@endphp
<div>
    <div class="grid grid-cols-12 gap-2 mt-8">
        <!-- BEGIN: Data List -->
        <div class="col-span-6 md:col-span-3">
            <div class="flex items-center gap-2">
                <div class="relative w-56 text-slate-500">
                    <input type="text" class="w-56 pr-10 form-control cari box" wire:model.live.debounce.300ms="search"
                        placeholder="Search no. Faktur" oninput="searchTable()">
                    <i class="absolute inset-y-0 right-0 w-4 h-4 my-auto mr-3" data-feather="search"></i>
                </div>

                <div>
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

                <div>
                    <select data-tw-merge id="pelanggan" name="pelanggan" wire:model.live="pelangganId"
                        aria-label="Default select example" class="w-auto form-control">
                        <option value=>- Pilih Pelanggan -</option>
                        @foreach ($pelanggan as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <select data-tw-merge id="sales"name="sales" wire:model.live="salesId"
                        aria-label="Default select example" class="w-auto form-control">
                        <option value=>- Pilih Sales -</option>
                        @foreach ($sales as $item)
                            <option value="{{ $item->id }}">{{ $item->nama_pegawai }}</option>
                        @endforeach
                    </select>
                </div>
                <button onclick="location.reload()" class="btn btn-md btn-secondary" wire:ignore>
                    <i data-feather="refresh-cw" class="w-4 h-4 mr-1"></i> Reload
                </button>
            </div>

        </div>
        <!-- END: Data List -->
    </div>
    {{-- <div class="flex justify-end gap-3">
        <div class="col-span-6 md:col-span-3" style="position: absolute; top: 245px; right:50px;">
            <div class="flex gap-2">
                <button class="text-white btn btn-success">
                    <i data-feather="file-text" class="w-4 h-4 mr-1"></i>Excel
                </button>
                <div class="flex gap-2">
                    <a id="print-pdf-button"
                        href="{{ route('cetak_pdf_laba_faktur', [
                            'search' => $search,
                            'salesId' => $salesId,
                            'mulaiId' => $mulaiId,
                            'selesaiId' => $selesaiId,
                            'pelangganId' => $pelangganId,
                        ]) }}"
                        target="_blank" class="btn btn-dark"><i data-feather="printer"
                            class="w-4 h-4 mr-1"></i>Print</a>
                </div>
            </div>
        </div>

        <div class="text-center" wire:loading wire:target="print">
            Loading PDF...
        </div>
    </div> --}}

    @forelse ($detail as $details)

        <div class="mt-2 overflow-auto box">
            <table class="w-full mt-2 ml-4">
                <tr>
                    <td class="font-bold sm:w-20">Tgl. Faktur:</td>
                    <td>{{ $details->tgl_faktur->format('d-m-Y') }}</td>
                    <td class="font-bold sm:w-20">Pelanggan:</td>
                    <td>{{ $details->getPelanggan->nama }}</td>
                    <td class="font-bold sm:w-20">Bayar:</td>
                    <td>
                        @if ($details->kredit == 0)
                            Cash
                        @elseif($details->kredit == 1)
                            Kredit
                        @endif
                    </td>
                    <td class="font-bold sm:w-20">No. SP:</td>
                    <td>{{ $details->no_sp }}</td>
                    <td class="font-bold sm:w-20">No. Pajak:</td>
                    <td>{{ $details->no_seri_pajak }}</td>
                </tr>
                <tr>
                    <td class="font-bold sm:w-20">No. Faktur:</td>
                    <td>{{ $details->no_faktur }}</td>
                    <td class="font-bold sm:w-20">Sales:</td>
                    <td>{{ $details->getSales->nama_pegawai }}</td>
                    <td class="font-bold sm:w-20">Tgl. JT:</td>
                    <td>{{ $details->tempo_kredit->format('d-m-Y') }}</td>
                    <td class="font-bold sm:w-20">Tgl. SP:</td>
                    <td>{{ date('d-m-Y', strtotime($details->sp->tgl_sp)) }}</td>
                    <td class="font-bold sm:w-20">Tgl. Pajak:</td>
                    <td>{{ $details->tgl_input->format('d-m-Y') }}</td>
                </tr>
            </table>

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
                        {{-- <th rowspan="2" class="border border-slate-600">Tanggal</th>
                        <th rowspan="2" class="border border-slate-600">No. Faktur</th>
                        <th rowspan="2" class="border border-slate-600">Pelanggan</th>
                        <th rowspan="2" class="border border-slate-600">Sales</th> --}}
                        <th rowspan="2" class="border border-slate-600">Barcode</th>
                        <th rowspan="2" class="border border-slate-600">Nama Produk</th>
                        <th rowspan="2" class="border border-slate-600">Satuan</th>
                        <th rowspan="2" class="border border-slate-600">Qty </th>
                        <th rowspan="2" class="border border-slate-600">Harga</th>
                        <th rowspan="2" class="border border-slate-600">Disc 1</th>
                        <th rowspan="2" class="border border-slate-600">Disc 2</th>
                        <th rowspan="2" class="border border-slate-600">Total</th>
                        <th rowspan="2" class="border border-slate-600">Modal</th>
                        <th rowspan="2" class="border border-slate-600">Margin</th>
                        <th rowspan="2" class="border border-slate-600">% </th>
                    </tr>
                </thead>

                <tbody>
                    @php
                        $hppFinal = 0;
                    @endphp
                    @foreach ($details->produk_penjualan as $item)
                        @php
                            $hpp = SetHarga::where('id_set_harga', $item->histori->id_set_harga)
                                ->where('id_produk', $item->id_produk)
                                ->where('satuan', $item->satuan)
                                // ->orderBy('id','desc')
                                ->first()->hpp_final;
                            $hpp_view = $hpp * $item->qty;
                            $hppFinal += $item->qty * $hpp;
                        @endphp
                        <tr class="text-center intro-x">
                            <td class="border border-slate-600">{{ $loop->iteration }}</td>
                            {{-- <td class="border border-slate-600">{{ $item->penjualan->tgl_input->format('d-m-Y') }}
                            </td>
                            <td class="border border-slate-600">{{ $item->penjualan->no_faktur }}</td>
                            <td class="border border-slate-600">{{ $item->penjualan->getPelanggan->nama }}</td>
                            <td class="border border-slate-600">{{ $item->penjualan->getSales->nama_pegawai }}</td> --}}
                            <td class="border border-slate-600">{{ $item->produk->barcode_produk }}</td>
                            <td class="border border-slate-600">{{ $item->produk->nama_obat_barang }}</td>
                            <td class="border border-slate-600">{{ $item->produk->satuanTerkecil->satuan }}</td>
                            <td class="border border-slate-600">{{ $item->qty }}</td>
                            <td class="border border-slate-600">
                                {{ number_format($item->harga, 0, ',', '.') }}
                            </td>
                            <td class="border border-slate-600">{{ $item->disc_1 }}</td>
                            <td class="border border-slate-600">{{ $item->disc_2 }}</td>

                            @php
                                // Menghapus pemisah ribuan dari total
                                $totalNumeric = floatval(str_replace('.', '', $item->total));

                                // Perhitungan
                                $hppTotal = $hpp * $item->qty;
                                $difference = $totalNumeric - $hppTotal;

                                // Menghitung margin sebagai persentase dari modal
                                $marginPercentage =
                                    $hppTotal > 0 ? ($difference / str_replace('.', '', $item->total)) * 100 : 0; // Hindari pembagian dengan nol
                            @endphp

                            <td class="border border-slate-600">
                                {{-- Format total dengan pemisah ribuan seperti semula --}}
                                {{ number_format($totalNumeric, 0, ',', '.') }}
                            </td>
                            <td class="border border-slate-600">
                                {{-- Format hasil perkalian --}}
                                {{ number_format($hpp_view, 0, ',', '.') }}
                            </td>
                            <td class="border border-slate-600">
                                {{-- Format hasil selisih --}}
                                {{ number_format($difference, 0, ',', '.') }}
                            </td>
                            <td class="border border-slate-600">
                                {{-- Format margin sebagai persentase --}}
                                {{ number_format($marginPercentage, 2, '.', ',') }}%
                            </td>



                        </tr>
                    @endforeach

                </tbody>

            </table>
            <div class="grid grid-cols-12 gap-3 mt-2 ml-4">
                <div class="col-span-2 md:col-span-1">
                    <div class="flex items-center mb-3">
                        <p class="inline-block mt-2 mb-2 sm:w-20">Sub Total :</p>
                        <h1 style="white-space: nowrap;">{{ number_format($details->subtotal, 0, ',', '.') }}</h1>
                    </div>
                </div>

                {{-- <div class="col-span-2 md:col-span-1">
                    <div class="flex items-center mb-3">
                        <p class="inline-block mt-2 mb-2 sm:w-20">Disc % :</p>
                        <h1 style="white-space: nowrap;">{{ $details->diskon }}</h1>
                    </div>
                </div> --}}

                <div class="col-span-2 md:col-span-1">
                    <div class="flex items-center mb-3">
                        <p class="inline-block mt-2 mb-2 sm:w-20">Total Jual :</p>
                        @php
                            $total_jual = $details->diskon ? $details->subtotal - $details->diskon : $details->subtotal;
                        @endphp
                        {{ number_format($total_jual, 0, ',', '.') }}
                    </div>
                </div>

                <div class="col-span-2 md:col-span-1">
                    <div class="flex items-center mb-3">
                        <p class="inline-block mt-2 mb-2 sm:w-20"> Total Modal:</p>
                        <h1 style="white-space: nowrap;"> {{ number_format($hppFinal, 0, ',', '.') }}</h1>
                    </div>
                </div>

                <div class="col-span-2 md:col-span-1">
                    <div class="flex items-center mb-3">
                        <p class="inline-block mt-2 mb-2 sm:w-20">Margin :</p>
                        <h1 style="white-space: nowrap;">
                            @php
                                $margin = $total_jual - $hppFinal;
                            @endphp
                            {{ number_format($margin, 0, ',', '.') }}
                        </h1>
                    </div>
                </div>

                <div class="col-span-2 md:col-span-1">
                    <div class="flex items-center mb-3">
                        <p class="inline-block mt-2 mb-2 sm:w-20">Margin % :</p>
                        @php
                            $formattedPercentage = ($margin / $total_jual) * 100;
                        @endphp
                        <h1 style="white-space: nowrap;">
                            {{ number_format($formattedPercentage, 2, '.', ',') }}
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="p-5 mt-5 font-bold text-center text-pending box">
            <h4>Belum ada data tersedia</h4>
        </div>
    @endforelse
    <!-- Pagination Links -->
    <div class="mt-2">
        {{ $detail->links() }}
    </div>
</div>
