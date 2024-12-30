@extends('layout.main')

@section('main')
    <div class="flex items-center mt-8 intro-y">
        <h2 class="mr-auto text-lg font-medium text-primary">
            Data Target Supervisor
        </h2>
    </div>
    @if (session('success'))
        @include('components.alert')
    @endif
    <div class="grid grid-cols-12 gap-2 mt-8">
        <div class="flex flex-wrap items-center col-span-12 mt-2 intro-y sm:flex-nowrap">
            @can('tambah_target_spv')
                <button class="mr-2 shadow-md btn btn-primary" data-tw-toggle="modal" data-tw-target="#tambah-target"><i
                        data-feather="edit-3" class="w-4 h-4 mr-3"></i> Tambah</button>
                @include('components.modal.modal-target-spv', [
                    'id_modal' => 'tambah-target',
                    'route' => 'tambah.target_spv',
                    'id' => '',
                    'supervisor_id' => '',
                    'target' => '',
                    'lihat' => false,
                ])
            @endcan
            @include('components.search', [
                'id_table' => 'myTable',
            ])
        </div>
        <!-- BEGIN: Data List -->
        <div class="col-span-12 overflow-auto intro-y lg:overflow-visible">
            <table class="table -mt-2 table-report" id="myTable">
                <thead style="background-color: #d3d3d3;">
                    <tr>
                        <th class="whitespace-nowrap">No</th>
                        <th class="whitespace-nowrap">Supervisor</th>
                        <th class="whitespace-nowrap">Area Rayon</th>
                        <th class="whitespace-nowrap">Tahun</th>
                        <th class="text-center whitespace-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($targets as $target)
                        <tr class="intro-x">
                            <td class="w-40">{{ $loop->iteration }}</td>
                            <td class="">{{ optional($target->pegawai)->nama_pegawai ?? '-' }}</td>
                            <td class="">{{ optional($target->rayon)->area_rayon ?? '-' }}</td>
                            <td class="">{{ $target->tahun }}</td>
                            <td class="w-56 table-report__action">
                                @can('aksi_target_spv')
                                    <div class="flex items-center justify-center">
                                        <a class="flex items-center mx-3 mr-3 text-primary" href="javascript:;"
                                            data-tw-toggle="modal" data-tw-target="#modal-lihat{{ $target->id }}"> <i
                                                data-feather="navigation" class="w-4 h-4 mr-1"></i> Detail </a>
                                        <a class="flex items-center mr-3 text-primary" href="javascript:;"
                                            data-tw-toggle="modal" data-tw-target="#modal-edit{{ $target->id }}"> <i
                                                data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
                                        <a class="flex items-center text-danger" href="javascript:;" data-tw-toggle="modal"
                                            data-tw-target="#delete-confirmation-modal{{ $target->id }}"> <i
                                                data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
                                        <!-- BEGIN: Delete Confirmation Modal -->
                                        @include('components.modal-delete', [
                                            'id_modal' => 'delete-confirmation-modal',
                                            'id' => $target->id,
                                            'route' => 'delete.target_spv',
                                        ])
                                        <!-- END: Delete Confirmation Modal -->

                                        {{-- modal lihat --}}
                                        @include('components.modal.modal-target-spv', [
                                            'id_modal' => 'modal-lihat',
                                            'id' => $target->id,
                                            'supervisor_id' => $target->supervisor,
                                            'route' => 'tambah.target_spv',
                                            'lihat' => true,
                                        ])

                                        {{-- modal edit --}}
                                        @include('components.modal.modal-target-spv', [
                                            'id_modal' => 'modal-edit',
                                            'id' => $target->id,
                                            'supervisor_id' => $target->supervisor,
                                            'route' => 'edit.target_spv',
                                            'lihat' => false,
                                        ])
                                    </div>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr class="intro-x">
                            <td class="font-bold text-center text-pending" colspan="5">Belum ada data tersedia</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- END: Data List -->
    </div>
@endsection
