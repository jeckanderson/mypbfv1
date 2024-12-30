@extends('layout.main')

@section('main')
    <div class="flex items-center mt-8 intro-y">
        <h2 class="mr-auto text-lg font-medium text-primary">
            Data Golongan
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-2 mt-8">
        <div class="flex flex-wrap items-center col-span-12 mt-2 intro-y sm:flex-nowrap">
            @can('tambah_golongan')
                <button class="mr-2 shadow-md btn btn-primary" data-tw-toggle="modal" data-tw-target="#tambah-sub-golongan"><i
                        data-feather="edit-3" class="w-4 h-4 mr-3"></i> Tambah</button>
                <!-- BEGIN: Modal Content -->
                @include('components.modal.modal-sub-golongan', [
                    'id_modal' => 'tambah-sub-golongan',
                    'route' => 'tambah.sub-golongan',
                    'id' => '',
                    'sub' => '',
                ])
            @endcan
            <!-- END: Modal Content -->

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
                        <th class="whitespace-nowrap">Nama Golongan</th>
                        <th class="text-center whitespace-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($subs as $sub)
                        <tr class="intro-x">
                            <td class="w-40">{{ $loop->iteration }}</td>
                            <td class="">{{ $sub->sub_golongan }}</td>
                            <td class="w-56 table-report__action">
                                @can('aksi_golongan')
                                    <div class="flex items-center justify-center">
                                        @if (!in_array($sub->sub_golongan, $undeleted))
                                            <a class="flex items-center mr-3 text-primary" href="javascript:;"
                                                data-tw-toggle="modal" data-tw-target="#edit-sub-golongan{{ $sub->id }}">
                                                <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
                                            <a class="flex items-center text-danger" href="javascript:;" data-tw-toggle="modal"
                                                data-tw-target="#delete-confirmation-modal{{ $sub->id }}"> <i
                                                    data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
                                            <!-- BEGIN: Delete Confirmation Modal -->
                                            @include('components.modal-delete', [
                                                'id_modal' => 'delete-confirmation-modal',
                                                'id' => $sub->id,
                                                'route' => 'delete.sub-golongan',
                                            ])
                                            <!-- END: Delete Confirmation Modal -->

                                            {{-- edit modal --}}
                                            @include('components.modal.modal-sub-golongan', [
                                                'id_modal' => 'edit-sub-golongan',
                                                'route' => 'edit.sub-golongan',
                                                'id' => $sub->id,
                                            ])
                                        @endif
                                    </div>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr class="intro-x">
                            <td class="font-bold text-center" colspan="3">Belum ada data tersedia</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- END: Data List -->
    </div>
@endsection
