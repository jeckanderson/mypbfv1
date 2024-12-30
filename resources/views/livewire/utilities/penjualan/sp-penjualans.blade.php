<div>
    <div class="grid grid-cols-12 gap-2 mt-8">
        <div class="col-span-6 md:col-span-3">
            <div class="flex flex-col sm:flex-row gap-1 items-center mb-2">
                <div class="col-span-6 mt-0 md:col-span-3">
                    <div class="col-span-6 md:col-span-3">
                        <div class="relative w-56 text-slate-500" wire:ignore>
                            <input type="text" class="w-56 pr-10 form-control cari box" placeholder="Search No. SP ..."
                                wire:model.live.debounce.300ms="search">
                            <i class="absolute inset-y-0 right-0 w-4 h-4 my-auto mr-3" data-feather="search"></i>
                        </div>
                    </div>
                </div>
                <div class="ml-2">
                    <input id="tanggal-dari" name="mulaiId" wire:model.lazy="mulaiId" type="date"
                        placeholder="Stok dari master" style="width: 150px;"
                        class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&[readonly]]:bg-slate-100 [&[readonly]]:cursor-not-allowed [&[readonly]]:dark:bg-darkmode-800 [&[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                </div>
                <label for="tanggal-sampai" class="inline-block mt-2 mb-2 sm:w-20 ml-2">s.d</label>
                <div class="ml-2">
                    <input id="tanggal-sampai" wire:model.lazy="selesaiId" name="selesaiId" type="date"
                        placeholder="Stok dari master" style="width: 150px;"
                        class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&[readonly]]:bg-slate-100 [&[readonly]]:cursor-not-allowed [&[readonly]]:dark:bg-darkmode-800 [&[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-1 items-center mb-2">
                <select id="pelanggan" name="pelanggan" wire:model.live="pelangganId"
                    aria-label="Default select example" class="w-auto form-select">
                    <option value="">- Pilih Pelanggan -</option>
                    @foreach ($pelanggan as $item)
                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                    @endforeach
                </select>

                <select id="sales" name="sales" wire:model.live="salesId" aria-label="Default select example"
                    class="w-auto form-select ml-2">
                    <option value="">- Pilih Sales -</option>
                    @foreach ($sales as $item)
                        <option value="{{ $item->pegawai_sales->id }}">{{ $item->pegawai_sales->nama_pegawai }}</option>
                    @endforeach
                </select>

                <select id="tipe-sp" wire:model.live="spId" aria-label="Default select example"
                    class="w-auto form-control ml-2">
                    <option value="">- Pilih SP -</option>
                    <option value="SP. Reguler">SP.Reguler</option>
                    <option value="SP. OOT">SP. OOT</option>
                    <option value="SP. Prekursor">SP. Prekursor</option>
                    <option value="SP. Psikotropika">SP. Psikotropika</option>
                    <option value="SP. Narkotika">SP. Narkotika</option>
                </select>
                <select id="sumber" wire:model.live="sumberId" aria-label="Default select example"
                    class="w-auto form-control ml-2">
                    <option value="">- Pilih Sumber SP -</option>
                    <option value="Website">Website</option>
                    <option value="Mobile">Mobile</option>
                </select>
                <button onclick="location.reload()" class="ml-2 btn btn-md btn-secondary" wire:ignore>
                    <i data-feather="refresh-cw" class="w-4 h-4 mr-1"></i> Reload
                </button>
            </div>

            <div class="col-span-6 md:col-span-3" style="position: absolute; top: 310px; right:80px;">
                <div class="flex gap-2">
                    <button class="btn btn-success text-white" wire:ignore><i data-feather="file-text"
                            class="w-4 h-4 mr-1"></i>Excel</span>
                    </button>
                    <a id="print-pdf-button"
                        href="{{ route('cetak_pdf_sp', [
                            'search' => $search,
                            'spId' => $spId,
                            'salesId' => $salesId,
                            'mulaiId' => $mulaiId,
                            'selesaiId' => $selesaiId,
                            'pelangganId' => $pelangganId,
                            'sumberId' => $sumberId,
                            'spId' => $spId,
                        ]) }}"
                        target="_blank" class="btn btn-facebook" wire:ignore><i data-feather="printer"
                            class="w-4 h-4 mr-1"></i>Print</a>
                </div>
            </div>

            <div class="text-center" wire:loading wire:target="print">
                Loading PDF...
            </div>


        </div>

    </div>

    <div class="overflow-auto box">

        <table class="table mt-5">
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
                    <th rowspan="2" class="border border-slate-600">Tanggal SP</th>
                    <th rowspan="2" class="border border-slate-600">Pelanggan</th>
                    <th rowspan="2" class="border border-slate-600">No. Surat Pesanan</th>
                    <th rowspan="2" class="border border-slate-600">Sales</th>
                    <th rowspan="2" class="border border-slate-600">Tipe SP</th>
                    <th rowspan="2" class="border border-slate-600">Sumber</th>

                </tr>

            </thead>

            <tbody>
                @forelse ($sppenjualan as $sppenjualans)
                    <tr class="text-center intro-x">
                        <td class="border border-slate-600">{{ $loop->iteration }}</td>
                        <td class="border border-slate-600">
                            {{ \Carbon\Carbon::parse($sppenjualans->tgl_input)->format('d-m-Y') }}</td>
                        <td class="border border-slate-600">
                            {{ \Carbon\Carbon::parse($sppenjualans->tgl_input)->format('d-m-Y') }}</td>
                        <td class="border border-slate-600">{{ $sppenjualans->pelangganPenjualan->nama }}</td>
                        <td class="border border-slate-600">{{ $sppenjualans->no_sp }}</td>
                        <td class="border border-slate-600">{{ $sppenjualans->salesPenjualan->nama_pegawai }}
                        </td>
                        <td class="border border-slate-600">{{ $sppenjualans->tipe_sp }}</td>
                        <td class="border border-slate-600">{{ $sppenjualans->sumber }}</td>

                    </tr>
                @empty
                    <tr>
                        <td class="font-bold text-center text-pending border border-slate-600" colspan="9">Belum
                            ada
                            data
                            tersedia</td>
                    </tr>
                @endforelse
            </tbody>

        </table>

    </div>


</div>
