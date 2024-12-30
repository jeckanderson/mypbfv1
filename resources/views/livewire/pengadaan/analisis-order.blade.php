<div class="grid grid-cols-12 gap-2 mt-8">
    @php
        use App\Models\HistoryStok;
        use App\Models\ProdukPenjualan;
        use App\Models\RencanaPengadaan;
        use App\Models\ObatBarang;
    @endphp
    <div class="flex flex-wrap items-center col-span-12 gap-2 mt-0 intro-y sm:flex-nowrap">
        <div data-tw-merge class="items-center block gap-2 sm:flex">
            <div class="flex gap-2 mb-0">
                <button class=" btn btn-pending"wire:ignore wire:click='sendDefecta'
                    wire:confirm='Apakah anda yakin akan mengirimkan ke defecta?'><i data-feather="edit-3"
                        class="w-4 h-4 mr-3"></i> Kirim Ke defecta</button>
                @include('components.search', [
                    'id_table' => 'myTable',
                ])
            </div>
            {{-- <label data-tw-merge for="horizontal-form-1" class="inline-block mt-0 mb-0 font-bold sm:w-20">
                Analisis
            </label> --}}
            <select data-tw-merge aria-label="Default select example" wire:model.live='analisis'
                class="w-40 mt-0 mb-0 form-control">
                <option value="1">1 Bulan</option>
                <option value="2">2 Bulan</option>
                <option value="3">3 Bulan</option>
                <option value="4">4 Bulan</option>
                <option value="5">5 Bulan</option>
                <option value="6">6 Bulan</option>
                <option value="7">7 Bulan</option>
                <option value="8">8 Bulan</option>
                <option value="9">9 Bulan</option>
                <option value="10">10 Bulan</option>
                <option value="11">11 Bulan</option>
                <option value="12">12 Bulan</option>
            </select>
        </div>
        {{-- <div data-tw-merge class="items-center block gap-2 sm:flex" wire:ignore>
            <label data-tw-merge for="horizontal-form-1" class="inline-block mt-0 mb-0 font-bold">
                Produk
            </label>
            <select data-tw-merge aria-label="Default select example" name="id_obat_barang"
                class="w-64 mt-0 mb-0 form-control tom-select" id="">
                <option value="">-- Pilih Produk --</option>
                @foreach ($produks as $barang)
                    <option value="{{ $barang->id }}">
                        {{ $barang->kode_obat_barang . ' || ' . $barang->nama_obat_barang }}</option>
                @endforeach
            </select>
        </div> --}}
        {{-- <div data-tw-merge class="items-center block gap-3 sm:flex">
            <label data-tw-merge for="horizontal-form-1" class="inline-block mt-0 mb-0 font-bold sm:w-40">
                Status Stok
            </label>
            <select data-tw-merge aria-label="Default select example" class="mt-0 mb-0 form-control">
                <option>-- Pilih Status --</option>
                <option>Over Stok</option>
                <option>Ideal Stok</option>
                <option>Under Stok</option>
            </select>
        </div> --}}
        {{-- <a href="/analisis-order-download-pdf" class="flex items-center text-white btn btn- btn-facebook" wire:ignore
            style="position: fixed; right: 50px;"><i data-feather="printer" class="w-4 h-4 mr-1"></i>Print
        </a>
        <a href="/analisis-order-download-excel" wire:ignore class="flex items-center text-white btn btn-success"
            style="position: fixed; right: 135px;"><i data-feather="file-text" class="w-4 h-4 mr-1"
                value="Export Excel"onclick="window.open('laporan-excel.php')"></i>Excel
        </a> --}}

    </div>
    <!-- BEGIN: Data List -->
    <div class="col-span-12 mt-0 overflow-auto intro-y lg:overflow-visible">
        <table class="table -mt-0 table-report" id="myTable">
            <thead style="background-color: #d3d3d3;">
                <tr>
                    <th class="whitespace-nowrap">No</th>
                    <th class="whitespace-nowrap">Barcode</th>
                    <th class="whitespace-nowrap">Nama Produk</th>
                    <th class="text-center whitespace-nowrap">Satuan Beli</th>
                    <th class="text-center whitespace-nowrap">Isi</th>
                    <th class="text-center whitespace-nowrap">Satuan Terkecil</th>
                    <th class="text-center whitespace-nowrap">Stok Tersedia</th>
                    <th class="text-center whitespace-nowrap">Stok Terjual</th>
                    <th class="text-center whitespace-nowrap">Stok Ideal</th>
                    <th class="text-center whitespace-nowrap">Status</th>
                    <th class="whitespace-nowrap">Golongan</th>
                    <th class="text-center whitespace-nowrap">Tipe</th>
                    <th class="text-center whitespace-nowrap">
                        <input data-tw-merge type="checkbox" wire:model.live='selectAll'
                            class="transition-all duration-100 ease-in-out shadow-sm border-slate-200 cursor-pointer rounded focus:ring-4 focus:ring-offset-0 focus:ring-primary focus:ring-opacity-20 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&amp;[type=&#039;radio&#039;]]:checked:bg-primary [&amp;[type=&#039;radio&#039;]]:checked:border-primary [&amp;[type=&#039;radio&#039;]]:checked:border-opacity-10 [&amp;[type=&#039;checkbox&#039;]]:checked:bg-primary [&amp;[type=&#039;checkbox&#039;]]:checked:border-primary [&amp;[type=&#039;checkbox&#039;]]:checked:border-opacity-10 [&amp;:disabled:not(:checked)]:bg-slate-100 [&amp;:disabled:not(:checked)]:cursor-not-allowed [&amp;:disabled:not(:checked)]:dark:bg-darkmode-800/50 [&amp;:disabled:checked]:opacity-70 [&amp;:disabled:checked]:cursor-not-allowed [&amp;:disabled:checked]:dark:bg-darkmode-800/50"
                            id="checkbox-switch-1" value="" />
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($produkPenjualan as $prod)
                    @php
                        $histori = HistoryStok::where('id_produk', $prod->id_produk)->where(
                            'id_perusahaan',
                            Auth::user()->id_perusahaan,
                        );

                        $jumlah = $histori->sum('stok_masuk') - $histori->sum('stok_keluar');
                        $jumlahProduk = ProdukPenjualan::where('id_produk', $prod->id_produk)->count();
                        // $jumlahIsi = $prod->produk->isi * $jumlahProduk;
                        $jumlahIsi = ($prod->produk->isi ?? 1) * $jumlahProduk;

                        $stokIdeal = $jumlahIsi / $analisis;
                    @endphp
                    <tr class="intro-x">
                        <td class="">{{ $loop->iteration }}</td>
                        {{-- <td class="">{{ $prod->produk->barcode_produk }}</td> --}}
                        <td class="">{{ $prod->produk->barcode_produk ?? '-' }}</td>
                        <td class="">{{ $prod->produk->nama_obat_barang ?? '-' }}</td>
                        <td class="text-center">{{ $prod->produk->satuanDasar->satuan ?? '-' }}</td>
                        <td class="text-center">{{ $prod->produk->isi ?? '1' }}</td>
                        <td class="text-center">{{ $prod->produk->satuanTerkecil->satuan ?? '-' }}</td>
                        <td class="text-center">{{ $jumlah }}</td>
                        <td class="text-center">{{ $jumlahIsi }}
                        <td class="text-center">{{ number_format($stokIdeal, 0, ',', '.') }}
                        </td>
                        @if ($jumlah == $stokIdeal)
                            <td class="text-center text-success">Stok Ideal</td>
                        @elseif ($jumlah < $stokIdeal)
                            <td class="text-center text-pending">Under Stok</td>
                        @elseif ($jumlah > $stokIdeal)
                            <td class="text-center text-danger">Over Stok</td>
                        @endif
                        <td class="">{{ $prod->produk->golonganProduk->sub_golongan ?? '-' }}</td>
                        <td class="text-center">{{ $prod->produk->tipe ?? '-' }}</td>
                        <td class="text-center table-report__action">
                            @if (RencanaPengadaan::where('id_perusahaan', Auth::user()->id_perusahaan)->where('tanggal', now()->toDateString())->where('sumber', 'order')->where('id_produk', optional($prod->produk)->id)->first())
                                <p class="font-bold text-success">Sudah Terkirim</p>
                            @else
                                <input data-tw-merge type="checkbox" wire:model='selectedProduk'
                                    class="transition-all duration-100 ease-in-out shadow-sm border-slate-200 cursor-pointer rounded focus:ring-4 focus:ring-offset-0 focus:ring-primary focus:ring-opacity-20 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&amp;[type=&#039;radio&#039;]]:checked:bg-primary [&amp;[type=&#039;radio&#039;]]:checked:border-primary [&amp;[type=&#039;radio&#039;]]:checked:border-opacity-10 [&amp;[type=&#039;checkbox&#039;]]:checked:bg-primary [&amp;[type=&#039;checkbox&#039;]]:checked:border-primary [&amp;[type=&#039;checkbox&#039;]]:checked:border-opacity-10 [&amp;:disabled:not(:checked)]:bg-slate-100 [&amp;:disabled:not(:checked)]:cursor-not-allowed [&amp;:disabled:not(:checked)]:dark:bg-darkmode-800/50 [&amp;:disabled:checked]:opacity-70 [&amp;:disabled:checked]:cursor-not-allowed [&amp;:disabled:checked]:dark:bg-darkmode-800/50"
                                    id="checkbox-switch-1" value="{{ optional($prod->produk)->id }}" />
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr class="intro-x">
                        <td class="font-bold text-pending text-center" colspan="13">Belum ada produk penjualan
                            tersedia</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <!-- END: Data List -->
</div>
