<div>
    <div class="grid grid-cols-12 gap-2 mt-8">
        <div class="col-span-6 md:col-span-3">
            <div class="flex items-center mb-2 ml-2">
                <div class="relative w-56 text-slate-500">
                    <input type="text" class="w-56 pr-10 form-control cari box" placeholder="Search No. SP... "
                        wire:model.live.debounce.300ms="search">
                    <i class="absolute inset-y-0 right-0 w-4 h-4 my-auto mr-3" data-feather="search"></i>
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

            <div class="flex items-center mb-2">
                <select data-tw-merge id="sales" aria-label="Default select example" wire:model.live="spId"
                    class="ml-2 form-control">
                    <option value="">- Pilih Supplier -</option>
                    @foreach ($suplier as $item)
                        <option value="{{ $item->id }}">{{ $item->nama_suplier }}</option>
                    @endforeach
                </select>

                <select id="tipe-sp" wire:model.live="tipeId" aria-label="Default select example"
                    class="ml-2 form-control">
                    <option value="">- Pilih SP -</option>
                    <option value="SP. Reguler">SP.Reguler</option>
                    <option value="SP. OOT">SP. OOT</option>
                    <option value="SP. Prekursor">SP. Prekursor</option>
                    <option value="SP. Psikotropika">SP. Psikotropika</option>
                    <option value="SP. Narkotika">SP. Narkotika</option>
                </select>
                <button onclick="location.reload()" class="ml-2 btn btn-md btn-secondary" wire:ignore>
                    <i data-feather="refresh-cw" class="w-4 h-4 mr-1"></i> Reload
                </button>
            </div>


            {{-- <div class="col-span-6 md:col-span-3" style="position: absolute; top: 385px; right:54px;">
                <div class="flex gap-2">
                    <button class="btn btn-success">
                        <span wire:ignore><i data-feather="file-text" class="w-5 h-5 mr-1"></i>Excel</span>
                    </button>
                    <a href="{{ route('cetak_pdf_vs_beli', [
                        'search' => $search,
                        'tipeId' => $tipeId,
                        'spId' => $spId,
                        'mulaiId' => $mulaiId,
                        'selesaiId' => $selesaiId,
                    ]) }}"
                        target="_blank" class="btn btn-primary"><span wire:ignore><i data-feather="printer"
                                class="w-5 h-5 mr-1"></i>PDF</span></a>
                </div>

            </div>


            <div class="col-span-6 md:col-span-3" style="position: absolute; top: 400px; right: 180px;">
                <div class="flex items-center mb-3">
                    <label for="search" class="inline-block mt-2 mb-2 sm:w-20">Cari</label>
                    <input type="text" id="search" name="search" wire:model.live.debounce.300ms="search"
                        class="block w-full rounded-md shadow-sm form-input">
                </div>
            </div> --}}

            <div class="text-center" wire:loading wire:target="print">
                Loading PDF...
            </div>


        </div>
    </div>

    <div class="overflow-auto box">

        {{-- <p>No. Sp : {{ $pembelian->sp->no_sp }}</p>
                    <p>Tgl. Sp : {{ $pembelian->sp->tgl_sp }}</p>
                    <p>Supplier : {{ $pembelian->suplier->nama_suplier }}</p>
                    <p>Tipe Sp : {{ $pembelian->sp->tipe_sp }}</p> --}}

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
                    <th class="border border-slate-600">No</th>
                    <th class="border border-slate-600">Supplier</th>
                    <th class="border border-slate-600">Nomor SP</th>
                    <th class="border border-slate-600">Nama Produk</th>
                    <th class="border border-slate-600">Satuan</th>
                    <th class="border border-slate-600">Qty SP</th>
                    <th class="border border-slate-600">Qty Beli</th>
                    <th class="border border-slate-600">Potensi Loss</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pembelian as $pembelians)
                    <tr class="text-center intro-x">
                        <td class="border border-slate-600">{{ $loop->iteration }}</td>
                        <td class="border border-slate-600">{{ $pembelians->pembelian->getSuplier->nama_suplier }}
                        <td class="border border-slate-600">{{ $pembelians->pembelian->no_sp }}
                        <td class="border border-slate-600">{{ $pembelians->produk->nama_obat_barang }}
                        </td>
                        <td class="border border-slate-600">{{ $pembelians->produk->satuanDasar->satuan }}
                        </td>
                        <td class="text-center border border-slate-600">
                            {{ $pembelians->rencanaOrders[0]->jumlah_order }}</td>
                        <td class="text-center border border-slate-600">{{ $pembelians->qty_faktur }}</td>
                        <td class="font-bold text-center border text-danger border-slate-600">
                            {{ $pembelians->rencanaOrders[0]->jumlah_order - $pembelians->qty_faktur }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="font-bold text-center border text-pending border-slate-600" colspan="8">Belum ada
                            data tersedia</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>

</div>
<!-- END: Data List -->
