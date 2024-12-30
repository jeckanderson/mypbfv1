<div>
    <div class="grid grid-cols-12 gap-4 mt-8">
        <div class="flex flex-wrap items-center col-span-12 gap-2 mt-0 intro-y sm:flex-nowrap">
            <div class="relative w-56 text-slate-500">
                <input type="text" class="w-56 pr-10 form-control cari box" placeholder="Cari nama produk..."
                    wire:model.live='cariProduk'>
                <i class="absolute inset-y-0 right-0 w-4 h-4 my-auto mr-3" data-feather="search"></i>
            </div>
            <div data-tw-merge class="items-center block sm:flex">
                <select wire:model.live="selectedGudang" aria-label="Default select example"
                    class="inline-block form-control sm:w-40">
                    <option value="">-- Pilih Gudang --</option>
                    @foreach ($gudangs as $gudang)
                        <option value="{{ $gudang->id }}">{{ $gudang->gudang }}</option>
                    @endforeach
                </select>
            </div>
            <div data-tw-merge class="items-center block sm:flex">
                <select wire:model.live="selectedRak" aria-label="Default select example"
                    class="inline-block mt-2 mb-2 form-control sm:w-40">
                    <option value="">-- Pilih Rak --</option>
                    @foreach ($raks as $rak)
                        <option value="{{ $rak->id }}">{{ $rak->rak }}</option>
                    @endforeach
                </select>
            </div>
            <div data-tw-merge class="items-center block sm:flex">
                <select wire:model.live="selectedSubRak" aria-label="Default select example"
                    class="inline-block mt-2 mb-2 form-control sm:w-40">
                    <option value="">-- Pilih Sub Rak --</option>
                    @foreach ($sub_rak as $rak)
                        <option value="{{ $rak->id }}">{{ $rak->sub_rak }}</option>
                    @endforeach
                </select>
                <button onclick="location.reload()" class="ml-2 btn btn-md btn-secondary" wire:ignore>
                    <i data-feather="refresh-cw" class="w-4 h-4 mr-1"></i> Reload
                </button>
            </div>
        </div>
    </div>
    <div class="col-span-12 overflow-auto intro-y lg:overflow-visible">
        <div class="mt-1 intro-y box">
            <table class="table mt-1">
                <thead style="background-color: #d3d3d3;">
                    <tr>
                        <th class="whitespace-nowrap">No</th>
                        <th class="whitespace-nowrap">Barcode</th>
                        <th class="whitespace-nowrap">Nama Produk</th>
                        <th class="whitespace-nowrap">Satuan</th>
                        <th class="whitespace-nowrap">Stok</th>
                        <th class="whitespace-nowrap">Tipe</th>
                        <th class="whitespace-nowrap">Gudang</th>
                        <th class="whitespace-nowrap">Rak</th>
                        <th class="whitespace-nowrap">Sub Rak</th>
                        <th class="text-center whitespace-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        // Mengurutkan data history berdasarkan nama produk secara alfabetis
                        $sortedHistorys = $historys->sortBy(function ($histori) {
                            return $histori->produk->nama_obat_barang;
                        });
                    @endphp
                    @forelse ($sortedHistorys as $histori)
                        <tr class="intro-x">
                            <td class="">{{ $loop->iteration }}</td>
                            <td class="">{{ $histori->produk->barcode_produk }}</td>
                            <td class="">{{ $histori->produk->nama_obat_barang }}</td>
                            <td class="">{{ $histori->produk->satuanTerkecil->satuan }}</td>
                            <td class="">
                                {{ $histori->sisaStok($histori->id_produk, $histori->id_gudang, $histori->id_rak, $histori->id_sub_rak) }}
                            </td>
                            <td class="">{{ $histori->produk->tipe }}</td>
                            <td class="">{{ $histori->gudang->gudang }}</td>
                            <td class="">{{ $histori->rak->rak }}</td>
                            <td class="">{{ $histori->subRak->sub_rak }}</td>
                            <td class="w-56 table-report__action">
                                <div class="flex items-center justify-center">
                                    <a class="flex items-center btn btn-sm btn-outline-primary"
                                        href="{{ route('kartu-stok', ['id_produk' => $histori->id_produk, 'id_gudang' => $histori->gudang, 'id_rak' => $histori->id_rak, 'id_sub_rak' => $histori->id_sub_rak]) }}">Kartu
                                        Stok </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="intro-x">
                            <td class="font-bold text-center text-pending" colspan="10">Belum ada data tersedia</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
