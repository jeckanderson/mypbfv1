@extends('layout.main')

@section('main')
    <div class="flex items-center mt-8 intro-y">
        <h2 class="mr-auto text-lg font-medium text-primary">
            Data Jabatan
        </h2>
    </div>
    @include('components.alert')
    <div class="grid grid-cols-12 mt-8">
        <div class="flex flex-wrap items-center col-span-12 mt-3 intro-y sm:flex-nowrap">
            @can('tambah_jabatan')
                <button class="mr-2 shadow-md btn btn-primary" data-tw-toggle="modal" data-tw-target="#basic-modal-preview"><i
                        data-feather="edit-3" class="w-4 h-4 mr-3"></i> Tambah</button>
            @endcan
            <!-- BEGIN: Modal Content -->
            <div id="basic-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="p-10 modal-body">
                            <div class="preview">
                                <form action="{{ route('create.jabatan') }}" method="POST">
                                    @csrf
                                    <div>
                                        <label for="vertical-form-1"
                                            class="font-medium form-label text-primary">Jabatan</label>
                                        <input id="vertical-form-1" name="jabatan" type="text" class="form-control"
                                            placeholder="Masukan Jabatan">
                                    </div>
                                    <button class="mt-5 btn btn-primary" type="submit"> Simpan </button>
                                    <button class="mt-5 btn btn-outline-danger" data-tw-dismiss="modal" type="button">
                                        Batal </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Modal Content -->

            @include('components.search', [
                'id_table' => 'myTable',
            ])
        </div>
        <!-- BEGIN: Data List -->
        <div class="col-span-12 mt-2 overflow-auto intro-y lg:overflow-visible">
            <table class="table table-report" id="myTable" style="border: 1px solid #add8e6;">
                <thead style="background-color: #add8e6; border-bottom: 2px solid #add8e6;">
                    <tr>
                        <th style="border: 1px solid #add8e6; padding: 4px; width: 30px;">No</th>
                        <th style="border: 1px solid #add8e6; padding: 4px;">Jabatan</th>
                        <th style="border: 1px solid #add8e6; padding: 4px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jabatans as $jabatan)
                        <tr class="intro-x">
                            <td style="border: 1px solid #add8e6; padding: 4px;">{{ $loop->iteration }}</td>
                            <td style="border: 1px solid #add8e6; padding: 4px;">{{ $jabatan->jabatan }}</td>
                            <td style="border: 1px solid #add8e6; padding: 4px;" class="w-56 table-report__action">
                                <div class="flex items-center justify-center text-primary">
                                    @can('aksi_jabatan')
                                        @if (!in_array($jabatan->jabatan, $undeleted))
                                            <a data-tw-toggle="modal" data-tw-target="#edit-modal{{ $jabatan->id }}"
                                                class="flex items-center mr-3" href="javascript:;">
                                                <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit
                                            </a>
                                            <a class="flex items-center text-danger" href="javascript:;" data-tw-toggle="modal"
                                                data-tw-target="#delete-confirmation-modal{{ $jabatan->id }}">
                                                <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete
                                            </a>
                                        @endif

                                        @include('components.modal-delete', [
                                            'id_modal' => 'delete-confirmation-modal',
                                            'route' => 'delete.jabatan',
                                            'id' => $jabatan->id,
                                        ])

                                        <!-- BEGIN: Modal Content -->
                                        <div id="edit-modal{{ $jabatan->id }}" class="modal" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="p-10 modal-body">
                                                        <div class="preview">
                                                            <form action="{{ route('edit.jabatan', ['id' => $jabatan->id]) }}"
                                                                method="POST">
                                                                @csrf
                                                                <div>
                                                                    <label for="vertical-form-1"
                                                                        class="font-medium form-label text-primary">Jabatan</label>
                                                                    <input value="{{ $jabatan->jabatan }}" id="vertical-form-1"
                                                                        name="jabatan" type="text" class="form-control"
                                                                        placeholder="Masukan jabatan Anda">
                                                                </div>
                                                                <button class="mt-5 btn btn-primary"
                                                                    type="submit">Simpan</button>
                                                                <button class="mt-5 btn btn-outline-danger"
                                                                    data-tw-dismiss="modal" type="button">
                                                                    Batal
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END: Modal Content -->
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="intro-x">
                            <td colspan="3" class="font-bold text-center text-pending">Data belum tersedia</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- END: Data List -->
    </div>
@endsection
