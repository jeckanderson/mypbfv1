<div id="{{ $id_modal . $id }}" class="modal" tabindex="-1" aria-hidden="true">
    <div class="rounded-lg modal-dialog modal-xl">
        <div class="modal-content">
            <form action="{{ route($route, ['id' => $id]) }}" method="post">
                @csrf
                <div class="p-15 modal-body">
                    <div class="preview">
                        <div class="flex w-full gap-3">
                            <div data-tw-merge class="items-center block mt-3 sm:flex">
                                <label data-tw-merge for="horizontal-form-1"
                                    class="inline-block mt-2 mb-2 sm:w-20">Filter
                                </label>
                                <input data-tw-merge id="myInputSearch" type="text" placeholder="Cari Nama Produk..."
                                    oninput="searchFunction()"
                                    class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                            </div>
                            <div data-tw-merge class="items-center block mt-3 sm:flex">
                                <label data-tw-merge for="horizontal-form-1" class="inline-block mt-2 mb-2 sm:w-40">
                                    Tahun
                                </label>
                                <input type="number" class="form-control tahun" id="tahun" required
                                    placeholder="Masukan Tahun" name="tahun" min="2022" max="3099">
                            </div>
                            <div data-tw-merge class="items-center block mt-3 sm:flex">
                                <label data-tw-merge for="horizontal-form-1"
                                    class="inline-block mt-2 mb-2 sm:w-20">Bulan
                                </label>
                                <select data-tw-merge id="bulanSelect" name="bulan" required
                                    aria-label="Default select example" class="form-control w-44 bulanSelect">
                                    <option value="">- Pilih Bulan -</option>
                                    <option value="Januari">Januari</option>
                                    <option value="Februari">Februari</option>
                                    <option value="Maret">Maret</option>
                                    <option value="April">April</option>
                                    <option value="Mei">Mei</option>
                                    <option value="Juni">Juni</option>
                                    <option value="Juli">Juli</option>
                                    <option value="Agustus">Agustus</option>
                                    <option value="September">September</option>
                                    <option value="Oktober">Oktober</option>
                                    <option value="November">November</option>
                                    <option value="Desember">Desember</option>
                                </select>
                            </div>
                        </div>
                        <div class="w-full overflow-auto">
                            <table class="table mt-3" id="myTableTargetProduk">
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
                                        text-align: center;
                                    }

                                    td {
                                        font-size: 1em;
                                    }
                                </style>
                                <thead>
                                    <tr class="header-gray">
                                        <td class="border border-slate-600 whitespace-nowrap">Barcode</td>
                                        <td class="border border-slate-600 whitespace-nowrap">Nama Produk</td>
                                        <td class="border border-slate-600 whitespace-nowrap">Stok</td>
                                        <td class="border border-slate-600 whitespace-nowrap">Satuan Terkecil</td>
                                        <td class="border border-slate-600 whitespace-nowrap">Status Aktif</td>
                                        <td class="border border-slate-600 whitespace-nowrap">Tipe</td>
                                        <td class="border border-slate-600 whitespace-nowrap">Target</td>
                                        <td class="border border-slate-600 whitespace-nowrap">Penjualan (A)</td>
                                        <td class="border border-slate-600 whitespace-nowrap">Retur Penjualan (B)</td>
                                        <td class="border border-slate-600 whitespace-nowrap">(A-B)</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($obatBarangs as $obatBarang)
                                        @php
                                            $penjualan = $obatBarang->produkPenjualan->count();
                                            $retur = $obatBarang->produkReturPenjualan->count();

                                            $totalIsi = 0;
                                            foreach ($obatBarang->produkPenjualan as $key => $value) {
                                                $diskonKelompok = App\Models\DiskonKelompok::where(
                                                    'id_obat_barang',
                                                    $value->id_produk,
                                                )
                                                    ->where('satuan_dasar_beli', $value->satuan)
                                                    ->first();

                                                if ($diskonKelompok && isset($diskonKelompok->isi)) {
                                                    $totalIsi += $diskonKelompok->isi;
                                                }
                                            }
                                            $totalRetur = 0;
                                            foreach ($obatBarang->produkReturPenjualan as $key => $value) {
                                                $diskonKelompok = App\Models\DiskonKelompok::where(
                                                    'id_obat_barang',
                                                    $value->produkPenjualan->id_produk,
                                                )
                                                    ->where('satuan_dasar_beli', $value->produkPenjualan->satuan)
                                                    ->first();

                                                if ($diskonKelompok && isset($diskonKelompok->isi)) {
                                                    $totalRetur += $diskonKelompok->isi;
                                                }
                                            }

                                            $hasil = $totalIsi - $totalRetur;
                                        @endphp
                                        <tr>
                                            <td class="border border-slate-600">
                                                {{ $obatBarang->barcode_produk }}</td>
                                            <td class="border border-slate-600">{{ $obatBarang->nama_obat_barang }}</td>
                                            <td class="border border-slate-600">{{ $obatBarang->stok_minimal }}</td>
                                            <td class="border border-slate-600">
                                                {{ $obatBarang->satuanTerkecil->satuan }}
                                            </td>
                                            <td class="border border-slate-600">
                                                {{ $obatBarang->status == 1 ? 'Aktif' : 'Non Aktif' }}</td>
                                            <td class="border border-slate-600">{{ $obatBarang->tipe }}</td>
                                            <td class="border border-slate-600">
                                                <input data-tw-merge id="horizontal-form-1" type="number"
                                                    placeholder="" name="target[{{ $loop->index }}][target_produk]"
                                                    class="w-32 disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                                                <input type="hidden" name="target[{{ $loop->index }}][id_produk]"
                                                    value="{{ $obatBarang->id }}">
                                            </td>
                                            <td class="border border-slate-600">
                                                {{ $totalIsi }}</td>
                                            <td class="border border-slate-600">
                                                {{ $totalRetur }}</td>
                                            <td class="border border-slate-600">
                                                {{ $hasil }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- footer --}}
                <div class="modal-footer">
                    <button class="mt-5 btn btn-primary" type="submit" name="submit"> Simpan </button>
                    <button class="mt-5 btn btn-outline-danger" data-tw-dismiss="modal" type="button"> Batal </button>

                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function searchFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("myInputSearch");
        filter = input.value.toUpperCase();
        console.log(filter);
        table = document.getElementById("myTableTargetProduk");
        tr = table.getElementsByTagName("tr");

        for (i = 0; i < tr.length; i++) {
            if (i === 0) {
                continue; // Skip the header row
            }

            td = tr[i].getElementsByTagName("td")[1];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

    function updateHiddenFields() {
        const tahunInputs = document.querySelectorAll('.tahun');
        const bulanSelects = document.querySelectorAll('.bulanSelect');
        const tahunHiddenInputs = document.querySelectorAll('.tahunHidden');
        const bulanHiddenInputs = document.querySelectorAll('.bulanHidden');

        for (let i = 0; i < tahunInputs.length; i++) {
            const tahunInput = tahunInputs[i];
            const bulanSelect = bulanSelects[i];
            const tahunHidden = tahunHiddenInputs[i];
            const bulanHidden = bulanHiddenInputs[i];

            tahunHidden.value = tahunInput.value;
            bulanHidden.value = bulanSelect.value;
        }
    }
</script>
