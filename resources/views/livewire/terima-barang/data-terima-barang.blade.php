<div class="grid grid-cols-12 mt-8">
    <div class="flex flex-wrap items-center col-span-12 gap-2 mt-2 intro-y sm:flex-nowrap">
        <div class="flex justify-end gap-2 mb-0">
            @can('tambah_terima_barang')
                <a href="/tambah-terima-barang"><button class="btn btn-primary" wire:ignore><i data-feather="edit-3"
                            class="w-4 h-4 mr-3"></i> Tambah</button>
                </a>
            @endcan
            <div class="relative w-56 mr-auto text-slate-500" wire:ignore>
                <input type="text" class="w-56 pr-10 form-control box" placeholder="Cari No. Faktur"
                    wire:model.live='search'>
                <i class="absolute inset-y-0 right-0 w-4 h-4 my-auto mr-3" data-feather="search"></i>
            </div>
        </div>
        <div class="flex gap-2 mt-0 mb-0 overflow-auto">
            {{-- <label data-tw-merge for="horizontal-form-1" class="inline-block mt-2 mb-2 font-bold sm:w-20">
                Tanggal
            </label> --}}
            <input data-tw-merge id="horizontal-form-1" type="date" placeholder="Stok dari master"
                wire:model.live='startDate'
                class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
            <p class="mt-3 w-full">s.d</p>
            <input data-tw-merge id="horizontal-form-1" type="date" placeholder="Stok dari master"
                wire:model.live='endDate'
                class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
            <button onclick="location.reload()" class="btn btn-md btn-secondary" wire:ignore>
                <i data-feather="refresh-cw" class="w-4 h-4 mr-1"></i> Reload
            </button>

        </div>
    </div>
    <!-- BEGIN: Data List -->
    <div class="col-span-12 overflow-auto intro-y lg:overflow-visible">
        <table class="table mt-0 table-report">
            <thead style="background-color: #d3d3d3;">
                <tr>
                    <th class="whitespace-nowrap">No</th>
                    <th class="whitespace-nowrap">Tanggal</th>
                    <th class="whitespace-nowrap">No. Reff</th>
                    <th class="whitespace-nowrap">No. Faktur</th>
                    <th class="whitespace-nowrap">Supplier</th>
                    <th class="whitespace-nowrap">Keterangan</th>
                    <th class="whitespace-nowrap">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($terimaBarangs as $barang)
                    <tr class="intro-x">
                        <td class="">{{ $loop->iteration }}</td>
                        <td class="">{{ $barang->tanggal->format('d-m-Y') }}</td>
                        <td class="">{{ $barang->no_reff }}</td>
                        <td class="">{{ $barang->no_faktur }}</td>
                        <td class="">{{ $barang->sp->suplier->nama_suplier }}</td>
                        <td class="">{{ $barang->keterangan }}</td>
                        <td class="flex gap-2">
                            @can('aksi_terima_barang')
                                <a href="/cetak-terima-barang-pdf/{{ $barang->id }}"><button
                                        class="btn btn-sm btn-outline-primary">Print</button></a>
                                <a href="/edit-terima-barang/{{ $barang->id }}"> <button
                                        class="btn btn-sm btn-outline-primary"> Edit </button></a>
                                <button class="btn btn-sm btn-outline-danger"
                                    wire:confirm="Apakah anda yakin akan menghapus data terima barang?"
                                    wire:click='hapusTerimaBarang({{ $barang->id }})'>Delete</button>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr class="intro-x">
                        <td class="font-bold text-center text-pending" colspan="7">Belum ada data tersedia</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <!-- END: Data List -->
</div>
