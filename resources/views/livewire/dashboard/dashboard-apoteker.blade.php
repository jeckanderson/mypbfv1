<div class="content">
    <div class="grid gap-6">
        <div class="col 2xl:col-span-9">
            <div class="grid gap-6">
                <!-- BEGIN: General Report -->
                <div class="col-span-12 mt-8">
                    <div class="flex items-center h-10 intro-y">
                        <h2 class="mr-5 text-lg font-medium truncate">
                            General Report
                        </h2>
                        <a href="" class="flex items-center ml-auto text-primary"> <i data-feather="refresh-ccw"
                                class="w-4 h-4 mr-3"></i> Reload Data </a>
                    </div>
                    <div class="grid grid-cols-12 gap-6 mt-5">
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                            <div class="report-box zoom-in">
                                <div class="p-5 box">
                                    <div class="flex">
                                        <i data-feather="shopping-cart" class="report-box__icon text-primary"></i>
                                    </div>
                                    <div class="mt-6 text-3xl font-medium leading-8"></div>
                                    <div class="mt-1 text-base text-slate-500">Nalai Stok</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                            <div class="report-box zoom-in">
                                <div class="p-5 box">
                                    <div class="flex">
                                        <i data-feather="credit-card" class="report-box__icon text-pending"></i>
                                        {{-- <div class="ml-auto">
                                            <div class="cursor-pointer report-box__indicator bg-danger tooltip"
                                                title="2% Lower than last month"> 2% <i data-feather="chevron-down"
                                                    class="w-4 h-4 ml-0.5"></i> </div>
                                        </div> --}}
                                    </div>
                                    <div class="mt-6 text-3xl font-medium leading-8"></div>
                                    <div class="mt-1 text-base text-slate-500">Stok Dagang</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                            <div class="report-box zoom-in">
                                <div class="p-5 box">
                                    <div class="flex">
                                        <i data-feather="monitor" class="report-box__icon text-warning"></i>
                                    </div>
                                    <div class="mt-6 text-3xl font-medium leading-8">
                                        Rp.</div>
                                    <div class="mt-1 text-base text-slate-500">Stok Konsinyasi</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                            <div class="report-box zoom-in">
                                <div class="p-5 box">
                                    <div class="flex">
                                        <i data-feather="monitor" class="report-box__icon text-success"></i>
                                    </div>
                                    <div class="mt-6 text-3xl font-medium leading-8"> Rp.
                                    </div>
                                    <div class="mt-1 text-base text-slate-500">Stok Exp Date</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-span-12 mt-6">
                    <div class="items-center block h-10 intro-y sm:flex">
                        <h2 class="mr-5 text-lg font-medium truncate">
                            Produk Penjualan Terbaik
                        </h2>
                    </div>
                    <div class="mt-8 overflow-auto intro-y lg:overflow-visible sm:mt-0">
                        <table class="table table-report sm:mt-2">
                            <thead>
                                <tr>
                                    <th class="whitespace-nowrap">Nama Produk</th>
                                    <th class="text-center whitespace-nowrap">Kode</th>
                                    <th class="text-center whitespace-nowrap">Jumlah Penjualan</th>
                                    <th class="text-center whitespace-nowrap">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($produks as $produk)
                                    <tr class="intro-x">
                                        <td>
                                            <a href=""
                                                class="font-medium whitespace-nowrap">{{ Str::title($produk->nama_obat_barang) }}</a>
                                        </td>
                                        <td class="text-center">{{ $produk->barcode_produk }}</td>
                                        <td class="text-center">{{ $produk->produk_penjualan_count }}</td>
                                        <td class="w-40">
                                            @if ($produk->status == 1)
                                                <div class="flex items-center justify-center text-success"> <i
                                                        data-feather="check-square" class="w-4 h-4 mr-2"></i> Active
                                                </div>
                                            @else
                                                <div class="flex items-center justify-center text-danger">Non Active
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
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
                </div> --}}
            </div>
        </div>
    </div>
</div>
