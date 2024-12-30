<div>
    <form wire:submit='simpanKontrabon'>
        <div class="p-5 mt-5 box">
            <div class="grid-cols-2 gap-5 sm:grid">
                <div class="">
                    <div data-tw-merge class="items-center block mt-1 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            Tanggal
                        </label>
                        <input data-tw-merge id="horizontal-form-1" type="date" placeholder="" wire:model='tgl_input'
                            class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                    </div>
                    <div data-tw-merge class="items-center block mt-1 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            No. Reff
                        </label>
                        <input data-tw-merge id="horizontal-form-1" type="text" placeholder="Auto"
                            wire:model='no_reff'
                            class="font-bold disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                    </div>
                    <div data-tw-merge class="items-center block mt-1 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            Pelanggan
                        </label>
                        <div class="flex w-full gap-2" wire:ignore>
                            <select data-tw-merge aria-label="Default select example"
                                class="font-bold form-control tom-select" wire:model.live='pelanggan' required>
                                <option value="">- Pilih Pelanggan -</option>
                                @forelse ($pelanggans as $pelanggan)
                                    <option value="{{ $pelanggan->id }}">{{ $pelanggan->nama }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <div data-tw-merge class="items-center block mt-1 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            Petugas
                        </label>
                        <div class="flex w-full gap-2">
                            <select data-tw-merge aria-label="Default select example" class="form-control"
                                wire:model='sales' required>
                                <option value="">- Pilih -</option>
                                @forelse ($salesman as $sal)
                                    <option value="{{ $sal->id }}">{{ $sal->nama_pegawai }} | {{ $sal->jabatan }}
                                    </option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                    </div>
                </div>
                <div data-tw-merge class="items-center block mt-2">
                    <div data-tw-merge class="items-center block">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            Keterangan
                        </label>
                        <textarea data-tw-merge id="horizontal-form-1" type="text" placeholder="" rows="7" wire:model='keterangan'
                            class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80"></textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal cari-pelanggan --}}
        {{-- <div id="cari-pelanggan" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="flex justify-center text-lg font-bold text-white modal-header bg-primary align-center">
                    Data Tagihan Pelanggan (Nama Pelanggan)
                </div>
                <div class="p-5 modal-body">
                    <div class="overflow-auto">
                        <div class="flex gap-3">
                            <div data-tw-merge class="flex items-center block gap-2 mt-1 mb-3">
                                <label data-tw-merge for="horizontal-form-1" class="inline-block mt-2 mb-2 sm:w-32">
                                    Hari Tagih
                                </label>
                                <select data-tw-merge aria-label="Default select example" class="form-control">
                                    <option>- Pilih -</option>
                                    <option>Box</option>
                                    <option>Botol</option>
                                </select>
                            </div>
                            <div data-tw-merge class="flex items-center block gap-2 mt-1 mb-3">
                                <label data-tw-merge for="horizontal-form-1" class="inline-block mt-2 mb-2 sm:w-32">
                                    Tgl JT
                                </label>
                                <input data-tw-merge id="horizontal-form-1" type="date" placeholder=""
                                    class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                            </div>
                            <div class="w-full form-check form-switch sm:w-auto sm:ml-auto sm:mt-0">
                                <div class="relative w-56 text-slate-500 ">
                                    <input type="text" class="w-56 pr-10 form-control" placeholder="Search...">
                                    <i class="absolute inset-y-0 right-0 w-4 h-4 my-auto mr-3"
                                        data-feather="search"></i>
                                </div>
                            </div>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="border border-slate-600">No</th>
                                    <th class="border border-slate-600">Tgl. Faktur</th>
                                    <th class="border border-slate-600">No. Faktur</th>
                                    <th class="border border-slate-600">Pelanggan</th>
                                    <th class="border border-slate-600">Jatuh Tempo</th>
                                    <th class="border border-slate-600">Total</th>
                                    <th class="border border-slate-600">Sales</th>
                                    <th class="border border-slate-600">Kolektor</th>
                                    <th class="border border-slate-600">Hari Tagih</th>
                                    <th class="border border-slate-600">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($piutangs as $piutang)
                                    <tr>
                                        <td class="border border-slate-600">Contoh Data</td>
                                        <td class="border border-slate-600">Contoh Data</td>
                                        <td class="border border-slate-600">Contoh Data</td>
                                        <td class="border border-slate-600">Contoh Data</td>
                                        <td class="border border-slate-600">Contoh Data</td>
                                        <td class="border border-slate-600">Contoh Data</td>
                                        <td class="border border-slate-600">Contoh Data</td>
                                        <td class="border border-slate-600">Contoh Data</td>
                                        <td class="border border-slate-600">Contoh Data</td>
                                        <td class="border border-slate-600">
                                            <input data-tw-merge type="checkbox"
                                                class="transition-all duration-100 ease-in-out shadow-sm border-slate-200 cursor-pointer rounded focus:ring-4 focus:ring-offset-0 focus:ring-primary focus:ring-opacity-20 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&amp;[type=&#039;radio&#039;]]:checked:bg-primary [&amp;[type=&#039;radio&#039;]]:checked:border-primary [&amp;[type=&#039;radio&#039;]]:checked:border-opacity-10 [&amp;[type=&#039;checkbox&#039;]]:checked:bg-primary [&amp;[type=&#039;checkbox&#039;]]:checked:border-primary [&amp;[type=&#039;checkbox&#039;]]:checked:border-opacity-10 [&amp;:disabled:not(:checked)]:bg-slate-100 [&amp;:disabled:not(:checked)]:cursor-not-allowed [&amp;:disabled:not(:checked)]:dark:bg-darkmode-800/50 [&amp;:disabled:checked]:opacity-70 [&amp;:disabled:checked]:cursor-not-allowed [&amp;:disabled:checked]:dark:bg-darkmode-800/50"
                                                id="checkbox-switch-1" value="" />
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="border border-slate-600">Pelanggan belum dipilih</td>
                                    </tr>
                                @endforelse
                                <tr>
                                    <td colspan="5" class="font-bold text-center border border-slate-600">Total
                                    </td>
                                    <td class="font-bold text-center border border-slate-600"></td>
                                    <td class="font-bold text-center border border-slate-600"></td>
                                    <td class="font-bold text-center border border-slate-600"></td>
                                    <td class="font-bold text-center border border-slate-600"></td>
                                    <td class="font-bold text-center border border-slate-600"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-tw-dismiss="modal">Batal</button>
                    <button class="btn btn-primary">Pilih</button>
                </div>
            </div>
        </div>
    </div> --}}
        {{-- End Modal daftar --}}
        {{-- <div class="relative w-56 mt-1 text-slate-600">
            <input type="text" class="w-56 pr-10 form-control cari box" placeholder="Cari nomor faktur..."
                wire:model.live.debounce.150ms='cari'>
            <div class="" wire:ignore>
                <i class="absolute inset-y-0 right-0 w-4 h-4 my-auto mr-3" data-feather="search"></i>
            </div>
        </div> --}}
        <div class="p-5 mt-2 box">
            <div class="overflow-auto">
                <div class="relative shadow-md border: w-56 mt-1 ml-2 text-slate-600">
                    <input type="text" class="w-56 pr-10 form-control cari box" placeholder="Cari nomor faktur..."
                        wire:model.live.debounce.150ms='cari'>
                    <div class="" wire:ignore>
                        <i class="absolute inset-y-0 right-0 w-4 h-4 my-auto mr-3" data-feather="search"></i>
                    </div>
                </div>
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
                            <th class="border border-slate-600">No</th>
                            <th class="border border-slate-600">Tgl. Faktur</th>
                            <th class="border border-slate-600">No. Faktur</th>
                            <th class="border border-slate-600">Sales</th>
                            <th class="border border-slate-600">Jatuh Tempo</th>
                            <th class="border border-slate-600">Total</th>
                            <th class="border border-slate-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($piutangs as $piutang)
                            @if ($piutang->sisa_hutang != 0)
                                <tr class="text-center">
                                    <td class="border border-slate-600">{{ $loop->iteration }}</td>
                                    <td class="border border-slate-600">
                                        {{ date('d-m-Y', strtotime(!is_null($piutang->penjualan) ? $piutang->penjualan->tgl_faktur : (!is_null($piutang->piutangAwal) ? $piutang->piutangAwal->tgl_faktur : ''))) }}
                                    </td>
                                    <td class="border border-slate-600">
                                        {{ !is_null($piutang->penjualan) ? $piutang->penjualan->no_faktur : (!is_null($piutang->piutangAwal) ? $piutang->piutangAwal->no_faktur : '') }}
                                    </td>
                                    <td class="border border-slate-600">
                                        {{ $piutang->getPelanggan->salesPelanggan->nama_pegawai }}</td>
                                    <td class="border border-slate-600">
                                        {{ date('d-m-Y', strtotime(!is_null($piutang->penjualan) ? $piutang->penjualan->tempo_kredit : (!is_null($piutang->piutangAwal) ? $piutang->piutangAwal->tgl_jth_tempo : ''))) }}
                                    </td>
                                    <td class="border border-slate-600">
                                        {{ number_format($piutang->sisa_hutang, 0, ',', '.') }}</td>
                                    <td class="text-center border border-slate-600">
                                        <input data-tw-merge type="checkbox" wire:model='selectedPiutang'
                                            class="transition-all duration-100 ease-in-out shadow-md border-slate-200 cursor-pointer rounded focus:ring-4 focus:ring-offset-0 focus:ring-primary focus:ring-opacity-20 dark:bg-darkmode-800 dark:transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&amp;[type=&#039;radio&#039;]]:checked:bg-primary [&amp;[type=&#039;radio&#039;]]:checked:border-primary [&amp;[type=&#039;radio&#039;]]:checked:border-opacity-10 [&amp;[type=&#039;checkbox&#039;]]:checked:bg-primary [&amp;[type=&#039;checkbox&#039;]]:checked:border-primary [&amp;[type=&#039;checkbox&#039;]]:checked:border-opacity-10 [&amp;:disabled:not(:checked)]:bg-slate-100 [&amp;:disabled:not(:checked)]:cursor-not-allowed [&amp;:disabled:not(:checked)]:dark:bg-darkmode-800/50 [&amp;:disabled:checked]:opacity-70 [&amp;:disabled:checked]:cursor-not-allowed [&amp;:disabled:checked]:dark:bg-darkmode-800/50"
                                            id="checkbox-switch-1" value="{{ $piutang->id }}" />
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td class="font-bold text-center border text-pending border-slate-600" colspan="7`">
                                    Pelanggan belum
                                    dipilih</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="flex justify-center gap-3 mt-5">
            <button class="px-10 btn btn-primary" type="submit">Simpan</button>
            <a href="/kontrabon" class="btn btn-outline-danger">Batal</a>
        </div>
    </form>
</div>
