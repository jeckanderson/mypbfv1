<div>
    <div class="flex flex-wrap gap-2 mt-5">
        <!-- Periode -->
        <div class="flex items-center">
            <label for="tanggal-dari" class="inline-block mt-2 mb-2 sm:w-20">Periode Mulai</label>
            <div class="form-control">
                <input id="tanggal-dari" name="mulaiId" wire:model.lazy="mulaiId" type="month"
                    class="w-full text-sm transition duration-200 ease-in-out rounded-md shadow-sm disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 border-slate-200 focus:ring-4 focus:ring-primary focus:border-primary dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700" />
            </div>
        </div>

        <div class="flex items-center">
            <label for="tanggal-sampai" class="inline-block mt-2 mb-2 sm:w-10">s/d</label>
            <div class="form-control">
                <input id="tanggal-sampai" name="sampaiId" wire:model.lazy="sampaiId" type="month"
                    class="w-full text-sm transition duration-200 ease-in-out rounded-md shadow-sm disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 border-slate-200 focus:ring-4 focus:ring-primary focus:border-primary dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700" />
            </div>
        </div>

        <!-- Jenis Produk -->
        <div class="flex items-center mt-auto">
            {{-- <label for="jenis" class="inline-block mt-2 mb-2 sm:w-20">Jenis Produk</label> --}}
            <select id="jenis" wire:model.live="jenisId" class="form-control">
                <option value="">Pilih Jenis Produk</option>
                @foreach ($jenis as $item)
                    <option value="{{ $item->id }}">{{ $item->jenis }}</option>
                @endforeach
            </select>
        </div>
        <!-- Golongan -->
        <div class="flex items-center mt-auto">
            {{-- <label for="golongan" class="inline-block mt-2 mb-2 sm:w-20">Golongan</label> --}}
            <select id="golongan" wire:model.live="golonganId" class="form-control">
                <option value="">Pilih Golongan</option>
                @foreach ($golongan as $item)
                    <option value="{{ $item->id }}">{{ $item->sub_golongan }}</option>
                @endforeach
            </select>
        </div>

        <!-- Pencarian -->
        <div class="flex items-center mt-auto">
            <div class="relative w-56 text-slate-500 {{ $class ?? '' }}">
                <input type="text" class="w-56 pr-10 form-control cari box" placeholder="Search nama produk ..."
                    wire:model.live.debounce.300ms="search">
                <i class="absolute inset-y-0 right-0 w-4 h-4 my-auto mr-3" data-feather="search"></i>
            </div>
        </div>

        <!-- Tombol dan Ekspor -->
        <div class="flex items-center gap-2 mt-auto">
            <button class="flex items-center text-white shadow-md btn btn-success" wire:ignore wire:click='export'>
                <span wire:ignore class="flex gap-1"><i data-feather="file-text" class="w-5 h-5 mr-1"></i>Excel</span>
            </button>
            {{-- <a href="{{ route('cetak_pdf_kas_bank', [
                'search' => $search,
                'golonganId' => $golonganId,
                'jenisId' => $jenisId,
                'mulaiId' => $mulaiId,
            ]) }}"
                target="_blank" class="btn btn-primary">
                <span wire:ignore class="flex gap-1"><i data-feather="printer" class="w-5 h-5 mr-1"></i>PDF</span>
            </a> --}}
        </div>

        <!-- Loading -->
        <div class="w-full text-center" wire:loading wire:target="print">
            Loading PDF...
        </div>
    </div>

    <div class="box">
        <div class="overflow-auto">
            <table class="table mt-5">
                <thead class="text-center">
                    <tr>
                        <th rowspan="2" class="border border-slate-600 whitespace-nowrap">No</th>
                        <th rowspan="2" class="border border-slate-600 whitespace-nowrap">Kode Obat NIE </th>
                        <th rowspan="2" class="border border-slate-600 whitespace-nowrap">Nama Obat</th>
                        <th rowspan="2" class="border border-slate-600 whitespace-nowrap">Kemasan</th>
                        <th rowspan="2" class="border border-slate-600 whitespace-nowrap">Stok Awal</th>
                        <th colspan="5" class="border border-slate-600 whitespace-nowrap">Jumlah Pemasukan</th>
                        <th colspan="10" class="border border-slate-600 whitespace-nowrap">Jumlah Pengeluaran</th>
                        <th rowspan="2" class="border border-slate-600 whitespace-nowrap">HJD</th>
                    </tr>
                    <tr>
                        <th class="border border-slate-600 whitespace-nowrap">Masuk IF</th>
                        <th class="border border-slate-600 whitespace-nowrap">Kode IF</th>
                        <th class="border border-slate-600 whitespace-nowrap">Masuk PBF</th>
                        <th class="border border-slate-600 whitespace-nowrap">Kode PBF</th>
                        <th class="border border-slate-600 whitespace-nowrap">Retur</th>
                        <th class="border border-slate-600 whitespace-nowrap">PBF</th>
                        <th class="border border-slate-600 whitespace-nowrap">Kode PBF</th>
                        <th class="border border-slate-600 whitespace-nowrap">RS</th>
                        <th class="border border-slate-600 whitespace-nowrap">Apotek</th>
                        <th class="border border-slate-600 whitespace-nowrap">Sarana Pemerintah</th>
                        <th class="border border-slate-600 whitespace-nowrap">Puskesmas</th>
                        <th class="border border-slate-600 whitespace-nowrap">Klinik</th>
                        <th class="border border-slate-600 whitespace-nowrap">Toko Obat</th>
                        <th class="border border-slate-600 whitespace-nowrap">Lainnya</th>
                        <th class="border border-slate-600 whitespace-nowrap">Retur</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($historys as $history)
                        <tr class="intro-x">
                            <td class="border border-slate-600 whitespace-nowrap">{{ $loop->iteration }}</td>
                            <td class="border border-slate-600 whitespace-nowrap">{{ $history->produk->no_ijin_edar }}
                            </td>
                            <td class="border border-slate-600 whitespace-nowrap">
                                {{ $history->produk->nama_obat_barang }}
                            </td>
                            <td class="border border-slate-600 whitespace-nowrap">
                                {{ $history->produk->satuanTerkecil->satuan }}</td>
                            <td class="border border-slate-600 whitespace-nowrap"></td>
                            <td class="border border-slate-600 whitespace-nowrap"></td>
                            <td class="border border-slate-600 whitespace-nowrap"></td>
                            <td class="border border-slate-600 whitespace-nowrap">
                                {{ $history->produkDiterima ? $history->produkDiterima->diterima : '' }}</td>
                            <td class="border border-slate-600 whitespace-nowrap">
                                {{ $history->produkDiterima ? $history->produkDiterima->pembelian->getSuplier->kode_e_report : '' }}
                            <td class="border border-slate-600 whitespace-nowrap">
                                {{ $history->returPembelian ? $history->returPembelian->qty_retur ?? '' : '' }}
                            </td>
                            <td class="border border-slate-600 whitespace-nowrap">
                                {{ $history->pelanggan ? ($history->pelanggan->tipe == 'PBF' ? $history->produkPenjualan->qty : '') : '' }}
                            </td>
                            <td class="border border-slate-600 whitespace-nowrap">
                                {{ $history->pelanggan ? ($history->pelanggan->tipe == 'PBF' ? $history->pelanggan->kode : '') : '' }}
                            </td>
                            <td class="border border-slate-600 whitespace-nowrap">
                                {{ $history->pelanggan && $history->pelanggan->tipe == 'RS' ? $history->produkPenjualan?->qty : '' }}
                            </td>
                            <td class="border border-slate-600 whitespace-nowrap">
                                {{ $history->pelanggan && $history->pelanggan->tipe == 'Apotek' ? $history->produkPenjualan?->qty : '' }}
                            </td>

                            <td class="border border-slate-600 whitespace-nowrap">
                                {{ $history->pelanggan && $history->pelanggan->tipe == 'Sarana Pemerintah' ? $history->produkPenjualan->qty : '' }}
                            </td>
                            <td class="border border-slate-600 whitespace-nowrap">
                                {{ $history->pelanggan && $history->pelanggan->tipe == 'Puskesmas' ? $history->produkPenjualan->qty : '' }}
                            </td>
                            <td class="border border-slate-600 whitespace-nowrap">
                                {{ $history->pelanggan && $history->pelanggan->tipe == 'Klinik' ? $history->produkPenjualan?->qty : '' }}
                            </td>
                            <td class="border border-slate-600 whitespace-nowrap">
                                {{ $history->pelanggan && $history->pelanggan->tipe == 'Toko Obat' ? $history->produkPenjualan->qty : '' }}
                            </td>
                            <td class="border border-slate-600 whitespace-nowrap">
                                {{ $history->pelanggan && $history->pelanggan->tipe == 'Lainnya' ? $history->produkPenjualan->qty : '' }}
                            </td>
                            <td class="border border-slate-600 whitespace-nowrap">
                                {{ $history->retur ? $history->retur->qty_retur : '' }}
                            </td>
                            <td class="border border-slate-600 whitespace-nowrap">
                                @php
                                    $ppn = App\Models\PPN::first()->ppn / 100;
                                    $hpp = '';
                                    if ($history->produkPenjualan) {
                                        $hpp = $history->produkPenjualan->harga * (1 + $ppn);
                                    }
                                @endphp

                                {{ number_format(floatVal($hpp), 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="font-bold text-center text-pending border border-slate-600" colspan="21">
                                Belum ada
                                data
                                tersedia</td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
        <div class="p-5">
            {{ $historys->links() }}
        </div>
    </div>
</div>
