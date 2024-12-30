@extends('layout.main')

@section('main')
    <div class="flex items-center mt-8 intro-y">
        <h2 class="mr-auto text-lg font-medium text-primary">
            Data Pelanggan
        </h2>
    </div>
    <div class="flex justify-between gap-2 mt-8">
        <div class="flex flex-wrap items-center col-span-12 mt-0 mr-auto intro-y sm:flex-nowrap">
            @can('tambah_pelanggan')
                <button class="mr-2 shadow-md btn btn-primary" data-tw-toggle="modal" data-tw-target="#tambah-pelanggan"><i
                        data-feather="edit-3" class="w-4 h-4 mr-3"></i> Tambah</button>

                <!-- BEGIN: Modal Content -->
                @include('components.modal.modal-pelanggan', [
                    'id_modal' => 'tambah-pelanggan',
                    'route' => 'tambah.pelanggan',
                    'id' => '',
                    'pelanggan' => '',
                ])
                <!-- END: Modal Content -->
            @endcan
            <div data-tw-merge class="items-center block sm:flex ">
                <form action="{{ route('pelanggan') }}" method="GET" class=" flex gap-2">
                    <div class="relative w-56 text-slate-500 {{ $class ?? '' }}">
                        <input type="text" class="w-56 pr-10 form-control cari box" placeholder="Search..."
                            name="search" value="{{ request()->search }}">
                        <i class="absolute inset-y-0 right-0 w-4 h-4 my-auto mr-3" data-feather="search"></i>
                    </div>
                    <button type="submit" class="shadow-md btn btn-secondary">Tampilkan</button>
                </form>
                {{-- @include('components.search', [
                    'id_table' => 'myTable',
                ]) --}}
            </div>
        </div>
        <div class="flex justify-between gap-2 mt-0">
            <a href="/pelanggan-download-excel" class="flex items-center text-white btn btn-success"><i
                    data-feather="file-text" class="w-4 h-4 mr-1"
                    value="Export Excel"onclick="window.open('laporan-excel.php')"></i>Excel
            </a>
            <a href="/pelanggan-download-pdf" class="flex items-center text-white btn btn-facebook"><i
                    data-feather="printer" class="w-4 h-4 mr-1"></i>Print
            </a>
            <button class="flex items-center text-white shadow-md btn btn-pending" wire:ignore data-tw-toggle="modal"
                data-tw-target="#importPelanggan"><i data-feather="download" class="w-4 h-4 mr-1"
                    value="Export Excel"></i>Import
            </button>
            @include('components.modal.modal-import', [
                'id_modal' => 'importPelanggan',
                'route' => 'import.pelanggan',
                'id' => '',
                'filename' => 'pelanggan.xlsx',
            ])
        </div>
    </div>

    <!-- BEGIN: Data List -->
    <div class="col-span-12 overflow-auto intro-y lg:overflow-visible">
        <div class="overflow-auto">
            <table class="table mt-0 table-report" id="myTable">
                <thead style="background-color: #d3d3d3;">
                    <tr>
                        <th class="whitespace-nowrap">Kode</th>
                        <th class="whitespace-nowrap">Kode E-report</th>
                        <th class="whitespace-nowrap">Nama Pelanggan</th>
                        <th class="whitespace-nowrap">No. SIA</th>
                        <th class="whitespace-nowrap">ED. SIA</th>
                        <th class="whitespace-nowrap">No. Tlp</th>
                        <th class="whitespace-nowrap">Apoteker</th>
                        <th class="whitespace-nowrap">No. SIPA</th>
                        <th class="whitespace-nowrap">ED. SIPA</th>
                        <th class="whitespace-nowrap">Kelompok</th>
                        <th class="whitespace-nowrap">Batas Piutang</th>
                        <th class="whitespace-nowrap">Piutang</th>
                        <th class="text-center whitespace-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pelanggans as $pelanggan)
                        <tr class="intro-x">
                            <td class="">{{ $pelanggan->kode }}</td>
                            <td class="">{{ $pelanggan->kode_e_report }}</td>
                            <td class="">{{ $pelanggan->nama }}</td>
                            <td class="">{{ $pelanggan->no_sia }}</td>
                            <td class="">{{ date('d-m-Y', strtotime($pelanggan->exp_date_sia)) }}</td>
                            <td class="">{{ $pelanggan->nomor }}</td>
                            <td class="">{{ $pelanggan->apoteker }}</td>
                            <td class="">{{ $pelanggan->no_sipa }}</td>
                            <td class="">{{ date('d-m-Y', strtotime($pelanggan->exp_date_sipa)) }}
                            </td>
                            <td class="">{{ $pelanggan->kelompokPelanggan->kelompok }}</td>
                            <td class="">{{ $pelanggan->batas_piutang }}</td>
                            <td>
                                @if ($pelanggan->piutang->isNotEmpty())
                                    {{ number_format($pelanggan->piutang->last()->sisa_hutang, 0, ',', '.') }}
                                @else
                                    0
                                @endif
                            </td>
                            <td class="w-56 table-report__action">
                                @can('aksi_pelanggan')
                                    <div class="flex items-center justify-center">
                                        <a class="flex items-center mr-3 text-primary" href="javascript:;"
                                            data-tw-toggle="modal" data-tw-target="#edit-pelanggan{{ $pelanggan->id }}"> <i
                                                data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
                                        <a class="flex items-center text-danger" href="javascript:;" data-tw-toggle="modal"
                                            data-tw-target="#delete-confirmation-modal{{ $pelanggan->id }}"> <i
                                                data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
                                        <!-- BEGIN: Delete Confirmation Modal -->
                                        @include('components.modal-delete', [
                                            'id_modal' => 'delete-confirmation-modal',
                                            'id' => $pelanggan->id,
                                            'route' => 'delete.pelanggan',
                                        ])
                                        <!-- END: Delete Confirmation Modal -->
                                        @include('components.modal.modal-pelanggan', [
                                            'id_modal' => 'edit-pelanggan',
                                            'route' => 'edit.pelanggan',
                                            'id' => $pelanggan->id,
                                        ])
                                    </div>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr class="intro-x">
                            <td class="font-bold text-center text-pending" colspan="13">Belum ada data tersedia</td>
                        </tr>
                    @endforelse


                </tbody>
            </table>
            {{ $pelanggans->links() }}
        </div>
    </div>
    <!-- END: Data List -->
    </div>
@endsection
