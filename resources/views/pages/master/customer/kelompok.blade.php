@extends('layout.main')

@section('main')
    <div class="flex items-center mt-8 intro-y">
        <h2 class="mr-auto text-lg font-medium text-primary">
            Data Kelompok
        </h2>
    </div>
    @include('components.alert')
    <div class="grid grid-cols-12 gap-2 mt-8">
        <div class="flex flex-wrap items-center col-span-12 mt-2 intro-y sm:flex-nowrap">
            @can('tambah_kelompok')
                <button class="mr-2 shadow-md btn btn-primary" data-tw-toggle="modal" data-tw-target="#tambah-kelompok"><i
                        data-feather="edit-3" class="w-4 h-4 mr-3"></i> Tambah</button>

                <!-- BEGIN: Modal Content -->
                @include('components.modal.modal-kelompok', [
                    'id_modal' => 'tambah-kelompok',
                    'route' => 'tambah.kelompok',
                    'id' => '',
                    'kelompok' => '',
                ])
                <!-- END: Modal Content -->
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
                        <th class="whitespace-nowrap">Nama Kelompok</th>
                        <th class="text-center whitespace-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kelompoks as $kelompok)
                        <tr class="intro-x">
                            <td class="w-40">{{ $loop->iteration }}</td>
                            <td class="">{{ $kelompok->kelompok }}</td>
                            <td class="w-56 table-report__action">
                                @can('aksi_kelompok')
                                    <div class="flex items-center justify-center">
                                        <a class="flex items-center mr-3 text-primary" href="javascript:;"
                                            data-tw-toggle="modal" data-tw-target="#edit-kelompok{{ $kelompok->id }}"> <i
                                                data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
                                        <a class="flex items-center text-danger" href="javascript:;" data-tw-toggle="modal"
                                            data-tw-target="#delete-confirmation-modal{{ $kelompok->id }}"> <i
                                                data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
                                        <!-- BEGIN: Delete Confirmation Modal -->
                                        @include('components.modal-delete', [
                                            'id_modal' => 'delete-confirmation-modal',
                                            'id' => $kelompok->id,
                                            'route' => 'delete.kelompok',
                                        ])
                                        <!-- END: Delete Confirmation Modal -->

                                        @include('components.modal.modal-kelompok', [
                                            'id_modal' => 'edit-kelompok',
                                            'route' => 'edit.kelompok',
                                            'id' => $kelompok->id,
                                        ])
                                    </div>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr class="intro-x">
                            <td class="font-bold text-center text-pending" colspan="3">Belum ada data tersedia</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- END: Data List -->
    </div>
@endsection
