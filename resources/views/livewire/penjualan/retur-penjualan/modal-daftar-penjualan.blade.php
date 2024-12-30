<div class="modal-content">
    <div class="flex justify-center text-lg font-bold text-white modal-header bg-primary align-center">
        Daftar Penjualan
    </div>
    <div class="p-5 modal-body">
        <div class="w-full mt-3 mb-3 form-check form-switch sm:w-auto sm:ml-auto sm:mt-0">
            <div class="relative w-56 text-slate-500 ">
                <input type="text" class="w-56 pr-10 form-control" placeholder="Search...">
                <i class="absolute inset-y-0 right-0 w-4 h-4 my-auto mr-3" data-feather="search"></i>
            </div>
        </div>
        <p class="mb-2 text-sm">*Tekan shift dan scroll untuk menggeser table</p>
        <div class="overflow-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th class="border border-slate-600">No</th>
                        <th class="border border-slate-600">Tanggal</th>
                        <th class="border border-slate-600">No. Faktur</th>
                        <th class="border border-slate-600">Pelanggan</th>
                        <th class="border border-slate-600">Sales</th>
                        <th class="border border-slate-600">No. Seri Pajak</th>
                        <th class="border border-slate-600">DPP</th>
                        <th class="border border-slate-600">PPN</th>
                        <th class="border border-slate-600">Total</th>
                        <th class="border border-slate-600">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($penjualans as $penjualan)
                        <tr>
                            <td class="border whitespace-nowrap border-slate-600">{{ $loop->iteration }}</td>
                            <td class="border whitespace-nowrap border-slate-600">{{ $penjualan->tgl_input }}</td>
                            <td class="border whitespace-nowrap border-slate-600">{{ $penjualan->no_faktur }}</td>
                            <td class="border whitespace-nowrap border-slate-600">{{ $penjualan->getPelanggan->nama }}
                            </td>
                            <td class="border whitespace-nowrap border-slate-600">
                                {{ $penjualan->getSales->nama_pegawai }}</td>
                            <td class="border whitespace-nowrap border-slate-600">{{ $penjualan->no_seri_pajak }}
                            <td class="border whitespace-nowrap border-slate-600">{{ $penjualan->dpp }}
                            <td class="border whitespace-nowrap border-slate-600">{{ $penjualan->ppn }}
                            <td class="border whitespace-nowrap border-slate-600">{{ $penjualan->total_hutang }}
                            <td class="border whitespace-nowrap border-slate-600">
                                <input data-tw-merge type="radio" wire:model='selectedPenjualan'
                                    class="transition-all duration-100 ease-in-out shadow-sm border-slate-200 cursor-pointer rounded focus:ring-4 focus:ring-offset-0 focus:ring-primary focus:ring-opacity-20 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&amp;[type=&#039;radio&#039;]]:checked:bg-primary [&amp;[type=&#039;radio&#039;]]:checked:border-primary [&amp;[type=&#039;radio&#039;]]:checked:border-opacity-10 [&amp;[type=&#039;checkbox&#039;]]:checked:bg-primary [&amp;[type=&#039;checkbox&#039;]]:checked:border-primary [&amp;[type=&#039;checkbox&#039;]]:checked:border-opacity-10 [&amp;:disabled:not(:checked)]:bg-slate-100 [&amp;:disabled:not(:checked)]:cursor-not-allowed [&amp;:disabled:not(:checked)]:dark:bg-darkmode-800/50 [&amp;:disabled:checked]:opacity-70 [&amp;:disabled:checked]:cursor-not-allowed [&amp;:disabled:checked]:dark:bg-darkmode-800/50"
                                    id="checkbox-switch-1" value="{{ $penjualan->id }}" />
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="font-bold text-center border border-slate-600" colspan="10">Belum ada data
                                penjualan tersedia</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-secondary" data-tw-dismiss="modal">Batal</button>
        <button class="btn btn-primary" data-tw-dismiss="modal" wire:click='pilihPenjualan'>Pilih</button>
    </div>
</div>
