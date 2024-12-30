<div class="modal-content">
    <div class="modal-header flex justify-left text-lg font-bold text-primary align-center py-3 rounded-t-md">
        Detail Mutasi Saldo
    </div>
    <form wire:submit.prevent='simpanMutasiSaldo'>
        <div class="modal-body p-5 bg-gray-100">
            @include('components.alert')
            <div class="overflow-auto">
                <div class="flex flex-col md:flex-row justify-center w-full gap-2 mt-1">
                    <div class="block flex items-center gap-2 mb-1">
                        <label for="no_reff" class="inline-block font-medium text-gray-700 sm:w-32">No. Reff</label>
                        <input id="no_reff" type="text" wire:model='no_reff' disabled
                            class="font-bold w-full text-sm border border-gray-300 shadow-sm rounded-md p-2 bg-gray-200 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
                    </div>
                    <div class="block flex items-center gap-2 mb-1">
                        <label for="tgl_input" class="inline-block font-medium text-gray-700 sm:w-32">Tanggal</label>
                        <div class="flex w-full items-center gap-2">
                            <input id="tgl_input" type="date" wire:model='tgl_input'
                                class="w-full text-sm border border-gray-300 shadow-sm rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
                            <button onclick="location.reload()" class="btn btn-md btn-secondary ml-2" wire:ignore>
                                <i data-feather="refresh-cw" class="w-4 h-4 mr-1"></i> Reload
                            </button>
                        </div>
                    </div>
                </div>
                <table class="table w-full mt-1 border-collapse">
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
                            <th class="border p-2 text-center">Akun Pengirim</th>
                            <th class="border p-2 text-center">Jumlah Saldo</th>
                            <th class="border p-2 text-center">Akun Penerima</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white hover:bg-gray-100">
                            <td class="border p-2">
                                <div class="flex w-full gap-2">
                                    <select aria-label="Pilih Akun Pengirim" wire:model='akun_pengirim' required
                                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                        <option value="">- Pilih -</option>
                                        @foreach ($akuns as $akun)
                                            <option value="{{ $akun->id }}">
                                                {{ $akun->kode }} | {{ $akun->nama_akun }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                            <td class="border p-2">
                                <input type="text" wire:model='jumlah_saldo' oninput="formatNumber(this)" required
                                    class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
                            </td>
                            <td class="border p-2">
                                <div class="flex w-full gap-2">
                                    <select aria-label="Pilih Akun Penerima" wire:model='akun_penerima' required
                                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                        <option value="">- Pilih -</option>
                                        @foreach ($akuns as $akun)
                                            <option value="{{ $akun->id }}">
                                                {{ $akun->kode }} | {{ $akun->nama_akun }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <label for="keterangan" class="inline-block font-medium text-gray-700 mt-3 mb-2">Keterangan</label>
                <textarea id="keterangan" rows="5" wire:model='keterangan' class="w-full p-2 border border-gray-300 rounded-md "></textarea>
            </div>
        </div>
        <div class="modal-footer flex justify-end gap-2 p-3 bg-gray-100 rounded-b-md">
            <button
                class="btn btn-primary px-4 py-2 text-white bg-primary rounded-md shadow-md hover:bg-primary-dark transition duration-300"
                type="submit" wire:loading.attr='disabled'>Simpan</button>
            <div class="btn btn-outline-danger px-4 py-2 rounded-md shadow-md hover:bg-primary hover:text-white transition duration-300"
                data-tw-dismiss="modal">Batal</div>
        </div>
    </form>
</div>

<script>
    function formatNumber(input) {
        input.value = input.value.replace(/[^\d.]/g, '');
        let number = parseFloat(input.value.replace(/\./g, '').replace(',', '.')).toFixed(0);
        input.value = isNaN(number) ? '0' : new Intl.NumberFormat('id-ID').format(number);
    }
</script>
