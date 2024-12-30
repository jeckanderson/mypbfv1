@extends('layout.main')

@section('main')
    <div class="flex items-center mt-8 intro-y">
        <h2 class="mr-auto text-lg font-medium text-primary">
            Data Supplier
        </h2>
    </div>
    <div class="flex justify-between gap-2 mt-8">
        <div class="flex flex-wrap items-center col-span-12 mt-0 mr-auto intro-y sm:flex-nowrap">
            @can('tambah_supplier')
                <button class="mr-2 shadow-md btn btn-primary" data-tw-toggle="modal" data-tw-target="#tambah-suplier"><i
                        data-feather="edit-3" class="w-4 h-4 mr-3"></i> Tambah</button>

                <!-- BEGIN: Modal Content -->
                @include('components.modal.modal-suplier', [
                    'id_modal' => 'tambah-suplier',
                    'route' => 'tambah.suplier',
                    'id' => '',
                    'sup' => '',
                ])
            @endcan
            <div data-tw-merge class="items-center block sm:flex">
                <form action="{{ route('suplier') }}" method="GET" class=" flex gap-2">
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
            <a href="/suplier-download-excel" class="flex items-center text-white btn btn-success"><i
                    data-feather="file-text" class="w-4 h-4 mr-1"
                    value="Export Excel"onclick="window.open('laporan-excel.php')"></i>Excel
            </a>
            <a href="/suplier-download-pdf" class="flex items-center text-wahite btn btn-facebook"><i data-feather="printer"
                    class="w-4 h-4 mr-1"></i>Print
            </a>
            <button class="flex items-center text-white shadow-md btn btn-pending" wire:ignore data-tw-toggle="modal"
                data-tw-target="#importSupplier"><i data-feather="download" class="w-4 h-4 mr-1"
                    value="Export Excel"></i>Import
            </button>
            @include('components.modal.modal-import', [
                'id_modal' => 'importSupplier',
                'route' => 'import.supplier',
                'id' => '',
                'filename' => 'supplier.xlsx',
            ])
        </div>
    </div>
    <!-- BEGIN: Data List -->
    <div class="col-span-12 overflow-auto intro-y lg:overflow-visible">
        <table class="table mt-0 table-report" id="myTable">
            <thead style="background-color: #d3d3d3;">
                <tr>
                    <th class="whitespace-nowrap">Kode</th>
                    <th class="whitespace-nowrap">Kode E-Report</th>
                    <th class="whitespace-nowrap">Nama Supplier</th>
                    <th class="whitespace-nowrap">NPWP</th>
                    <th class="whitespace-nowrap">No. Telp</th>
                    <th class="whitespace-nowrap">Hutang</th>
                    <th class="text-center whitespace-nowrap">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($suplier as $sup)
                    <tr class="intro-x">
                        <td class="">{{ $sup->kode }}</td>
                        <td class="">{{ $sup->kode_e_report }}</td>
                        <td class="">{{ $sup->nama_suplier }}</td>
                        <td class="">{{ $sup->npwp }}</td>
                        <td class="">{{ $sup->no_telepon }}</td>
                        <td class="">{{ number_format($sup->hutangs->sum('sisa_hutang'), 0, ',', '.') }}</td>
                        <td class="w-56 table-report__action">
                            @can('aksi_supplier')
                                <div class="flex items-center justify-center">
                                    <a class="flex items-center mr-3 text-primary" href="javascript:;" data-tw-toggle="modal"
                                        data-tw-target="#edit-suplier{{ $sup->id }}"> <i data-feather="check-square"
                                            class="w-4 h-4 mr-1"></i> Edit </a>
                                    <a class="flex items-center text-danger" href="javascript:;" data-tw-toggle="modal"
                                        data-tw-target="#delete-confirmation-modal{{ $sup->id }}"> <i
                                            data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
                                    <!-- BEGIN: Delete Confirmation Modal -->
                                    @include('components.modal-delete', [
                                        'id_modal' => 'delete-confirmation-modal',
                                        'id' => $sup->id,
                                        'route' => 'delete.suplier',
                                    ])
                                    <!-- END: Delete Confirmation Modal -->

                                    @include('components.modal.modal-suplier', [
                                        'id_modal' => 'edit-suplier',
                                        'route' => 'edit.suplier',
                                        'id' => $sup->id,
                                    ])
                                </div>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr class="intro-x">
                        <td class="font-bold text-center text-pending" colspan="8">Belum ada data tersedia!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $suplier->links() }}
    </div>
@endsection
