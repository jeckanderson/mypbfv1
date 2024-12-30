<div class="">
    @php
        use App\Models\StokAwal;
        use App\Models\RencanaOrder;
    @endphp
    <div class="flex items-center mt-8 intro-y">
        <h2 class="mr-auto text-lg font-medium text-primary">
            Data Produk
        </h2>
    </div>
    <div class="flex justify-between gap-2 mt-8">
        <div class="flex flex-wrap items-center col-span-12 intro-y sm:flex-nowrap" wire:ignore>
            @can('tambah_produk')
                <button class="mr-2 shadow-md btn btn-primary" id="tombol-tambah" data-tw-toggle="modal"
                    data-tw-target="#modal-tambah"><i data-feather="edit-3" class="w-4 h-4 mr-3"></i> Tambah</button>
                {{-- modal begin --}}
                @include('components.modal.obat-barang.modal-obat-barang', [
                    'id_modal' => 'modal-tambah',
                    'route' => 'tambah.obat-barang',
                    'id' => '',
                    'barang' => '',
                ])
                {{-- end modal --}}
            @endcan

            <div class="flex flex-wrap items-center col-span-12 intro-y sm:flex-nowrap overflow-visible">
                <select class="form-control tom-select w-full sm:w-72 relative z-50" wire:model.live='cari'>
                    <option value="w-full">Cari Produk</option>
                    @forelse ($produks as $produk)
                        <option value="{{ $produk->id }}">{{ $produk->nama_obat_barang }}</option>
                    @empty
                    @endforelse
                </select>
                <button onclick="location.reload()" class="ml-2 btn btn-md btn-secondary" wire:ignore>
                    <i data-feather="refresh-cw" class="w-4 h-4 mr-1"></i> Reload
                </button>
                
            </div>
            {{-- @include('components.search', [
                'id_table' => 'myTable',
            ]) --}}
        </div>
        <div class="flex flex-wrap items-center col-span-12 gap-2 ml-auto intro-y sm:flex-nowrap">
            <a href="/produk-download-excel" class="flex items-center text-white btn btn-success" wire:ignore>
                <i data-feather="file-text" class="w-4 h-4 mr-1"></i> Excel
            </a>
            <a href="/obat-dan-barang-download-pdf" class="flex items-center btn btn-facebook" wire:ignore>
                <i data-feather="printer" class="w-4 h-4 mr-1"></i> Print
            </a>
            <button class="flex items-center text-white shadow-md btn btn-pending" wire:ignore data-tw-toggle="modal"
                data-tw-target="#import"><i data-feather="download" class="w-4 h-4 mr-1" value="Export Excel"></i>Import
            </button>
        </div>

        @include('components.modal.modal-import', [
            'id_modal' => 'import',
            'route' => 'import.obat-barang',
            'id' => '',
            'filename' => 'importObatBarang.xlsx',
        ])
    </div>


    <!-- BEGIN: Data List -->
    <div class="overflow-x-auto">
        <table class="table mt-2 table-report border-collapse w-full text-sm relative z-10" id="myTable"
            style="border: 1px solid #add8e6;">
            <thead style="background-color: #add8e6; border-bottom: 2px solid #add8e6;">
                <tr>
                    <th style="border: 1px solid #add8e6; padding: 4px;">Barcode</th>
                    <th style="border: 1px solid #add8e6; padding: 4px;">Nama Produk</th>
                    <th style="border: 1px solid #add8e6; padding: 4px;">Kategori</th>
                    <th style="border: 1px solid #add8e6; padding: 4px;">Golongan</th>
                    <th style="border: 1px solid #add8e6; padding: 4px;">Jenis</th>
                    <th style="border: 1px solid #add8e6; padding: 4px;">Produsen</th>
                    <th style="border: 1px solid #add8e6; padding: 4px;">Tipe</th>
                    <th style="border: 1px solid #add8e6; padding: 4px;">NIE</th>
                    <th style="border: 1px solid #add8e6; padding: 4px;">Kode E-report</th>
                    <th style="border: 1px solid #add8e6; padding: 4px;">Status</th>
                    <th style="border: 1px solid #add8e6; padding: 4px;" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($obat_barang as $barang)
                    <tr class="intro-x hover:bg-blue-50">
                        <td style="border: 1px solid #add8e6; padding: 4px;">{{ $barang->barcode_produk }}</td>
                        <td style="border: 1px solid #add8e6; padding: 4px;">{{ $barang->nama_obat_barang }}</td>
                        <td style="border: 1px solid #add8e6; padding: 4px;">{{ $barang->kelompok->golongan }}</td>
                        <td style="border: 1px solid #add8e6; padding: 4px;">{{ $barang->golonganProduk->sub_golongan }}
                        </td>
                        <td style="border: 1px solid #add8e6; padding: 4px;">{{ $barang->jenis_obat_barang }}</td>
                        <td style="border: 1px solid #add8e6; padding: 4px;">
                            {{ $barang->produsenProduk?->produsen ?? '-' }}</td>
                        <td style="border: 1px solid #add8e6; padding: 4px;">{{ $barang->tipe }}</td>
                        <td style="border: 1px solid #add8e6; padding: 4px;">{{ $barang->no_ijin_edar }}</td>
                        <td style="border: 1px solid #add8e6; padding: 4px;">{{ $barang->kode_obat_barang }}</td>
                        <td
                            style="border: 1px solid #add8e6; padding: 4px; color: {{ $barang->status == 1 ? 'green' : 'red' }};">
                            {{ $barang->status == 1 ? 'Aktif' : 'Tidak Aktif' }}
                        </td>
                        <td style="border: 1px solid #add8e6; padding: 4px;" class="text-center">
                            @can('aksi_produk')
                                <div class="flex items-center justify-center gap-2">
                                    <a class="text-blue-500 hover:underline" href="/set-harga-jual/{{ $barang->id }}">
                                        Harga
                                    </a>
                                    <a class="text-blue-500 hover:underline" href="javascript:;" data-tw-toggle="modal"
                                        data-tw-target="#modal-edit{{ $barang->id }}">
                                        Edit
                                    </a>
                                    @if (!StokAwal::where('id_perusahaan', Auth::user()->id_perusahaan)->where('id_obat_barang', $barang->id)->first() && !RencanaOrder::where('id_produk', $barang->id)->first())
                                        <a class="flex items-left text-danger" href="javascript:;" data-tw-toggle="modal"
                                            data-tw-target="#delete-confirmation-modal{{ $barang->id }}">
                                            <div class="flex gap-1">
                                                Delete
                                            </div>
                                        </a>
                                    @endif
                                    <!-- BEGIN: Delete Confirmation Modal -->
                                    @include('components.modal-delete', [
                                        'id_modal' => 'delete-confirmation-modal',
                                        'id' => $barang->id,
                                        'route' => 'delete.obat-barang',
                                    ])
                                    <!-- END: Delete Confirmation Modal -->

                                    {{-- modal edit --}}
                                    @include('components.modal.obat-barang.modal-obat-barang', [
                                        'id_modal' => 'modal-edit',
                                        'route' => 'edit.obat-barang',
                                        'id' => $barang->id,
                                    ])
                                    {{-- end modal edit --}}
                                </div>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr class="intro-x">
                        <td class="font-bold text-center text-pending" colspan="11">Belum ada data tersedia
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $obat_barang->links() }}
</div>
@if (app('request')->input('nama_obat_barang'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var tombolTambah = document.getElementById("tombol-tambah");
            tombolTambah.click();
        });
    </script>
@endif
</div>
