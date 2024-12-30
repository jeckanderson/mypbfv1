@extends('layout.main')

@section('main')
    <div class="flex items-center mt-8 intro-y">
        <h2 class="mr-auto text-lg font-medium text-primary">
            Data User
        </h2>
    </div>
    @if (session('success'))
        @include('components.alert')
    @endif
    <div class="grid grid-cols-12 gap-2 mt-8">
        <div class="flex flex-wrap items-center col-span-12 mt-2 intro-y sm:flex-nowrap">
            @can('tambah_user')
                <button class="mr-2 shadow-md btn btn-primary" data-tw-toggle="modal" data-tw-target="#basic-modal-preview"><i
                        data-feather="edit-3" class="w-4 h-4 mr-3"></i> Tambah</button>
            @endcan
            <!-- BEGIN: Modal Content -->
            <div id="basic-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="p-10 modal-body">
                            <form action="{{ route('tambah.set_user') }}" method="POST">
                                @csrf
                                <div class="preview">
                                    <div class="col-span-12 mt-3 intro-y sm:col-span-6">
                                        <label for="input-wizard-6" class="form-label">Nama Pegawai</label>
                                        <select id="input-wizard-6" class="form-select" required name="name">
                                            @foreach ($pegawais as $pegawai)
                                                <option>{{ $pegawai->nama_pegawai }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-span-12 mt-3 intro-y sm:col-span-6">
                                        <label for="input-wizard-6" class="form-label">Tingkat Akses</label>
                                        <select id="input-wizard-6" class="form-select" required name="role">
                                            @foreach ($roles as $role)
                                                <option>{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label for="vertical-form-1" class="form-label">Email</label>
                                        <input id="vertical-form-1" type="email" class="form-control"
                                            placeholder="Masukan email anda" required name="email">
                                    </div>
                                    <div class="mt-3">
                                        <label for="vertical-form-1" class="form-label">Password</label>
                                        <input id="vertical-form-1" type="password" class="form-control" placeholder=""
                                            required name="password">
                                    </div>
                                    <div class="mt-3">
                                        <div class="form-check form-switch">
                                            <label class="form-check-label" for="checkbox-switch-7">Aktif</label>
                                            <input id="checkbox-switch-7" class="mx-3 form-check-input" type="checkbox"
                                                checked name="status">
                                        </div>
                                    </div>
                                    <button type="submit" class="mt-5 btn btn-primary"> Simpan </button>
                                    <button class="mt-5 btn btn-outline-danger" data-tw-dismiss="modal" type="button">
                                        Batal </button>
                                </div>
                            </form>
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
        <div class="col-span-12 overflow-auto intro-y lg:overflow-visible">
            <table class="table -mt-2 table-report" id="myTable">
                <thead style="background-color: #d3d3d3;">
                    <tr>
                        <th class="whitespace-nowrap">No</th>
                        <th class="whitespace-nowrap">Email</th>
                        <th class="whitespace-nowrap">Nama Pegawai</th>
                        <th class="whitespace-nowrap">Tingkat Akses</th>
                        <th class="text-center whitespace-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="intro-x">
                            <td class="w-40">{{ $loop->iteration }}</td>
                            <td class="">{{ $user->email }}</td>
                            <td class="">{{ $user->name }}</td>
                            <td class="">{{ $user->status == 'main' ? 'Akun Utama' : $user->getRoleNames()->first() }}
                            </td>
                            <td class="w-56 table-report__action">
                                <div class="flex items-center justify-center text-primary">
                                    @can('aksi_user')
                                        @if (!$user->id == Auth::user()->id && !$user->status == 'main')
                                            <a class="flex items-center mr-3" href="javascript:;" data-tw-toggle="modal"
                                                data-tw-target="#edit-modal{{ $user->id }}"> <i data-feather="check-square"
                                                    class="w-4 h-4 mr-1"></i> Edit </a>
                                            <a class="flex items-center text-danger" href="javascript:;" data-tw-toggle="modal"
                                                data-tw-target="#delete-confirmation-modal{{ $user->id }}"> <i
                                                    data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
                                        @elseif($user->status != 'main')
                                            <a class="flex items-center mr-3" href="javascript:;" data-tw-toggle="modal"
                                                data-tw-target="#edit-modal{{ $user->id }}"> <i data-feather="check-square"
                                                    class="w-4 h-4 mr-1"></i> Edit </a>
                                            @if ($user->id != Auth::user()->id)
                                                <a class="flex items-center text-danger" href="javascript:;"
                                                    data-tw-toggle="modal"
                                                    data-tw-target="#delete-confirmation-modal{{ $user->id }}"> <i
                                                        data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
                                            @endif
                                        @else
                                            <p class="font-bold text-pending">Tidak Tersedia</p>
                                        @endif
                                        <!-- BEGIN: Delete Confirmation Modal -->
                                        @include('components.modal-delete', [
                                            'id_modal' => 'delete-confirmation-modal',
                                            'id' => $user->id,
                                            'route' => 'delete.set_user',
                                        ])
                                        <!-- END: Delete Confirmation Modal -->

                                        <!-- BEGIN: Modal Content -->
                                        <div id="edit-modal{{ $user->id }}" class="modal" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="p-10 modal-body">
                                                        <form action="{{ route('edit.set_user', ['id' => $user->id]) }}"
                                                            method="POST">
                                                            @csrf
                                                            <div class="preview">
                                                                <div class="col-span-12 mt-3 intro-y sm:col-span-6">
                                                                    <label for="input-wizard-6" class="form-label">Nama
                                                                        Pegawai</label>
                                                                    <select id="input-wizard-6" class="form-select" required
                                                                        name="name">
                                                                        @foreach ($pegawais as $pegawai)
                                                                            <option
                                                                                {{ $user->name == $pegawai->nama_pegawai ? 'selected' : '' }}>
                                                                                {{ $pegawai->nama_pegawai }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-span-12 mt-3 intro-y sm:col-span-6">
                                                                    <label for="input-wizard-6" class="form-label">Tingkat
                                                                        Akses</label>
                                                                    <select id="input-wizard-6" class="form-select" required
                                                                        name="role">
                                                                        @foreach ($roles as $role)
                                                                            <option
                                                                                {{ $user->getRoleNames()->first() == $role->name ? 'selected' : '' }}>
                                                                                {{ $role->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div>
                                                                    <label for="vertical-form-1"
                                                                        class="form-label">Email</label>
                                                                    <input id="vertical-form-1" type="email"
                                                                        class="form-control" placeholder="Masukan email anda"
                                                                        required name="email" value="{{ $user->email }}">
                                                                </div>
                                                                <div class="mt-3">
                                                                    <label for="vertical-form-1"
                                                                        class="form-label">Password</label>
                                                                    <input id="vertical-form-1" type="password"
                                                                        class="form-control" placeholder="" required
                                                                        name="password" value="{{ $user->password }}">
                                                                </div>
                                                                <div class="mt-3">
                                                                    <div class="form-check form-switch">
                                                                        <label class="form-check-label"
                                                                            for="checkbox-switch-7">Aktif</label>
                                                                        <input id="checkbox-switch-7"
                                                                            class="mx-3 form-check-input" type="checkbox"
                                                                            checked name="status"
                                                                            {{ $user->status == '1' ? 'checked' : '' }}>
                                                                    </div>
                                                                </div>
                                                                <button type="submit"
                                                                    class="mt-5 btn btn-primary">Simpan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END: Modal Content -->
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- END: Data List -->
    </div>
@endsection
