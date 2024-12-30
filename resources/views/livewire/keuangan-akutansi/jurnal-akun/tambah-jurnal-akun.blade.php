<div>
    <div class="p-5 mt-5 bg-white rounded-lg shadow-lg">
        <div class="flex flex-col sm:flex-row gap-6">
            <div class="flex-1 flex flex-col gap-4">
                <div class="flex flex-col">
                    <label for="no-reff" class="text-gray-700 font-semibold mb-2">
                        No. Reff
                    </label>
                    <input id="no-reff" type="text" placeholder="Masukkan No. Reff" wire:model='no_reff' disabled
                        class="font-bold bg-gray-100 text-gray-700 border border-gray-300 rounded-md py-2 px-3 w-full focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300 dark:focus:ring-primary dark:focus:border-primary" />
                </div>
            </div>
            <div class="flex-1 flex flex-col gap-4">
                <!-- Konten untuk kolom kedua di sini -->
                <div class="flex flex-col">
                    <label for="tanggal" class="text-gray-700 font-semibold mb-2">
                        Tanggal
                    </label>
                    <input id="tanggal" type="date" placeholder="Pilih Tanggal" wire:model='tgl_input'
                        value="{{ now()->toDateString() }}" disabled
                        class="bg-gray-100 text-gray-700 border border-gray-300 rounded-md py-2 px-3 w-full focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300 dark:focus:ring-primary dark:focus:border-primary" />
                </div>
            </div>
        </div>
    </div>


    {{-- Modal input-data --}}
    <div class="" wire:ignore>
        <div id="input-data" class="modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <livewire:keuangan-akutansi.jurnal-akun.modal-jurnal-akun />
            </div>
        </div>
    </div>
    {{-- End Modal daftar --}}


    <div class="p-5 mt-1 box">
        <div class="overflow-auto">
            <div class="" wire:ignore>
                <button data-tw-toggle="modal" data-tw-target="#input-data" class="mb-3 btn btn-pending">Input
                    Data</button>
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
                        text-align: left;
                    }

                    td {
                        font-size: 1em;
                    }
                </style>
                <thead>
                    <tr class="header-gray">
                        <th class="border border-slate-600">Kode</th>
                        <th class="border border-slate-600">Nama Akun</th>
                        <th class="border border-slate-600">Debet</th>
                        <th class="border border-slate-600">Kredit</th>
                        <th class="border border-slate-600">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($detailJurnalAkun as $jurnal)
                        <tr class="text-center">
                            <td class="border border-slate-600">{{ $jurnal->akun->kode }}</td>
                            <td class="border border-slate-600">{{ $jurnal->akun->nama_akun }}</td>
                            <td class="border border-slate-600">{{ number_format($jurnal->debet, 0, ',', '.') }}</td>
                            <td class="border border-slate-600">{{ number_format($jurnal->kredit, 0, ',', '.') }}</td>
                            <td class="border border-slate-600 ">
                                <button class="btn btn-outline-danger btn-sm"
                                    wire:click='hapusJurnalAkun({{ $jurnal->id }})'
                                    wire:confirm='Apakah anda yakin akan menghapus data?'>Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="font-bold text-center border text-pending border-slate-600" colspan="5">Belum
                                ada data
                                tersedia</td>
                        </tr>
                    @endforelse
                    <tr>
                        <td colspan="2" class="font-bold text-center border border-slate-600">Total</td>
                        <td class="font-bold text-left border border-slate-600">
                            {{ number_format($detailJurnalAkun->sum('debet'), 0, ',', '.') }}
                        </td>
                        <td class="font-bold text-left border border-slate-600">
                            {{ number_format($detailJurnalAkun->sum('kredit'), 0, ',', '.') }}
                        </td>
                        <td class="font-bold text-center border border-slate-600"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="p-5 mt-1 box">
        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-32">
            Keterangan
        </label>
        <textarea data-tw-merge id="horizontal-form-1" type="text" placeholder="" rows="5" wire:model='keterangan'
            class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80"></textarea>
    </div>
    <div class="flex justify-center gap-3 mt-5">
        @if ($detailJurnalAkun->sum('debet') - $detailJurnalAkun->sum('kredit') != 0)
            <button class="px-10 btn btn-primary" disabled>Belum Seimbang Debet Kredit</button>
        @else
            <button class="px-10 btn btn-primary" wire:click='simpanJurnalAkun'>Simpan</button>
        @endif
        <a href="/jurnal-akun"><button class="btn btn-outline-danger">Batal</button></a>
    </div>
</div>
