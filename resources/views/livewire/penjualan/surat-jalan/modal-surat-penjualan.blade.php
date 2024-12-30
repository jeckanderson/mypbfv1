<div class="modal-content">
    <div class="modal-header flex justify-left text-lg font-bold text-primary align-left">
        Data Faktur Penjualan
    </div>
    <div class="modal-body p-2">
        <div class="overflow-auto">
            <div class="flex items-center gap-2 mt-3 mb-3">
                <input id="search-box" type="text" placeholder="Search Pelanggan ..."
                    class="w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 transition duration-200 ease-in-out focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80"
                    onkeyup="searchByCustomerName()" />
            </div>
            <table class="table">
                <style>
                    .border {
                        border: 1px solid #bbb;
                    }

                    .header-gray {
                        background-color: #e0e0e0;
                        color: black;
                    }

                    th,
                    td {
                        padding: 3px;
                        text-align: left;
                    }

                    th {
                        font-weight: bold;
                        text-align: center;
                    }

                    td {
                        font-size: 12px;
                    }
                </style>
                <thead>
                    <tr class="header-gray">
                        <th class="border">No</th>
                        <th class="border">Tgl. Faktur</th>
                        <th class="border">No. Faktur</th>
                        <th class="border">Pelanggan</th>
                        <th class="border">Sales</th>
                        <th class="border">Total</th>
                        <th class="border">Actions</th>
                    </tr>
                </thead>
                <tbody id="penjualan-table">
                    @forelse ($penjualans as $penjualan)
                        <tr class="text-center">
                            <td class="border">{{ $loop->iteration }}</td>
                            <td class="border">{{ date('d-m-Y', strtotime($penjualan->tgl_faktur)) }}</td>
                            <td class="border">{{ $penjualan->no_faktur }}</td>
                            <td class="border pelanggan-name">{{ $penjualan->getPelanggan->nama }}</td>
                            <td class="border">{{ $penjualan->getSales->nama_pegawai }}</td>
                            <td class="border">{{ number_format($penjualan->total_tagihan, 0, ',', '.') }}</td>
                            <td class="border text-center">
                                <input type="checkbox" wire:model='selectedPenjualan' id="checkbox-switch-1"
                                    value="{{ $penjualan->id }}"
                                    class="transition-all duration-100 ease-in-out shadow-sm border-slate-200 cursor-pointer rounded focus:ring-4 focus:ring-primary focus:ring-opacity-20 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50" />
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="font-bold text-center text-pending border" colspan="7">Belum ada data
                                penjualan tersedia</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary" data-tw-dismiss="modal" wire:click='pilihPenjualan'>Pilih</button>
        <button class="btn btn-outline-danger" data-tw-dismiss="modal">Batal</button>
    </div>
</div>

<script>
    function searchByCustomerName() {
        let input = document.getElementById('search-box');
        let filter = input.value.toLowerCase();
        let table = document.getElementById('penjualan-table');
        let rows = table.getElementsByTagName('tr');

        for (let i = 0; i < rows.length; i++) {
            let td = rows[i].getElementsByClassName('pelanggan-name')[0];
            if (td) {
                let textValue = td.textContent || td.innerText;
                if (textValue.toLowerCase().indexOf(filter) > -1) {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }
        }
    }
</script>
