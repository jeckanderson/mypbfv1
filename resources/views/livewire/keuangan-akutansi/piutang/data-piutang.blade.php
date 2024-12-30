<div class="grid grid-cols-12 gap-2 mt-8">
    <!-- BEGIN: Data List -->
    <div class="col-span-12 overflow-auto intro-y lg:overflow-visible">
        <div class="justify-between gap-2 sm:flex">
            @can('tambah_pembayaran_piutang')
                <a href="/tambah-pembayaran-piutang"><button class="btn btn-primary"><i data-feather="edit-3"
                            class="w-4 h-4 mr-3"></i> Tambah</button>
                </a>
            @endcan
            @include('components.search', [
                'id_table' => 'tableHutang',
            ])
            <div class="">
                <div class="flex gap-2 mb-2 mr-auto overflow-auto sm:mb-0">
                    {{-- <label data-tw-merge for="horizontal-form-1" class="inline-block mt-2 mb-2 font-bold sm:w-0"> tanggal
                    </label> --}}
                    <input data-tw-merge id="horizontal-form-1" type="date" placeholder="Stok dari master"
                        wire:model.live='startDate'
                        class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                    <p class="w-full mt-3">s.d</p>
                    <input data-tw-merge id="horizontal-form-1" type="date" placeholder="Stok dari master"
                        wire:model.live='endDate'
                        class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                </div>
            </div>
            <button onclick="location.reload()" class="btn btn-md btn-secondary" wire:ignore>
                <i data-feather="refresh-cw" class="w-4 h-4 mr-1"></i> Reload
            </button>
        </div>
        <table class="table table-report" id="tableHutang">
            <thead style="background-color: #d3d3d3;">
                <tr>
                    <th class="whitespace-nowrap">No</th>
                    <th class="whitespace-nowrap">Tanggal</th>
                    <th class="whitespace-nowrap">No. Reff</th>
                    <th class="whitespace-nowrap">Total Bayar</th>
                    <th class="whitespace-nowrap">Keterangan</th>
                    <th class="whitespace-nowrap">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($piutangPengguna as $piutang)
                    <tr class="intro-x">
                        <td class="whitespace-nowrap">{{ $loop->iteration }}</td>
                        <td class="whitespace-nowrap">{{ date('d-m-Y', strtotime($piutang->tgl_input)) }}</td>
                        <td class="whitespace-nowrap">{{ $piutang->no_reff }}</td>
                        <td class="whitespace-nowrap">Rp. {{ number_format($piutang->total_bayar, 0, ',', '.') }}</td>
                        <td class="whitespace-nowrap">{{ $piutang->keterangan }}</td>
                        <td class="gap-2 whitespace-nowrapflex">
                            @can('aksi_pembayaran_piutang')
                                <a href="/edit-pembayaran-piutang/{{ $piutang->id }}"> <button
                                        class="btn btn-sm btn-outline-primary">Lihat</button></a>
                                <a href="/cetak-pembayaran-piutang/{{ $piutang->id }}">
                                    <button class="btn btn-sm btn-outline-primary">Print</button></a>
                                <button class="btn btn-sm btn-outline-danger"
                                    wire:click='hapusPembayaranPiutang({{ $piutang->id }})'
                                    wire:confirm='Apakah anda yakin akan menghapus data?'>Delete</button>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr class="intro-x">
                        <td class="font-bold text-center text-pending whitespace-nowrap" colspan="6">Belum ada data
                            tersedia</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <!-- END: Data List -->
</div>
