<div>
    {{-- <div class="p-5 mt-3 box">
        <h1 class="text-4xl font-bold text-left text-pending">Total {{ number_format($total, 0, ',', '.') }}</h1>
    </div> --}}
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
    <form wire:submit='simpanReturPenjualan'>

        <div class="p-5 mt-5 box">
            <div class="grid-cols-2 gap-5 sm:grid">
                <div class="">
                    <div data-tw-merge class="items-center block mt-1 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            No. Reff
                        </label>
                        <input data-tw-merge id="horizontal-form-1" type="text" placeholder="Auto" wire:model='no_reff'
                            disabled
                            class="font-bold disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                    </div>
                    <div data-tw-merge class="items-center block mt-1 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            Pelanggan
                        </label>
                        <input data-tw-merge id="horizontal-form-1" type="text" placeholder="Auto"
                            wire:model='pelanggan' disabled
                            class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                    </div>
                    <div data-tw-merge class="items-center block mt-1 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            Sales
                        </label>
                        <input data-tw-merge id="horizontal-form-1" type="text" placeholder="" wire:model='sales'
                            disabled
                            class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                    </div>
                </div>
                <div data-tw-merge class="items-center block mt-2">
                    <div data-tw-merge class="items-center block mt-1 sm:flex" wire:ignore>
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            No. Faktur
                        </label>
                        {{-- <div class="flex w-full item-center">
                        <input data-tw-merge id="horizontal-form-1" type="text" placeholder="" wire:model='no_faktur'
                            disabled
                            class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                        <button class="ml-2 btn btn-warning" data-tw-toggle="modal"
                            data-tw-target="#daftar-pelanggan">Cari</button>
                    </div> --}}
                        <select class="font-bold form-control tom-select" id=""
                            wire:model.live='tambahPenjualan'>
                            <option value="">- Pilih -</option>
                            @forelse ($penjualans as $penjualan)
                                <option value="{{ $penjualan->id }}">{{ $penjualan->no_faktur }}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                    <div data-tw-merge class="items-center block mt-1 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            Tanggal Retur
                        </label>
                        <input type="date" disabled value="{{ now()->format('Y-m-d') }}"
                            class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal daftar-pelanggan --}}
        <div id="daftar-pelanggan" class="modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <livewire:penjualan.retur-penjualan.modal-daftar-penjualan />
            </div>
        </div>
        {{-- End Modal daftar --}}

        <div class="p-5 mt-1 box">
            <div class="overflow-auto">
                <table class="table">
                    <thead>
                        <tr class="header-gray">
                            <td class="border border-slate-600 text-center">No</td>
                            <td class="border border-slate-600 text-center">Barcode Produk</td>
                            <td class="border border-slate-600 text-center">Produk</td>
                            <td class="border border-slate-600 text-center">Satuan</td>
                            <td class="border border-slate-600 text-center">No. Batch</td>
                            <td class="border border-slate-600 text-center">Exp Date</td>
                            <td class="border border-slate-600 text-center">Qty</td>
                            <td class="border border-slate-600 text-center">Yang Bisa Diretur</td>
                            <td class="border border-slate-600 text-center">Qty Retur</td>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($produkPenjualan as $index=> $prod)
                            <tr wire:key='my-{{ $index }}'>
                                <td class="border border-slate-600 text-center">{{ $loop->iteration }}</td>
                                <td class="border border-slate-600 text-center">{{ $prod->produk->barcode_produk }}</td>
                                <td class="border border-slate-600">{{ $prod->produk->nama_obat_barang }} <br>
                                    <small class="text-sm font-bold text-pending">{{ $prod->getGudang->gudang }} -
                                        {{ $prod->getRak->rak }} -
                                        {{ $prod->getSubRak->sub_rak }}</small>
                                </td>
                                <td class="border border-slate-600 text-center">
                                    {{ $prod->produk->satuanDasar->satuan }}</td>
                                <td class="border border-slate-600 text-center">{{ $prod->batch }}</td>
                                <td class="border border-slate-600 text-center">
                                    {{ $prod->exp_date != '-' ? date('d-m-Y', strtotime($prod->exp_date)) : '-' }}
                                </td>
                                <td class="border border-slate-600 text-center">{{ $prod->qty }}</td>
                                <td class="border border-slate-600 text-center">
                                    {{ $prod->retur ? $prod->qty - $prod->retur->sum('qty_retur') : $prod->qty }}</td>
                                <td class="border border-slate-600 text-center">
                                    <input type="number" class="form-control text-center"
                                        wire:model='qty.{{ $index }}' name="{{ $index }}"
                                        id="qty{{ $index }}" min="0" required
                                        max="{{ $prod->retur ? $prod->qty - $prod->retur->sum('qty_retur') : $prod->qty }}"
                                        {{-- wire:change='hitungJumlah({{ $index }})' --}}>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="font-bold text-center border text-pending border-slate-600" colspan="9">
                                    Belum ada
                                    produk
                                    yang dipilih</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="p-5 mt-1 box">
            <style>
                @keyframes blink {

                    0%,
                    100% {
                        opacity: 1;
                    }

                    50% {
                        opacity: 0.5;
                    }
                }

                .blink {
                    animation: blink 1s infinite;
                }
            </style>

            <div class="w-full btn btn-pending btn-sm blink" wire:click='updateAngka()'>
                Klik Disini Dulu Sebelum Simpan
            </div>
            <div class="grid-cols-2 gap-5 sm:grid">

                <div class="">
                    <div data-tw-merge class="items-center block mt-1 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            Total Piutang
                        </label>
                        <input data-tw-merge id="horizontal-form-1" type="text" placeholder="" disabled
                            value="{{ number_format($total_piutang, 0, ',', '.') }}"
                            class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                    </div>
                    <div data-tw-merge class="items-center block mt-1 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            Sisa Piutang
                        </label>
                        <input data-tw-merge id="horizontal-form-1" type="text" placeholder="" disabled
                            value="{{ number_format($sisa_piutang, 0, ',', '.') }}"
                            class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                    </div>
                    <div data-tw-merge class="items-center block mt-1 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            Uang Retur
                        </label>
                        <input data-tw-merge id="horizontal-form-1" type="text" placeholder=""
                            value="{{ number_format($uang_retur, 0, ',', '.') }}" disabled
                            class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                    </div>
                    <div data-tw-merge class="items-center block mt-1 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            Akun
                        </label>
                        <select data-tw-merge aria-label="Default select example" class="form-control"
                            wire:model='akun' required>
                            <option>- Pilih Akun -</option>
                            @foreach ($akunTetap as $akun)
                                <option value="{{ $akun->id }}">{{ $akun->nama_akun }}</option>
                            @endforeach
                            @forelse ($akuns as $item)
                                <option value="{{ $akun->id }}">{{ $akun->nama_akun }}</option>

                            @empty
                            @endforelse
                        </select>
                    </div>
                </div>
                <div data-tw-merge class="items-center block mt-2">
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
                            Total
                        </label>
                        <input data-tw-merge id="horizontal-form-1" type="text" placeholder="" disabled
                            value="{{ number_format($total, 0, ',', '.') }}"
                            class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                    </div>
                    <div data-tw-merge class="items-center block mt-1 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            No. Seri Pajak
                        </label>
                        <input data-tw-merge id="horizontal-form-1" type="text" placeholder=""
                            wire:model='no_seri_pajak' disabled
                            class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                    </div>
                </div>
            </div>
        </div>
        <div class="flex justify-center gap-3 mt-5">
            <button class="px-10 btn btn-primary" type="submit">Simpan</button>
            <a href="/retur-penjualan">
                <div class="btn btn-outline-danger">Batal</div>
            </a>
        </div>
    </form>
</div>
