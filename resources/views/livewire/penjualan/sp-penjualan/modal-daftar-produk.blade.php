<div class="modal-content">
    <div class="flex justify-center text-lg font-bold text-white modal-header bg-primary align-center">
        Daftar Produk
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
                <thead>
                    <tr>
                        <th class="border border-slate-600">Kode</th>
                        <th class="border border-slate-600">Nama Barang</th>
                        <th class="border border-slate-600">Golongan</th>
                        <th class="border border-slate-600">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($produks as $prod)
                        <tr>
                            <td class="border border-slate-600">{{ $prod->barcode_produk }}</td>
                            <td class="border border-slate-600">{{ $prod->nama_obat_barang }}</td>
                            <td class="border border-slate-600">{{ $prod->golonganProduk->sub_golongan }}</td>
                            <td class="border border-slate-600">
                                <input data-tw-merge type="checkbox" wire:model='selectedProduk'
                                    class="transition-all duration-100 ease-in-out shadow-sm border-slate-200 cursor-pointer rounded focus:ring-4 focus:ring-offset-0 focus:ring-primary focus:ring-opacity-20 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&amp;[type=&#039;radio&#039;]]:checked:bg-primary [&amp;[type=&#039;radio&#039;]]:checked:border-primary [&amp;[type=&#039;radio&#039;]]:checked:border-opacity-10 [&amp;[type=&#039;checkbox&#039;]]:checked:bg-primary [&amp;[type=&#039;checkbox&#039;]]:checked:border-primary [&amp;[type=&#039;checkbox&#039;]]:checked:border-opacity-10 [&amp;:disabled:not(:checked)]:bg-slate-100 [&amp;:disabled:not(:checked)]:cursor-not-allowed [&amp;:disabled:not(:checked)]:dark:bg-darkmode-800/50 [&amp;:disabled:checked]:opacity-70 [&amp;:disabled:checked]:cursor-not-allowed [&amp;:disabled:checked]:dark:bg-darkmode-800/50"
                                    id="checkbox-switch-1" value="{{ $prod->id }}" />
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="font-bold text-pending text-center" colspan="4">Belum ada data produk tersedia
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-secondary" data-tw-dismiss="modal">Batal</button>
        <button class="btn btn-primary" data-tw-dismiss="modal" wire:click='tambahProduk'>Pilih</button>
    </div>
</div>
