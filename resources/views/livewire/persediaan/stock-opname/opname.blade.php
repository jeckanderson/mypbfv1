<div>
    <div class="flex items-center mt-5 intro-y">
    </div>
    <div class="grid grid-cols-12 gap-2 mt-2">
        <div class="flex flex-wrap items-center col-span-12 mt-1 intro-y sm:flex-nowrap">
            <a href="/tambah-stok-opname"><button class="mr-2 shadow-md btn btn-primary" wire:ignore><i
                        data-feather="edit-3" class="w-4 h-4 mr-3"></i> Tambah SO</button></a>
            @can('akses_tambah_stok_masuk')
                <button class="mr-2 shadow-md btn btn-pending" wire:ignore data-tw-toggle="modal"
                    data-tw-target="#basic-modal-preview"><i data-feather="archive" class="w-4 h-4 mr-3"></i> Tambah
                    SM</button>
            @endcan
            <div class="flex flex-wrap items-center col-span-12 mt-0 intro-y sm:flex-nowrap">
                <input type="text" class="w-56 pr-10 form-control box" placeholder="Search nama produk"
                    wire:model.live.debounce.250ms='cari'>
                <i class="absolute inset-y-0 right-0 w-0 h-4 my-auto mr-2" data-feather="search"></i>
            </div>
            <!-- BEGIN: Modal Content -->
            <div id="basic-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
                <div class="rounded-lg modal-dialog modal-lg">
                    <livewire:persediaan.stock-opname.tambah-stok-masuk />
                </div>
            </div>
            <!-- END: Modal Content -->
            <div data-tw-merge class="items-center block ml-2 sm:flex">
                {{-- <label data-tw-merge for="horizontal-form-1" class="inline-block mt-2 mb-2 font-bold sm:w-24">
                    Gudang
                </label> --}}
                <select data-tw-merge aria-label="Default select example"
                    class="mt-2 mb-2 form-control nline-block sm:w-40" wire:model.live='selectedGudang'>
                    <option>-- Pilih Gudang --</option>
                    @forelse ($gudangs as $gudang)
                        <option value="{{ $gudang->id }}">{{ $gudang->gudang }}</option>
                    @empty
                    @endforelse
                </select>
            </div>
            <div data-tw-merge class="items-center block ml-2 sm:flex">
                {{-- <label data-tw-merge for="horizontal-form-1" class="inline-block mt-2 mb-2 font-bold sm:w-20"
                    wire:model.live='selectedRak'>
                    Rak
                </label> --}}
                <select data-tw-merge aria-label="Default select example"
                    class="inline-block mt-2 mb-2 form-control sm:w-40" wire:model.live='selectedRak'>
                    <option>-- Pilih Rak --</option>
                    @forelse ($raks as $rak)
                        <option value="{{ $rak->id }}">{{ $rak->rak }}</option>
                    @empty
                    @endforelse
                </select>
            </div>
            <div data-tw-merge class="items-center block ml-2 sm:flex">
                {{-- <label data-tw-merge for="horizontal-form-1" class="inline-block mt-2 mb-2 font-bold sm:w-32">
                    Sub Rak
                </label> --}}
                <select data-tw-merge aria-label="Default select example"
                    class="inline-block mt-2 mb-2 form-control sm:w-40" wire:model.live='selectedSubRak'>
                    <option>-- Pilih Sub Rak --</option>
                    @forelse ($subRak as $rak)
                        <option value="{{ $rak->id }}">{{ $rak->sub_rak }}</option>
                    @empty
                    @endforelse
                </select>
            </div>
            <div data-tw-merge class="items-center block ml-2 sm:flex">
                {{-- <label data-tw-merge for="horizontal-form-1" class="inline-block mt-2 mb-2 font-bold sm:w-32">
                    Tanggal SO
                </label> --}}
                <input type="date" class="form-control" wire:model.live='selectedSO' name="" id="">
            </div>

            <button onclick="location.reload()" class="ml-2 btn btn-md btn-secondary" wire:ignore>
                <i data-feather="refresh-cw" class="w-4 h-4 mr-1"></i> Reload
            </button>

            <div class="flex items-center sm:flex">
                <a href="{{ route('export_data_stok_opname_pdf', ['gudang' => $selectedGudang, 'rak' => $selectedRak, 'sub_rak' => $selectedSubRak, 'tgl_so' => $selectedSO]) }}"
                    class="flex items-center text-white shadow-md btn btn-facebook"
                    style="position: fixed; right: 5px;">
                    <div class="flex" wire:ignore>
                        <i data-feather="printer" class="w-4 h-4 mr-1"></i> Print
                    </div>
                </a>
                <a href="{{ route('excel_data_stok_opname', ['gudang' => $selectedGudang, 'rak' => $selectedRak, 'sub_rak' => $selectedSubRak, 'tgl_so' => $selectedSO]) }}"
                    class="flex items-center text-white shadow-md btn btn-success"
                    style="position: fixed; right: 75px;">
                    <div class="flex" wire:ignore>
                        <i data-feather="file-text" class="w-4 h-4 mr-1"></i> Excel
                    </div>
                </a>
            </div>
        </div>
    </div>
    <!-- BEGIN: Data List -->
    <div class="col-span-12 overflow-auto intro-y lg:overflow-visible">
        <div class="mt-1 intro-y box">
            <div class="overflow-x-auto">
                <table class="table mt-2">
                    <thead style="background-color: #d3d3d3;">
                        <tr>
                            {{-- <th class="whitespace-nowrap">No</th> --}}
                            <th class="whitespace-nowrap">Tgl SO</th>
                            <th class="whitespace-nowrap">Nama Produk</th>
                            <th class="whitespace-nowrap">No. Batch</th>
                            <th class="whitespace-nowrap">Exp. Date</th>
                            <th class="whitespace-nowrap">Satuan</th>
                            <th class="whitespace-nowrap">Stok Tercatat</th>
                            <th class="whitespace-nowrap">Stok Real</th>
                            <th class="whitespace-nowrap">Selisih Stok</th>
                            <th class="whitespace-nowrap">Nominal Selisih</th>
                            <th class="whitespace-nowrap">Keterangan</th>
                            <th class="whitespace-nowrap">Gudang</th>
                            <th class="whitespace-nowrap">Rak</th>
                            <th class="whitespace-nowrap">Sub Rak</th>
                            {{-- <th class="whitespace-nowrap">Ket Satuan</th> --}}
                            <th class="whitespace-nowrap">Tipe</th>
                            <th class="whitespace-nowrap">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $nominal = 0;
                        @endphp
                        @forelse ($stokOpname as $stok)
                            @php
                                $nominal += $stok->nominal_selisih;
                            @endphp
                            <tr class="intro-x">
                                {{-- <td class="w-40">{{ $loop->iteration }}</td> --}}
                                <td class="whitespace-nowrap">{{ date('d-m-Y', strtotime($stok->tgl_so)) }}</td>
                                <td class="whitespace-nowrap">{{ $stok->produk->nama_obat_barang }}</td>
                                <td class="whitespace-nowrap">{{ $stok->no_batch }}</td>
                                <td class="whitespace-nowrap">
                                    {{ $stok->exp_date != '-' ? date('d-m-Y', strtotime($stok->exp_date)) : '-' }}</td>
                                <td class="whitespace-nowrap">{{ $stok->produk->satuanTerkecil->satuan }}</td>
                                <td class="whitespace-nowrap">{{ $stok->stok_tercatat }}</td>
                                <td class="whitespace-nowrap">{{ $stok->stok_real }}</td>
                                <td class="whitespace-nowrap">{{ $stok->selisih_stok }}</td>
                                <td class="whitespace-nowrap">
                                    {{ number_format($stok->nominal_selisih, 0, ',', '.') }}
                                </td>
                                <td class="whitespace-nowrap">{{ $stok->keterangan }}</td>
                                <td class="whitespace-nowrap">{{ $stok->gudangStok->gudang }}</td>
                                <td class="whitespace-nowrap">{{ $stok->rakStok->rak }}</td>
                                <td class="whitespace-nowrap">{{ $stok->subRak->sub_rak }}</td>
                                {{-- <td class="whitespace-nowrap">{{ $stok->produk->ket_satuan }}</td> --}}
                                <td class="whitespace-nowrap">{{ $stok->produk->tipe }}</td>
                                <td>
                                    @can('aksi_stok_opname')
                                        <button class="btn btn-outline-danger btn-sm"
                                            wire:confirm="Apakah anda yakin akan menghapusnya?"
                                            wire:click='hapusOpname({{ $stok->id }})'>Delete</button>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr class="intro-x">
                                <td class="font-bold text-center text-pending" colspan="16">Belum ada data opname
                                    tersedia</td>
                            </tr>
                        @endforelse
                        <tr>
                            <td colspan="8" class="font-bold text-center">Total</td>
                            <td colspan="15"><strong>{{ number_format($nominal, 0, ',', '.') }}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="p-2 mt-3">
                {{ $stokOpname->links() }}
            </div>
        </div>
    </div>
</div>
