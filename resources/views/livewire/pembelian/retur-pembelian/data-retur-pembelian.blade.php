<div class="grid grid-cols-12 gap-2 mt-8">
    <!-- BEGIN: Data List -->
    <div class="col-span-12 overflow-auto intro-y lg:overflow-visible">
        <div class="flex justify-start items-center gap-2">
            @can('tambah_retur_pembelian')
                <a href="/tambah-retur-pembelian">
                    <button class="shadow-md btn btn-primary" wire:ignore>
                        <i data-feather="edit-3" class="w-4 h-4 mr-2"></i> Tambah
                    </button>
                </a>
            @endcan

            <div class="relative w-56 text-slate-500" wire:ignore>
                <input type="text" class="w-full pr-10 form-control box" placeholder="Cari nomor faktur..."
                    wire:model.live='search'>
                <i class="absolute inset-y-0 right-0 w-4 h-4 my-auto mr-3" data-feather="search"></i>
            </div>

            <div class="flex items-center gap-2">
                <input id="startDate" type="date" placeholder="Stok dari master" wire:model.live='startDate'
                    class="form-control">
                <span class="w-full">s.d</span>
                <input id="endDate" type="date" placeholder="Stok dari master" wire:model.live='endDate'
                    class="form-control">
            </div>

            <button onclick="location.reload()" class="btn btn-md btn-secondary" wire:ignore>
                <i data-feather="refresh-cw" class="w-4 h-4 mr-1"></i> Reload
            </button>
        </div>

        <div class="table-wrapper">
            <table class="table -mt-1 table-report">
                <style>
                    .table-wrapper {
                        overflow-x: auto;
                    }

                    .table-report {
                        width: 100%;
                        border-collapse: collapse;
                    }

                    .table-report th,
                    .table-report td {
                        padding: 8px 12px;
                        text-align: center;
                    }

                    .table-report thead th {
                        background-color: #d3d3d3;
                        color: black;
                    }

                    @media screen and (max-width: 768px) {

                        .table-report th,
                        .table-report td {
                            width: auto;
                            display: block;
                            text-align: left;
                        }

                        .table-report th {
                            text-align: right;
                        }
                    }
                </style>
                <thead>
                    <tr>
                        <th class="whitespace-nowrap">No. Reff</th>
                        <th class="whitespace-nowrap">No. Faktur</th>
                        <th class="whitespace-nowrap">Tgl. Input</th>
                        <th class="whitespace-nowrap">Nama Supplier</th>
                        <th class="whitespace-nowrap">No. Seri Pajak</th>
                        <th class="whitespace-nowrap">DPP</th>
                        <th class="whitespace-nowrap">PPN</th>
                        <th class="whitespace-nowrap">Total</th>
                        <th class="whitespace-nowrap">Keterangan</th>
                        <th class="whitespace-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($returPembelian as $retur)
                        <tr class="intro-x">
                            <td class="whitespace-nowrap">{{ $retur->no_reff }}</td>
                            <td class="whitespace-nowrap">{{ $retur->no_faktur }}</td>
                            <td class="whitespace-nowrap">{{ $retur->tgl_input->format('d-m-Y') }}</td>
                            <td class="whitespace-nowrap">{{ $retur->suplier->nama_suplier }}</td>
                            <td class="whitespace-nowrap">{{ $retur->no_seri_pajak ?? '-' }}</td>
                            <td class="whitespace-nowrap">{{ number_format($retur->dpp, 0, ',', '.') }}</td>
                            <td class="whitespace-nowrap">{{ number_format($retur->ppn, 0, ',', '.') }}</td>
                            <td class="whitespace-nowrap">{{ number_format($retur->ppn + $retur->dpp, 0, ',', '.') }}
                            </td>
                            <td class="whitespace-nowrap">{{ $retur->keterangan }}</td>
                            <td class="flex gap-2 whitespace-nowrap">
                                @can('aksi_retur_pembelian')
                                    <a href="/cetak-retur-pembelian-pdf/{{ $retur->id }}">
                                        <button class="btn btn-sm btn-outline-primary">Print</button>
                                    </a>
                                    <button class="btn btn-sm btn-outline-danger"
                                        wire:confirm='Apakah anda yakin akan menghapus data?'
                                        wire:click='hapusReturPembelian({{ $retur->id }})'>Delete</button>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr class="intro-x">
                            <td class="font-bold text-center text-pending whitespace-nowrap" colspan="10">Belum ada
                                data tersedia</td>
                        </tr>
                    @endforelse
                    <tr>
                        <td colspan="5" class="font-bold text-center whitespace-nowrap">Total</td>
                        <td class="font-bold whitespace-nowrap">
                            {{ number_format($returPembelian->sum('dpp'), 0, ',', '.') }}</td>
                        <td class="font-bold whitespace-nowrap">
                            {{ number_format($returPembelian->sum('ppn'), 0, ',', '.') }}
                        </td>
                        <td class="font-bold whitespace-nowrap">
                            {{ number_format($returPembelian->sum('ppn') + $returPembelian->sum('dpp'), 0, ',', '.') }}
                        </td>
                        <td class="whitespace-nowrap"></td>
                        <td class="whitespace-nowrap"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- END: Data List -->
</div>
