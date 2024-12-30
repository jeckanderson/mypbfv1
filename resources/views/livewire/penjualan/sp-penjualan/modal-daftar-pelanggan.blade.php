<div class="modal-content">
    <div class="flex justify-left text-lg font-bold text-primary modal-header align-center">
        Daftar Pelanggan
    </div>
    <div class="p-6 modal-body">
        <div class="overflow-auto">
            <div
                class="w-full mt-2 mb-2 form-check form-switch sm:w-60 sm:ml-auto sm:mt-0 shadow-md border border-gray-200 rounded-lg">
                <div class="flex items-center justify-between p-2">
                    @include('components.search', [
                        'id_table' => 'tablePelanggan',
                    ])
                </div>
            </div>

            <table class="table" id="tablePelanggan">
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
                        <th class="border border-slate-600">Pilih</th>
                        <th class="border border-slate-600">Kode</th>
                        <th class="border border-slate-600">Nama Pelanggan</th>
                        <th class="border border-slate-600">Exp SIA</th>
                        <th class="border border-slate-600">Exp SIPA</th>
                        <th class="border border-slate-600">Batas Piutang</th>
                        <th class="border border-slate-600">Jumlah Piutang</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pelanggans as $pelanggan)
                        <?php
                        $latestPiutang = $pelanggan->piutang()->latest()->first();
                        $pelanggan->sisa_hutang = $latestPiutang ? $latestPiutang->sisa_hutang : null;
                        
                        ?>
                        <tr>
                            <td class="border border-slate-600">
                                @if (
                                    // Cek bahwa SIA dan SIPA tidak kadaluarsa
                                    (\Carbon\Carbon::parse($pelanggan->exp_date_sia)->isFuture() ||
                                        \Carbon\Carbon::parse($pelanggan->exp_date_sia)->isToday()) &&
                                        (\Carbon\Carbon::parse($pelanggan->exp_date_sipa)->isFuture() ||
                                            \Carbon\Carbon::parse($pelanggan->exp_date_sipa)->isToday()) &&
                                        // Cek bahwa piutang tidak melebihi batas piutang
                                        $pelanggan->sisa_hutang < str_replace('.', '', $pelanggan->batas_piutang))
                                    <input data-tw-merge type="radio" value="{{ $pelanggan->id }}"
                                        class="transition-all duration-100 ease-in-out shadow-sm border-slate-200 cursor-pointer rounded focus:ring-4 focus:ring-offset-0 focus:ring-primary focus:ring-opacity-20 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&amp;[type=&#039;radio&#039;]]:checked:bg-primary [&amp;[type=&#039;radio&#039;]]:checked:border-primary [&amp;[type=&#039;radio&#039;]]:checked:border-opacity-10 [&amp;[type=&#039;checkbox&#039;]]:checked:bg-primary [&amp;[type=&#039;checkbox&#039;]]:checked:border-primary [&amp;[type=&#039;checkbox&#039;]]:checked:border-opacity-10 [&amp;:disabled:not(:checked)]:bg-slate-100 [&amp;:disabled:not(:checked)]:cursor-not-allowed [&amp;:disabled:not(:checked)]:dark:bg-darkmode-800/50 [&amp;:disabled:checked]:opacity-70 [&amp;:disabled:checked]:cursor-not-allowed [&amp;:disabled:checked]:dark:bg-darkmode-800/50"
                                        id="checkbox-switch-{{ $pelanggan->id }}" wire:model='selectedPelanggan' />
                                @endif
                            </td>

                            <td class="border border-slate-600">{{ $pelanggan->kode }}</td>
                            <td class="border border-slate-600">{{ $pelanggan->nama }}</td>
                            <td
                                class="border border-slate-600 {{ \Carbon\Carbon::parse($pelanggan->exp_date_sia)->isPast() && !\Carbon\Carbon::parse($pelanggan->exp_date_sia)->isToday() ? 'text-danger' : '' }}">
                                {{ date('d-m-Y', strtotime($pelanggan->exp_date_sia)) }}
                            </td>
                            <td
                                class="border border-slate-600 {{ \Carbon\Carbon::parse($pelanggan->exp_date_sipa)->isPast() && !\Carbon\Carbon::parse($pelanggan->exp_date_sipa)->isToday() ? 'text-danger' : '' }}">
                                {{ date('d-m-Y', strtotime($pelanggan->exp_date_sipa)) }}
                            </td>


                            <td class="text-right border border-slate-600">{{ $pelanggan->batas_piutang }}</td>
                            <td class="text-right border border-slate-600">
                                {{ number_format($pelanggan->sisa_hutang, 0, ',', '.') ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="font-bold text-center border border-slate-600" colspan="7">Belum ada data
                                pelanggan tersedia</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary" data-tw-dismiss="modal" wire:click='pilihPelanggan'>Pilih</button>
        <button class="btn btn-outline-danger" data-tw-dismiss="modal">Batal</button>
    </div>
</div>
