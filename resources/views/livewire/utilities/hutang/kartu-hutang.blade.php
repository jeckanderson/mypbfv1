<div>
    <div class="gap-2 mt-8">

        <div class="col-span-6 md:col-span-3">
            <label for="tanggal-dari" class="inline-block mt-1 ml-1 sm:w-auto text-sm">Tgl.Faktur</label>
            <div class="flex justify-between">
                <div class="flex items-center w-1/4 ">
                    <div>
                        <input id="tanggal-dari" name="mulaiId" wire:model.live="mulaiId" type="date"
                            placeholder="Stok dari master" style="width: full;"
                            class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&[readonly]]:bg-slate-100 [&[readonly]]:cursor-not-allowed [&[readonly]]:dark:bg-darkmode-800 [&[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                    </div>
                    <label for="tanggal-sampai" class="inline-block mt-2 mb-2 ml-2 text-center sm:w-auto">s.d</label>
                    <div class="ml-2">
                        <input id="tanggal-sampai" wire:model.live="selesaiId" name="selesaiId" type="date"
                            placeholder="Stok dari master" style="width: full;"
                            class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&[readonly]]:bg-slate-100 [&[readonly]]:cursor-not-allowed [&[readonly]]:dark:bg-darkmode-800 [&[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                    </div>
                </div>
                <div
                    class="ml-auto p-3 text-lg font-bold text-pending border border-slate-300 rounded-lg shadow-sm bg-white">
                    Total Hutang : {{ number_format($total, 0, ',', '.') }}
                </div>

            </div>

            <div class="flex items-center w-1/4 gap-2 mb-2" wire:ignore>
                {{-- <label data-tw-merge for="sales" class="inline-block mt-2 mb-2 sm:w-20">
                    Supplier
                </label> --}}
                <select data-tw-merge id="sales" aria-label="Default select example" wire:model.live="spId"
                    class="rounded-md form-control tom-select w-full">
                    <option value="w-full">Supplier</option>
                    @foreach ($suplier as $item)
                        <option value="{{ $item->id }}">{{ $item->nama_suplier }}</option>
                    @endforeach
                </select>
                <button onclick="location.reload()" class="btn btn-md btn-secondary" wire:ignore>
                    <i data-feather="refresh-cw" class="w-4 h-4 mr-1"></i> Reload
                </button>
                <div class="col-span-5 md:col-span-2">
                    <div class="w=full flex gap-2 justify-end">
                        <button class="text-white btn btn-success" wire:click="exportExcel" wire:ignore>
                            <i data-feather="file-text" class="w-4 h-4 mr-1"></i> Excel
                        </button>
                        <a href="{{ route('print_kartu_hutang', [
                            'search' => $search,
                            'spId' => $spId,
                            'mulaiId' => $mulaiId,
                            'selesaiId' => $selesaiId,
                        ]) }}"
                            target="_blank" class="btn btn-facebook">
                            <div class="flex gap-1"wire:ignore>
                                <i data-feather="printer" class="w-4 h-4 mr-1"></i> Print
                            </div>
                        </a>
                    </div>
                </div>
                <div class="text-center" wire:loading wire:target="print">
                    Loading PDF...
                </div>
            </div>
            {{-- <div class="col-span-5 md:col-span-2">
                <div class="w=full flex gap-2 justify-end">
                    <button class="text-white btn btn-success" wire:click="exportExcel" wire:ignore>
                        <i data-feather="file-text" class="w-4 h-4 mr-1"></i> Excel
                    </button>
                    <a href="{{ route('print_kartu_hutang', [
                        'search' => $search,
                        'spId' => $spId,
                        'mulaiId' => $mulaiId,
                        'selesaiId' => $selesaiId,
                    ]) }}"
                        target="_blank" class="btn btn-facebook">
                        <div class="flex gap-1"wire:ignore>
                            <i data-feather="printer" class="w-4 h-4 mr-1"></i> print
                        </div>
                    </a>
                </div>
            </div>
            <div class="text-center" wire:loading wire:target="print">
                Loading PDF...
            </div> --}}
        </div>
    </div>
    @forelse ($data as $i => $item)
        <div class="col-span-12 overflow-auto intro-y lg:overflow-visible">
            <div class="mt-2 intro-y box">
                <div
                    class="flex flex-col items-center p-1 border-b sm:flex-row bg-primary border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="flex w-1/2 gap-3 my-1 font-bold text-white text-md">
                        <label for="">{{ $item['name'] }}</label>
                        <label for="w-60">Total Hutang :</label>
                        <label for="">{{ number_format($item['total'], 0, ',', '.') }}</label>
                    </h2>
                </div>

                <div class="col-span-12 overflow-auto intro-y lg:overflow-visible">
                    <div class="overflow-auto">
                        @foreach ($item['piutang'] as $hutang)
                            <table class="table mt-2 table-auto bg-slate-600">
                                <style>
                                    .border {
                                        border: 1px solid #bbb;
                                    }

                                    .header-gray {
                                        background-color: #e0e0e0;
                                        color: black;
                                    }

                                    table {
                                        width: 100%;
                                        border-collapse: collapse;
                                    }

                                    th,
                                    td {
                                        padding: 2px;
                                        /* Mengurangi padding agar lebih rapat */
                                        text-align: left;
                                    }

                                    th {
                                        font-weight: bold;
                                        text-align: center;
                                    }

                                    td {
                                        font-size: 0.9em;
                                        /* Memperkecil ukuran font */
                                    }
                                </style>
                                <thead>
                                    <tr class="header-gray">
                                        <th rowspan="2" class="border border-slate-600">No</th>
                                        <th colspan="6" class="border border-slate-600">Data Faktur</th>
                                        <th colspan="10" class="border border-slate-600">Data Pembayaran /
                                            Retur</th>
                                    </tr>
                                    <tr class="header-gray">
                                        <th class="border border-slate-600">Tgl Input</th>
                                        <th class="border border-slate-600">No. Reff</th>
                                        <th class="border border-slate-600">Tgl Faktur</th>
                                        <th class="border border-slate-600">No Faktur</th>
                                        <th class="border border-slate-600">Tgl JT</th>
                                        <th class="border border-slate-600">Hutang</th>
                                        <th class="border border-slate-600">No Reff</th>
                                        <th class="border border-slate-600">Tanggal</th>
                                        <th class="border border-slate-600">Retur</th>
                                        <th class="border border-slate-600">Bayar</th>
                                        <th class="border border-slate-600">Sisa Hutang</th>
                                        <th class="border border-slate-600">Uang Retur</th>
                                        <th class="border border-slate-600">Hutang Final</th>
                                        <th class="border border-slate-600">Note</th>
                                        <th class="border border-slate-600">Kas/Bank</th>
                                        <th class="border border-slate-600">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $jumlahBaris = count($hutang['details']);
                                    @endphp
                                    <tr class="intro-x">
                                        <td rowspan="{{ $jumlahBaris }}"
                                            class="align-top border border-slate-600 whitespace-nowrap">
                                            {{ $hutang['no'] }}</td>
                                        <td rowspan="{{ $jumlahBaris }}"
                                            class="align-top border border-slate-600 whitespace-nowrap">
                                            {{ $hutang['tanggal'] }}</td>
                                        <td rowspan="{{ $jumlahBaris }}"
                                            class="align-top border border-slate-600 whitespace-nowrap">
                                            {{ $hutang['no_reff'] }}</td>
                                        <td rowspan="{{ $jumlahBaris }}"
                                            class="align-top border border-slate-600 whitespace-nowrap">
                                            {{ $hutang['tanggal_faktur'] }}</td>
                                        <td rowspan="{{ $jumlahBaris }}"
                                            class="align-top border border-slate-600 whitespace-nowrap">
                                            {{ $hutang['no_faktur'] }}</td>
                                        <td rowspan="{{ $jumlahBaris }}"
                                            class="align-top border border-slate-600 whitespace-nowrap">
                                            {{ $hutang['tempo_kredit'] }}</td>
                                        <td rowspan="{{ $jumlahBaris }}"
                                            class="align-top border border-slate-600 whitespace-nowrap">
                                            {{ number_format($hutang['total_tagihan'] ?? 0, 0, ',', '.') }}
                                        </td>
                                        @php $first = $hutang['details'][0]; @endphp
                                        <td class="border border-slate-600 whitespace-nowrap">
                                            {{ $first['no_reff'] }}</td>
                                        <td class="border border-slate-600 whitespace-nowrap">
                                            {{ $first['tanggal'] }}</td>
                                        <td class="border border-slate-600 whitespace-nowrap">
                                            {{ number_format($first['retur'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="border border-slate-600 whitespace-nowrap">
                                            {{ number_format($first['bayar_retur'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="border border-slate-600 whitespace-nowrap">
                                            {{ number_format($first['sisa_hutang'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="border border-slate-600 whitespace-nowrap">
                                            {{ number_format($first['uang_retur'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="border border-slate-600 whitespace-nowrap">
                                            {{ number_format($first['sisa_hutang'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="border border-slate-600 whitespace-nowrap">
                                            {{ $first['type'] }}</td>
                                        <td class="border border-slate-600 whitespace-nowrap">
                                            {{ $first['akun'] }}</td>
                                        <td class="border border-slate-600 whitespace-nowrap">
                                            {{ $first['keterangan'] }}</td>
                                    </tr>
                                    @foreach ($hutang['details'] as $item)
                                        @if ($loop->first)
                                            @continue
                                        @endif
                                        <tr>
                                            <td class="border border-slate-600 whitespace-nowrap">
                                                {{ $item['no_reff'] }}</td>
                                            <td class="border border-slate-600 whitespace-nowrap">
                                                {{ $item['tanggal'] }}</td>
                                            <td class="border border-slate-600 whitespace-nowrap">
                                                {{ number_format($item['retur'] ?? 0, 0, ',', '.') }}</td>
                                            <td class="border border-slate-600 whitespace-nowrap">
                                                {{ number_format($item['bayar_retur'] ?? 0, 0, ',', '.') }}
                                            </td>
                                            <td class="border border-slate-600 whitespace-nowrap">
                                                {{ number_format($item['sisa_hutang'] ?? 0, 0, ',', '.') }}
                                            </td>
                                            <td class="border border-slate-600 whitespace-nowrap">
                                                {{ number_format($item['uang_retur'] ?? 0, 0, ',', '.') }}</td>
                                            <td class="border border-slate-600 whitespace-nowrap">
                                                {{ number_format($item['sisa_hutang'] ?? 0, 0, ',', '.') }}
                                            </td>
                                            <td class="border border-slate-600 whitespace-nowrap">
                                                {{ $item['type'] }}</td>
                                            <td class="border border-slate-600 whitespace-nowrap">
                                                {{ $item['akun'] }}</td>
                                            <td class="border border-slate-600 whitespace-nowrap">
                                                {{ $item['keterangan'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="border border-slate-600" colspan="6">Total</th>
                                        <td class="border border-slate-600">
                                            {{ number_format($hutang['total_tagihan'] ?? 0, 0, ',', '.') }}
                                        </td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td class="border border-slate-600">
                                            {{ number_format($hutang['total_retur'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="border border-slate-600">
                                            {{ number_format($hutang['total_bayar'] ?? 0, 0, ',', '.') }}</td>
                                        <td></td>
                                        <td></td>
                                        <td class="border border-slate-600">
                                            {{ number_format($hutang['piutang_final'] ?? 0, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>

    @empty
        <div class="mt-3 box">
            <h3 class="p-5 font-bold text-pending text-center">Belum ada data tersedia</h3>
        </div>
    @endforelse

    <div class="mt-3 box">
        {{ $hutang_pengguna->links() }}
    </div>
</div>
