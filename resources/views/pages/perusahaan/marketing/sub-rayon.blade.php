@extends('layout.main')

@section('main')
    <div class="flex items-center mt-8 intro-y">
        <h2 class="mr-auto text-lg font-medium text-primary">
            Data Sub Rayon
        </h2>
    </div>
    @include('components.alert')
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="flex flex-wrap items-center col-span-12 mt-5 intro-y sm:flex-nowrap">
            @can('tambah_sub_rayon')
                <button class="mr-2 shadow-md btn btn-primary" data-tw-toggle="modal" data-tw-target="#basic-modal-preview"><i
                        data-feather="edit-3" class="w-4 h-4 mr-3"></i> Tambah</button>
                <!-- BEGIN: Modal Content -->
                <div id="basic-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="p-10 modal-body">
                                <div class="preview">
                                    <form action="{{ route('tambah.sub_rayon') }}" method="POST">
                                        @csrf
                                        <div>
                                            <label for="vertical-form-1" class="font-medium form-label text-primary">Sub
                                                Rayon</label>
                                            <input id="vertical-form-1" type="text" class="form-control"
                                                placeholder="Masukan Sub Rayon" name="sub_rayon">
                                        </div>
                                        <button type="submit" class="mt-5 btn btn-primary">Simpan</button>
                                        <button class="mt-5 btn btn-outline-danger" data-tw-dismiss="modal" type="button">
                                            Batal </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan
            <!-- END: Modal Content -->
            @include('components.search', [
                'id_table' => 'myTable',
            ])
        </div>
    </div>
    <!-- BEGIN: Data List -->
    <div class="col-span-12 overflow-auto intro-y lg:overflow-visible">
        <table class="table -mt-5 table-report" id="myTable">
            <thead style="background-color: #d3d3d3;">
                <tr>
                    <th class="whitespace-nowrap">No</th>
                    <th class="whitespace-nowrap">Nama Sub Rayon</th>
                    <th class="text-center whitespace-nowrap">Actions</th>
                </tr>
            </thead>
            <tbody>
                @if (!$subRayons->isNotEmpty())
                    <tr class="intro-x">
                        <td class="font-bold text-center text-pending" colspan="3">Belum ada data tersedia</td>
                    </tr>
                @endif
                @foreach ($subRayons as $rayon)
                    <tr class="intro-x">
                        <td class="w-40">{{ $loop->iteration }}</td>
                        <td class="">{{ $rayon->sub_rayon }}</td>
                        <td class="w-56 table-report__action">
                            @can('aksi_sub_rayon')
                                <div class="flex items-center justify-center text-primary">
                                    <a class="flex items-center mr-3" href="javascript:;" data-tw-toggle="modal"
                                        data-tw-target="#edit-rayon{{ $rayon->id }}"> <i data-feather="check-square"
                                            class="w-4 h-4 mr-1"></i> Edit </a>
                                    <a class="flex items-center text-danger" href="javascript:;" data-tw-toggle="modal"
                                        data-tw-target="#delete-confirmation-modal{{ $rayon->id }}"> <i
                                            data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
                                    <!-- BEGIN: Delete Confirmation Modal -->
                                    @include('components.modal-delete', [
                                        'id_modal' => 'delete-confirmation-modal',
                                        'id' => $rayon->id,
                                        'route' => 'delete.sub_rayon',
                                    ])
                                    <!-- END: Delete Confirmation Modal -->

                                    <!-- BEGIN: edit Content -->
                                    <div id="edit-rayon{{ $rayon->id }}" class="modal" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="p-10 modal-body">
                                                    <div class="preview">
                                                        <form action="{{ route('edit.sub_rayon', ['id' => $rayon->id]) }}"
                                                            method="POST">
                                                            @csrf
                                                            <div>
                                                                <label for="vertical-form-1"
                                                                    class="font-medium form-label text-primary">Sub
                                                                    Rayon</label>
                                                                <input id="vertical-form-1" type="text" class="form-control"
                                                                    placeholder="Masukan Area Rayon" name="sub_rayon"
                                                                    value="{{ $rayon->sub_rayon }}">
                                                            </div>
                                                            <button type="submit" class="mt-5 btn btn-primary">Simpan</button>
                                                            <button class="mt-5 btn btn-outline-danger" data-tw-dismiss="modal"
                                                                type="button"> Batal </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END: Modal Content -->
                                </div>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- END: Data List -->
    </div>
@endsection