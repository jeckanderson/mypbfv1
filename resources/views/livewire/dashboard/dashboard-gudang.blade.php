<div class="content">
    <div class="grid gap-6">
        <div class="col 2xl:col-span-9">
            <div class="grid gap-6">
                <div class="col-span-12 mt-6">
                    <div class="items-center block h-10 intro-y sm:flex">
                        <h2 class="mr-5 text-lg font-medium truncate">
                            Dashboard Gudang
                        </h2>
                        <div class="flex items-center gap-2 mt-3 sm:ml-auto sm:mt-0">
                            <label for="date" class="mt-2 form-label">Expired</label>
                            <input type="date" class="form-control" wire:model.live='expDateFrom' name=""
                                id="">
                            <input type="date" class="form-control" wire:model.live='expDateTo' name=""
                                id="">
                            <label for="date" class="w-24 mt-2 form-label">Gudang</label>
                            <select class="form-select" wire:model.live='selectedGudang'>
                                @forelse($gudangs as $gudang)
                                    <option value="{{ $gudang->id }}">{{ $gudang->gudang }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <div class="mt-8 overflow-auto intro-y lg:overflow-visible sm:mt-0">
                        <table class="table table-report sm:mt-2">
                            <thead>
                                <tr>
                                    <th class="whitespace-nowrap">Nama Produk</th>
                                    <th class="text-center whitespace-nowrap">Satuan</th>
                                    <th class="text-center whitespace-nowrap">Stok</th>
                                    <th class="text-center whitespace-nowrap">Batch</th>
                                    <th class="text-center whitespace-nowrap">Exp Date</th>
                                    <th class="text-center whitespace-nowrap">Gudang</th>
                                    <th class="text-center whitespace-nowrap">Rak</th>
                                    <th class="text-center whitespace-nowrap">Sub Rak</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($produks as $produk)
                                    <tr class="intro-x">
                                        <td>
                                            <a href=""
                                                class="font-medium whitespace-nowrap">{{ Str::title($produk->produk->nama_obat_barang) }}</a>
                                        </td>
                                        <td class="text-center">{{ $produk->produk->satuanTerkecil->satuan }}</td>
                                        <td class="text-center">
                                            {{ $produks->sum('stok_masuk') - $produks->sum('stok_keluar') }}</td>
                                        <td class="text-center">{{ $produk->no_batch }}</td>
                                        <td class="text-center">{{ $produk->exp_date }}</td>
                                        <td class="text-center">{{ $produk->gudang->gudang }}</td>
                                        <td class="text-center">{{ $produk->rak->rak }}</td>
                                        <td class="text-center">{{ $produk->subRak->sub_rak }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="font-bold text-center">Belum ada data tersedia</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="flex flex-wrap items-center mt-3 intro-y sm:flex-row sm:flex-nowrap">
                        <nav class="w-full sm:w-auto sm:mr-auto">
                            <ul class="pagination">
                                <!-- Tombol navigasi ke halaman sebelumnya -->
                                <li class="page-item {{ $produks->previousPageUrl() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $produks->previousPageUrl() }}"> <i class="w-4 h-4"
                                            data-feather="chevron-left"></i> </a>
                                </li>
                                <!-- Daftar halaman -->
                                @foreach ($produks->getUrlRange(1, $produks->lastPage()) as $page => $url)
                                    <li class="page-item {{ $page == $produks->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach
                                <!-- Tombol navigasi ke halaman berikutnya -->
                                <li class="page-item {{ $produks->nextPageUrl() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $produks->nextPageUrl() }}"> <i class="w-4 h-4"
                                            data-feather="chevron-right"></i> </a>
                                </li>
                            </ul>
                        </nav>
                        <!-- Jumlah item per halaman -->
                        <select class="w-20 mt-3 form-select box sm:mt-0" wire:model.live='row'>
                            <option>10</option>
                            <option>25</option>
                            <option>35</option>
                            <option>50</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
