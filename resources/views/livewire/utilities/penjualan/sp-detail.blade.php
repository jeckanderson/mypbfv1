<div>
    <div class="grid grid-cols-12 gap-2 mt-8">
        <div class="col-span-6 md:col-span-3">
            <div class="flex items-center mb-2">
                <div class="col-span-6 mt-0 md:col-span-3">
                    <div class="col-span-6 md:col-span-3">
                        <div class="relative w-56 text-slate-500">
                            <input type="text" class="w-56 pr-10 form-control cari box" placeholder="Search No. SP ..."
                                wire:model.live.debounce.300ms="search">
                            <i class="absolute inset-y-0 right-0 w-4 h-4 my-auto mr-3" data-feather="search"></i>
                        </div>
                    </div>
                </div>

                <div class="ml-2">
                    <input id="tanggal-dari" name="mulaiId" wire:model.lazy="mulaiId" type="date"
                        placeholder="Stok dari master" style="width: 150px;"
                        class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&[readonly]]:bg-slate-100 [&[readonly]]:cursor-not-allowed [&[readonly]]:dark:bg-darkmode-800 [&[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                </div>
                <label for="tanggal-sampai" class="inline-block mt-2 mb-2 ml-2 sm:w-20">s.d</label>
                <div class="ml-2">
                    <input id="tanggal-sampai" wire:model.lazy="selesaiId" name="selesaiId" type="date"
                        placeholder="Stok dari master" style="width: 150px;"
                        class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&[readonly]]:bg-slate-100 [&[readonly]]:cursor-not-allowed [&[readonly]]:dark:bg-darkmode-800 [&[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                </div>
            </div>

            <div class="flex flex-col items-center gap-2 mb-2 sm:flex-row">
                <select id="pelanggan" name="pelanggan" wire:model.live="pelangganId"
                    aria-label="Default select example" class="w-auto form-select">
                    <option value="">- Pilih Pelanggan -</option>
                    @foreach ($pelanggan as $item)
                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                    @endforeach
                </select>

                <select id="sales" name="sales" wire:model.live="salesId" aria-label="Default select example"
                    class="w-auto form-select">
                    <option value="">- Pilih Sales -</option>
                    @foreach ($sales as $item)
                        <option value="{{ $item->pegawai_sales->id }}">{{ $item->pegawai_sales->nama_pegawai }}</option>
                    @endforeach
                </select>

                <select id="tipe-sp" wire:model.live="spId" aria-label="Default select example"
                    class="w-auto form-control">
                    <option value="">- Pilih Tipe SP -</option>
                    <option>SP. Reguler</option>
                    <option>SP. OOT</option>
                    <option>SP. Prekursor</option>
                    <option>SP. Psikotropika</option>
                    <option>SP. Narkotika</option>
                    <option>SP. Bonus</option>
                </select>

                <select id="sumber" wire:model.live="sumberId" aria-label="Default select example"
                    class="w-auto form-control">
                    <option value="">- Pilih Sumber -</option>
                    <option value="">Website</option>
                    <option value="">Mobile</option>
                </select>
                <button onclick="location.reload()" class="ml-0 btn btn-md btn-secondary" wire:ignore>
                    <i data-feather="refresh-cw" class="w-4 h-4 mr-1"></i> Reload
                </button>
            </div>

            {{-- <div class="col-span-6 md:col-span-3" style="position: absolute; top: 300px; right:80px;">
                <div class="flex gap-2">
                    <button class="text-white btn btn-success" wire:ignore><i data-feather="file-text"
                            class="w-4 h-4 mr-1"></i>Excel</span>
                    </button>
                    <a id="print-pdf-button"
                        href="{{ route('cetak_pdf_detail_sp', [
                            'search' => $search,
                            'spId' => $spId,
                            'salesId' => $salesId,
                            'mulaiId' => $mulaiId,
                            'selesaiId' => $selesaiId,
                            'pelangganId' => $pelangganId,
                            'sumberId' => $sumberId,
                            'spId' => $spId,
                        ]) }}"
                        target="_blank" class="btn btn-facebook" wire:ignore><i data-feather="printer"
                            class="w-4 h-4 mr-1"></i>Print</a>
                </div>
            </div> --}}

            <div class="text-center" wire:loading wire:target="print">
                Loading PDF...
            </div>

        </div>
    </div>

    @forelse ($sp as $produkpenjualans)
        <div class="p-5 mt-2 overflow-auto box">
            <div class="grid grid-cols-12 gap-3 mt-2 ml-4">
                <div class="col-span-12 md:col-span-3">
                    <div class="flex items-center mb-1">
                        <p class="inline-block sm:w-24">Tanggal :</p>
                        <h1>{{ \Carbon\Carbon::parse($produkpenjualans->tgl_input)->format('d-m-Y') }}</h1>
                    </div>

                    <div class="flex items-center mb-1">
                        <p class="inline-block sm:w-24">No. Reff: </p>
                        <h1>{{ $produkpenjualans->no_reff }}</h1>
                    </div>
                </div>

                <div class="col-span-12 md:col-span-3">
                    <div class="flex items-center mb-1">
                        <p class="inline-block sm:w-24">Pelanggan:</p>
                        <h1>{{ $produkpenjualans->pelangganPenjualan->nama }}</h1>
                    </div>
                    <div class="flex items-center mb-1">
                        <p class="inline-block sm:w-24">Sales: </p>
                        <h1>{{ $produkpenjualans->salesPenjualan->nama_pegawai }}</h1>
                    </div>
                </div>

                <div class="col-span-12 md:col-span-3">
                    <div class="flex items-center mb-1">
                        <p class="inline-block sm:w-24">No. Sp:</p>
                        <h1>{{ $produkpenjualans->no_sp }}</h1>
                    </div>
                    <div class="flex items-center mb-1">
                        <p class="inline-block sm:w-24">Tgl. Sp: </p>
                        <h1>{{ \Carbon\Carbon::parse($produkpenjualans->tgl_sp)->format('d-m-Y') }}</h1>
                    </div>
                </div>

                <div class="col-span-12 md:col-span-3">
                    <div class="flex items-center mb-1">
                        <p class="inline-block sm:w-24">Tipe. Sp :</p>
                        <h1>{{ $produkpenjualans->tipe_sp }}</h1>
                    </div>
                    <div class="flex items-center mb-1">
                        <p class="inline-block sm:w-24">Sumber: </p>
                        <h1>{{ $produkpenjualans->sumber }}</h1>
                    </div>
                </div>
            </div>

            <div class="overflow-auto">
                <table class="table mt-2">
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
                            text-align: center;
                        }

                        td {
                            font-size: 1em;
                        }
                    </style>
                    <thead>
                        <tr class="header-gray">
                            <th rowspan="2" class="border border-slate-600">No</th>
                            <th rowspan="2" class="border border-slate-600">Nama Produk</th>
                            <th rowspan="2" class="border border-slate-600">Kategori</th>
                            <th rowspan="2" class="border border-slate-600">Golongan</th>
                            <th rowspan="2" class="border border-slate-600">Jenis Produk</th>
                            <th rowspan="2" class="border border-slate-600"> Jumlah</th>
                            <th rowspan="2" class="border border-slate-600">Satuan</th>
                            <th rowspan="2" class="border border-slate-600">Keterangan</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($produkpenjualans->produkPenjualan as $item)
                            <tr class="text-center intro-x">
                                <td class="border border-slate-600 text-center">{{ $loop->iteration }}</td>
                                <td class="border border-slate-600">
                                    {{ $item->produk->nama_obat_barang }}
                                </td>
                                <td class="border border-slate-600 text-center">
                                    {{ $item->produk->kelompok->golongan }}
                                </td>
                                <td class="border border-slate-600 text-center">
                                    {{ $item->produk->golonganProduk->sub_golongan }}
                                </td>
                                <td class="border border-slate-600 text-center">
                                    {{ $item->produk->jenis_obat_barang }}
                                </td>
                                <td class="border border-slate-600 text-center">{{ $item->qty_sp }}</td>
                                <td class="border border-slate-600 text-center">{{ $item->satuanProduk->satuan }}
                                </td>
                                <td class="border border-slate-600">
                                    {{ $item->keterangan }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="font-bold text-center border text-pending border-slate-600" colspan="9">
                                    Belum ada
                                    data
                                    tersedia</td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>
    @empty
        <div class="p-5 font-bold text-center text-pending box">
            Belum ada data tersedia
        </div>
    @endforelse

</div>

<script>
    function validateDateInputs() {
        var tanggalDari = document.getElementById('tanggal-dari').value;
        var tanggalSampai = document.getElementById('tanggal-sampai').value;

        if (!tanggalDari || !tanggalSampai) {
            alert('Harap isi kedua tanggal sebelum mencetak PDF!');
            return false;
        }

        return true;
    }

    document.addEventListener('DOMContentLoaded', function() {
        var printPdfButton = document.getElementById('print-pdf-button');
        printPdfButton.addEventListener('click', function(event) {
            if (!validateDateInputs()) {
                event.preventDefault();
            }
        });
    });
</script>
