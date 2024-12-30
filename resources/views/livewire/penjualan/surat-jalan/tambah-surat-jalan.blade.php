<div>
    <form wire:submit='simpanSuratJalan'>
        <div class="p-5 mt-5 box">
            <div class="grid-cols-2 gap-5 sm:grid">
                <div class="">
                    <div data-tw-merge class="items-center block mt-1 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            No. Reff
                        </label>
                        <input data-tw-merge id="horizontal-form-1" type="text" placeholder="Auto" wire:model='no_reff'
                            @if ($isChangeStatus) disabled @endif
                            class="font-bold disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                    </div>
                    <div data-tw-merge class="items-center block mt-1 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            Tanggal
                        </label>
                        <input data-tw-merge id="horizontal-form-1" type="date" placeholder="" wire:model='tanggal'
                            @if ($isChangeStatus) disabled @endif
                            class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                    </div>
                </div>
                <div data-tw-merge class="items-center block mt-2">
                    <div data-tw-merge class="items-center block mt-1 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            Pengirim
                        </label>
                        <select data-tw-merge aria-label="Default select example" class="form-control"
                            @if ($isChangeStatus) disabled @endif wire:model='sales'>
                            <option>- Pilih -</option>
                            @forelse ($pegawais as $pegawai)
                                <option value="{{ $pegawai->id }}">{{ $pegawai->nama_pegawai }} |
                                    {{ $pegawai->jabatan }}
                                </option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                    <div data-tw-merge class="items-center block mt-1 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            Ekspedisi
                        </label>
                        <select data-tw-merge aria-label="Default select example" class="form-control" required
                            wire:model='ekspedisi' @if ($isChangeStatus) disabled @endif>
                            <option>- Pilih -</option>
                            @forelse ($dataEkspedisi as $eks)
                                <option value="{{ $eks->id }}">{{ $eks->nama_ekspedisi }} | {{ $eks->nomor }}
                                </option>
                            @empty
                                <option disabled>No expeditions available</option>
                            @endforelse
                        </select>

                    </div>
                </div>
            </div>
        </div>

        {{-- Modal daftar-pelanggan --}}
        <div id="daftar-pelanggan" class="modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <livewire:penjualan.surat-jalan.modal-surat-penjualan :id=$id>
            </div>
        </div>
        {{-- End Modal daftar --}}

        <div class="p-5 mt-1 box">
            <div class="overflow-auto">
                <div class="flex justify-end mb-5 mr-5 mt-3">
                    @if (!$isChangeStatus)
                        <div data-tw-toggle="modal" data-tw-target="#daftar-pelanggan" class="btn btn-pending">Tambah
                            +</div>
                    @endif
                    <button onclick="location.reload()" class="btn btn-md btn-secondary ml-2" wire:ignore>
                        <i data-feather="refresh-cw" class="w-4 h-4 mr-1"></i> Reload
                    </button>
                </div>
                <table class="table">
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
                            <th class="border border-slate-600">Tgl. Faktur</th>
                            <th class="border border-slate-600">No. Faktur</th>
                            <th class="border border-slate-600">Pelanggan</th>
                            <th class="border border-slate-600">Sales</th>
                            <th class="border border-slate-600">Total</th>
                            @if ($isChangeStatus)
                                <th class="border border-slate-600">Status Pengiriman</th>
                            @else
                                <th class="border border-slate-600">Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dataPenjualan as $index => $jual)
                            <tr class="text-center">
                                <td class="border border-slate-600">{{ $loop->iteration }}</td>
                                <td class="border border-slate-600">
                                    {{ date('d-m-Y', strtotime($jual->penjualan->tgl_faktur)) }}</td>
                                <td class="border border-slate-600">{{ $jual->penjualan->no_faktur }}</td>
                                <td class="border border-slate-600">{{ $jual->penjualan->getPelanggan->nama }}</td>
                                <td class="border border-slate-600">{{ $jual->penjualan->getSales->nama_pegawai }}</td>
                                <td class="border border-slate-600">
                                    {{ number_format($jual->penjualan->total_tagihan, 0, ',', '.') }}
                                </td>
                                <td class="flex gap-2 text-center border border-slate-600">
                                    @if ($isChangeStatus)
                                        <Select class="form-control" wire:model='status.{{ $index }}'>
                                            <option value="">- Pilih -</option>
                                            <option value="1">Terkirim</option>
                                            <option value="0">Tidak Terkirim</option>
                                        </Select>
                                    @else
                                        <div class="btn btn-sm btn-outline-danger"
                                            wire:confirm='Apakah anda yakin akan menghapus data?'
                                            wire:click='hapusDataPenjualan({{ $jual->id }})'>Delete</div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="font-bold text-center text-pending border border-slate-600" colspan="7">
                                    Belum ada data
                                    tersedia</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="p-5 mt-1 box">
            <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                Keterangan
            </label>
            <textarea data-tw-merge id="horizontal-form-1" type="date" placeholder="" rows="5" wire:model='keterangan'
                @if ($isChangeStatus) disabled @endif
                class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80"></textarea>
        </div>
        <div class="flex justify-center gap-3 mt-5">
            <button class="px-10 btn btn-primary" type="submit" wire:loading.remove>Simpan</button>
            <button class="px-10 btn btn-primary" disabled wire:loading>Menyimpan...</button>
            <a href="/surat-jalan">
                <div class="btn btn-outline-danger">Batal</div>
            </a>
        </div>
    </form>
</div>
