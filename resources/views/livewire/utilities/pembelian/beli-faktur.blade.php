<div>
    <div class="grid grid-cols-12 gap-2 mt-8">
        <div class="col-span-6 md:col-span-3">
            <div class="flex items-center mb-2">
                <div class="relative w-56 text-slate-500 ml-2">
                    <input type="text" class="w-56 pr-10 form-control cari box" placeholder="Search No. Faktur..."
                        wire:model.live.debounce.300ms="search">
                    <i class="absolute inset-y-0 right-0 w-4 h-4 my-auto mr-3" data-feather="search"></i>
                </div>

                <div class="ml-2">
                    <input id="tanggal-dari" name="mulaiId" wire:model.lazy="mulaiId" type="date"
                        placeholder="Stok dari master" style="width: 150px;"
                        class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&[readonly]]:bg-slate-100 [&[readonly]]:cursor-not-allowed [&[readonly]]:dark:bg-darkmode-800 [&[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                </div>
                <label for="tanggal-sampai" class="inline-block mt-2 mb-2 ml-2 sm:w-20">s.d</label>
                <div class="ml-2">
                    <input id="tanggal-sampai" wire:model.lazy="selesaiId" name="selesaiId" type="date"
                        placeholder="Stok dari master" style="width: 150px;"
                        class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&[readonly]]:bg-slate-100 [&[readonly]]:cursor-not-allowed [&[readonly]]:dark:bg-darkmode-800 [&[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                </div>
            </div>

            <div class="flex items-center mb-2">
                <select data-tw-merge id="sales" aria-label="Default select example" wire:model.live="spId"
                    class="ml-2 form-control">
                    <option value="">- Pilih Supplier -</option>
                    @foreach ($suplier as $item)
                        <option value="{{ $item->id }}">{{ $item->nama_suplier }}</option>
                    @endforeach
                </select>
                <button onclick="location.reload()" class="ml-2 btn btn-md btn-secondary" wire:ignore>
                    <i data-feather="refresh-cw" class="w-4 h-4 mr-1"></i> Reload
                </button>
            </div>

            {{-- <div class="col-span-6 md:col-span-3" style="position: absolute; top: 340px; right:54px;">
                <div class="flex gap-2">
                    <button class="btn btn-success">
                        <span wire:ignore><i data-feather="file-text" class="w-5 h-5 mr-1"></i>Excel</span>
                    </button>
                    <a href="{{ route('cetak_pdf_faktur_beli', [
                        'search' => $search,
                        'pembayaranId' => $pembayaranId,
                        'spId' => $spId,
                        'mulaiId' => $mulaiId,
                        'selesaiId' => $selesaiId,
                    ]) }}"
                        target="_blank" class="btn btn-primary"><span wire:ignore><i data-feather="printer"
                                class="w-5 h-5 mr-1"></i>PDF</span></a>
                </div>

            </div>

            <div class="col-span-6 md:col-span-3" style="position: absolute; top: 350px; right: 190px;">
                <div class="flex items-center mb-3">
                    <label for="search" class="inline-block mt-2 mb-2 sm:w-20">Cari</label>
                    <input type="text" id="search" name="search" wire:model.live.debounce.300ms="search"
                        class="block w-full rounded-md shadow-sm form-input">
                </div>
            </div> --}}

            <div class="text-center" wire:loading wire:target="print">
                Loading PDF...
            </div>
        </div>
    </div>


    <div class="overflow-auto box">
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
                    <th rowspan="2" class="border border-slate-600">No</th>
                    <th rowspan="2" class="border border-slate-600">Tanggal</th>
                    <th rowspan="2" class="border border-slate-600">No. Faktur</th>
                    <th rowspan="2" class="border border-slate-600">Supplier</th>
                    <th rowspan="2" class="border border-slate-600">Pembayaran</th>
                    <th rowspan="2" class="border border-slate-600">DPP</th>
                    <th rowspan="2" class="border border-slate-600">PPN</th>
                    <th rowspan="2" class="border border-slate-600">Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pembelians as $pembelian)
                    <tr class="text-center intro-x">
                        <td class="border border-slate-600">{{ $loop->iteration }}</td>
                        <td class="border border-slate-600">{{ date('d-m-Y', strtotime($pembelian->tgl_input)) }}</td>
                        <td class="border border-slate-600">{{ $pembelian->no_faktur }}</td>
                        <td class="border border-slate-600">{{ $pembelian->getSuplier->nama_suplier }}</td>
                        <td class="border border-slate-600">
                            {{ $pembelian->kredit == 1 ? 'Kredit' : 'Cash' }}</td>
                        <td class="border border-slate-600">{{ number_format($pembelian->dpp, 0, ',', '.') }}</td>
                        <td class="border border-slate-600">{{ number_format($pembelian->ppn, 0, ',', '.') }}</td>
                        <td class="border border-slate-600">{{ number_format($pembelian->total_tagihan, 0, ',', '.') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="font-bold text-center text-pending">Belum ada data tersedia</td>
                    </tr>
                @endforelse
            </tbody>

            <tfoot>
                <tr class="text-center">
                    <td colspan="5" class="border border-slate-600">Total</td>
                    <td class="border border-slate-600">{{ number_format($pembelians->sum('dpp'), 0, ',', '.') }}</td>
                    <td class="border border-slate-600">{{ number_format($pembelians->sum('ppn'), 0, ',', '.') }}</td>
                    <td class="border border-slate-600">
                        {{ number_format($pembelians->sum('total_tagihan'), 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
