<div class="grid grid-cols-12 gap-2 mt-8">
    <!-- BEGIN: Data List -->
    <div class="col-span-12 overflow-auto intro-y lg:overflow-visible">
        <div class="gap-2 sm:flex">
            <div data-tw-merge class="flex items-center block gap-2">
                <label data-tw-merge for="horizontal-form-1" class="inline-block mt-2 mb-2 sm:w-0">
                </label>
                <select data-tw-merge aria-label="Default select example" class="form-control sm:w-60"
                    wire:model.live='suplier'>
                    <option>- Pilih Supplier -</option>
                    @foreach ($supliers as $sup)
                        <option value="{{ $sup->id }}">{{ $sup->nama_suplier }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-2 mb-2 overflow-auto sm:mb-0">
                {{-- <label data-tw-merge for="horizontal-form-1" class="inline-block mt-2 mb-2 sm:w-0">
                    Tanggal
                </label> --}}
                <input data-tw-merge id="horizontal-form-1" type="date" placeholder="Stok dari master"
                    wire:model.live='startDate'
                    class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                <p class="w-full mt-3">s.d</p>
                <input data-tw-merge id="horizontal-form-1" type="date" placeholder="Stok dari master"
                    wire:model.live='endDate'
                    class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                <button onclick="location.reload()" class="btn btn-md btn-secondary" wire:ignore>
                    <i data-feather="refresh-cw" class="w-4 h-4 mr-1"></i> Reload
                </button>
                {{-- <a href="/produk-download-excel" class="flex items-center text-white btn btn-success" wire:ignore>
                    <i data-feather="file-text" class="w-4 h-4 mr-1"></i> Excel
                </a>
                <a href="/pajak-masukan.blade.php" class="flex items-center btn btn-facebook" wire:ignore>
                    <i data-feather="printer" class="w-4 h-4 mr-1"></i> Print
                </a> --}}
            </div>
        </div>
        <div class="box">
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
                        <th rowspan="2" class="border border-slate-600">Tanggal</th>
                        <th rowspan="2" class="border border-slate-600">No. Faktur</th>
                        <th rowspan="2" class="border border-slate-600">Supplier</th>
                        <th colspan="3" class="border border-slate-600">Pajak</th>
                        <th rowspan="2" class="border border-slate-600">DPP</th>
                        <th rowspan="2" class="border border-slate-600">PPN</th>
                        <th rowspan="2" class="border border-slate-600">Total</th>
                    </tr>
                    <tr class="header-gray">
                        <th class="border border-slate-600">No. Seri </th>
                        <th class="border border-slate-600">Tanggal</th>
                        <th class="border border-slate-600">Kompensasi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($returPembelian as $retur)
                        <tr class="text-center intro-x">
                            <td class="border border-slate-600 ">{{ date('d-m-Y', strtotime($retur->tgl_input)) }}</td>
                            <td class="border border-slate-600 ">{{ $retur->no_faktur }}</td>
                            <td class="border border-slate-600 ">{{ $retur->suplier->nama_suplier }}</td>
                            <td class="border border-slate-600 ">{{ $retur->no_seri_pajak }}</td>
                            <td class="border border-slate-600 ">
                                {{ date('d-m-Y', strtotime($retur->pembelian->tgl_faktur_pajak)) }}</td>
                            <td class="border border-slate-600 ">
                                {{ date('d-m-Y', strtotime($retur->pembelian->kompensasi_pajak)) }}</td>
                            <td class="border border-slate-600 ">{{ number_format($retur->dpp, 0, ',', '.') }}</td>
                            <td class="border border-slate-600 ">{{ number_format($retur->ppn, 0, ',', '.') }}</td>
                            <td class="border border-slate-600 ">{{ number_format($retur->total, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                    @endforelse
                    <tr>
                        <td class="font-bold text-center border border-slate-600" colspan="6">Total</td>
                        <td class="font-bold text-left border border-slate-600">
                            {{ number_format($returPembelian->sum('dpp'), 0, ',', '.') }}</td>
                        <td class="font-bold text-left border border-slate-600">
                            {{ number_format($returPembelian->sum('ppn'), 0, ',', '.') }}</td>
                        <td class="font-bold text-left border border-slate-600">
                            {{ number_format($returPembelian->sum('total'), 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- END: Data List -->
</div>
