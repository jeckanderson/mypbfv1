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

        /* Gaya khusus untuk lebar kolom */
        .col-no-batch {
            width: 10%;
            /* Atur lebar sesuai kebutuhan */
        }

        .col-ED {
            width: 8%;
            /* Atur lebar sesuai kebutuhan */
        }

        .col-qty-sp {
            width: 6%;
        }

        .col-total {
            width: 9%;
            /* Atur lebar sesuai kebutuhan */
        }

        .col-disc1 {
            width: 7%;
            /* Atur lebar sesuai kebutuhan */
        }

        .col-disc2 {
            width: 7%;
            /* Atur lebar sesuai kebutuhan */
        }

        .col-stok {
            width: 7%;
            /* Atur lebar sesuai kebutuhan */
        }

        .col-qty {
            width: 5%;
            /* Atur lebar sesuai kebutuhan */
        }

        .col-satuan {
            width: 5%;
            /* Atur lebar sesuai kebutuhan */
        }

        .col-no {
            width: 2%;
            /* Atur lebar sesuai kebutuhan */
        }

        .col-harga {
            width: 10%;
            /* Atur lebar sesuai kebutuhan */
        }
    </style>
    @php
        use Picqer\Barcode\BarcodeGeneratorHTML;
        $generator = new BarcodeGeneratorHTML();
        use App\Models\DiskonKelompok;
        use App\Models\StokAwal;
        use App\Models\ProdukDiterima;
        use App\Models\SetNoFaktur;
    @endphp
    @if (!SetNoFaktur::where('id_perusahaan', Auth::user()->id_perusahaan)->first())
        <div class="p-2 mt-5 box">
            <p><a href="/setting-nomor-faktur" class="font-bold text-danger">Setting nomor faktur</a> terlebih dahulu
                untuk
                menambahkan penjualan</p>
        </div>
    @else
        <form wire:submit='simpanPenjualan'>
            <div class="grid-cols-3 gap-4 mt-2 sm:grid">
                <div class="p-2 box drop-shadow ">
                    <div data-tw-merge class="items-center block mt-1 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            No SP
                        </label>
                        <div class="flex w-full font-bold item-center" wire:ignore>
                            {{-- <input data-tw-merge id="horizontal-form-1" type="text" placeholder="" wire:model='no_sp'
                                disabled
                                class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" /> --}}
                            {{-- <div class="ml-2 btn btn-primary" data-tw-toggle="modal" data-tw-target="#cari-no-sp">Cari</div> --}}
                            <select class="w-full form-control tom-select" wire:model.live='id_sp'>
                                <option value="">- Pilih -</option>
                                @forelse ($spPenjualan as $item)
                                    <option value="{{ $item->id }}">{{ $item->no_sp }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <div data-tw-merge class="items-center block mt-1 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            Tgl. SP
                        </label>
                        <input data-tw-merge id="horizontal-form-1" type="date" placeholder="" wire:model='tgl_input'
                            disabled
                            class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                    </div>
                    <div data-tw-merge class="items-center block mt-1 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            Tgl. Faktur
                        </label>
                        <input data-tw-merge id="horizontal-form-1" type="date" placeholder=""
                            wire:model='tgl_faktur'disabled
                            class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                    </div>
                    <div data-tw-merge class="items-center block mt-1 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            No Reff
                        </label>
                        <div class="flex w-full item-center">
                            <input data-tw-merge id="horizontal-form-1" type="text" placeholder=""
                                wire:model='no_reff'
                                class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                        </div>
                    </div>
                </div>
                <div class="p-3 mt-5 mb-5 text-center box">
                    <label for="no-reff" class="font-bold form-label text-pending">NO. FAKTUR</label>
                    <input type="text" class="font-bold text-center form-control" name="" id=""
                        {{-- placeholder="Auto" wire:model='no_faktur' disabled> --}} placeholder="Auto" wire:model='no_faktur'>
                    <div class="flex justify-center mt-2">
                        @if ($no_faktur)
                            {!! $generator->getBarcode($no_reff, $generator::TYPE_CODE_128) !!}
                        @endif
                    </div>
                </div>
                <div class="p-2 box">
                    <div data-tw-merge class="items-center block mt-1 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            Pelanggan
                        </label>
                        <div class="flex w-full item-center">
                            <input data-tw-merge id="horizontal-form-1" type="text" placeholder=""
                                wire:model='pelanggan' disabled
                                class="font-bold disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                        </div>
                    </div>
                    <div data-tw-merge class="items-center block mt-1 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            Sales
                        </label>
                        <div class="flex w-full item-center">
                            <input data-tw-merge id="horizontal-form-1" type="text" placeholder="" wire:model='sales'
                                disabled
                                class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                        </div>
                    </div>
                    <div data-tw-merge class="items-center block gap-2 mt-1 sm:flex">
                        <div class="flex">
                            <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-32">
                                Kredit
                            </label>
                            <div class="form-check form-switch">
                                <input id="checkbox-switch-7" class="mx-3 form-check-input" type="checkbox" checked
                                    wire:model.live="kredit" {{ $total_hutang != 0 ? 'required' : '' }}>
                            </div>
                        </div>
                        {{-- <label data-tw-merge for="horizontal-form-1" class="inline-block mt-2 mb-2">
                            Date
                        </label> --}}
                        <input data-tw-merge id="horizontal-form-1" type="date" placeholder=""
                            wire:model='tempo_kredit' {{ $disabled }} {{ $total_hutang != 0 ? 'required' : '' }}
                            class="sm:w-full disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                    </div>
                    <div data-tw-merge class="items-center block mt-1 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            No Seri Pajak
                        </label>
                        <div class="flex w-full item-center">
                            <input data-tw-merge id="horizontal-form-1" type="text" placeholder=""
                                wire:model='no_seri_pajak' readonly required
                                class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                            <div class="ml-2 btn btn-pending" data-tw-toggle="modal" data-tw-target="#data-pajak">
                                Cari
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <h4 class="border p-3 mt-2 mb-2 text-4xl font-bold font-medium box text-pending text-right">
                    {{ number_format($total_hutang, 0, ',', '.') }}
                </h4>
            </div>

            {{-- modal cari no sp --}}
            <div id="cari-no-sp" class="modal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <livewire:penjualan.penjualan.modal-cari-sp />
                </div>
            </div>
            {{-- end modal cari no sp --}}
            {{-- modal cari no seri pajak --}}
            <div id="data-pajak" class="modal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <livewire:penjualan.penjualan.modal-cari-seri-pajak />
                </div>
            </div>
            {{-- end modal cari pelanggan --}}

            {{-- <div class="col-span-12 mt-5 overflow-auto intro-y lg:overflow-visible">
                <div class="p-2 mt-1 box">
                    <h1 class="text-5xl font-bold text-pending">Total
                        {{ number_format($total_hutang, 0, ',', '.') }}
                    </h1>
                </div>
            </div> --}}

            @if ($unlockDisplay)
                <div class="flex justify-end gap-3 mt-3">
                    <label for="vertical-form-1" class="w-32 mt-2 font-medium form-label text-primary">Buka
                        Harga</label>
                    <input type="password" class="form-control" wire:model='password'
                        placeholder="Masukan Password Harga">
                    <div class="btn btn-sm btn-primary" wire:click='unlock'>Unlock</div>
                    <div class="btn btn-sm btn-outline-danger" wire:click='cancelUnlock'>
                        Close
                    </div>
                </div>
            @endif
            <div class="mt-2 text-center text-danger">
                {{ $message }} <br>
                <p wire:loading>Memproses...</p>
            </div>
            <div class="mt-2 overflow-auto box">
                <table class="table text-center">
                    {{-- <style>
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

                        /* Gaya khusus untuk lebar kolom */
                        .col-no-batch {
                            width: 10%;
                            /* Atur lebar sesuai kebutuhan */
                        }


                        .col-ED {
                            width: 8%;
                            /* Atur lebar sesuai kebutuhan */
                        }

                        .col-qty-sp {
                            width: 6%;
                        }

                        .col-total {
                            width: 9%;
                            /* Atur lebar sesuai kebutuhan */
                        }

                        .col-disc1 {
                            width: 7%;
                            /* Atur lebar sesuai kebutuhan */
                        }

                        .col-disc2 {
                            width: 7%;
                            /* Atur lebar sesuai kebutuhan */
                        }

                        .col-stok {
                            width: 7%;
                            /* Atur lebar sesuai kebutuhan */
                        }

                        .col-qty {
                            width: 5%;
                            /* Atur lebar sesuai kebutuhan */
                        }

                        .col-satuan {
                            width: 5%;
                            /* Atur lebar sesuai kebutuhan */
                        }

                        .col-no {
                            width: 2%;
                            /* Atur lebar sesuai kebutuhan */
                        }

                        .col-harga {
                            width: 10%;
                            /* Atur lebar sesuai kebutuhan */
                        }
                    </style> --}}

                    <thread>
                        <tr class="header-gray">
                            <th class="border border-slate-600 col-no">No</th>
                            {{-- <th class="border">Barcode</th> --}}
                            <th class="border border-slate-600">Nama Produk</th>
                            <th class="border border-slate-600 col-qty-sp">Qty-SP</th>
                            <th class="border border-slate-600 col-satuan">Satuan</th>
                            <th class="border border-slate-600 col-no-batch">No.Batch</th>
                            <th class="border border-slate-600 col-ED">Exp Date</th>
                            <th class="border border-slate-600 col-stok">Stok</th>
                            <th class="border border-slate-600 col-qty">Qty</th>
                            <th class="border border-slate-600 col-harga">Harga @if ($produks)
                                    <div class="mt-2 btn btn-sm btn-primary" wire:click='openLockDisplay'>Unlock</div>
                                @endif
                            </th>
                            <th class="border border-slate-600 col-disc1">Disc %-1</th>
                            <th class="border border-slate-600 col-disc2">Disc %-2</th>
                            <th class="border border-slate-600 col-total">Total</th>
                        </tr>
                    </thread>

                    <tbody>
                        @forelse ($produks as $key => $prod)
                            @php
                                $isiStok = \App\Models\DiskonKelompok::where('id_obat_barang', $prod->produk->id)
                                    ->where('id_kelompok', \App\Models\Pelanggan::find($id_pelanggan)->kelompok)
                                    ->where('satuan_dasar_beli', $prod->produk->satuan_dasar_beli)
                                    ->first()->isi;
                                $query = \App\Models\HistoryStok::where('id_produk', $prod->id_produk)
                                    ->where('no_batch', $prod->batch)
                                    ->where('id_gudang', $prod->gudang)
                                    ->where('id_rak', $prod->rak)
                                    ->where('id_sub_rak', $prod->sub_rak);

                                $stok_akhir = $query->sum('stok_masuk') - $query->sum('stok_keluar');
                            @endphp
                            <tr>
                                <td class="border border-slate-600 text-center p-1">{{ $loop->iteration }}</td>
                                {{-- <td class="border border-slate-600">{{ $prod->produk->barcode_produk }}</td> --}}
                                <td class="border border-slate-600 p-1" style="width: 250px;">
                                    {{ $prod->produk->nama_obat_barang }}</td>
                                <td class="border border-slate-600 text-center p-1">{{ $prod->qty_sp }}</td>
                                <td class="border border-slate-600 text-center p-1">{{ $prod->satuanProduk->satuan }}
                                </td>
                                <td class="border border-slate-600 text-center p-1" style="width: 80px;">
                                    {{ $prod->batch }}
                                </td>
                                <td class="border border-slate-600 text-center p-1" style="width: 100px;">
                                    {{ date('d-m-Y', strtotime($prod->exp_date)) }}</td>
                                <td class="border border-slate-600 text-center p-1">{{ $stok_akhir / $isiStok }}</td>
                                <td class="border border-slate-600 text-center p-1">{{ $prod->qty }}</td>
                                <td class="border border-slate-600 p-1">
                                    <input type="text" {{ $readonly }} class="form-control"
                                        oninput="formatNumber(this)" style="width: 110px;"
                                        wire:change='hitung({{ $key }})'
                                        wire:model.live.lazy='penghitungan.{{ $key }}.harga'>
                                </td>

                                <td class="border border-slate-600 p-1">
                                    <input type="text" {{ $readonly }} class="form-control w-full p-1"
                                        wire:change='hitung({{ $key }})'
                                        onkeyup="return checkInput(event,'0123456789.',this)" style="width: 60px;"
                                        wire:model.live.lazy='penghitungan.{{ $key }}.disc_1'>
                                </td>

                                <td class="border border-slate-600 p-1">
                                    <input type="text" {{ $readonly }} class="form-control w-full p-1"
                                        wire:change='hitung({{ $key }})'
                                        onkeyup="return checkInput(event,'0123456789.',this)" style="width: 60px;"
                                        wire:model.live.lazy='penghitungan.{{ $key }}.disc_2'>
                                </td>

                                <td class="p-1">
                                    <input type="text" class="form-control text-md w-full p-1" readonly
                                        wire:model.live.lazy='penghitungan.{{ $key }}.total'>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td class="text-lg font-bold text-center border text-pending border-slate-600"
                                    colspan="12">
                                    No SP belum
                                    dipilih
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-2 mt-2 box">
                <style>
                    /* Animasi kedip */
                    @keyframes blink {

                        0%,
                        100% {
                            opacity: 1;
                        }

                        50% {
                            opacity: 0.5;
                        }
                    }

                    /* Kelas untuk tombol berkedip */
                    .blink {
                        animation: blink 1s infinite;
                    }
                </style>

                <!-- Tombol dengan animasi berkedip -->
                <div class="btn btn-pending btn-sm w-full blink" wire:click="updateAngka()">
                    Klik Disini Dulu Sebelum Simpan
                </div>

                <div class="grid-cols-2 gap-2 sm:grid">
                    <div class="">
                        <div data-tw-merge class="items-center block mt-1 sm:flex">
                            <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                                Sub Total
                            </label>
                            <input data-tw-merge id="horizontal-form-1" type="text" placeholder="" disabled
                                value="{{ number_format($subtotal, 0, ',', '.') }}"
                                class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                        </div>
                        <div data-tw-merge class="items-center block mt-1 sm:flex" style="display:none;">
                            <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                                Disc %
                            </label>
                            <div class="flex w-full gap-2">
                                <input data-tw-merge id="horizontal-form-1" type="text" placeholder="%"
                                    wire:model.live.debounce.500ms='diskon'
                                    class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                                <input data-tw-merge id="horizontal-form-1" type="text" placeholder=""
                                    value="{{ number_format($hasil_diskon, 0, ',', '.') }}" disabled
                                    class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                            </div>
                        </div>
                        <div data-tw-merge class="items-center block mt-1 sm:flex">
                            <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                                DPP
                            </label>
                            <input data-tw-merge id="horizontal-form-1" type="text" placeholder="" disabled
                                value="{{ number_format($dpp, 0, ',', '.') }}"
                                class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                        </div>
                        <div data-tw-merge class="items-center block mt-1 sm:flex">
                            <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                                PPN
                            </label>
                            <input data-tw-merge id="horizontal-form-1" type="text" placeholder="" disabled
                                value="{{ number_format($ppn, 0, ',', '.') }}"
                                class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                        </div>
                        <div data-tw-merge class="items-center block mt-1 sm:flex">
                            <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                                Biaya 1
                            </label>
                            <div class="flex w-full gap-2">
                                <input data-tw-merge id="horizontal-form-1" type="text" placeholder=""
                                    wire:model.live.debounce.500ms='biaya1' oninput="formatNumber(this)"
                                    class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                                <select data-tw-merge aria-label="Default select example" class="form-control"
                                    {{ $biaya1 != 0 ? 'required' : '' }} wire:model='akun_biaya1'>
                                    <option value="">- Pilih Akun -</option>
                                    @forelse ($akuns2 as $akun)
                                        <option value="{{ $akun->kode }}">{{ $akun->nama_akun }}</option>
                                    @empty
                                        <!-- Tindakan jika data tidak ditemukan -->
                                    @endforelse
                                </select>
                            </div>
                        </div>
                        <div data-tw-merge class="items-center block mt-1 sm:flex">
                            <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                                Biaya 2
                            </label>
                            <div class="flex w-full gap-2">
                                <input data-tw-merge id="horizontal-form-1" type="text" placeholder=""
                                    wire:model.live.debounce.500ms='biaya2' oninput="formatNumber(this)"
                                    class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                                <select data-tw-merge aria-label="Default select example" class="form-control"
                                    wire:model='akun_biaya2' {{ $biaya2 != 0 ? 'required' : '' }}>
                                    <option value="">- Pilih Akun -</option>
                                    @forelse ($akuns2 as $akun)
                                        <option value="{{ $akun->kode }}">{{ $akun->nama_akun }}</option>
                                    @empty
                                        <!-- Tindakan jika data tidak ditemukan -->
                                    @endforelse
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div data-tw-merge class="items-center block mt-1 sm:flex">
                            <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                                Tagihan
                            </label>
                            <input data-tw-merge id="horizontal-form-1" type="text" placeholder="" disabled
                                value="{{ number_format($total_tagihan, 0, ',', '.') }}"
                                class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                        </div>
                        <div data-tw-merge class="items-center block mt-1 sm:flex">
                            <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                                Akun Bayar
                            </label>
                            <select data-tw-merge aria-label="Default select example" class="form-control"
                                wire:model='akun_bayar' {{ $jumlah_bayar != 0 ? 'required' : '' }}>
                                <option value="">- Pilih Akun -</option>
                                @forelse ($akuns->where('kas_bank', 1) as $akun)
                                    <option value="{{ $akun->kode }}">{{ $akun->nama_akun }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                        <div data-tw-merge class="items-center block mt-1 sm:flex">
                            <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                                Jumlah Bayar
                            </label>
                            <input data-tw-merge id="horizontal-form-1" type="text" placeholder=""
                                wire:model.live.debounce.500ms='jumlah_bayar' oninput="formatNumber(this)"
                                class="bayar disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                        </div>
                        <div data-tw-merge class="items-center block mt-1 sm:flex">
                            <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                                Total Tagihan
                            </label>
                            <input data-tw-merge id="horizontal-form-1" type="text" placeholder=""
                                value="{{ number_format($total_hutang, 0, ',', '.') }}" disabled
                                class="kurang disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                        </div>
                    </div>
                </div>
                <div data-tw-merge class="items-center block mt-1 sm:flex">
                    <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-52">
                        Keterangan
                    </label>
                    <textarea data-tw-merge id="horizontal-form-1" type="text" placeholder="" rows="4" wire:model='keterangan'
                        class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80"></textarea>
                </div>
                <div class="flex justify-center gap-2 mt-5">
                    <button class="px-10 btn btn-primary" type="submit" wire:loading.remove>Simpan</button>
                    <button class="px-10 btn btn-primary" disabled wire:loading>Menyimpan...</button>
                    <a href="/penjualan" class="btn btn-outline-danger">Batal</a>
                </div>

            </div>
        </form>
        <script>
            function formatNumber(input) {
                input.value = input.value.replace(/[^\d.]/g, '');

                let number = parseFloat(input.value.replace(/\./g, '').replace(',', '.')).toFixed(0);
                input.value = isNaN(number) ? '0' : new Intl.NumberFormat('id-ID').format(number);
            }
        </script>

    @endif
</div>


<script>
    $(document).ready(function() {
        $("body").on("change", ".bayar", function() {
            var bayar = $(this).val();
            var kurang = $(".kurang").val();
            var kredit = $("#checkbox-switch-7").val();
            console.log(bayar + '/' + kurang + '/' + kredit);
        })
    })

    function formatNumber(input) {
        input.value = input.value.replace(/[^\d.]/g, '');
        let number = parseFloat(input.value.replace(/\./g, '').replace(',', '.')).toFixed(0);
        input.value = isNaN(number) ? '0' : new Intl.NumberFormat('id-ID').format(number);
    }

    function formatDisc(input) {
        input.value = input.value.replace(/[^\d.]/g, '');
        let number = parseFloat(input.value.replace(/\./g, '').replace(',', '')).toFixed(0);
        input.value = isNaN(number) ? '0' : new Intl.NumberFormat('id-ID').format(number);
    }

    function parseFormattedValue(value) {
        return value.replace(/\./g, '');
    }
    const inputElement = document.getElementById('formattedInput');

    function formatPajak() {
        let value = inputElement.value.replace(/\D/g, '');
        if (value.length > 13) {
            value = value.slice(0, 13);
        }
        ft
        value = value.replace(/^(\d{3})(\d{2})/, "$1.$2.");
        inputElement.value = value;
    }
    inputElement.addEventListener('input', formatPajak);

    function checkInput(e, chars, field) {
        let teks = field.value;
        let teksSplit = teks.split("");
        let teksOke = [];
        for (let i = 0; i < teksSplit.length; i++) {
            if (chars.indexOf(teksSplit[i]) != -1) {
                teksOke.push(teksSplit[i]);
            }
        }
        field.value = teksOke.join("");
    }
</script>
