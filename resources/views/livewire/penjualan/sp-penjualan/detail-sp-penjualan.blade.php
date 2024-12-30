<div>
    @php
        use App\Models\DiskonKelompok;
        use App\Models\Satuan;
    @endphp
    <form wire:submit="simpanSPPenjualan">
        <div class="p-5 mt-5 box">
            <div class="grid-cols-2 gap-5 sm:grid">
                <div class="">
                    <div data-tw-merge class="items-center block mt-3 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            Tanggal
                        </label>
                        <input data-tw-merge id="horizontal-form-1" type="date" placeholder="" readonly
                            wire:model='tgl_input'
                            class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                    </div>
                    <div data-tw-merge class="items-center block mt-1 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            No. Reff
                        </label>
                        <input data-tw-merge id="horizontal-form-1" type="text" placeholder="Auto"
                            wire:model='no_reff' readonly
                            class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                    </div>
                    <div data-tw-merge class="items-center block mt-1 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            Tgl. SP
                        </label>
                        <input data-tw-merge id="horizontal-form-1" type="date" placeholder="" wire:model='tgl_sp'
                            class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                    </div>
                    <div data-tw-merge class="items-center block mt-1 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            No. SP
                        </label>
                        <input data-tw-merge id="horizontal-form-1" type="text" placeholder="" wire:model='no_sp'
                            required
                            class="font-bold disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                    </div>
                </div>
                <div data-tw-merge class="items-center block mt-2">
                    <div data-tw-merge class="items-center block mt-1 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            Pelanggan
                        </label>
                        <div class="w-full">
                            <div class="flex w-full item-center">
                                <input data-tw-merge id="horizontal-form-1" type="text" placeholder=""
                                    wire:model='pelanggan' readonly required
                                    class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                                <div class="ml-2 btn btn-pending" data-tw-toggle="modal"
                                    data-tw-target="#daftar-pelanggan">
                                    Cari</div>
                            </div>
                            @error('pelanggan')
                                <span class="mt-1 text-danger">Lengkapi kolom berikut untuk bisa menyimpan </span>
                            @enderror
                        </div>
                    </div>
                    <div data-tw-merge class="items-center block mt-1 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            Sales
                        </label>
                        <div class="w-full">
                            <input data-tw-merge id="horizontal-form-1" type="text" placeholder="" wire:model='sales'
                                readonly required
                                class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                            @error('pelanggan')
                                <span class="mt-1 text-danger">Lengkapi kolom berikut untuk bisa menyimpan </span>
                            @enderror
                        </div>
                    </div>
                    <div data-tw-merge class="items-center block mt-1 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            Tipe SP
                        </label>
                        <select data-tw-merge aria-label="Default select example" class="form-control" required
                            wire:model='tipe_sp'>
                            <option value="">- Pilih -</option>
                            <option>SP. Reguler</option>
                            <option>SP. OOT</option>
                            <option>SP. Prekursor</option>
                            <option>SP. Psikotropika</option>
                            <option>SP. Narkotika</option>
                            <option>SP. Bonus</option>
                        </select>
                    </div>
                    {{-- End Modal daftar --}}
                    <div data-tw-merge class="items-center block mt-2 sm:flex" wire:ignore>
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60"> Produk </label>
                        <select data-tw-merge aria-label="Default select example"
                            class="font-bold form-control tom-select" wire:model.live='tambahProduk' id="produks">
                            <option value="">-- Pilih Produk --</option>
                            @forelse ($produks as $produk)
                                <option value="{{ $produk->id }}">
                                    {{ $produk->nama_obat_barang . ' || ' . $produk->jenis_obat_barang }}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                    {{-- Modal daftar-produk --}}
                </div>
            </div>
        </div>

        {{-- Modal daftar-pelanggan --}}
        <div id="daftar-pelanggan" class="modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <livewire:penjualan.sp-penjualan.modal-daftar-pelanggan />
            </div>
        </div>
        <div id="daftar-produk" class="modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <livewire:penjualan.sp-penjualan.modal-daftar-produk />
            </div>
        </div>
        {{-- End Modal daftar --}}

        <div class="p-5 mt-1 box">
            <div class="overflow-auto">
                <table class="table">
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

                        /* th {
                            font-weight: bold;
                            text-align: center;
                        } */

                        td {
                            font-size: 1em;
                        }
                    </style>
                    <thead>
                        <tr class="header-gray">
                            <td class="border border-slate-600">No</td>
                            <td class="border border-slate-600">Barcode</td>
                            <td class="border border-slate-600">Nama Produk</td>
                            <td class="border border-slate-600">Golongan</td>
                            <td class="border border-slate-600">Jenis Produk</td>
                            <td class="border border-slate-600 text-center">Qty.Pesanan</td>
                            <td class="border border-slate-600 text-center">Satuan.Produk</td>
                            <td class="border border-slate-600">Actions</td>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dataProduk as $key=> $prod)
                            @php
                                $items = [];
                                if ($prod->produk) {
                                    $items = DiskonKelompok::where('id_obat_barang', $prod->produk->id)
                                        ->pluck('satuan_dasar_beli')
                                        ->toArray();
                                }

                                $filteredItems = array_filter($items, function ($value) {
                                    return $value !== null;
                                });

                                $satuans = array_unique($filteredItems);
                            @endphp

                            <tr>
                                <td class="border border-slate-600">{{ $loop->iteration }}</td>
                                <td class="border border-slate-600">
                                    {{ $prod->produk?->barcode_produk ?? '-' }}
                                </td>
                                <td class="border border-slate-600">
                                    {{ $prod->produk->nama_obat_barang ?? '-' }}
                                <td class="border border-slate-600">
                                    {{ $prod->produk->golonganProduk->sub_golongan ?? '-' }}
                                </td>
                                </td>
                                <td class="border border-slate-600">{{ $prod->produk->jenis_obat_barang ?? '-' }}
                                </td>
                                <td class="border border-slate-600 text-center">
                                    <input type="number" class="w-60 form-control text-center" min="1"
                                        required wire:model='simpan.{{ $key }}.qty_sp'>
                                </td>
                                <td class="border border-slate-600 text-center">
                                    <select data-tw-merge aria-label="Default select example"
                                        class="form-control text-center"
                                        wire:model='simpan.{{ $key }}.satuan' required>
                                        <option value="">- Pilih Satuan -</option>
                                        @forelse ($satuans as $satuan)
                                            <option value="{{ $satuan }}">{{ Satuan::find($satuan)->satuan }}
                                            </option>
                                        @empty
                                        @endforelse
                                    </select>
                                </td>
                                <td class="w-32 border center border-slate-600">
                                    <div class="btn btn-outline-danger btn-sm"
                                        wire:confirm="Apakah anda yakin akan menghapusnya?"
                                        wire:click='hapusProduk({{ $prod->id }})'>Delete</div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="font-bold text-center border text-pending border-slate-600" colspan="8">
                                    Belum ada
                                    produk ditambahkan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="p-5 mt-3 box">
            <div data-tw-merge class="items-center block mt-3">
                <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                    Keterangan
                </label>
                <textarea data-tw-merge id="horizontal-form-1" type="text" placeholder="" rows="5" wire:model='keterangan'
                    class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80"></textarea>
            </div>
        </div>
        <div class="flex justify-center gap-3 mt-5">
            <button class="px-10 btn btn-primary" wire:loading.remove type="submit">Simpan</button>
            <button class="px-10 btn btn-primary" disabled wire:loading>Memproses...</button>
            <a href="{{ url('/sp-penjualan') }}" class="btn btn-outline-danger">Batal</a>
        </div>
    </form>
</div>
