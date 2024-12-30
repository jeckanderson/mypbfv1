<div>
    @php
        use App\Models\SetHarga;
    @endphp
    <div class="grid grid-cols-12 gap-2 mt-8">
        <!-- BEGIN: Data List -->
        <div class="col-span-6 md:col-span-3">
            <div class="flex gap-3">
                <div class="flex items-center mb-2">
                    <div class="col-span-6 md:col-span-3">
                        <div class="relative w-56 text-slate-500">
                            <input type="text" class="w-56 pr-10 form-control cari box" placeholder="Search No. Faktur"
                                wire:model.live.debounce.300ms="search">
                            <i class="absolute inset-y-0 right-0 w-4 h-4 my-auto mr-3" data-feather="search"></i>
                        </div>
                    </div>
                    <label for="tanggal-dari" class="inline-block mb-2 mr-2 sm:w-80"></label>
                    <input data-tw-merge id="horizontal-form-1" type="date" placeholder="Stok dari master"
                        wire:model.lazy="mulaiId"
                        class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                    <p class="p-3">s.d</p>
                    <input data-tw-merge id="horizontal-form-1" type="date" placeholder="Stok dari master"
                        wire:model.lazy="selesaiId"
                        class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                </div>
                <div class="flex items-center mb-2">
                    {{-- <label data-tw-merge for="pelanggan" class="inline-block mt-2 mb-2 sm:w-20">
                        Pelanggan
                    </label> --}}
                    <select data-tw-merge id="pelanggan" name="pelanggan" wire:model.live="pelangganId"
                        aria-label="Default select example" class="w-auto form-control">
                        <option value=>- Pilih Pelanggan -</option>
                        @foreach ($pelanggan as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center mb-2">
                    {{-- <label data-tw-merge for="sales" class="inline-block mt-2 mb-2 sm:w-20">
                        Sales
                    </label> --}}
                    <select data-tw-merge id="sales"name="sales" wire:model.live="salesId"
                        aria-label="Default select example" class=" w-auto form-control">
                        <option value=>- Pilih Sales -</option>
                        @foreach ($sales as $item)
                            <option value="{{ $item->id }}">{{ $item->nama_pegawai }}</option>
                        @endforeach
                    </select>
                    <button onclick="location.reload()" class="ml-2 btn btn-md btn-secondary" wire:ignore>
                        <i data-feather="refresh-cw" class="w-4 h-4 mr-1"></i> Reload
                    </button>
                </div>
            </div>
        </div>
        <!-- END: Data List -->
    </div>

    {{-- <div class="flex justify-end gap-3">
        <div class="col-span-6 md:col-span-3" style="position: absolute; top: 270px; right:80px;">
            <div class="flex gap-2">
                <button class="btn btn-success text-white">
                    <i data-feather="file-text" class="w-5 h-5 mr-1"></i>Excel
                </button>
                <div class="flex gap-2">
                    <a id="print-pdf-button"
                        href="{{ route('cetak_pdf_laba_produk', [
                            'search' => $search,
                            'salesId' => $salesId,
                            'mulaiId' => $mulaiId,
                            'selesaiId' => $selesaiId,
                            'pelangganId' => $pelangganId,
                        ]) }}"
                        target="_blank" class="btn btn-dark"><i data-feather="printer"
                            class="w-5 h-5 mr-1"></i>Print</a>
                </div>
            </div>

        </div>

        <div class="text-center" wire:loading wire:target="print">
            Loading PDF...
        </div>
    </div> --}}

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
                        <th rowspan="2" class="border border-slate-600">Tanggal</th>
                        <th rowspan="2" class="border border-slate-600">No. Faktur</th>
                        <th rowspan="2" class="border border-slate-600">Pelanggan</th>
                        <th rowspan="2" class="border border-slate-600">Sales</th>
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
                    @forelse ($detail as $details)
                        @php
                            $hppFinal = SetHarga::where('id_set_harga', $details->histori->id_set_harga)
                                ->where('id_produk', $details->id_produk)
                                ->where('satuan', $details->satuan)
                                ->first()->hpp_final;
                        @endphp
                        <tr class="text-center intro-x">
                            <td class="border border-slate-600">{{ $loop->iteration }}</td>
                            <td class="border border-slate-600">
                                {{ date('d-m-Y', strtotime($details->penjualan->tgl_faktur)) }}</td>
                            <td class="border border-slate-600">{{ $details->penjualan->no_faktur }}</td>
                            <td class="border border-slate-600">{{ $details->penjualan->getPelanggan->nama }}</td>
                            <td class="border border-slate-600">{{ $details->penjualan->getSales->nama_pegawai }}</td>
                            <td class="border border-slate-600">{{ $details->produk->barcode_produk }}</td>
                            <td class="border border-slate-600">{{ $details->produk->nama_obat_barang }}</td>
                            <td class="border border-slate-600">{{ $details->satuanProduk->satuan }}
                            </td>
                            <td class="border border-slate-600">{{ $details->qty }}</td>
                            <td class="border border-slate-600">{{ number_format($details->harga, 0, ',', '.') }}</td>
                            <td class="border border-slate-600">{{ number_format($details->disc_1, 1, '.', '.') }}
                            </td>
                            <td class="border border-slate-600">{{ number_format($details->disc_2, 1, '.', '.') }}
                            </td>
                            @php
                                // Menghapus pemisah ribuan dari total
                                $totalNumeric = floatval(str_replace('.', '', $details->total));

                                // Perhitungan
                                $hppTotal = $hppFinal * $details->qty;
                                $difference = $totalNumeric - $hppTotal;

                                // Menghitung margin sebagai persentase dari modal
                                $marginPercentage =
                                    $hppTotal > 0 ? ($difference / str_replace('.', '', $details->total)) * 100 : 0; // Hindari pembagian dengan nol
                            @endphp

                            <td class="border border-slate-600">
                                {{-- Format total dengan pemisah ribuan seperti semula --}}
                                {{ number_format($totalNumeric, 0, ',', '.') }}
                            </td>
                            <td class="border border-slate-600">
                                {{-- Format hasil perkalian --}}
                                {{ number_format($hppTotal, 0, ',', '.') }}
                            </td>
                            <td class="border border-slate-600">
                                {{-- Format hasil selisih --}}
                                {{ number_format($difference, 0, ',', '.') }}
                            </td>
                            <td class="border border-slate-600">
                                {{-- Format margin sebagai persentase dengan 2 angka di belakang koma --}}
                                {{ number_format($marginPercentage, 2, '.', '.') }}%
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="font-bold text-center text-pending border border-slate-600" colspan="16">
                                Belum ada
                                data
                                tersedia</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>
    <div class="mt-4">
        {{ $detail->links() }}
    </div>
</div>


<script>
    function validateDateInputs() {
        var tanggalDari = document.getElementById('tanggal-dari').value;
        var tanggalSampai = document.getElementById('tanggal-sampai').value;

        if (!tanggalDari || !tanggalSampai) {
            alert('Harap isi kedua tanggal sebelum mencetak PDF!');
            return false;
        }

        return true;
    }

    document.addEventListener('DOMContentLoaded', function() {
        var printPdfButton = document.getElementById('print-pdf-button');
        printPdfButton.addEventListener('click', function(event) {
            if (!validateDateInputs()) {
                event.preventDefault(); // Prevent the default action (printing PDF) if validation fails
            }
        });
    });
</script>
