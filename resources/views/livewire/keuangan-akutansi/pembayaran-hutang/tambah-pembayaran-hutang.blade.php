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
    <form wire:submit="simpanHutang">
        <div class="p-5 mt-5 box">
            <div class="grid-cols-2 gap-5 sm:grid">
                <div class="">
                    <div data-tw-merge class="items-center block mt-1 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            Tanggal
                        </label>
                        <input type="date" value="{{ now()->format('Y-m-d') }}"
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
                            Supplier
                        </label>
                        <div class="flex w-full gap-2">
                            <select data-tw-merge aria-label="Default select example" class="form-control"
                                wire:model.live='suplier'>
                                <option>- Pilih -</option>
                                @forelse ($supliers as $sup)
                                    <option value="{{ $sup->id }}">{{ $sup->nama_suplier }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <div data-tw-merge class="items-center block mt-1 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            Akun Bayar
                        </label>

                        @if ($id)
                        @else
                            <div class="flex w-full gap-2" wire:model='akun_bayar'>
                                <select data-tw-merge aria-label="Default select example" class="font-bold form-control"
                                    required>
                                    <option value="">- Pilih Akun -</option>
                                    @forelse ($akuns as $akun)
                                        <option value="{{ $akun->id }}">{{ $akun->kode }} | {{ $akun->nama_akun }}
                                        </option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                        @endif
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
        <div class="p-5 mt-1 box">
            <div class="overflow-auto">
                <table class="table">
                    <thead>
                        <tr class="header-gray">
                            <th class="border border-slate-600">No</th>
                            <th class="border border-slate-600">No. Faktur</th>
                            <th class="border border-slate-600">Tgl Faktur</th>
                            <th class="border border-slate-600">Tgl JT</th>
                            <th class="border border-slate-600">Total Hutang</th>
                            <th class="border border-slate-600">Sisa Hutang</th>
                            <th class="border border-slate-600">Bayar</th>
                            @if (!$id)
                                <th class="border border-slate-600">Sisa</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($hutangs as $index => $hutang)
                            <tr class="">
                                <td class="border border-slate-600">{{ $loop->iteration }}</td>
                                <td class="border border-slate-600">
                                    {{ $hutang->sourceable ? $hutang->sourceable->no_faktur : '-' ?? '-' }}
                                </td>
                                <td class="border border-slate-600 font-bold text-primary">
                                    {{ date('d-m-Y', strtotime($hutang->sourceable ? $hutang->sourceable->tgl_faktur : '-' ?? '-')) }}
                                </td>
                                <td class="border border-slate-600 font-bold text-pending">
                                    {{ date('d-m-Y', strtotime($hutang->sourceable ? $hutang->sourceable->tempo_kredit : '-' ?? '-')) }}
                                </td>
                                <td class="border border-slate-600">
                                    {{ number_format(str_replace('.', '', $hutang->total_hutang), 0, ',', '.') }}</td>
                                <td class="border border-slate-600">
                                    {{ number_format(str_replace('.', '', $hutang->sisa_hutang), 0, ',', '.') }}</td>
                                <td class="border border-slate-600 ">
                                    @if ($id)
                                        <input type="text" class="form-control" value="{{ $hutang->nominal_bayar }}"
                                            readonly>
                                    @else
                                        <input type="text" class="form-control"
                                            wire:model.live.debounce.150ms='bayar.{{ $index }}'
                                            wire:change="hitungJumlah({{ $index }})"
                                            oninput="formatNumber(this)">
                                    @endif
                                </td>
                                @if (!$id)
                                    <td class="border border-slate-600">
                                        <input type="text" class="form-control" disabled
                                            value="{{ number_format($sisa_hutang[$index] ?? 0, 0, ',', '.') }}"
                                            wire:model='sisa.{{ $index }}'>
                                        <p class="text-sm text-danger">{{ $error[$index] ?? '' }}</p>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td class="font-bold text-center border text-pending border-slate-600" colspan="8">
                                    Belum ada data
                                    hutang dipilih</td>
                            </tr>
                        @endforelse
                        <tr>
                            <td colspan="5" class="font-bold text-center border border-slate-600">Total</td>
                            <td class="font-bold text-center border border-slate-600">
                                {{-- {{ $hutangs->sum('sisa_hutang') }} --}}
                            </td>
                            <td class="font-bold text-center border border-slate-600">
                                @if ($id)
                                    {{ number_format(
                                        $hutangs->sum(function ($hutang) {
                                            return str_replace('.', '', $hutang->nominal_bayar);
                                        }),
                                        0,
                                        ',',
                                        '.',
                                    ) }}
                                @else
                                    {{ number_format($total_bayar, 0, ',', '.') ?? '' }}
                                @endif
                            </td>
                            @if (!$id)
                                <td class="font-bold text-center border border-slate-600"></td>
                            @endif
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        @if (!$id)
            <div class="flex justify-center gap-3 mt-5">
                <button class="px-10 btn btn-primary" type="submit" wire:loading.remove>Simpan</button>
                <button class="px-10 btn btn-primary" disabled wire:loading>Simpan</button>
                <a href="/pembayaran-hutang" class="btn btn-outline-danger">Batal</a>
            </div>
        @endif
    </form>
    <script>
        function formatNumber(input) {
            input.value = input.value.replace(/[^\d.]/g, '');

            let number = parseFloat(input.value.replace(/\./g, '').replace(',', '.')).toFixed(0);
            input.value = isNaN(number) ? '0' : new Intl.NumberFormat('id-ID').format(number);
        }
    </script>
</div>
