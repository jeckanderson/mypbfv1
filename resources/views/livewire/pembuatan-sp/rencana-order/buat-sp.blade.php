<div class="modal-content">
    @php
        use App\Models\ObatBarang;
        use App\Models\RencanaOrder;
    @endphp
    <form wire:submit.prevent="buatSP">
        <div class="modal-header border-b border-gray-200 dark:border-gray-700 pb-4">
            <h2 class="text-lg text-primary font-semibold text-gray-900 dark:text-gray-100">Supplier
                {{ $sup->nama_suplier }}</h2>
        </div>
        <div class="p-2 modal-body">
            @include('components.alert')
            <div data-tw-merge class="flex items-center mt-1">
                <label data-tw-merge for="horizontal-form-1" class="inline-block mt-2 mb-2 sm:w-32">
                    Tgl SP
                </label>
                <input type="date" id="" class="w-full form-control" required wire:model='tgl_sp'>
            </div>
            <div data-tw-merge class="flex items-center mt-1">
                <label data-tw-merge for="horizontal-form-1" class="inline-block mt-2 mb-2 sm:w-32">
                    Tipe SP
                </label>
                <select data-tw-merge aria-label="Default select example" class="w-full form-control"
                    wire:model.live="tipe">
                    <option>- Pilih -</option>
                    <option value="REG">SP. Reguler</option>
                    <option value="OOT">SP. OOT</option>
                    <option value="Prek">SP. Prekursor</option>
                    <option value="Psiko">SP. Psikotropika</option>
                    <option value="Narko">SP. Narkotika</option>
                </select>
            </div>
            <div data-tw-merge class="flex items-center mt-1">
                <label data-tw-merge for="horizontal-form-1" class="inline-block mt-2 mb-2 sm:w-32">
                    No Sp
                </label>
                <div class="flex w-full gap-3">
                    <input type="text" name="" id=""
                        class="w-full form-control font-bold text-pending" required wire:model="noSp"
                        {{ $disabled }}>
                    <input data-tw-merge type="checkbox"
                        class="transition-all mt-2 ml-3 duration-100 ease-in-out shadow-sm border-slate-200 cursor-pointer rounded focus:ring-4 focus:ring-offset-0 focus:ring-primary focus:ring-opacity-20 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&amp;[type=&#039;radio&#039;]]:checked:bg-primary [&amp;[type=&#039;radio&#039;]]:checked:border-primary [&amp;[type=&#039;radio&#039;]]:checked:border-opacity-10 [&amp;[type=&#039;checkbox&#039;]]:checked:bg-primary [&amp;[type=&#039;checkbox&#039;]]:checked:border-primary [&amp;[type=&#039;checkbox&#039;]]:checked:border-opacity-10 [&amp;:disabled:not(:checked)]:bg-slate-100 [&amp;:disabled:not(:checked)]:cursor-not-allowed [&amp;:disabled:not(:checked)]:dark:bg-darkmode-800/50 [&amp;:disabled:checked]:opacity-70 [&amp;:disabled:checked]:cursor-not-allowed [&amp;:disabled:checked]:dark:bg-darkmode-800/50"
                        id="checkbox-switch-6" value="" checked wire:model.live='active' />
                </div>
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
                            <td class="border text-center border-slate-600">No</td>
                            <td class="border text-center border-slate-600">Nama Produk</td>
                            <td class="border text-center border-slate-600">Golongan</td>
                            <td class="border text-center border-slate-600">Jenis Produk</td>
                            <td class="border text-center border-slate-600">Jumlah Order</td>
                            <td class="border text-center border-slate-600">Satuan</td>
                            <td class="border text-center border-slate-600">Keterangan</td>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $prod)
                            @php
                                $order = RencanaOrder::where('id', $prod)->first();
                            @endphp
                            <tr>
                                <td class="border border-slate-600">{{ $loop->iteration }}</td>
                                <td class="border border-slate-600">{{ $order->produk->nama_obat_barang }}</td>
                                <td class="border text-center border-slate-600">
                                    {{ $order->produk->golonganProduk->sub_golongan }}
                                </td>
                                <td class="border text-center border-slate-600">{{ $order->produk->jenis_obat_barang }}
                                </td>
                                <td class="border text-center border-slate-600">
                                    {{ $order->jumlah_order }}
                                </td>
                                <td class="border text-center border-slate-600">
                                    {{ $order->produk->satuanDasar->satuan }}</td>
                                <td class="border border-slate-600">
                                    {{ $order->keterangan }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td class="font-bold text-center text-pending border border-slate-600" colspan="7">
                                    Belum ada
                                    produk yang dipilih!</td>
                            </tr>
                        @endforelse
                        <tr>
                            <td colspan="7" class="font-bold text-pending border border-slate-600">Jumlah
                                : {{ count($products) }} Item Produk
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div data-tw-merge class="items-center mt-3">
                <label data-tw-merge for="horizontal-form-1" class="inline-block mt-2 mb-2 sm:w-32">
                    Keterangan
                </label>
                <textarea type="text" wire:model="keterangan" class="form-control" placeholder="Masukan keterangan" rows="5"></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" wire:loading.remove type="submit">Simpan</button>
            <button wire:loading class="btn btn-primary" disabled>
                Menyimpan...
            </button>
            <button class="mt-5 btn btn-outline-danger" data-tw-dismiss="modal" type="button"> Batal </button>
        </div>
    </form>
</div>
