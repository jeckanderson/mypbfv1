@extends('layout.main')

@section('main')
    <div class="flex items-center mt-8 intro-y">
        <h2 class="mr-auto text-lg font-medium text-primary">
            Data Akun Akuntansi
        </h2>
    </div>
    @include('components.alert')
    <div class="grid grid-cols-12 gap-2 mt-8">
        <div class="flex flex-wrap items-center col-span-12 mt-2 intro-y sm:flex-nowrap">
            @can('tambah_akun_akuntansi')
                <button class="mr-2 shadow-md btn btn-primary" data-tw-toggle="modal" data-tw-target="#tambah-akun"><i
                        data-feather="edit-3" class="w-4 h-4 mr-3"></i> Tambah</button>

                <!-- BEGIN: tambah data -->
                @include('components.modal.modal-akun-akutansi', [
                    'id_modal' => 'tambah-akun',
                    'route' => 'tambah.akun-akutansi',
                    'id' => '',
                    'akun' => '',
                ])
            @endcan
            <button class="mr-2 shadow-md btn btn-pending" data-tw-toggle="modal" data-tw-target="#tampil-jenis-akun"><i
                    data-feather="rss" class="w-4 h-4 mr-3"></i> Jenis Akun</button>
            <!-- END: tambah data -->
            <!-- BEGIN: tampil jenis akun -->
            <div id="tampil-jenis-akun" class="modal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="p-10 modal-body">
                            <table class="table border border-slate-600">
                                <thead class="font-bold text-center">
                                    <tr>
                                        <td class="border border-slate-600">Kode</td>
                                        <td class="border border-slate-600">Jenis Akun</td>
                                        <td class="border border-slate-600">Debet</td>
                                        <td class="border border-slate-600">Kredit</td>
                                        <td class="border border-slate-600">Laporan</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="border border-slate-600">1-0000</td>
                                        <td class="border border-slate-600">Aktiva</td>
                                        <td class="text-lg text-center border border-slate-600">+</td>
                                        <td class="text-lg text-center border border-slate-600">-</td>
                                        <td class="border border-slate-600">Neraca</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-slate-600">2-0000</td>
                                        <td class="border border-slate-600">Kewajiban</td>
                                        <td class="text-lg text-center border border-slate-600">-</td>
                                        <td class="text-lg text-center border border-slate-600">+</td>
                                        <td class="border border-slate-600">Neraca</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-slate-600">3-0000</td>
                                        <td class="border border-slate-600">Modal</td>
                                        <td class="text-lg text-center border border-slate-600">-</td>
                                        <td class="text-lg text-center border border-slate-600">+</td>
                                        <td class="border border-slate-600">Neraca</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-slate-600">4-0000</td>
                                        <td class="border border-slate-600">Pendapatan</td>
                                        <td class="text-lg text-center border border-slate-600">-</td>
                                        <td class="text-lg text-center border border-slate-600">+</td>
                                        <td class="border border-slate-600">Laba/Rugi</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-slate-600">5-0000</td>
                                        <td class="border border-slate-600">HPP</td>
                                        <td class="text-lg text-center border border-slate-600">+</td>
                                        <td class="text-lg text-center border border-slate-600">-</td>
                                        <td class="border border-slate-600">Laba/Rugi</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-slate-600">6-0000</td>
                                        <td class="border border-slate-600">Biaya</td>
                                        <td class="text-lg text-center border border-slate-600">+</td>
                                        <td class="text-lg text-center border border-slate-600">-</td>
                                        <td class="border border-slate-600">Laba/Rugi</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-slate-600">7-0000</td>
                                        <td class="border border-slate-600">Pendapatan Lain</td>
                                        <td class="text-lg text-center border border-slate-600">-</td>
                                        <td class="text-lg text-center border border-slate-600">+</td>
                                        <td class="border border-slate-600">Laba/Rugi</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-slate-600">8-0000</td>
                                        <td class="border border-slate-600">Biaya Lain</td>
                                        <td class="text-lg text-center border border-slate-600">+</td>
                                        <td class="text-lg text-center border border-slate-600">-</td>
                                        <td class="border border-slate-600">Laba/Rugi</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: tampil jenis akun -->

            @include('components.search', [
                'id_table' => 'myTable',
            ])
        </div>
        <!-- BEGIN: Data List -->
        <div class="col-span-12 overflow-auto intro-y lg:overflow-visible">
            <table class="table -mt-2 table-report" id="myTable">
                <thead style="background-color: #d3d3d3;">
                    <tr>
                        <th class="whitespace-nowrap">Kode</th>
                        <th class="whitespace-nowrap">Nama Akun</th>
                        <th class="whitespace-nowrap">Jenis</th>
                        <th class="text-center whitespace-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($akunTetap as $akun)
                        <tr class="intro-x">
                            <td class="w-40">{{ $akun->kode }}</td>
                            <td>{{ $akun->nama_akun }}</td>
                            <td>{{ $akun->jenis_akun }}</td>
                            <td class="text-center text-pending">Tidak Tersedia</td>
                        </tr>
                    @endforeach
                    @forelse ($akuns as $akun)
                        <tr class="intro-x">
                            <td class="w-40">{{ $akun->kode }}</td>
                            <td>{{ $akun->nama_akun }}</td>
                            <td>{{ $akun->jenis_akun }}</td>
                            <td class="w-56 table-report__action">
                                @can('aksi_akun_akuntansi')
                                    <div class="flex items-center justify-center">
                                        <a class="flex items-center mr-3 text-primary" href="javascript:;"
                                            data-tw-toggle="modal" data-tw-target="#edit-akun{{ $akun->id }}">
                                            <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit
                                        </a>
                                        <a class="flex items-center text-danger" href="javascript:;" data-tw-toggle="modal"
                                            data-tw-target="#delete-confirmation-modal{{ $akun->id }}">
                                            <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete
                                        </a>
                                        <!-- BEGIN: Delete Confirmation Modal -->
                                        @include('components.modal-delete', [
                                            'id_modal' => 'delete-confirmation-modal',
                                            'id' => $akun->id,
                                            'route' => 'delete.akun-akutansi',
                                        ])
                                        <!-- END: Delete Confirmation Modal -->

                                        @include('components.modal.modal-akun-akutansi', [
                                            'id_modal' => 'edit-akun',
                                            'route' => 'edit.akun-akutansi',
                                            'id' => $akun->id,
                                        ])
                                    </div>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr class="intro-x">
                            <td class="font-bold text-center" colspan="4">Data Masih Default</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- END: Data List -->
    </div>
@endsection
