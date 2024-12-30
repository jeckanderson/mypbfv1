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
                                    <div class="mt-1 text-base text-slate-500">Total Hutang</div>
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
                                    <div class="mt-6 text-3xl font-medium leading-8">{{ $piutangJT }}</div>
                                    <div class="mt-1 text-base text-slate-500">Total Piutang JT</div>
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
                                        Rp. {{ number_format($hutang, 0, ',', '.') }}</div>
                                    <div class="mt-1 text-base text-slate-500">Total Pembayaran Hutang</div>
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
                                        {{ number_format($piutang, 0, ',', '.') }}</div>
                                    <div class="mt-1 text-base text-slate-500">Total Pembayaran Piutang</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 mt-6">
                    <div class="items-center block h-10 intro-y sm:flex">
                        <h2 class="mr-5 text-lg font-medium truncate">
                            Pembayaran Hutang
                        </h2>
                    </div>
                    <div class="mt-8 overflow-auto intro-y lg:overflow-visible sm:mt-0">
                        <table class="table table-report sm:mt-2">
                            <thead>
                                <tr>
                                    <th class="whitespace-nowrap">No Reff</th>
                                    <th class="text-center whitespace-nowrap">Suplier</th>
                                    <th class="text-center whitespace-nowrap">Tanggal Input</th>
                                    <th class="text-center whitespace-nowrap">Jumlah Bayar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($daftarHutang as $hutang)
                                    <tr class="intro-x">
                                        <td class="text-center">{{ $hutang->no_reff }}</td>
                                        <td class="text-center">{{ $hutang->getSuplier->nama_suplier }}</td>
                                        <td class="text-center">{{ $hutang->tgl_input }}</td>
                                        <td class="text-center">{{ number_format($hutang->total_bayar, 0, ',', '.') }}
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
                                <li class="page-item {{ $daftarHutang->previousPageUrl() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $daftarHutang->previousPageUrl() }}"> <i
                                            class="w-4 h-4" data-feather="chevron-left"></i> </a>
                                </li>
                                <!-- Daftar halaman -->
                                @foreach ($daftarHutang->getUrlRange(1, $daftarHutang->lastPage()) as $page => $url)
                                    <li class="page-item {{ $page == $daftarHutang->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach
                                <!-- Tombol navigasi ke halaman berikutnya -->
                                <li class="page-item {{ $daftarHutang->nextPageUrl() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $daftarHutang->nextPageUrl() }}"> <i class="w-4 h-4"
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
                <div class="col-span-12 mt-6">
                    <div class="items-center block h-10 intro-y sm:flex">
                        <h2 class="mr-5 text-lg font-medium truncate">
                            Pembayaran Piutang
                        </h2>
                    </div>
                    <div class="mt-8 overflow-auto intro-y lg:overflow-visible sm:mt-0">
                        <table class="table table-report sm:mt-2">
                            <thead>
                                <tr>
                                    <th class="whitespace-nowrap">No Reff</th>
                                    <th class="text-center whitespace-nowrap">Metode</th>
                                    <th class="text-center whitespace-nowrap">Tanggal Input</th>
                                    <th class="text-center whitespace-nowrap">Jumlah Bayar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($daftarPiutang as $piutang)
                                    <tr class="intro-x">
                                        <td class="text-center">{{ $piutang->no_reff }}</td>
                                        <td class="text-center">{{ Str::title($piutang->metode) }}</td>
                                        <td class="text-center">{{ $piutang->tgl_input }}</td>
                                        <td class="text-center">{{ number_format($piutang->total_bayar, 0, ',', '.') }}
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
                                <li class="page-item {{ $daftarHutang->previousPageUrl() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $daftarHutang->previousPageUrl() }}"> <i
                                            class="w-4 h-4" data-feather="chevron-left"></i> </a>
                                </li>
                                <!-- Daftar halaman -->
                                @foreach ($daftarHutang->getUrlRange(1, $daftarHutang->lastPage()) as $page => $url)
                                    <li class="page-item {{ $page == $daftarHutang->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach
                                <!-- Tombol navigasi ke halaman berikutnya -->
                                <li class="page-item {{ $daftarHutang->nextPageUrl() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $daftarHutang->nextPageUrl() }}"> <i
                                            class="w-4 h-4" data-feather="chevron-right"></i> </a>
                                </li>
                            </ul>
                        </nav>
                        <!-- Jumlah item per halaman -->
                        <select class="w-20 mt-3 form-select box sm:mt-0" wire:model.live='row2'>
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
