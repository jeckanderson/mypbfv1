<div class="modal-content">
    <form wire:submit="simpanSeriPajak">
        <div class="flex justify-left text-lg font-bold modal-header text-primary align-center">
            Data No Seri Pajak
        </div>
        <div class="p-5 modal-body">
            <div class="overflow-auto">
                <div class="w-full mt-3 mb-3 form-check form-switch sm:w-auto sm:ml-auto sm:mt-0">
                    <div class="relative w-56 text-slate-500 ">
                        <input type="text" class="w-56 pr-10 form-control" placeholder="Search..."
                            wire:model.live.debounce.150ms='search'>
                        <i class="absolute inset-y-0 right-0 w-4 h-4 my-auto mr-3" data-feather="search"></i>
                    </div>
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
                            <th class="border border-slate-600">No Seri Pajak</th>
                            <th class="border border-slate-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($seriPajak as $pajak)
                            <tr>
                                <td class="border border-slate-600">{{ $loop->iteration }}</td>
                                <td class="border border-slate-600">{{ $pajak->pajak }}</td>
                                <td class="border border-slate-600">
                                    <input data-tw-merge type="radio" value="{{ $pajak->id }}"
                                        wire:model='selectedPajak'
                                        class="transition-all duration-100 ease-in-out shadow-sm border-slate-200 cursor-pointer rounded focus:ring-4 focus:ring-offset-0 focus:ring-primary focus:ring-opacity-20 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&amp;[type=&#039;radio&#039;]]:checked:bg-primary [&amp;[type=&#039;radio&#039;]]:checked:border-primary [&amp;[type=&#039;radio&#039;]]:checked:border-opacity-10 [&amp;[type=&#039;checkbox&#039;]]:checked:bg-primary [&amp;[type=&#039;checkbox&#039;]]:checked:border-primary [&amp;[type=&#039;checkbox&#039;]]:checked:border-opacity-10 [&amp;:disabled:not(:checked)]:bg-slate-100 [&amp;:disabled:not(:checked)]:cursor-not-allowed [&amp;:disabled:not(:checked)]:dark:bg-darkmode-800/50 [&amp;:disabled:checked]:opacity-70 [&amp;:disabled:checked]:cursor-not-allowed [&amp;:disabled:checked]:dark:bg-darkmode-800/50"
                                        id="checkbox-switch-1{{ $pajak->id }}" />
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="font-bold text-center text-pending border border-slate-600" colspan="3">
                                    Belum ada nomor
                                    seri pajak tersedia</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="flex justify-center mt-2 align-item-center">
                    {{ $seriPajak->links() }}
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" type="submit" wire:loading.remove>Simpan</button>
            <button class="btn btn-primary" disabled wire:loading>Menyimpan...</button>
            <a href="javascript:void(0);" class="btn btn-outline-danger" data-tw-dismiss="modal">Batal</a>
        </div>
    </form>
</div>
