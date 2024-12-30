<div>
    <div class="grid grid-cols-12 gap-2 mt-8">
        <div class="col-span-6 md:col-span-3">
            <div class="flex flex-col sm:flex-row gap-2 items-center mb-2">
                <div class="col-span-6 mt-0 md:col-span-3">
                    <div class="col-span-6 md:col-span-3">
                        <div class="relative w-56 text-slate-500" wire:ignore>
                            <input type="text" class="w-56 pr-10 form-control cari box"
                                placeholder="Search Pelanggan ..." wire:model.live.debounce.300ms="search">
                            <i class="absolute inset-y-0 right-0 w-4 h-4 my-auto mr-3" data-feather="search"></i>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <!-- Tanggal Mulai Input -->
                    <div>
                        <input id="tanggal-dari" name="mulaiId" wire:model.lazy="mulaiId" type="date"
                            placeholder="Stok dari master" style="width: 150px;"
                            class="w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90
                   focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40
                   disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent
                   [&[readonly]]:bg-slate-100 [&[readonly]]:cursor-not-allowed [&[readonly]]:dark:bg-darkmode-800 [&[readonly]]:dark:border-transparent
                   transition duration-200 ease-in-out
                   dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                    </div>

                    <!-- Label Separator -->
                    <label for="tanggal-sampai" class="w-8 text-center">s.d</label>

                    <!-- Tanggal Sampai Input -->
                    <div>
                        <input id="tanggal-sampai" wire:model.lazy="selesaiId" name="selesaiId" type="date"
                            placeholder="Stok dari master" style="width: 150px;"
                            class="w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90
                   focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40
                   disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent
                   [&[readonly]]:bg-slate-100 [&[readonly]]:cursor-not-allowed [&[readonly]]:dark:bg-darkmode-800 [&[readonly]]:dark:border-transparent
                   transition duration-200 ease-in-out
                   dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                    </div>
                </div>

            </div>

            <div class="flex flex-col sm:flex-row items-center gap-2 mb-3">
                {{-- <select data-tw-merge id="pelanggan" name="pelanggan" wire:model.live="pelangganId"
                    aria-label="Default select example" class="w-full sm:w-auto form-control">
                    <option value="">- Pilih Pelanggan -</option>
                    @foreach ($pelanggan as $item)
                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                    @endforeach
                </select> --}}

                <select data-tw-merge id="sales" name="sales" wire:model.live="salesId"
                    aria-label="Default select example" class="w-full sm:w-auto form-control">
                    <option value="">- Pilih Sales -</option>
                    @foreach ($sales as $item)
                        <option value="{{ $item->pegawai_sales->id }}">{{ $item->pegawai_sales->nama_pegawai }}</option>
                    @endforeach
                </select>

                <select data-tw-merge id="pembayaranId" name="pembayaranId" wire:model.live="pembayaranId"
                    aria-label="Default select example" class="w-full sm:w-auto form-control">
                    <option value="">- Pilih Pembayaran -</option>
                    <option value="2">Cash</option>
                    <option value="1">Kredit</option>
                </select>

                <select data-tw-merge id="arearayon" name="arearayon" wire:model.live="arearayonId"
                    aria-label="Default select example" class="w-full sm:w-auto form-control">
                    <option value="">- Pilih Area Rayon -</option>
                    @foreach ($arearayon as $item)
                        <option value="{{ $item->id }}">{{ $item->area_rayon }}</option>
                    @endforeach
                </select>

                <select data-tw-merge id="subrayon" name="subrayon" wire:model.live="subrayonId"
                    aria-label="Default select example" class="w-full sm:w-auto form-control">
                    <option value="">- Pilih Sub Rayon</option>
                    @foreach ($subrayon as $item)
                        <option value="{{ $item->id }}">{{ $item->sub_rayon }}</option>
                    @endforeach
                </select>

                <select data-tw-merge id="supervisor" name="supervisor" wire:model.live="supervisorId"
                    aria-label="Default select example" class="w-full sm:w-auto form-control">
                    <option value="">- Pilih Supervisor -</option>
                    @foreach ($spv as $item)
                        <option value="{{ $item->pegawai_supervisor->id }}">
                            {{ $item->pegawai_supervisor->nama_pegawai }}</option>
                    @endforeach
                </select>
                {{-- <div class="col-span-6 md:col-span-3"style="position: absolute; top: 275px; right:90px;">
                    <div class="flex gap-2">
                        <button class="btn text-white btn-success" wire:ignore>
                            <i data-feather="file-text" class="w-4 h-4 mr-1"></i>Excel
                        </button>

                        <a id="print-pdf-button"
                            href="{{ route('cetak_pdf_rekap', [
                                'search' => $search,
                                // 'pembayaranId' => $pembayaranId,
                                'salesId' => $salesId,
                                'mulaiId' => $mulaiId,
                                'selesaiId' => $selesaiId,
                                'arearayonId' => $arearayonId,
                                'subrayonId' => $subrayonId,
                                'supervisorId' => $supervisorId,
                                'pelangganId' => $pelangganId,
                            ]) }}"
                            target="_blank" class="btn btn-facebook" wire:ignore><i data-feather="printer"
                                class="w-4 h-4 mr-1"></i>Print</a>

                    </div>
                </div> --}}
                <button onclick="location.reload()" class="ml-2 btn btn-md btn-secondary" wire:ignore>
                    <i data-feather="refresh-cw" class="w-4 h-4 mr-1"></i> Reload
                </button>
            </div>

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
                    <th rowspan="2" class="border border-slate-600">Pelanggan</th>
                    <th rowspan="2" class="border border-slate-600">Sales</th>
                    <th rowspan="2" class="border border-slate-600">Sub Total</th>
                    {{-- <th rowspan="2" class="border border-slate-600">Disc %</th>
                    <th rowspan="2" class="border border-slate-600">Disc Nominal</th> --}}
                    <th rowspan="2" class="border border-slate-600">DPP</th>
                    <th rowspan="2" class="border border-slate-600">PPN</th>
                    <th rowspan="2" class="border border-slate-600">Total</th>
                    <th rowspan="2" class="border border-slate-600">Biaya 1</th>
                    <th rowspan="2" class="border border-slate-600">Biaya 2</th>
                    <th rowspan="2" class="border border-slate-600">Total Tagihan</th>
                    <th rowspan="2" class="border border-slate-600">Jumlah Bayar</th>
                    <th rowspan="2" class="border border-slate-600">Piutang</th>
                    <th rowspan="2" class="border border-slate-600">Pembayaran</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $biaya1 = 0;
                    $biaya2 = 0;
                    $jumlah_bayar = 0;
                @endphp
                @forelse ($penjualan as $penjualans)
                    @php
                        $b1 = str_replace('.', '', $penjualans->biaya1);
                        $b2 = str_replace('.', '', $penjualans->biaya2);
                        $jb = str_replace('.', '', $penjualans->jumlah_bayar);

                        $biaya1 += $b1;
                        $biaya2 += $b2;
                        $jumlah_bayar += $jb;
                    @endphp
                    <tr class="text-center intro-x">
                        <td class="border border-slate-600">{{ $loop->iteration }}</td>
                        <td class="border border-slate-600">{{ $penjualans->tgl_faktur->format('d-m-Y') }}</td>
                        <td class="border border-slate-600">{{ $penjualans->no_faktur }}</td>
                        <td class="border border-slate-600">{{ $penjualans->getPelanggan->nama }}</td>
                        <td class="border border-slate-600">{{ $penjualans->getSales->nama_pegawai }}</td>
                        <td class="border border-slate-600">{{ number_format($penjualans->subtotal, 0, ',', '.') }}
                        </td>
                        {{-- <td class="border border-slate-600">{{ $penjualans->diskon }}</td>
                        <td class="border border-slate-600">
                            {{ number_format($penjualans->hasil_diskon, 0, ',', '.') }}</td> --}}
                        <td class="border border-slate-600">{{ number_format($penjualans->dpp, 0, ',', '.') }}</td>
                        <td class="border border-slate-600">{{ number_format($penjualans->ppn, 0, ',', '.') }}</td>
                        <td class="border border-slate-600">
                            {{ number_format($penjualans->ppn + $penjualans->dpp, 0, ',', '.') }}</td>
                        <td class="border border-slate-600">{{ number_format($b1, 0, ',', '.') }}</td>
                        <td class="border border-slate-600">{{ number_format($b2, 0, ',', '.') }}</td>
                        <td class="border border-slate-600">
                            {{ number_format($penjualans->total_tagihan, 0, ',', '.') }}</td>
                        <td class="border border-slate-600">
                            {{ number_format($jb, 0, ',', '.') }}</td>
                        <td class="border border-slate-600">
                            {{ number_format($penjualans->total_hutang, 0, ',', '.') }}</td>
                        <td class="border border-slate-600">{{ $penjualans->kredit == 0 ? 'Cash' : 'Kredit' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td class="font-bold text-center text-pending border border-slate-600" colspan="17">Belum
                            ada data
                            tersedia</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr class="font-bold text-center">
                    <td colspan="5" class="border border-slate-600">Total</td>
                    {{-- sub total sama dengan hpp --}}
                    <td class="border border-slate-600">{{ number_format($penjualan->sum('dpp'), 0, ',', '.') }}</td>
                    <td class="border border-slate-600">{{ number_format($penjualan->sum('dpp'), 0, ',', '.') }}</td>
                    <td class="border border-slate-600">{{ number_format($penjualan->sum('ppn'), 0, ',', '.') }}</td>
                    <td class="border border-slate-600">
                        {{ number_format($penjualan->sum('ppn') + $penjualan->sum('dpp'), 0, ',', '.') }}</td>
                    <td class="border border-slate-600">{{ number_format($biaya1, 0, ',', '.') }}
                    </td>
                    <td class="border border-slate-600">{{ number_format($biaya2, 0, ',', '.') }}
                    </td>
                    <td class="border border-slate-600">
                        {{ number_format($penjualan->sum('total_tagihan'), 0, ',', '.') }}</td>
                    <td class="border border-slate-600">
                        {{ number_format($jumlah_bayar, 0, ',', '.') }}</td>
                    <td class="border border-slate-600">
                        {{ number_format($penjualan->sum('total_hutang'), 0, ',', '.') }}</td>
                    <td colspan="5" class="border border-slate-600"></td>
                </tr>
            </tfoot>
        </table>
    </div>
    <!-- Pagination Links -->
    <div class="mt-2">
        {{ $penjualan->links() }}
    </div>
</div>
