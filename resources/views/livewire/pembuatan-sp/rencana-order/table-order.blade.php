<div>
    @php
        use App\Models\RencanaOrder;
        use App\Models\NoSPPembelian;
    @endphp
    <div
        class="flex flex-col items-center p-2 border-b sm:flex-row bg-primary border-slate-200/60 dark:border-darkmode-400">
        <h2 class="mr-auto text-base font-medium text-white">
            {{ $nama_suplier }}
        </h2>
        <div class="w-full mt-3 form-check form-switch sm:w-auto sm:ml-auto sm:mt-0">
            <div class="relative w-56 mr-auto text-slate-500">
                <input type="text" class="w-56 pr-10 form-control box" wire:model.live='search'
                    placeholder="Search Nama Produk ...">
                <i class="absolute inset-y-0 right-0 w-4 h-4 my-auto mr-3" data-feather="search"></i>
            </div>
        </div>
    </div>
    <div class="flex justify-end gap-3 mt-3 mb-3">
        <button class=" btn btn-outline-primary" data-tw-toggle="modal"
            data-tw-target="#tambah-produk{{ $sup->id }}">Tambah
            Produk +</button>
    </div>
    <div class="overflow-auto">

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
                    <th class="text-center border border-slate-600">
                        <input data-tw-merge type="checkbox" wire:model.live='selectAll'
                            class="transition-all duration-100 ease-in-out shadow-sm border-slate-200 cursor-pointer rounded focus:ring-4 focus:ring-offset-0 focus:ring-primary focus:ring-opacity-20 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&amp;[type=&#039;radio&#039;]]:checked:bg-primary [&amp;[type=&#039;radio&#039;]]:checked:border-primary [&amp;[type=&#039;radio&#039;]]:checked:border-opacity-10 [&amp;[type=&#039;checkbox&#039;]]:checked:bg-primary [&amp;[type=&#039;checkbox&#039;]]:checked:border-primary [&amp;[type=&#039;checkbox&#039;]]:checked:border-opacity-10 [&amp;:disabled:not(:checked)]:bg-slate-100 [&amp;:disabled:not(:checked)]:cursor-not-allowed [&amp;:disabled:not(:checked)]:dark:bg-darkmode-800/50 [&amp;:disabled:checked]:opacity-70 [&amp;:disabled:checked]:cursor-not-allowed [&amp;:disabled:checked]:dark:bg-darkmode-800/50"
                            id="checkbox-switch-6" />
                    </th>
                    <th class="border border-slate-600">Nama Produk</th>
                    <th class="border border-slate-600">Golongan</th>
                    <th class="border border-slate-600">Jenis Produk</th>
                    <th class="border border-slate-600">Jumlah Order</th>
                    <th class="border border-slate-600">Satuan</th>
                    <th class="border border-slate-600">Keterangan</th>
                    <th class="border border-slate-600">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr class="intro-x">
                        <td class="text-center border border-slate-600">
                            <input data-tw-merge type="checkbox" wire:model.live="updateTypes"
                                class="transition-all duration-100 ease-in-out shadow-sm border-slate-200 cursor-pointer rounded focus:ring-4 focus:ring-offset-0 focus:ring-primary focus:ring-opacity-20 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&amp;[type=&#039;radio&#039;]]:checked:bg-primary [&amp;[type=&#039;radio&#039;]]:checked:border-primary [&amp;[type=&#039;radio&#039;]]:checked:border-opacity-10 [&amp;[type=&#039;checkbox&#039;]]:checked:bg-primary [&amp;[type=&#039;checkbox&#039;]]:checked:border-primary [&amp;[type=&#039;checkbox&#039;]]:checked:border-opacity-10 [&amp;:disabled:not(:checked)]:bg-slate-100 [&amp;:disabled:not(:checked)]:cursor-not-allowed [&amp;:disabled:not(:checked)]:dark:bg-darkmode-800/50 [&amp;:disabled:checked]:opacity-70 [&amp;:disabled:checked]:cursor-not-allowed [&amp;:disabled:checked]:dark:bg-darkmode-800/50"
                                id="checkbox-switch-6" value='{{ $order->id }}' />
                        </td>
                        <td class="border border-slate-600">{{ $order->produk->nama_obat_barang }}</td>
                        <td class="border text-center border-slate-600">
                            {{ $order->produk->golonganProduk->sub_golongan }}</td>
                        <td class="border text-center border-slate-600">{{ $order->produk->jenis_obat_barang }}</td>
                        <td class="border text-center border-slate-600">{{ $order->jumlah_order }}</td>
                        <td class="border text-center border-slate-600">{{ $order->produk->satuanDasar->satuan }}</td>
                        <td class="border border-slate-600">{{ $order->keterangan }}</td>
                        <td class="border text-center border-slate-600">
                            <button class="btn btn-outline-danger btn-sm" wire:loading.remove
                                wire:click="deleteProduk({{ $order->id }})"
                                wire:confirm="Anda yakin akan menghapus produk?">
                                Delete
                            </button>
                            <button class="btn btn-danger btn-sm" wire:loading
                                wire:target="deleteProduk({{ $order->id }})">
                                Menghapus...
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr class="intro-x">
                        <td class="font-bold text-center border text-pending border-slate-600" colspan="8">Belum ada
                            data
                            tersedia
                        </td>
                    </tr>
                @endforelse
                <tr>
                    <td colspan="8" class="text-right">
                        Jumlah Item : {{ count($updateTypes) }}
                        @if (NoSPPembelian::where('id_perusahaan', Auth::user()->id_perusahaan)->first())
                            <button class="text-white btn btn-success btn-sm" data-tw-toggle="modal"
                                wire:click='updateProduk' data-tw-target="#buat-sp{{ $sup->id }}">Buat
                                SP +</button>
                        @else
                            <button disabled class="btn btn-pending">No Sp Belum di set</button>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
