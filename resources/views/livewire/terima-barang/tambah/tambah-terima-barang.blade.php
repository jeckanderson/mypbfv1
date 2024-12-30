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
    </style>
    @php
        use App\Models\ProdukDiterima;
    @endphp
    <form wire:submit='simpanTerimaBarang'>
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
                            Tanggal
                        </label>
                        <input data-tw-merge id="horizontal-form-1" type="date" placeholder="" wire:model='tanggal'
                            readonly
                            class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                    </div>
                    <div data-tw-merge class="items-center block mt-1 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            No. Faktur
                        </label>
                        <div class="flex w-full item-center" wire:ignore>
                            {{-- <input data-tw-merge id="horizontal-form-1" type="text" placeholder="" wire:model='no_faktur'
                            class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" /> --}}
                            @if (!$id)
                                <select class="w-full form-control tom-select" wire:model.live='getPembelian'>
                                    <option value="">- Pilih -</option>
                                    @forelse ($daftarPembelian as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->no_faktur . ' | ' . $item->no_reff }}
                                        </option>
                                    @empty
                                    @endforelse
                                </select>
                                {{-- <button class="ml-2 btn btn-warning" data-tw-toggle="modal"
                                data-tw-target="#cari">Cari</button> --}}
                            @else
                                <input type="text" disabled value="  {{ $no_faktur }}" class="form-control">
                            @endif
                        </div>
                    </div>
                </div>
                <div data-tw-merge class="items-center block mt-1">
                    <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                        Keterangan
                    </label>
                    <textarea rows="5" data-tw-merge id="horizontal-form-1" type="text" placeholder="" wire:model='keterangan'
                        class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80"></textarea>
                </div>
            </div>
        </div>

        {{-- Modal Cari --}}
        <div id="cari" class="modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <livewire:terima-barang.tambah.pilih-pembelian />
            </div>
        </div>
        {{-- End Modal Cari --}}

        @if ($getPembelian)
            <p class="mt-5 font-bold text-pending">Pilih Produk</p>
            {{-- handel pemilihan produk yang diterima --}}
            <div class="p-5 mt-3 box">
                <div class="overflow-auto">
                    {{-- <div class="w-full mt-3 mb-3 form-check form-switch sm:w-auto sm:ml-auto sm:mt-0">
                <div class="relative w-56 text-slate-500 ">
                    <input type="text" class="w-56 pr-10 form-control" placeholder="Search...">
                    <i class="absolute inset-y-0 right-0 w-4 h-4 my-auto mr-3" data-feather="search"></i>
                </div>
            </div> --}}
                    <table class="table">
                        <thead>
                            <tr class="header-gray">
                                <th class="border border-slate-600">Barcode</th>
                                <th class="border border-slate-600">Nama Produk</th>
                                <th class="border border-slate-600">Jumlah</th>
                                <th class="border border-slate-600">Satuan</th>
                                <th class="border border-slate-600">Tersedia</th>
                                <th class="border border-slate-600">Diterima</th>
                                <th class="border border-slate-600">Pilih</th>
                                {{-- <input data-tw-merge type="checkbox" value=""
                                        class="transition-all duration-100 ease-in-out shadow-sm border-slate-200 cursor-pointer rounded focus:ring-4 focus:ring-offset-0 focus:ring-primary focus:ring-opacity-20 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&amp;[type=&#039;radio&#039;]]:checked:bg-primary [&amp;[type=&#039;radio&#039;]]:checked:border-primary [&amp;[type=&#039;radio&#039;]]:checked:border-opacity-10 [&amp;[type=&#039;checkbox&#039;]]:checked:bg-primary [&amp;[type=&#039;checkbox&#039;]]:checked:border-primary [&amp;[type=&#039;checkbox&#039;]]:checked:border-opacity-10 [&amp;:disabled:not(:checked)]:bg-slate-100 [&amp;:disabled:not(:checked)]:cursor-not-allowed [&amp;:disabled:not(:checked)]:dark:bg-darkmode-800/50 [&amp;:disabled:checked]:opacity-70 [&amp;:disabled:checked]:cursor-not-allowed [&amp;:disabled:checked]:dark:bg-darkmode-800/50"
                                        id="checkbox-switch" />
                                </th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($produkPembelian as $index => $prod)
                                <tr>
                                    <td class="border border-slate-600">{{ $prod->order->produk->barcode_produk }}</td>
                                    <td class="border border-slate-600">{{ $prod->order->produk->nama_obat_barang }}
                                    </td>
                                    <td class="border border-slate-600">{{ $prod->qty_faktur }}</td>
                                    <td class="border border-slate-600">
                                        {{ $prod->produk->satuanDasar->satuan }}</td>
                                    <td class="border border-slate-600">
                                        @php
                                            $qtyFaktur = intval($prod->qty_faktur);
                                            $reduction = isset($mengurang[$index]) ? intval($mengurang[$index]) : 0;
                                            $produkDiterima = ProdukDiterima::where('id_pembelian', $prod->id_pembelian)
                                                ->where('id_produk', $prod->order->produk->id)
                                                ->sum('diterima');

                                            $hasil[$index] = $qtyFaktur - $reduction - $produkDiterima;
                                        @endphp

                                        {{ $hasil[$index] ?? $qtyFaktur }}
                                    </td>
                                    <td class="border border-slate-600">
                                        <input wire:model.live='mengurang.{{ $index }}' type="number"
                                            class="form-control">
                                    </td>
                                    <td class="border text-center border-slate-600">
                                        @if (isset($mengurang[$index]) && $hasil[$index] >= 0 && $mengurang[$index] != null)
                                            <input data-tw-merge type="checkbox" value="{{ $prod->order->id }}"
                                                wire:model='selectedProduk'
                                                class="transition-all duration-100 ease-in-out shadow-sm border-slate-200 cursor-pointer rounded focus:ring-4 focus:ring-offset-0 focus:ring-primary focus:ring-opacity-20 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&amp;[type=&#039;radio&#039;]]:checked:bg-primary [&amp;[type=&#039;radio&#039;]]:checked:border-primary [&amp;[type=&#039;radio&#039;]]:checked:border-opacity-10 [&amp;[type=&#039;checkbox&#039;]]:checked:bg-primary [&amp;[type=&#039;checkbox&#039;]]:checked:border-primary [&amp;[type=&#039;checkbox&#039;]]:checked:border-opacity-10 [&amp;:disabled:not(:checked)]:bg-slate-100 [&amp;:disabled:not(:checked)]:cursor-not-allowed [&amp;:disabled:not(:checked)]:dark:bg-darkmode-800/50 [&amp;:disabled:checked]:opacity-70 [&amp;:disabled:checked]:cursor-not-allowed [&amp;:disabled:checked]:dark:bg-darkmode-800/50"
                                                id="checkbox-switch" />
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="font-bold text-center border text-pending border-slate-600"
                                        colspan="7">
                                        Belum ada
                                        pembelian
                                        yang dipilih</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="flex justify-end mt-2">
                        <div class="btn btn-pending" wire:click='selectProduk'>Masuk Gudang </div>
                    </div>
                </div>
            </div>
        @endif


        {{-- <div class="flex justify-end mt-5">
        <button class="btn btn-primary" data-tw-toggle="modal" data-tw-target="#tambah">Tambah +</button>
    </div> --}}

        {{-- modal tambah --}}
        <div id="tambah" class="modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <livewire:terima-barang.tambah.pilih-produk :id="$id" />
            </div>
        </div>
        {{-- end modal tambah --}}
        <p class="mt-5 font-bold text-pending">Pemindahan ke gudang</p>
        <livewire:terima-barang.tambah.table-produk :id="$id" />
        <div class="flex justify-center gap-3 mt-5">
            <button class="btn btn-primary" id="btnSimpan" type="submit" wire:loading.remove>Simpan</button>
            <button class="btn btn-primary" disabled wire:loading>Menyimpan...</button>
            <a href="/terima-barang" class="btn btn-outline-danger">Batal</a>
        </div>
    </form>
</div>
