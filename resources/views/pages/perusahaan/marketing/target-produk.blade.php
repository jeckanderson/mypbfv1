@extends('layout.main')

@section('main')
    @php
        use App\Models\TargetProduk;
    @endphp
    <div class="flex items-center mt-8 intro-y">
        <h2 class="mr-auto text-lg font-medium text-primary">
            Data Target Produk
        </h2>
    </div>
    @include('components.alert')
    <div class="grid grid-cols-12 gap-2 mt-8">
        <div class="flex flex-wrap items-center col-span-12 mt-2 intro-y sm:flex-nowrap">
            @can('tambah_target_produk')
                <button class="mr-2 shadow-md btn btn-primary" data-tw-toggle="modal" data-tw-target="#tambah-data"><i
                        data-feather="edit-3" class="w-4 h-4 mr-3"></i> Tambah</button>
                <!-- BEGIN: Modal Content -->
                @include('components.modal.modal-target-produk', [
                    'id_modal' => 'tambah-data',
                    'route' => 'tambah.target_produk',
                    'targetTahun' => '',
                    'targetBulan' => '',
                    'id' => '',
                    'lihat' => false,
                ])
                <!-- END: Modal Content -->
            @endcan

            <div data-tw-merge class="items-center block sm:flex">
                @include('components.search', [
                    'id_table' => 'tableTargetProduk',
                ])
            </div>
        </div>
    </div>
    <!-- BEGIN: Data List -->
    <div class="col-span-12 mt-2 overflow-auto intro-y lg:overflow-visible">
        <div class="overflow-x-auto">
            <table class="table -mt-2 table-report" id="tableTargetProduk">
                <thead style="background-color: #d3d3d3;">
                    <tr>
                        <th class="whitespace-nowrap">No</th>
                        <th class="whitespace-nowrap">Tahun</th>
                        <th class="whitespace-nowrap">Bulan</th>
                        <th class="whitespace-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($targetProduks as $targetProduk)
                        <tr class="intro-x">
                            <td class="text-center w-40">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $targetProduk->tahun }}</td>
                            <td class="text-center">{{ $targetProduk->bulan }}</td>
                            <td class="table-report__action w-72">
                                @can('aksi_target_produk')
                                    <div class="flex items-center justify-center">
                                        <a class="flex items-center mx-3 mr-3 text-primary" href="javascript:;"
                                            data-tw-toggle="modal"
                                            data-tw-target="#modal-lihat{{ $targetProduk->tahun }}{{ $targetProduk->bulan }}">
                                            <i data-feather="navigation" class="w-4 h-4 mr-1"></i> Detail </a>
                                        <a href="/target-produk-download-pdf/{{ $targetProduk->id }}"
                                            class="flex items-center mr-3 text-primary">
                                            <i data-feather="printer" class="w-5 h-5 mr-1"></i>Print
                                        </a>
                                        <a class="flex items-center mr-3 text-primary" href="javascript:;"
                                            data-tw-toggle="modal"
                                            data-tw-target="#edit-target-produk{{ $targetProduk->tahun }}{{ $targetProduk->bulan }}">
                                            <i data-feather="check-square" class="w-4 h-4 mr-1"></i>Edit </a>
                                        <a class="flex items-center text-danger" href="javascript:;" data-tw-toggle="modal"
                                            data-tw-target="#delete-target-produk{{ $targetProduk->tahun }}{{ $targetProduk->bulan }}">
                                            <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
                                        <!-- BEGIN: Delete Confirmation Modal -->
                                        <div id="delete-target-produk{{ $targetProduk->tahun }}{{ $targetProduk->bulan }}"
                                            class="modal" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="p-0 modal-body">
                                                        <div class="p-5 text-center">
                                                            <i data-feather="x-circle"
                                                                class="w-16 h-16 mx-auto mt-3 text-danger"></i>
                                                            <div class="mt-5 text-3xl">Are you sure?</div>
                                                            <div class="mt-2 text-slate-500">
                                                                Do you really want to delete these records?
                                                                <br>
                                                                This process cannot be undone.
                                                            </div>
                                                        </div>
                                                        <div class="px-5 pb-8 text-center">
                                                            <form
                                                                action="{{ route('delete.target_produk', ['id' => $targetProduk->id]) }}"
                                                                method="POST">
                                                                @csrf
                                                                <input type="hidden" value="{{ $targetProduk->tahun }}"
                                                                    name="tahun">
                                                                <input type="hidden" value="{{ $targetProduk->bulan }}"
                                                                    name="bulan">
                                                                @foreach (TargetProduk::where('id_perusahaan', Auth::user()->id_perusahaan)->where('tahun', $targetProduk->tahun)->where('bulan', $targetProduk->bulan)->get() as $targetProduk)
                                                                    <input data-tw-merge id="horizontal-form-1" type="hidden"
                                                                        placeholder=""
                                                                        name="target[{{ $loop->index }}][target_produk]"
                                                                        value="{{ $targetProduk->target }}">
                                                                    <input type="hidden"
                                                                        name="target[{{ $loop->index }}][id_produk]"
                                                                        value="{{ $targetProduk->obatBarang->id }}">
                                                                @endforeach
                                                                <button type="button" data-tw-dismiss="modal"
                                                                    class="w-24 mr-1 btn btn-secondary">Cancel</button>
                                                                <button type="submit"
                                                                    class="w-24 btn btn-danger">Delete</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END: Delete Confirmation Modal -->

                                        {{-- edit modal --}}
                                        @include('components.modal.modal-edit-target-produk', [
                                            'id_modal' =>
                                                'edit-target-produk' . $targetProduk->tahun . $targetProduk->bulan,
                                            'route' => 'edit.target_produk',
                                            'targetTahun' => $targetProduk->tahun,
                                            'targetBulan' => $targetProduk->bulan,
                                            'lihat' => false,
                                        ])

                                        {{-- @include('pdf.target_produk', [
                                        'id_modal' => 'targetproduk' . $targetProduk->tahun . $targetProduk->bulan,
                                        'route' => 'export_target_produk_pdf',
                                        'lihat' => false,
                                    ]) --}}

                                        {{-- edit modal --}}
                                        @include('components.modal.modal-edit-target-produk', [
                                            'id_modal' =>
                                                'modal-lihat' . $targetProduk->tahun . $targetProduk->bulan,
                                            'route' => 'edit.target_produk',
                                            'targetTahun' => $targetProduk->tahun,
                                            'targetBulan' => $targetProduk->bulan,
                                            'lihat' => true,
                                        ])
                                    </div>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr class="intro-x">
                            <td colspan="13" class="font-bold text-center text-pending">Belum ada data tersedia</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <!-- END: Data List -->
@endsection
