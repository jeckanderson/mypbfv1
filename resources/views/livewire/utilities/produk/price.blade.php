<div>
    @php
        use App\Models\HistoryStok;

    @endphp

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

    <div class="grid grid-cols-12 gap-2 mt-8">
        <!-- Filter Form -->
        <div class="col-span-12 overflow-auto intro-y lg:overflow-visible">
            <div class="flex flex-wrap items-center gap-2 mt-0">
                <div class="flex items-center gap-2">
                    <div class="col-span-6 mt-0 md:col-span-3">
                        <div class="col-span-6 md:col-span-3">
                            <div class="relative w-56 text-slate-500">
                                <input type="text" class="w-56 pr-10 form-control cari box"
                                    placeholder="Search Nama Produk... " wire:model.live.debounce.300ms="search">
                                <i class="absolute inset-y-0 right-0 w-4 h-4 my-auto mr-3" data-feather="search"></i>
                            </div>
                        </div>
                    </div>
                    {{-- <label for="kelompok" class="inline-block w-32 sm:w-40">Kelompok</label> --}}
                    <select id="kelompok" name="kelompok" wire:model.live="kelompokId"
                        class="block rounded-md shadow-sm form-select">
                        <option value="">- Pilih Kelompok -</option>
                        @foreach ($kelompok as $item)
                            <option value="{{ $item->id }}">{{ $item->kelompok }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center">
                    {{-- <label for="golongan" class="inline-block w-32 sm:w-40">Kategori</label> --}}
                    <select id="golongan" name="golongan" wire:model.live="golonganId"
                        class="block rounded-md shadow-sm form-select">
                        <option value="">- Pilih Kategori -</option>
                        @foreach ($golongan as $item)
                            <option value="{{ $item->id }}">{{ $item->golongan }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center">
                    {{-- <label for="produsen" class="inline-block w-32 sm:w-40">Produsen</label> --}}
                    <select id="produsen" name="produsen" wire:model.live="produsenId"
                        class="block rounded-md shadow-sm form-select">
                        <option value="">- Pilih Produsen -</option>
                        @foreach ($produsen as $item)
                            <option value="{{ $item->id }}">{{ $item->produsen }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center">
                    {{-- <label for="order" class="inline-block w-32 sm:w-40">Urutkan</label> --}}
                    <select id="order" name="order" wire:model.live="order"
                        class="block rounded-md shadow-sm form-select">
                        <option value="3">Semua</option>
                        <option value="1">Terlama</option>
                        <option value="2">Terbaru</option>
                    </select>
                    <button onclick="location.reload()" class="ml-2 btn btn-md btn-secondary" wire:ignore>
                        <i data-feather="refresh-cw" class="w-4 h-4 mr-1"></i> Reload
                    </button>
                </div>

                <div class="flex items-center mr-auto">
                    {{-- <label for="search" class="inline-block w-32 sm:w-40">Cari</label> --}}
                    {{-- <input type="text" id="search" name="search" wire:model.live.debounce.300ms="search"
                        class="block rounded-md shadow-sm form-input"> --}}
                </div>
                <div class="col-span-6 md:col-span-3">
                    <div class="flex gap-2">
                        @if (!$profile->logo_perusahaan)
                            <button class="text-white btn btn-success" wire:click='alert'>
                                <div class="flex gap-1"wire:ignore>
                                    <i data-feather="file-text" class="w-4 h-4 mr-1"></i>Excel
                                </div>
                            </button>
                            <button wire:click='alert' class="btn btn-facebook">
                                <div class="flex gap-1" wire:ignore>
                                    <i data-feather="printer" class="w-4 h-4 mr-1"></i>Print
                                </div>
                            </button>
                        @else
                            <a
                                href="{{ route('cetak_excel', [
                                    'search' => $search,
                                    'kelompokId' => $kelompokId,
                                    'produsenId' => $produsenId,
                                    'golonganId' => $golonganId,
                                    'order' => $order,
                                ]) }}">
                                <button class="text-white btn btn-success">
                                    <div class="flex gap-1"wire:ignore>
                                        <i data-feather="file-text" class="w-5 h-5 mr-1"></i>Excel
                                    </div>
                                </button>
                            </a>

                            <a href="{{ route('cetak_pdf', [
                                'search' => $search,
                                'kelompokId' => $kelompokId,
                                'produsenId' => $produsenId,
                                'golonganId' => $golonganId,
                                'order' => $order,
                            ]) }}"
                                target="_blank" class="btn btn-facebook">
                                <div class="flex gap-3" wire:ignore>
                                    <i data-feather="printer" class="w-4 h-4 mr-1"></i>Print
                                </div>
                            </a>
                        @endif
                    </div>
                </div>

                <div class="text-center" wire:loading wire:target="print">
                    Loading PDF...
                </div>
            </div>
        </div>
    </div>


    <div class="col-span-12 md:col-span-9">
        <div class="mt-2 box">
            @if ($setharga && !$setharga->isEmpty())
                <table class="table">
                    <thead>
                        <tr class="header-gray">
                            <th rowspan="2">No</th>
                            <!-- <th rowspan="2">Kode</th> -->
                            <th rowspan="2">Nama Produk</th>
                            <th rowspan="2">Kelompok</th>
                            <th rowspan="2">Produsen</th>
                            <th rowspan="2">Satuan</th>
                            <th rowspan="2">Stok</th>
                            <th rowspan="2">Harga</th>
                            <th rowspan="2">Disc 1</th>
                            <th rowspan="2">Disc 2</th>
                            <th rowspan="2">HNA</th>
                            <th rowspan="2">HNA + PPN</th>
                            <th rowspan="2">Waktu Masuk Produk</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($setharga as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <!-- <td>{{ $item->produk->kode_obat_barang }}</td> -->
                                <td>{{ $item->produk->nama_obat_barang }}</td>
                                <td>{{ $item->kelompok->kelompok }}</td>
                                <td>{{ $item->produk->produsenProduk->produsen }}</td>
                                <td>{{ $item->satuanProduk->satuan }}</td>
                                <td>{{ (HistoryStok::where('id_produk', $item->id_produk)->sum('stok_masuk') - HistoryStok::where('id_produk', $item->id_produk)->sum('stok_keluar')) / $item->isi }}
                                </td>
                                <td>{{ number_format($item->hasil_laba, 0, ',', '.') }}</td>
                                <td>{{ $item->disc_1 }}%</td>
                                <td>{{ $item->disc_2 }}%</td>
                                <td>{{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                                <td>{{ number_format($item->harga_jual * (1 + $ppn / 100), 0, ',', '.') }}</td>
                                <td>{{ $item->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $setharga->links() }}
            @else
                <div class="p-5 box">
                    <p class="text-center text-pending">Belum Ada Data yang tersedia.</p>
                </div>
            @endif
        </div>

    </div>
</div>
