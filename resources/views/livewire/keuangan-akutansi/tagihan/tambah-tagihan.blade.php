<div>
    <form wire:submit='simpanTagihan'>
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
                            wire:model='no_reff' disabled
                            class="font-bold disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                    </div>
                    <div data-tw-merge class="items-center block mt-1 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            Kolektor
                        </label>
                        <div class="flex w-full gap-2">
                            <select data-tw-merge aria-label="Default select example" class="form-control" required
                                wire:model.live='kolektor'>
                                <option>- Pilih -</option>
                                @forelse ($kolektors as $pegawai)
                                    <option value="{{ $pegawai->id }}">{{ $pegawai->nama_pegawai }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <div data-tw-merge class="items-center block mt-1 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            Area Rayon
                        </label>
                        <div class="flex w-full gap-2">
                            <select data-tw-merge aria-label="Default select example" class="form-control" required
                                wire:model.live='area_rayon'>
                                <option>- Pilih -</option>
                                @forelse ($rayons as $rayon)
                                    <option value="{{ $rayon->id }}">{{ $rayon->area_rayon }}</option>
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
                        <textarea data-tw-merge id="horizontal-form-1" type="text" placeholder="" rows="5" wire:model='keterangan'
                            class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80"></textarea>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="relative w-56 mt-1 text-slate-500">
            <div data-tw-merge class="items-center block sm:flex">
                @include('components.search', [
                    'id_table' => 'tableHutang',
                ])
            </div>
            <input type="text" class="w-56 pr-10 form-control cari box" placeholder="Cari nomor faktur..."
                wire:model.live.debounce.150ms='cari'>
            <div class="" wire:ignore>
                <i class="absolute inset-y-0 right-0 w-4 h-4 my-auto mr-3" data-feather="search"></i>
            </div>
        </div> --}}
        <div class="p-5 mt-1 box">
            <div class="overflow-auto">
                <div class="relative shadow-md border: w-56 mt-1 ml-2 text-slate-600" wire:ignore>
                    {{-- <div data-tw-merge class="relative shadow-md block ml-3"> --}}
                    @include('components.search', [
                        'id_table' => 'tableHutang',
                    ])
                </div>
                <table class="table" id="tableHutang">
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
                    <thead>
                        <tr class="header-gray">
                            <th class="border border-slate-600">No</th>
                            <th class="border border-slate-600">Tgl. Faktur</th>
                            <th class="border border-slate-600">No. Faktur</th>
                            <th class="border border-slate-600">Pelanggan</th>
                            <th class="border border-slate-600">Salesman</th>
                            <th class="border border-slate-600">Total Piutang</th>
                            <th class="border border-slate-600">Jatuh Tempo</th>
                            <th class="border border-slate-600">Hari Tagih</th>
                            <th class="border border-slate-600">Total</th>
                            <th class="border border-slate-600">Pilih</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dataTagihan as $tagihan)
                            @if ($tagihan->sisa_hutang != 0)
                                <tr class="text-center">
                                    <td class="border border-slate-600">{{ $loop->iteration }}</td>
                                    <td class="border border-slate-600">
                                        {{ date('d-m-Y', strtotime(!is_null($tagihan->penjualan) ? $tagihan->penjualan->tgl_faktur : (!is_null($tagihan->piutangAwal) ? $tagihan->piutangAwal->tgl_faktur : ''))) }}
                                    </td>
                                    <td class="border border-slate-600">
                                        {{ !is_null($tagihan->penjualan) ? $tagihan->penjualan->no_faktur : (!is_null($tagihan->piutangAwal) ? $tagihan->piutangAwal->no_faktur : '') }}
                                    </td>
                                    <td class="font-bold border border-slate-600">{{ $tagihan->getPelanggan->nama }}
                                    </td>
                                    <td class="border border-slate-600">
                                        {{ $tagihan->getPelanggan->salesPelanggan->nama_pegawai }}</td>
                                    <td class="border border-slate-600">
                                        {{ number_format($tagihan->sisa_hutang, 0, ',', '.') ?? '-' }}
                                    </td>
                                    <td class="border border-slate-600">
                                        {{ date('d-m-Y', strtotime(!is_null($tagihan->penjualan) ? $tagihan->penjualan->tempo_kredit : (!is_null($tagihan->piutangAwal) ? $tagihan->piutangAwal->tgl_jth_tempo : ''))) }}
                                    <td class="border border-slate-600">{{ $tagihan->getPelanggan->hari_tagih }}</td>
                                    <td class="border border-slate-600">
                                        {{ number_format($tagihan->sisa_hutang, 0, ',', '.') }}
                                    </td>
                                    <td class="border border-slate-600">
                                        <div class="flex justify-center items-center text-center">
                                            @if (!in_array($tagihan->id, $unChecked))
                                                <input data-tw-merge type="checkbox" wire:model='selectedPiutang'
                                                    class="transition-all duration-100 ease-in-out shadow-sm border-slate-200 cursor-pointer rounded focus:ring-4 focus:ring-offset-0 focus:ring-primary focus:ring-opacity-20 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&amp;[type=&#039;radio&#039;]]:checked:bg-primary [&amp;[type=&#039;radio&#039;]]:checked:border-primary [&amp;[type=&#039;radio&#039;]]:checked:border-opacity-10 [&amp;[type=&#039;checkbox&#039;]]:checked:bg-primary [&amp;[type=&#039;checkbox&#039;]]:checked:border-primary [&amp;[type=&#039;checkbox&#039;]]:checked:border-opacity-10 [&amp;:disabled:not(:checked)]:bg-slate-100 [&amp;:disabled:not(:checked)]:cursor-not-allowed [&amp;:disabled:not(:checked)]:dark:bg-darkmode-800/50 [&amp;:disabled:checked]:opacity-70 [&amp;:disabled:checked]:cursor-not-allowed [&amp;:disabled:checked]:dark:bg-darkmode-800/50"
                                                    id="checkbox-switch-1" value="{{ $tagihan->id }}" />
                                            @else
                                                <p class="font-bold text-pending text-center">Sudah Terbuat</p>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td class="font-bold text-center border text-pending border-slate-600" colspan="10">
                                    Belum ada
                                    area
                                    rayon yang terpilih</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="flex justify-center gap-3 mt-5">
            <button class="px-10 btn btn-primary" type="submit" wire:loading.remove>Simpan</button>
            <button class="px-10 btn btn-primary" disabled wire:loading>Menyimpan...</button>
            <a href="/tagihan-pelanggan" class="btn btn-outline-danger">Batal</a>

        </div>
    </form>
</div>
