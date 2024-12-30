<div class="">
    <div class="grid grid-cols-12 gap-2 mt-8">
        <div class="flex flex-wrap items-center col-span-12 mt-2 intro-y sm:flex-nowrap">
            @can('tambah_ekspedisi')
                <button class="mr-2 shadow-md btn btn-primary" data-tw-toggle="modal" data-tw-target="#tambah-ekspedisi"><i
                        data-feather="edit-3" class="w-4 h-4 mr-3"></i> Tambah</button>
                <div id="tambah-ekspedisi" class="modal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <livewire:master.modal-data-ekspedisi />
                    </div>
                </div>
            @endcan

            @include('components.search', [
                'id_table' => 'myTable',
            ])
            <p class="font-bold" wire:loading>Memproses...</p>
        </div>
        <div class="col-span-12 overflow-auto intro-y lg:overflow-visible">
            <table class="table -mt-2 table-report" id="myTable">
                <thead style="background-color: #d3d3d3;">
                    <tr>
                        <th class="whitespace-nowrap">No</th>
                        <th class="whitespace-nowrap">Nama Ekspedisi</th>
                        <th class="whitespace-nowrap">Plat Nomor Armada </th>
                        <th class="text-center whitespace-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dataEkspedisi as $ekspedisi)
                        <tr class="intro-x">
                            <td class="">{{ $loop->iteration }}</td>
                            <td class="">{{ $ekspedisi->nama_ekspedisi }}</td>
                            <td class="">{{ $ekspedisi->nomor ? $ekspedisi->nomor : 'Belum ditambahkan' }}</td>
                            <td class="w-56 table-report__action">
                                @can('aksi_ekspedisi')
                                    <div class="flex items-center justify-center" wire:ignore>
                                        <button class="flex items-center mr-3 text-primary" data-tw-toggle="modal"
                                            wire:ignore data-tw-target="#edit-ekspedisi{{ $ekspedisi->id }}"> <i
                                                data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit </button>
                                        <button class="flex items-center text-danger" data-tw-toggle="modal"
                                            wire:click='deleteEKspedisi({{ $ekspedisi->id }})' wire:ignore
                                            wire:confirm='Apakah anda yakin akan menghapus?'
                                            data-tw-target="#delete-confirmation-modal{{ $ekspedisi->id }}"> <i
                                                data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete </button>
                                        <div id="edit-ekspedisi{{ $ekspedisi->id }}" class="modal" tabindex="-1"
                                            aria-hidden="true" wire:ignore>
                                            <div class="modal-dialog">
                                                <livewire:master.modal-data-ekspedisi :id="$ekspedisi->id" />
                                            </div>
                                        </div>
                                    </div>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr class="intro-x">
                            <td class="font-bold text-center text-pending" colspan="4">Belum ada data tersedia!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
