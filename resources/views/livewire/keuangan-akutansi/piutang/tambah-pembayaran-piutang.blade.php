<div>
    @php
        use App\Models\PiutangPengguna;
    @endphp
    <form wire:submit='simpanPembayaranPiutang'>
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
                            Metode
                        </label>
                        <div class="flex w-full gap-2">
                            <select data-tw-merge aria-label="Default select example" class="form-control"
                                wire:model.live='metode' {{ $disabled }}>
                                <option>- Pilih -</option>
                                {{-- <option value="pelanggan">Dari Data Pelanggan</option> --}}
                                <option value="tagihan">Dari Tagihan Pelanggan</option>
                            </select>
                        </div>
                    </div>
                    <div data-tw-merge class="items-center block mt-1 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            Akun Bayar
                        </label>
                        @if (!$id)
                            <div class="flex w-full gap-2" wire:ignore>
                                <select data-tw-merge aria-label="Default select example"
                                    class="font-bold form-control tom-select" wire:model='akun_bayar'>
                                    <option value="">- Pilih -</option>
                                    @foreach ($akuns as $akun)
                                        <option value="{{ $akun->id }}">
                                            {{ $akun->kode }} | {{ $akun->nama_akun }} </option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <input type="text" wire:model='akun_bayar' class="form-control">
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
        {{-- <div class="relative w-56 mt-1 text-slate-500">
            <input type="text" class="w-56 pr-10 form-control cari box" placeholder="Cari nomor faktur..."
                wire:model.debounce.300ms="searchTerm">
            <div class="" wire:ignore>
                <i class="absolute inset-y-0 right-0 w-4 h-4 my-auto mr-3" data-feather="search"></i>
            </div>
        </div> --}}
        @if ($metode == 'pelanggan')
            <div class="flex p-5 mt-1 box">
                <label for="" class="w-40 mt-2 font-bold text-pending">*Pilih Pelanggan</label>
                <select data-tw-merge aria-label="Default select example" class="w-64 form-control tom-select"
                    wire:model.live='pelanggan'>
                    <option value="">- Pilih -</option>
                    @foreach ($pelanggans as $pelanggan)
                        <option value="{{ $pelanggan->id }}">
                            {{ $pelanggan->nama }}</option>
                    @endforeach
                </select>
            </div>
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
                                <th class="border border-slate-600">Tgl. Jatuh Tempo</th>
                                <th class="border border-slate-600">Total Piutang</th>
                                <th class="border border-slate-600">Sisa Piutang</th>
                                <th class="border border-slate-600">Bayar</th>
                                <th class="border border-slate-600">Sisa</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($piutangPengguna as $index => $piutang)
                                @if ($piutang->sisa_hutang != 0)
                                    <tr class="text-center">
                                        <td class="border border-slate-600">{{ $loop->iteration }}</td>
                                        <td class="border border-slate-600">
                                            @if ($piutang->sumber == 'penjualan')
                                                {{ !is_null($piutang->penjualan) ? date('d-m-Y', strtotime($piutang->penjualan->tgl_faktur)) : '-' }}
                                            @elseif ($piutang->sumber == 'piutang awal')
                                                {{ !is_null($piutang->piutangAwal) ? date('d-m-Y', strtotime($piutang->piutangAwal->tgl_faktur)) : '-' }}
                                            @elseif (!is_null($piutang->penjualan))
                                                {{ date('d-m-Y', strtotime($piutang->penjualan->tgl_faktur)) }}
                                            @else
                                                -
                                            @endif
                                        </td>

                                        {{-- <td class="border border-slate-600">
                                            @if ($piutang->sumber == 'penjualan')
                                                {{ !is_null($piutang->penjualan) ? $piutang->penjualan->tgl_faktur : '-' }}
                                            @elseif($piutang->sumber == 'piutang awal')
                                                {{ !is_null($piutang->piutangAwal) ? $piutang->piutangAwal->tgl_faktur : '-' }}
                                            @elseif(!is_null($piutang->penjualan))
                                                {{ $piutang->penjualan->tgl_faktur }}
                                            @else
                                                -
                                            @endif
                                        </td> --}}
                                        <td class="border border-slate-600">
                                            @if ($piutang->sumber == 'penjualan')
                                                {{ !is_null($piutang->penjualan) ? $piutang->penjualan->no_faktur : '-' }}
                                            @elseif($piutang->sumber == 'piutang awal')
                                                {{ !is_null($piutang->piutangAwal) ? $piutang->piutangAwal->no_faktur : '-' }}
                                            @elseif(!is_null($piutang->penjualan))
                                                {{ $piutang->penjualan->no_faktur }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="border border-slate-600">
                                            @if ($piutang->sumber == 'penjualan')
                                                {{ !is_null($piutang->penjualan) ? date('d-m-Y', strtotime($piutang->penjualan->tempo_kredit)) : '-' }}
                                            @elseif($piutang->sumber == 'piutang awal')
                                                {{ !is_null($piutang->piutangAwal) ? date('d-m-Y', strtotime($piutang->piutangAwal->tgl_jth_tempo)) : '-' }}
                                            @elseif(!is_null($piutang->penjualan))
                                                {{ date('d-m-Y', strtotime($piutang->penjualan->tempo_kredit)) }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="border border-slate-600">
                                            {{ number_format($piutang->sisa_hutang, 0, ',', '.') }}</td>
                                        <td class="border border-slate-600">
                                            <input type="text" class="flex form-control" oninput="formatNumber(this)"
                                                wire:model.debounce.250ms='bayar.{{ $index }}'
                                                wire:change="hitungJumlah({{ $index }})">
                                        </td>
                                        <td class="border border-slate-600">
                                            <input type="text" class="flex form-control" disabled
                                                wire:model='sisa.{{ $index }}'
                                                value="{{ isset($sisa_hutang[$index]) ? number_format($sisa_hutang[$index], 0, ',', '.') : 0 }}">
                                            <p class="text-sm text-danger">{{ $error[$index] ?? '' }}</p>
                                        </td>
                                    </tr>
                                @endif
                            @empty
                                <tr>
                                    <td class="font-bold text-center border text-pending border-slate-600"
                                        colspan="7">Belum ada
                                        data tersedia</td>
                                </tr>
                            @endforelse
                            <tr>
                                <td colspan="4" class="font-bold text-center border border-slate-600">Total</td>
                                <td class="font-bold text-center border border-slate-600"></td>
                                <td class="font-bold text-center border border-slate-600">
                                    {{ $total_bayar ?? 0 }}</td>
                                <td class="font-bold text-center border border-slate-600"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @elseif($metode == 'tagihan')
            <div class="flex items-center p-3 mt-1 space-x-4 box">
                <!-- Pilih Tagihan Field -->
                @if (!$id)
                    <div class="flex-auto">
                        <label for="pilihTagihan" class="block font-normal text-pending">*Pilih Tagihan</label>
                        <select id="pilihTagihan" class="w-full form-control" wire:model.live='pilihTagihan'
                            onchange="updateBarcode()">
                            <option value="">- Pilih -</option>
                            @foreach ($tagihans as $tagihan)
                                <option value="{{ $tagihan->id }}" data-barcode="{{ $tagihan->barcode }}">
                                    {{ $tagihan->no_reff . ' | ' . $tagihan->areaRayon->area_rayon }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Scan Barcode Field -->
                    <div class="flex-auto ml-2">
                        <label for="barcode" class="block font-normal text-pending">*Scan Barcode</label>
                        <input type="text" id="barcode" class="w-full form-control"
                            placeholder="Scan or Enter Barcode" wire:model.live='barcodeTagihan'>
                    </div>
                @endif
            </div>


            <script>
                function updateBarcode() {
                    // Get the selected option
                    var selectElement = document.getElementById('pilihTagihan');
                    var selectedOption = selectElement.options[selectElement.selectedIndex];

                    // Get the barcode data attribute
                    var barcode = selectedOption.getAttribute('data-barcode');

                    // Set the barcode input value
                    document.getElementById('barcode').value = barcode;
                }
            </script>

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
                                <th class="border border-slate-600">No. Referensi</th>
                                <th class="border border-slate-600">No. Faktur</th>
                                <th class="border border-slate-600">Tgl. Faktur</th>
                                <th class="border border-slate-600">Tgl. Tempo</th>
                                <th class="border border-slate-600">Area Rayon</th>
                                <th class="border border-slate-600">Total Piutang</th>
                                <th class="border border-slate-600">Keterangan</th>
                                <th class="border border-slate-600">Bayar</th>
                                @if (!$id)
                                    <th class="border border-slate-600">Sisa</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @if ($tagihanPengguna)
                                @foreach ($piutangPengguna2 as $index => $tagihan)
                                    <tr class="text-center">
                                        <td class="border border-slate-600">{{ $loop->iteration }}</td>
                                        <td class="border border-slate-600">
                                            {{ $tagihan->penjualan->no_reff ?? $tagihan->piutangAwal->no_reff }}
                                        </td>
                                        <td class="border border-slate-600">
                                            {{ $tagihan->penjualan->no_faktur ?? $tagihan->piutangAwal->no_faktur }}
                                        </td>
                                        <td class="border border-slate-600">
                                            {{ optional($tagihan->penjualan)->tgl_faktur ? $tagihan->penjualan->tgl_faktur->format('d-m-Y') : optional($tagihan->piutangAwal)->tgl_faktur->format('d-m-Y') }}
                                        </td>
                                        <td class="border border-slate-600">
                                            {{ optional($tagihan->penjualan)->tempo_kredit ? $tagihan->penjualan->tempo_kredit->format('d-m-Y') : optional($tagihan->piutangAwal)->tempo_kredit->format('d-m-Y') }}
                                        </td>
                                        <td class="border border-slate-600">
                                            {{ $tagihan->getPelanggan->areaRayon->area_rayon }}</td>
                                        <td class="border border-slate-600">
                                            {{ number_format(str_replace('.', '', $tagihan->sisa_hutang), 0, ',', '.') }}
                                        </td>
                                        <td class="border border-slate-600">{{ $tagihanPengguna->keterangan }}
                                        </td>
                                        <td class="border border-slate-600">
                                            @if ($id)
                                                <input type="text" class="form-control"
                                                    value="{{ number_format($tagihan->nominal_bayar, 0, ',', '.') }}"
                                                    readonly>
                                            @else
                                                <input type="text" class="flex form-control"
                                                    oninput="formatNumber(this)"
                                                    wire:model.debounce.250ms='bayar.{{ $index }}'
                                                    wire:change="hitungJumlah({{ $index }})">
                                            @endif
                                        </td>
                                        @if (!$id)
                                            <td class="border border-slate-600">
                                                <input type="text" class="flex form-control" disabled
                                                    wire:model='sisa.{{ $index }}'
                                                    value="{{ number_format($sisa_hutang[$index] ?? 0) }}">
                                                <p class="text-sm text-danger">{{ $error[$index] ?? '' }}</p>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7"
                                        class="font-bold text-center border text-pending border-slate-600">
                                        Belum ada
                                        data tersedia</td>
                                </tr>
                            @endif
                            <tr>
                                <td colspan="6" class="font-bold text-center border border-slate-600">
                                    Total</td>
                                </td>
                                <td class="font-bold text-center border border-slate-600"></td>
                                <td class="font-bold text-center border border-slate-600"></td>
                                <td class="font-bold text-center border border-slate-600">
                                    @if ($id)
                                        {{ number_format($piutangPengguna2->sum('nominal_bayar'), 0, ',', '.') }}
                                    @else
                                        {{ $total_bayar ?? 0 }}
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
        @endif

        @if (!$id)
            <div class="flex justify-center gap-3 mt-5">
                @if ($metode)
                    <button class="px-10 btn btn-primary">Simpan</button>
                @endif
                <a href="/pembayaran-piutang" class="btn btn-outline-danger">Batal</a>
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
