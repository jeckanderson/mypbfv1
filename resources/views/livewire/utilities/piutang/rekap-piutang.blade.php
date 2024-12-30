<div>
    <div class="grid grid-cols-12 gap-6 mt-5">

        <div class="col-span-6 md:col-span-3">


            <div class="flex items-center mb-3">
                <label for="tanggal-dari" class="inline-block mt-2 mb-2 sm:w-20">Tanggal</label>
                <div class="ml-8">
                    <input id="tanggal-dari" name="mulaiId" wire:model.lazy="mulaiId" type="date"
                        placeholder="Stok dari master" style="width: 150px;"
                        class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&[readonly]]:bg-slate-100 [&[readonly]]:cursor-not-allowed [&[readonly]]:dark:bg-darkmode-800 [&[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                </div>
                <label for="tanggal-sampai" class="inline-block mt-2 mb-2 ml-2 sm:w-20">s/d</label>
                <div class="ml-2">
                    <input id="tanggal-sampai" wire:model.lazy="selesaiId" name="selesaiId" type="date"
                        placeholder="Stok dari master" style="width: 150px;"
                        class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&[readonly]]:bg-slate-100 [&[readonly]]:cursor-not-allowed [&[readonly]]:dark:bg-darkmode-800 [&[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                </div>
            </div>



            <div class="col-span-6 md:col-span-3"style="position: absolute; top: 285px; right:55px;">
                <div class="flex gap-2">
                    <button class="btn btn-success">
                        <span wire:ignore><i data-feather="file-text" class="w-5 h-5 mr-1"></i>Excel</span>
                    </button>
                    <a href="{{ route('cetak_pdf_rekap_piutang', [
                        'search' => $search,
                    
                        'mulaiId' => $mulaiId,
                        'selesaiId' => $selesaiId,
                    ]) }}"
                        target="_blank" class="btn btn-primary"><span wire:ignore><i data-feather="printer"
                                class="w-5 h-5 mr-1"></i>PDF</span></a>
                </div>
            </div>

            <div class="col-span-6 md:col-span-3" style="position: absolute; top: 295px; right: 180px;">
                <div class="flex items-center mb-3">
                    <label for="search" class="inline-block mt-2 mb-2 sm:w-20">Cari</label>
                    <input type="text" id="search" name="search" wire:model.live.debounce.300ms="search"
                        class="block w-full rounded-md shadow-sm form-input">
                </div>
            </div>

            <div class="text-center" wire:loading wire:target="print">
                Loading PDF...
            </div>
        </div>
    </div>
    <div class="box">
        <div class="overflow-auto">
            <table class="table mt-5">
                <thead class="text-center">
                    <tr>
                        <th rowspan="2" class="border border-slate-600">No</th>
                        <th rowspan="2" class="border border-slate-600">Kode</th>
                        <th rowspan="2" class="border border-slate-600">Nama Pelanggan</th>
                        <th rowspan="2" class="border border-slate-600">Jumlah Piutang</th>
                        <th rowspan="2" class="border border-slate-600">Pembayaran</th>
                        <th rowspan="2" class="border border-slate-600">Sisa Piutang</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($piutang as $piutangs)
                        <tr class="text-center intro-x">
                            <td class="border border-slate-600">{{ $loop->iteration }}</td>
                            <td class="border border-slate-600">{{ $piutangs->getPelanggan->kode }}</td>

                            <td class="border border-slate-600">
                                {{ $piutangs->getPelanggan->nama }}</td>
                            <td class="border border-slate-600">{{ $piutangs->total_hutang }}</td>
                            <td class="border border-slate-600">{{ $piutangs->sumber }}</td>
                            <td class="border border-slate-600">{{ $piutangs->sisa_hutang }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="font-bold text-center border border-slate-600" colspan="9">Belum ada
                                data
                                tersedia</td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>
</div>
