<div class="grid grid-cols-12 gap-2 mt-8">
    <!-- BEGIN: Data List -->
    <div class="col-span-12 overflow-auto intro-y lg:overflow-visible">
        <div class="flex justify-start items-center gap-2">
            @can('tambah_surat_jalan')
                <a href="/tambah-surat-jalan">
                    <button class="btn btn-primary" wire:ignore>
                        <i data-feather="edit-3" class="w-4 h-4 mr-2"></i> Tambah
                    </button>
                </a>
            @endcan

            <div class="relative w-56 text-slate-500" wire:ignore>
                <input type="text" class="w-full pr-10 form-control box" placeholder="Search No. Reff ..."
                    wire:model.live.debounce.300ms="search">
                <i class="absolute inset-y-0 right-0 w-4 h-6 my-auto mr-3" data-feather="search"></i>
            </div>

            <div class="flex items-center gap-2">
                <input id="startDate" type="date" wire:model.live="startDate"
                    class="form-control w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary dark:bg-darkmode-800 dark:focus:ring-slate-700">
                <span class="w-full">s.d</span>
                <input id="endDate" type="date" wire:model.live="endDate"
                    class="form-control w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary dark:bg-darkmode-800 dark:focus:ring-slate-700">
            </div>
            <button onclick="location.reload()" class="btn btn-md btn-secondary" wire:ignore>
                <i data-feather="refresh-cw" class="w-4 h-4 mr-1"></i> Reload
            </button>
        </div>

        <table class="table table-report">
            <thead style="background-color: #d3d3d3;">
                <tr>
                    <th class="whitespace-nowrap">No</th>
                    <th class="whitespace-nowrap">Tanggal</th>
                    <th class="whitespace-nowrap">No. Reff</th>
                    <th class="whitespace-nowrap">Sales</th>
                    <th class="whitespace-nowrap">Expedisi</th>
                    <th class="whitespace-nowrap">Keterangan</th>
                    <th class="whitespace-nowrap">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($suratJalan as $surat)
                    <tr class="intro-x">
                        <td class="whitespace-nowrap">{{ $loop->iteration }}</td>
                        <td class="whitespace-nowrap">{{ date('d-m-Y', strtotime($surat->tanggal)) }}</td>
                        <td class="whitespace-nowrap">{{ $surat->no_reff }}</td>
                        <td class="whitespace-nowrap">{{ $surat->getSales->nama_pegawai }}</td>
                        <td class="whitespace-nowrap">{{ $surat->getEkspedisi->nama_ekspedisi }}</td>
                        <td class="whitespace-nowrap">{{ $surat->keterangan }}</td>
                        <td class="gap-2 whitespace-nowrapflex">
                            @can('aksi_surat_jalan')
                                <a href="/status-surat-jalan/{{ $surat->id }}"> <button
                                        class="btn btn-sm btn-outline-primary">Status Pengiriman</button></a>
                                <a href="/cetak-surat-jalan/{{ $surat->id }}"> <button
                                        class="btn btn-sm btn-outline-primary">Print SJ</button></a>
                                <a href="/cetak-surat-jalan/{{ $surat->id }}?status=true"> <button
                                        class="btn btn-sm btn-outline-primary">Print Status</button></a>
                                <a href="/edit-surat-jalan/{{ $surat->id }}"><button
                                        class="btn btn-sm btn-outline-primary">Edit</button></a>
                                <button class="btn btn-sm btn-outline-danger" wire:click='hapusSurat({{ $surat->id }})'
                                    wire:confirm='Apakah anda yakin akan menghapusnya?'>Delete</button>
                            @endcan

                        </td>
                    </tr>
                @empty
                    <tr class="intro-x">
                        <td class="font-bold text-center text-pending whitespace-nowrap" colspan="7">Belum ada data
                            tersedia</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <!-- END: Data List -->
</div>
