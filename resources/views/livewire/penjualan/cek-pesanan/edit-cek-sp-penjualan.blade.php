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
    <form wire:submit='simpanCekSPPenjualan'>
        @php
            use App\Models\Satuan;
            use App\Models\HistoryStok;
        @endphp
        <div class="p-5 mt-5 box">

            <div class="grid-cols-2 gap-5 sm:grid">
                <div class="">
                    <div data-tw-merge class="items-center block mt-1 sm:flex">
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
                        <div class="flex w-full item-center">
                            <input data-tw-merge id="horizontal-form-1" type="text" placeholder=""
                                wire:model='pelanggan' readonly
                                class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                            {{-- <div class="ml-2 btn btn-sm btn-primary" data-tw-toggle="modal" data-tw-target="#daftar-pelanggan">
                                Cari
                            </div> --}}
                        </div>
                    </div>
                    <div data-tw-merge class="items-center block mt-1 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            Sales
                        </label>
                        <input data-tw-merge id="horizontal-form-1" type="text" placeholder="" wire:model='sales'
                            readonly
                            class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                    </div>
                    <div data-tw-merge class="items-center block mt-1 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            Tipe SP
                        </label>
                        <select data-tw-merge aria-label="Default select example" class="font-bold form-control"
                            wire:model='tipe_sp' required disabled>
                            <option value="">- Pilih -</option>
                            <option>SP. Reguler</option>
                            <option>SP. OOT</option>
                            <option>SP. Prekursor</option>
                            <option>SP. Psikotropika</option>
                            <option>SP. Narkotika</option>
                            <option>SP. Bonus</option>
                        </select>
                    </div>

                    <div class="items-center block mt-1 form-switch sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-40">
                            Sudah Di Cek
                        </label>
                        <input id="checkbox-switch-7" class="mx-3 form-check-input" type="checkbox"
                            wire:model='status_cek' {{ $status_cek == 1 ? 'checked' : '' }} required>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal daftar-pelanggan --}}
        <div id="daftar-pelanggan" class="modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <livewire:penjualan.sp-penjualan.modal-daftar-pelanggan />
            </div>
        </div>
        {{-- End Modal daftar --}}
        <div class="p-5 mt-1 box">
            <div class="overflow-auto">
                <table class="table">
                    <thead>
                        <tr class="header-gray">
                            <td class="border border-slate-600">No</td>
                            <td class="border border-slate-600">Barcode</td>
                            <td class="border border-slate-600">Nama Produk </td>
                            <td class="border border-slate-600">Golongan</td>
                            <td class="border border-slate-600 whitespace-nowrap">Qty SP</td>
                            <td class="border border-slate-600">Satuan</td>
                            <td class="border border-slate-600">Pengambilan</td>
                            <td class="border border-slate-600">Batch</td>
                            <td class="border border-slate-600">Exp Date</td>
                            <td class="border border-slate-600">Stok Real</td>
                            <td class="border border-slate-600">Terpesan</td>
                            <td class="border border-slate-600">Sisa Stock</td>
                            <td class="border border-slate-600">Gudang</td>
                            <td class="border border-slate-600">Rak</td>
                            <td class="border border-slate-600">Sub Rak</td>
                            <td class="border border-slate-600">Qty</td>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($produks as $key => $prod)
                            <tr>
                                <td class="border border-slate-600 whitespace-nowrap">{{ $loop->iteration }}
                                    <input type="hidden" wire:model='penyimpanan.{{ $key }}.id_produk'
                                        class="w-32 form-control" readonly>
                                </td>
                                <td class="border border-slate-600 whitespace-nowrap">
                                    {{ $prod->produk->barcode_produk }}
                                    @if ($prod->produk_tambahan == 0)
                                        <div class="btn btn-outline-primary btn-sm"
                                            wire:click='tambahProduk({{ $prod->id }})'
                                            wire:confirm='Apakah anda yakin akan menambah produk?'>+</div>
                                    @else
                                        <div class="btn btn-outline-danger btn-sm"
                                            wire:click='hapusProduk({{ $prod->id }})'
                                            wire:confirm='Yakin untuk menghapus produk?'
                                            wire:confirm='Apakah anda yakin akan menghapus porduk?'>-</div>
                                    @endif
                                </td>
                                <td class="border border-slate-600 whitespace-nowrap">
                                    {{ $prod->produk->nama_obat_barang }}
                                </td>
                                <td class="border border-slate-600 whitespace-nowrap">
                                    {{ $prod->produk->golonganProduk->sub_golongan }}
                                </td>
                                <td class="border border-slate-600 whitespace-nowrap">{{ $prod->qty_sp }}</td>
                                <td class="border border-slate-600 whitespace-nowrap">
                                    {{ Satuan::find($prod->satuan)->satuan }}
                                </td>
                                <td class="border border-slate-600 whitespace-nowrap">
                                    <select data-tw-merge aria-label="Default select w-40 example"
                                        class="w-60 form-control" required
                                        wire:model="penyimpanan.{{ $key }}.selectedBatch"
                                        wire:change="updateStorageData({{ $key }})" style="width: 100px;">
                                        <option value="">- Pilih -</option>
                                        {{-- <option value="{{ json_encode(['sumber' => 'kosong']) }}">Stok Kosong</option> --}}
                                        @forelse ($listStok->where('id_produk', $prod->produk->id) as $list)
                                            @if ($list->sisaStokBatch($list->id_produk, $list->no_batch, $list->id_gudang, $list->id_rak, $list->id_sub_rak) != 0)
                                                <option value="{{ $list->id }}">
                                                    {{ $list->no_batch . ' | ' . $list->gudang->gudang . ' | ' . $list->rak->rak . ' | ' . $list->subRak->sub_rak }}
                                                </option>
                                            @endif
                                        @empty
                                        @endforelse
                                        <option value="kosong">--Tidak Tersedia--</option>
                                    </select>
                                </td>
                                <td class="border border-slate-600 whitespace-nowrap">
                                    <input type="text" wire:model='penyimpanan.{{ $key }}.no_batch'
                                        class="w-32 form-control" readonly>
                                </td>
                                <td class="border border-slate-600 whitespace-nowrap">

                                    <input type="date" wire:model='penyimpanan.{{ $key }}.exp_date'
                                        class="w-32 form-control" readonly>
                                </td>
                                <td class="border border-slate-600 whitespace-nowrap">

                                    <input type="number" wire:model='penyimpanan.{{ $key }}.stok_real'
                                        class="w-32 form-control" readonly>
                                </td>
                                <td class="border border-slate-600 whitespace-nowrap">
                                    <input type="text" wire:model='penyimpanan.{{ $key }}.terpesan'
                                        class="w-32 form-control" readonly>
                                </td>
                                <td class="border border-slate-600 whitespace-nowrap">
                                    <input type="text" wire:model='penyimpanan.{{ $key }}.sisa_stok'
                                        class="w-32 form-control" readonly>
                                </td>
                                <td class="border border-slate-600 whitespace-nowrap">
                                    <input type="text" wire:model='penyimpanan.{{ $key }}.gudang'
                                        class="w-32 form-control" readonly>
                                </td>
                                <td class="border border-slate-600 whitespace-nowrap">
                                    <input type="text" wire:model='penyimpanan.{{ $key }}.rak'
                                        class="w-32 form-control" readonly>
                                </td>
                                <td class="border border-slate-600 whitespace-nowrap">
                                    <input type="text" wire:model='penyimpanan.{{ $key }}.sub_rak'
                                        class="w-32 form-control" readonly>
                                </td>
                                <td class="w-32 border border-slate-600 whitespace-nowrap">
                                    <div class="flex gap-2">
                                        <input type="number" min="0"
                                            data-id="{{ $prod->id_produk }}-{{ $prod->satuan }}"
                                            data-max="{{ $prod->qty_sp }}" max="{{ $prod->qty_sp }}"
                                            class="w-24 form-control qty"
                                            wire:model='penyimpanan.{{ $key }}.qty' required>
                                        <div class="btn btn-sm btn-pending" data-tw-toggle="modal"
                                            data-tw-target="#cek-barcode-produk{{ $prod->id }}">Cek Barcode</div>
                                    </div>
                                </td>
                            </tr>
                            {{-- modal --}}
                            <div class="" wire:ignore>
                                <div id="cek-barcode-produk{{ $prod->id }}" class="modal" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <livewire:penjualan.cek-pesanan.cek-barcode-produk :index="$key" />
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td class="font-bold text-center text-pending" colspan="16">Belum ada data tersedia
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="p-5 mt-1 box">
            <div data-tw-merge class="items-center block mt-3">
                <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                    Keterangan
                </label>
                <textarea data-tw-merge id="horizontal-form-1" type="text" placeholder="" rows="5" wire:model='keterangan'
                    class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80"></textarea>
            </div>
        </div>
        <div class="flex justify-center gap-3 mt-5">
            <button class="px-10 btn btn-primary" type="submit" wire:loading.remove>Simpan</button>
            <button class="px-10 btn btn-primary" disabled wire:loading>Menyimpan...</button>
            <div class="btn btn-outline-danger"><a href="/cek-sp-penjualan">Batal</a></div>
        </div>
    </form>
    <script>
        document.addEventListener('livewire:load', function() {
            Livewire.on('produkDitambahkan', function() {
                Livewire.emit('refreshComponent');
            });
        });
    </script>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        Livewire.on('stok-tidak-cukup', postId => {
            if (confirm(
                    'Terdapat stock yang tidak mencukupi, apakah Anda ingin melanjutkan?'
                )) {
                // Jika pengguna memilih "OK", lanjutkan proses
                Livewire.dispatch('lanjutkanProses');
            } else {
                // Jika pengguna memilih "Cancel", hentikan proses
                // Anda dapat menambahkan logika tambahan jika diperlukan
            }
        })
        const qtyInputs = document.querySelectorAll('.qty');

        function checkQuantities(event) {

            const changedInput = event.target;
            if (!changedInput) return;
            const id = changedInput.dataset.id;
            if (!id) {
                return;
            }
            const max = parseInt(changedInput.dataset.max) || 0;

            let total = 0;

            qtyInputs.forEach(input => {
                if (input.dataset.id === id) {
                    total += parseInt(input.value) || 0;
                }
            });

            if (total > max) {
                alert(`Jumlah input melebihi permintaan`);
                changedInput.value = '';
            }

        }
        qtyInputs.forEach(input => {
            input.addEventListener('change', checkQuantities);
        });


    });
</script>
