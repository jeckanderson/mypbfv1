<div class="modal-content">
    <div class="flex justify-center text-lg font-bold text-white modal-header bg-primary align-center">
        Daftar Surat Pesanan
    </div>
    <div class="p-5 modal-body">
        <div class="overflow-auto">
            <div class="w-full mt-3 mb-3 form-check form-switch sm:w-auto sm:ml-auto sm:mt-0">
                <div class="relative w-56 text-slate-500 ">
                    <input type="text" class="w-56 pr-10 form-control" placeholder="Search...">
                    <i class="absolute inset-y-0 right-0 w-4 h-4 my-auto mr-3" data-feather="search"></i>
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th class="border border-slate-600">Aksi</th>
                        <th class="border border-slate-600">No</th>
                        <th class="border border-slate-600">No. SP</th>
                        <th class="border border-slate-600">Tgl. SP</th>
                        <th class="border border-slate-600">Pelanggan</th>
                        <th class="border border-slate-600">Marketing</th>
                        <th class="border border-slate-600">Tipe SP</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($spPenjualan as $sp)
                        <tr>
                            <td class="border border-slate-600">
                                <input data-tw-merge type="radio" value="{{ $sp->id }}" wire:model='selectedSP'
                                    class="transition-all duration-100 ease-in-out shadow-sm border-slate-200 cursor-pointer rounded focus:ring-4 focus:ring-offset-0 focus:ring-primary focus:ring-opacity-20 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&amp;[type=&#039;radio&#039;]]:checked:bg-primary [&amp;[type=&#039;radio&#039;]]:checked:border-primary [&amp;[type=&#039;radio&#039;]]:checked:border-opacity-10 [&amp;[type=&#039;checkbox&#039;]]:checked:bg-primary [&amp;[type=&#039;checkbox&#039;]]:checked:border-primary [&amp;[type=&#039;checkbox&#039;]]:checked:border-opacity-10 [&amp;:disabled:not(:checked)]:bg-slate-100 [&amp;:disabled:not(:checked)]:cursor-not-allowed [&amp;:disabled:not(:checked)]:dark:bg-darkmode-800/50 [&amp;:disabled:checked]:opacity-70 [&amp;:disabled:checked]:cursor-not-allowed [&amp;:disabled:checked]:dark:bg-darkmode-800/50"
                                    id="radio-switch-1{{ $sp->id }}" />
                            </td>
                            <td class="border border-slate-600">{{ $loop->iteration }}</td>
                            <td class="border border-slate-600">{{ $sp->no_sp }}</td>
                            <td class="border border-slate-600">{{ $sp->tgl_sp }}</td>
                            <td class="border border-slate-600">{{ $sp->pelangganPenjualan->nama }}</td>
                            <td class="border border-slate-600">{{ $sp->salesPenjualan->nama_pegawai }}</td>
                            <td class="border border-slate-600">{{ $sp->tipe_sp }}</td>
                        </tr>

                    @empty
                        <tr>
                            <td class="font-bold text-center" colspan="8">Belum ada data sp tersedia</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary" wire:click='pilihSP' data-tw-dismiss="modal">Pilih</button>
        <button class="btn btn-outline-danger" data-tw-dismiss="modal">Batal</button>
    </div>
</div>
