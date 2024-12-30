<div class="grid grid-cols-12 gap-2 mt-8">
    <!-- BEGIN: Data List -->
    <div class="col-span-12 overflow-auto intro-y lg:overflow-visible">
        <div class="flex justify-start items-center gap-2">
            @can('tambah_retur_penjualan')
                <a href="/tambah-retur-penjualan">
                    <button class="btn btn-primary" wire:ignore>
                        <i data-feather="edit-3" class="w-4 h-4 mr-2"></i> Tambah
                    </button>
                </a>
            @endcan

            <div class="relative w-56 text-slate-500" wire:ignore>
                <input type="text" class="w-full pr-10 form-control box" placeholder="Search No. Faktur ..."
                    wire:model.live='search'>
                <i class="absolute inset-y-0 right-0 w-4 h-4 my-auto mr-3" data-feather="search"></i>
            </div>

            <div class="flex items-center gap-2">
                <input id="startDate" type="date" wire:model.live='startDate'
                    class="form-control w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400 focus:ring-4 focus:ring-primary dark:bg-darkmode-800 dark:focus:ring-slate-700">
                <span class="w-full">s.d</span>
                <input id="endDate" type="date" wire:model.live='endDate'
                    class="form-control w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400 focus:ring-4 focus:ring-primary dark:bg-darkmode-800 dark:focus:ring-slate-700">
            </div>
            <button onclick="location.reload()" class="btn btn-md btn-secondary" wire:ignore>
                <i data-feather="refresh-cw" class="w-4 h-4 mr-1"></i> Reload
            </button>

            <!-- Uncomment the following buttons if needed -->
            <!-- <a href="#" class="flex items-center text-white shadow-md btn btn-success">
        <i data-feather="file-text" class="w-4 h-4 mr-1"></i> Export Excel
    </a>
    <a href="#" class="flex items-center text-white shadow-md btn btn-facebook">
        <i data-feather="printer" class="w-4 h-4 mr-1"></i> Print
    </a> -->
        </div>

        <div class="overflow-auto">
            <table class="table table-report">
                <thead style="background-color: #d3d3d3;">
                    <tr>
                        <th class="whitespace-nowrap">No</th>
                        <th class="whitespace-nowrap">No. Reff</th>
                        <th class="whitespace-nowrap">Tgl. Retur</th>
                        <th class="whitespace-nowrap">No. Faktur</th>
                        <th class="whitespace-nowrap">Nama Pelanggan</th>
                        <th class="whitespace-nowrap">Sales</th>
                        <th class="whitespace-nowrap">No Seri Pajak</th>
                        <th class="whitespace-nowrap">DPP</th>
                        <th class="whitespace-nowrap">PPN</th>
                        <th class="whitespace-nowrap">Total</th>
                        {{-- <th class="whitespace-nowrap">Keterangan</th> --}}
                        <th class="whitespace-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($returPenjualan as $retur)
                        <tr class="intro-x">
                            <td class="whitespace-nowrap ">{{ $loop->iteration }}</td>
                            <td class="whitespace-nowrap ">{{ $retur->no_reff }}</td>
                            <td class="whitespace-nowrap ">{{ $retur->tgl_input->format('d-m-Y') }}</td>
                            <td class="whitespace-nowrap ">{{ $retur->no_faktur }}</td>
                            <td class="whitespace-nowrap ">{{ $retur->getPelanggan->nama }}</td>
                            <td class="whitespace-nowrap ">{{ $retur->getSales->nama_pegawai }}</td>
                            <td class="whitespace-nowrap ">{{ $retur->no_seri_pajak }}</td>
                            <td class="whitespace-nowrap ">{{ number_format($retur->dpp, 0, ',', '.') }}</td>
                            <td class="whitespace-nowrap ">{{ number_format($retur->ppn, 0, ',', '.') }}</td>
                            <td class="whitespace-nowrap ">{{ number_format($retur->total, 0, ',', '.') }}</td>
                            {{-- <td class="whitespace-nowrap ">{{ $retur->keterangan }}</td> --}}
                            <td class="flex gap-2 whitespace-nowrap">
                                @can('aksi_penjualan')
                                    {{-- <button class="btn btn-sm btn-outline-primary">Detail</button> --}}
                                    <a href="/cetak-retur-penjualan/{{ $retur->id }}"> <button
                                            class="btn btn-sm btn-outline-primary">Print</button></a>
                                    {{-- <button class="btn btn-sm btn-outline-primary">Edit</button> --}}
                                    <button class="btn btn-sm btn-outline-danger"
                                        wire:confirm='Apakah anda yakin akan menghapus data?'
                                        wire:click='hapusReturPenjualan({{ $retur->id }})'>Delete</button>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr class="intro-x">
                            <td class="font-bold text-center text-pending whitespace-nowrap" colspan="12">Belum ada
                                data tersedia
                            </td>
                        </tr>
                    @endforelse
                    <tr>
                        <td class="font-bold text-center whitespace-nowrap" colspan="6">Total</td>
                        <td class="font-bold whitespace-nowrap"></td>
                        <td class="font-bold whitespace-nowrap">
                            {{ number_format($returPenjualan->sum('dpp'), 0, ',', '.') }}</td>
                        <td class="font-bold whitespace-nowrap">
                            {{ number_format($returPenjualan->sum('ppn'), 0, ',', '.') }}</td>
                        <td class="font-bold whitespace-nowrap">
                            {{ number_format($returPenjualan->sum('total'), 0, ',', '.') }}</td>
                        <td class="font-bold whitespace-nowrap"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- END: Data List -->
</div>
