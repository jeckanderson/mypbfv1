<div>
    @php
        use App\Models\HistoryStok;
    @endphp
    <form wire:submit='simpanReturPembelian'>
        <div class="p-5 mt-5 box">
            <div class="grid-cols-2 gap-5 sm:grid">
                <div class="">
                    <div data-tw-merge class="items-center block mt-1 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            No. Reff
                        </label>
                        <input data-tw-merge id="horizontal-form-1" type="text" placeholder="Auto" wire:model='no_reff'
                            class="font-bold disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                    </div>
                    <div data-tw-merge class="items-center block mt-1 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            Supplier
                        </label>
                        <input data-tw-merge id="horizontal-form-1" type="text" placeholder="Auto"
                            wire:model='suplier'
                            class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                    </div>
                    <div data-tw-merge class="items-center block mt-1 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            Tanggal Retur
                        </label>
                        <input type="date" value="{{ now()->format('Y-m-d') }}"
                            class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                    </div>
                </div>
                <div data-tw-merge class="items-center block mt-2">
                    <div data-tw-merge class="items-center block mt-1 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            No. Faktur
                        </label>
                        <div class="flex w-full item-center" wire:ignore>
                            <select class="font-bold form-control tom-select" wire:model.live='pilihPembelian'>
                                <option value="">- Pilih -</option>
                                @forelse ($pembelians as $pembelian)
                                    <option value="{{ $pembelian->id }}">{{ $pembelian->no_faktur }}</option>
                                @empty
                                @endforelse
                            </select>
                            {{-- <input data-tw-merge id="horizontal-form-1" type="text" placeholder="" wire:model='no_faktur'
                            class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                        <div class="ml-2 btn btn-warning" data-tw-toggle="modal" data-tw-target="#daftar-pembelian">Cari
                        </div> --}}
                            <button onclick="location.reload()" class="ml-2 btn btn-md btn-secondary" wire:ignore>
                                <i data-feather="refresh-cw" class="w-4 h-4 mr-1"></i> Reload
                            </button>
                        </div>
                    </div>
                    <div data-tw-merge class="items-center block mt-1 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mt-1 mb-2 sm:w-60">
                            No. Reff TB
                        </label>
                        <div class="flex w-full item-center">
                            <input data-tw-merge id="horizontal-form-1" type="text" placeholder=""
                                wire:model='no_reff_tb'
                                class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                        </div>
                    </div>
                    <div data-tw-merge class="items-center block mt-2 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">Produk</label>
                        <select data-tw-merge aria-label="Default select example" class="form-control tom-select "
                            wire:model.live='tambahProduk' id="">
                            <option value="">- Pilih -</option>
                            @forelse ($produkPilihan as $produk)
                                <option value="{{ $produk->id }}">
                                    {{ $produk->produk->nama_obat_barang . ' | ' . $produk->no_batch . ' | ' . $produk->gudang->gudang . ' | ' . $produk->rak->rak . ' | ' . $produk->subRak->sub_rak }}
                                </option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal daftar-pembelian --}}
        <div id="daftar-pembelian" class="modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <livewire:pembelian.retur-pembelian.modal-daftar-pembelian />
            </div>
        </div>
        {{-- End Modal daftar --}}

        {{-- start modal tambah --}}
        <div id="tambah" class="modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <livewire:pembelian.retur-pembelian.modal-daftar-terima-barang :id_pembelian="$id_pembelian" />
            </div>
        </div>
        {{-- end modal tambah --}}
        {{-- <div class="flex justify-between mt-5">
            <div class="p-5 mr-auto text-4xl font-bold box">
                Total {{ number_format($total, 0, ',', '.') }}
            </div>
            <div class="btn btn-primary" data-tw-toggle="modal" data-tw-target="#tambah">Tambah +</div>
            <div class="flex gap-3">
                <label for="select">Tambah Produk</label>
                <select class="form-control tom-select" wire:model.live='tambahProduk' id="">
                    <option value="">- Pilih -</option>
                    @forelse ($produkPilihan as $produk)
                        <option value="{{ $produk->id }}">
                            {{ $produk->produk->nama_obat_barang . ' | ' . $produk->no_batch . ' | ' . $produk->gudang->gudang . ' | ' . $produk->rak->rak . ' | ' . $produk->subRak->sub_rak }}
                        </option>
                    @empty
                    @endforelse
                </select>
            </div>
        </div> --}}

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
                            text-align: center;
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
                            <td class="border border-slate-600">No</td>
                            <td class="border border-slate-600">Barcode</td>
                            <td class="border border-slate-600">Produk</td>
                            <td class="border border-slate-600">Satuan Beli</td>
                            <td class="border border-slate-600">Isi</td>
                            <td class="border border-slate-600">Satuan Terkecil</td>
                            <td class="border border-slate-600">No. Batch</td>
                            <td class="border border-slate-600">Exp Date</td>
                            <td class="border border-slate-600">Stok</td>
                            <td class="border border-slate-600">Qty Retur</td>
                            <td class="border border-slate-600">Actions</td>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($produkRetur as $index => $prod)
                            @php
                                $history = HistoryStok::where('id_produk', $prod->id_produk)
                                    ->where('no_batch', $prod->history->no_batch)
                                    ->where('id_gudang', $prod->history->id_gudang)
                                    ->where('id_rak', $prod->history->id_rak)
                                    ->where('id_sub_rak', $prod->history->id_sub_rak);
                                $stok = $history->sum('stok_masuk') - $history->sum('stok_keluar');
                            @endphp
                            <tr>
                                <td class="border border-slate-600">{{ $loop->iteration }}</td>
                                <td class="border border-slate-600">{{ $prod->produk->barcode_produk }}</td>
                                <td class="border border-slate-600">
                                    {{ $prod->produk->nama_obat_barang }} <br>
                                    <small class="text-sm font-bold text-pending">{{ $prod->history->gudang->gudang }} -
                                        {{ $prod->history->rak->rak }} -
                                        {{ $prod->history->subRak->sub_rak }}</small>
                                </td>
                                <td class="border border-slate-600">{{ $prod->produk->satuanDasar->satuan }}</td>
                                <td class="border border-slate-600">{{ $prod->produk->isi }}</td>
                                <td class="border border-slate-600">{{ $prod->produk->satuanTerkecil->satuan }}</td>
                                <td class="border border-slate-600">{{ $prod->history->no_batch }}</td>
                                <td class="border border-slate-600">
                                    {{ date('d-m-Y', strtotime($prod->history->exp_date)) }}</td>
                                <td class="border border-slate-600">
                                    {{ $stok }}
                                </td>
                                <td class="border border-slate-600">
                                    <input type="number" min="0" class="w-full text-center form-control"
                                        wire:model='retur.{{ $index }}' max="{{ $stok }}"
                                        min="1">
                                </td>
                                <td class="border border-slate-600">
                                    <div class="btn btn-outline-danger btn-sm"
                                        wire:click='hapusProdukRetur({{ $prod->id }})'
                                        wire:confirm='Apakah anda yakin akan menghapus produk?'>Delete</div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="font-bold text-center border text-pending border-slate-600" colspan="12">
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
            <div class="btn btn-pending btn-sm w-full" wire:click='hitungRetur'>Klik Disini Sebelum Simpan</div>
            <div class="grid-cols-2 gap-5 sm:grid">
                <div class="">
                    <div data-tw-merge class="items-center block mt-1 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            Total Hutang
                        </label>
                        <input data-tw-merge id="horizontal-form-1" type="text" placeholder="Auto" disabled
                            value="{{ number_format($total_hutang, 0, ',', '.') }}"
                            class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                    </div>
                    <div data-tw-merge class="items-center block mt-1 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            Sisa Hutang
                        </label>
                        <input data-tw-merge id="horizontal-form-1" type="text" placeholder="Auto" disabled
                            value="{{ number_format($sisa_hutang, 0, ',', '.') }}"
                            class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                    </div>
                    <div data-tw-merge class="items-center block mt-1 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            Uang Retur
                        </label>
                        <input data-tw-merge id="horizontal-form-1" type="text" placeholder="Auto"
                            value="{{ number_format($uang_retur, 0, ',', '.') }}" disabled
                            class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                    </div>
                    <div data-tw-merge class="items-center block mt-1 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mt-2 mb-2 sm:w-60">
                            Akun
                        </label>
                        <select data-tw-merge aria-label="Default select example" class="form-control"
                            {{ $disabled }} wire:model='akun_bayar' {{ $uang_retur ? 'required' : '' }}
                            @if ($uang_retur > 0) required @endif>
                            <option>- Pilih -</option>
                            @forelse ($akuns as $akun)
                                <option value="{{ $akun->id }}">{{ $akun->nama_akun }}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                </div>
                <div data-tw-merge class="items-center block">
                    <div data-tw-merge class="items-center block mt-1 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            DPP
                        </label>
                        <input data-tw-merge id="horizontal-form-1" type="text" placeholder=""
                            value="{{ number_format($dpp, 0, ',', '.') }}" disabled
                            class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                    </div>
                    <div data-tw-merge class="items-center block mt-1 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            PPN
                        </label>
                        <input data-tw-merge id="horizontal-form-1" type="text" placeholder=""
                            value="{{ number_format($ppn, 0, ',', '.') }}" disabled
                            class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                    </div>
                    <div data-tw-merge class="items-center block mt-1 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            Total
                        </label>
                        <input data-tw-merge id="horizontal-form-1" type="text" placeholder=""
                            value="{{ number_format($total, 0, ',', '.') }}" disabled
                            class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                    </div>
                    <div data-tw-merge class="items-center block mt-1 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            No. Seri Pajak
                        </label>
                        <input data-tw-merge id="horizontal-form-1" type="text" placeholder=""
                            wire:model='no_seri_pajak'
                            class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                    </div>
                </div>
            </div>
            <div data-tw-merge class="items-center block mt-1">
                <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                    Keterangan
                </label>
                <textarea data-tw-merge id="horizontal-form-1" type="text" placeholder="" rows="5" wire:model='keterangan'
                    class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80"></textarea>
            </div>
        </div>
        <div class="flex justify-center gap-3 mt-5">
            <button class="px-10 btn btn-primary" type="submit">Simpan</button>
            <a href="/retur-pembelian" class="btn btn-outline-danger">Batal</a>
        </div>
    </form>
</div>
