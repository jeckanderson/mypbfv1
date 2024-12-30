<div class="p-5 mt-3 box">
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
    <p class="mb-2 text-slate-800 text-small">*tekan shift dan scroll untuk geser table</p>
    <div class="overflow-auto">
        <table class="table">
            <thead>
                <tr class="header-gray">
                    <td class="border border-slate-600">Barcode</td>
                    <td class="border border-slate-600">Nama Produk</td>
                    <td class="border border-slate-600">Satuan</td>
                    <td class="border border-slate-600">Qyt SP</td>
                    <td class="border border-slate-600">Qyt Faktur</td>
                    <td class="border border-slate-600">Diterima</td>
                    <td class="border border-slate-600">Batch</td>
                    <td class="border border-slate-600">Tgl. Exp Date</td>
                    <td class="border border-slate-600">Gudang</td>
                    <td class="border border-slate-600">Rak</td>
                    <td class="border border-slate-600">Sub Rak</td>
                    <td class="border border-slate-600">Actions</td>
                </tr>
            </thead>
            <tbody>
                @forelse ($produks as $index=> $prod)
                    <tr wire:key='produks-{{ $index }}'>
                        <td class="border border-slate-600 whitespace-nowrap">
                            {{ $prod->produk->barcode_produk }}</td>
                        <td class="border border-slate-600 whitespace-nowrap">
                            {{ $prod->produk->nama_obat_barang }}</td>
                        <td class="border border-slate-600 whitespace-nowrap">
                            {{ $prod->produk->satuanDasar->satuan }}</td>
                        <td class="border border-slate-600 whitespace-nowrap">{{ $prod->order->jumlah_order }}</td>
                        <td class="border border-slate-600 whitespace-nowrap">{{ $prod->produkPembelian->qty_faktur }}
                        </td>
                        <td class="border border-slate-600 whitespace-nowrap">
                            {{ $prod->diterima }}
                        </td>
                        <td class="border border-slate-600 whitespace-nowrap">
                            <input type="text" class="w-32 font-bold form-control"
                                wire:model='diterima.{{ $index }}.batch'>
                        </td>
                        <td class="border border-slate-600 whitespace-nowrap">
                            <input type="date" class="w-min-32 form-control"
                                wire:model='diterima.{{ $index }}.tgl_exp_date'>
                        </td>
                        <td class="border border-slate-600 whitespace-nowrap">
                            <select data-tw-merge aria-label=".form-select-sm example" required
                                wire:model='diterima.{{ $index }}.gudang'
                                class="disabled:bg-slate-100 w-32 disabled:cursor-not-allowed disabled:dark:bg-darkmode-800/50 [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md py-2 px-3 pr-8 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 text-xs py-1.5 pl-2 pr-8 mt-2 mt-2">
                                <option value="">- Pilih -</option>
                                @forelse ($gudangs as $gudang)
                                    <option value="{{ $gudang->id }}">{{ $gudang->gudang }}</option>
                                @empty
                                    <option value="">Gudang belum ditambahkan</option>
                                @endforelse
                            </select>
                        </td>
                        <td class="border border-slate-600 whitespace-nowrap ">
                            <select data-tw-merge aria-label=".form-select-sm example"
                                wire:model='diterima.{{ $index }}.rak' required
                                class="disabled:bg-slate-100 w-32 disabled:cursor-not-allowed disabled:dark:bg-darkmode-800/50 [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md py-2 px-3 pr-8 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 text-xs py-1.5 pl-2 pr-8 mt-2 mt-2">
                                <option value="">- Pilih -</option>
                                @forelse ($raks as $rak)
                                    <option value="{{ $rak->id }}">{{ $rak->rak }}</option>
                                @empty
                                    <option value="">Rak belum ditambahkan</option>
                                @endforelse
                            </select>
                        </td>
                        <td class="border border-slate-600 whitespace-nowrap">
                            <select data-tw-merge aria-label=".form-select-sm example"
                                wire:model='diterima.{{ $index }}.sub_rak' required
                                class="disabled:bg-slate-100 w-32 disabled:cursor-not-allowed disabled:dark:bg-darkmode-800/50 [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md py-2 px-3 pr-8 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 text-xs py-1.5 pl-2 pr-8 mt-2 mt-2">
                                <option value="">- Pilih -</option>
                                @forelse ($sub_rak as $sub)
                                    <option value="{{ $sub->id }}">{{ $sub->sub_rak }}</option>
                                @empty
                                    <option value="">Sub rak belum ditambahkan</option>
                                @endforelse
                            </select>
                        </td>
                        <td class="border border-slate-600 whitespace-nowrap">
                            <button class="shadow-md btn btn-outline-danger btn-sm"
                                wire:click='hapusProduk({{ $prod->id }})'
                                wire:confirm="Anda yakin akan menghapus produk?">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="font-bold text-center border text-pending border-slate-600" colspan="12">Belum ada
                            produk
                            yang dipilih</td>
                    </tr>
                @endforelse
                <tr>
                    <td colspan="12" class="font-bold border border-slate-600 text-bold">Total</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
