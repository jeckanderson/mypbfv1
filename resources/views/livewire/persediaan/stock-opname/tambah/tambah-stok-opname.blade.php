<div>
    @php
        use App\Models\HistoryStok;
    @endphp
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="flex flex-wrap items-center col-span-12 gap-2 mt-0 intro-y sm:flex-nowrap">
            <div data-tw-merge class="items-center block sm:flex">
                <a href="/stok-opname"><button class="mr-2 btn btn-pending" wire:ignore><i data-feather="corner-up-left"
                            class="w-4 h-4 mr-1"></i>
                        Kembali</button></a>
            </div>
            <div data-tw-merge class="items-center block sm:flex">
                {{-- <label data-tw-merge for="horizontal-form-1" class="inline-block mt-2 mb-2 font-bold sm:w-24">
                    Gudang
                </label> --}}
                <select data-tw-merge aria-label="Default select example"
                    class="inline-block mt-2 mb-2 form-control sm:w-40" wire:model.live='selectedGudang'>
                    <option value="">-- Pilih Gudang --</option>
                    @forelse ($gudangs as $gudang)
                        <option value="{{ $gudang->id }}">{{ $gudang->gudang }}</option>
                    @empty
                    @endforelse
                </select>
            </div>
            <div data-tw-merge class="items-center block sm:flex">
                {{-- <label data-tw-merge for="horizontal-form-1" class="inline-block mt-2 mb-2 font-bold sm:w-20">
                    Rak
                </label> --}}
                <select data-tw-merge aria-label="Default select example"
                    class="inline-block mt-2 mb-2 form-control sm:w-40" wire:model.live='selectedRak'>
                    <option value="">-- Pilih Rak --</option>
                    @forelse ($raks as $rak)
                        <option value="{{ $rak->id }}">{{ $rak->rak }}</option>
                    @empty
                    @endforelse
                </select>
            </div>
            <div data-tw-merge class="items-center block sm:flex">
                {{-- <label data-tw-merge for="horizontal-form-1" class="inline-block mt-2 mb-2 font-bold sm:w-32">
                    Sub Rak
                </label> --}}
                <select data-tw-merge aria-label="Default select example"
                    class="inline-block mt-2 mb-2 form-control sm:w-40" wire:model.live='selectedSubRak'>
                    <option value="">-- Pilih Sub Rak --</option>
                    @forelse ($subRak as $rak)
                        <option value="{{ $rak->id }}">{{ $rak->sub_rak }}</option>
                    @empty
                    @endforelse
                </select>
                <button onclick="location.reload()" class="ml-2 btn btn-md btn-secondary" wire:ignore>
                    <i data-feather="refresh-cw" class="w-4 h-4 mr-1"></i> Reload
                </button>
            </div>
            <div data-tw-merge class="items-center block sm:flex">
                <a href="/stok-opname-download-pdf" class="flex items-center text-white shadow-md btn btn-facebook"
                    wire:ignore style="position: fixed; right: 5px;"><i data-feather="printer"
                        class="w-4 h-4 mr-1"></i>Print
                </a>
                <a href="/stok-opname-download-excel" class="flex items-center text-white shadow-md btn btn-success"
                    wire:ignore style="position: fixed; right: 75px;"><i data-feather="file-text" class="w-4 h-4 mr-1"
                        value="Export Excel"onclick="window.open('laporan-excel.php')"></i>Excel
                </a>
            </div>
            {{-- <div data-tw-merge class="items-center block sm:flex">
                <label data-tw-merge for="horizontal-form-1" class="inline-block mt-2 mb-2 font-bold sm:w-20">
                    Tipe
                </label>
                <select data-tw-merge aria-label="Default select example" class="form-control">
                    <option>- Pilih -</option>
                    <option>Dagang</option>
                    <option>Konsinyasi</option>
                </select>
            </div>
            <div class="">
                <button class="btn btn-primary">Tampilkan</button>
            </div> --}}
        </div>
    </div>
    <div class="col-span-12 overflow-auto intro-y lg:overflow-visible">
        <div class="mt-1 intro-y box">
            <div
                class="flex flex-col items-center p-2 border-b sm:flex-row bg-primary border-slate-200/60 dark:border-darkmode-400">
                <h2 class="mr-auto text-base font-medium text-white">
                    Data Histori Stok
                </h2>
                <div class="w-full mt-3 form-check form-switch sm:w-auto sm:ml-auto sm:mt-0">
                    <div class="relative w-56 text-slate-500 ">
                        @include('components.search', [
                            'id_table' => 'myTable',
                        ])
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="table mt-1" id="myTable">
                    <style>
                        .border {
                            border: 1px solid #bbb;
                            /* Contoh warna abu-abu untuk border */
                        }

                        .header-gray {
                            background-color: #e0e0e0;
                            /* Contoh warna abu-abu */
                            color: black;
                            /* Warna teks hitam */
                        }
                    </style>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            margin: 20px;
                        }

                        table {
                            width: 100%;
                            border-collapse: collapse;
                            margin: 20px 0;
                        }

                        th,
                        td {
                            padding: 3px;
                            text-align: left;
                        }

                        .border {
                            border: 1px solid #bbb;
                            /* Contoh warna abu-abu untuk border */
                        }

                        .header-gray {
                            background-color: #e0e0e0;
                            /* Contoh warna abu-abu */
                            color: black;
                            /* Warna teks hitam */
                        }

                        th {
                            font-weight: bold;
                            text-align: left;
                        }

                        td {
                            font-size: 1em;
                        }
                    </style>
                    <thead>
                        <tr class="header-gray">
                            <th class="whitespace-nowrap">Nama Produk</th>
                            <th class="whitespace-nowrap">No. Batch</th>
                            <th class="whitespace-nowrap">Exp. Date</th>
                            <th class="whitespace-nowrap">Stok</th>
                            <th class="whitespace-nowrap">Satuan</th>
                            <th class="whitespace-nowrap">Tipe</th>
                            <th class="whitespace-nowrap">Gudang</th>
                            <th class="whitespace-nowrap">Rak</th>
                            <th class="whitespace-nowrap">Sub Rak</th>
                            <th class="text-center whitespace-nowrap">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $sortedHistoryStok = $historyStok->sortBy(function ($history) {
                                return $history->produk->nama_obat_barang;
                            });
                        @endphp

                        @forelse ($sortedHistoryStok as $history)
                            @php
                                $tercatat = $history->sisaStokBatch(
                                    $history->id_produk,
                                    $history->no_batch,
                                    $history->id_gudang,
                                    $history->id_rak,
                                    $history->id_sub_rak,
                                );
                            @endphp
                            @if ($tercatat != 0)
                                <tr class="intro-x">
                                    <td class="w-60">{{ $history->produk->nama_obat_barang }}</td>
                                    <td class="">{{ $history->no_batch }}</td>
                                    <td class="">{{ date('d-m-Y', strtotime($history->exp_date)) }}</td>
                                    <td class="">
                                        {{ $tercatat }}
                                    </td>
                                    <td class="">{{ $history->produk->satuanTerkecil->satuan }}</td>
                                    <td class="">{{ $history->produk->tipe }}</td>
                                    <td class="">{{ $history->gudang->gudang }}</td>
                                    <td class="">{{ $history->rak->rak }}</td>
                                    <td class="">{{ $history->subRak->sub_rak }}</td>
                                    <td class="w-56 table-report__action">
                                        <div class="flex items-center justify-center">
                                            <a class="flex items-center btn btn-sm btn-outline-primary"
                                                href="javascript:;" data-tw-toggle="modal"
                                                data-tw-target="#cetak-kartu-stok{{ $history->id }}">
                                                Opname
                                            </a>
                                        </div>
                                        <div id="cetak-kartu-stok{{ $history->id }}" class="modal" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <livewire:persediaan.stock-opname.tambah.modal-tambah-stok-opname
                                                    :tercatat="$tercatat" :history="$history" />
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr class="intro-x">
                                <td class="font-bold text-center text-pending" colspan="11">Belum ada data tersedia
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
