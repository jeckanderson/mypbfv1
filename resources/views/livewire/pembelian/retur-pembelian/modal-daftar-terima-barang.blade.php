<div class="modal-content">
    @php
        use App\Models\Satuan;
        use App\Models\Gudang;
        use App\Models\Rak;
        use App\Models\SubRak;
        use App\Models\HistoryStok;
    @endphp
    <div class="flex justify-center text-lg font-bold text-white modal-header bg-primary align-center">
        Daftar Produk Terima Barang (No. Faktur {{ $faktur }})
    </div>
    <div class="p-5 modal-body">
        <div class="w-full mt-3 mb-3 form-check form-switch sm:w-auto sm:ml-auto sm:mt-0">
            <div class="relative w-56 text-slate-500 ">
                <input type="text" class="w-56 pr-10 form-control" placeholder="Search...">
                <i class="absolute inset-y-0 right-0 w-4 h-4 my-auto mr-3" data-feather="search"></i>
            </div>
        </div>
        <p class="mt-2 mb-2 text-sm">* Tekan shift dan scroll untuk menggeser</p>
        <div class="overflow-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th class="border border-slate-600">Kode</th>
                        <th class="border border-slate-600">Nama Barang</th>
                        <th class="border border-slate-600">No Batch</th>
                        <th class="border border-slate-600">Exp. Date</th>
                        <th class="border border-slate-600">Satuan</th>
                        <th class="border border-slate-600">Stok</th>
                        <th class="border border-slate-600">Gudang</th>
                        <th class="border border-slate-600">Rak</th>
                        <th class="border border-slate-600">Sub Rak</th>
                        <th class="border border-slate-600">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($produkTerimaBarang as $prod)
                        <tr>
                            <td class="border border-slate-600 whitespace-nowrap">{{ $prod->produk->kode_obat_barang }}
                            </td>
                            <td class="border border-slate-600 whitespace-nowrap">{{ $prod->produk->nama_obat_barang }}
                            </td>
                            <td class="border border-slate-600 whitespace-nowrap">{{ $prod->no_batch }}</td>
                            <td class="border border-slate-600 whitespace-nowrap">{{ $prod->tgl_exp_date }}</td>
                            <td class="border border-slate-600 whitespace-nowrap">{{ $prod->produk->satuan_dasar_beli }}
                            </td>
                            <td class="border border-slate-600 whitespace-nowrap">
                                {{ HistoryStok::where('id_produk', $prod->produk->id)->where('id_gudang', $prod->gudang)->where('id_rak', $prod->rak)->where('id_sub_rak', $prod->sub_rak)->latest()->first()->stok_akhir }}
                            </td>
                            <td class="border border-slate-600 whitespace-nowrap">
                                {{ Gudang::find($prod->gudang)->gudang }}</td>
                            <td class="border border-slate-600 whitespace-nowrap">{{ Rak::find($prod->rak)->rak }}</td>
                            <td class="border border-slate-600 whitespace-nowrap">
                                {{ SubRak::find($prod->sub_rak)->sub_rak }}</td>
                            <td class="border border-slate-600 whitespace-nowrap">
                                <input data-tw-merge type="checkbox" wire:model='selectedProduk'
                                    class="transition-all duration-100 ease-in-out shadow-sm border-slate-200 cursor-pointer rounded focus:ring-4 focus:ring-offset-0 focus:ring-primary focus:ring-opacity-20 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&amp;[type=&#039;radio&#039;]]:checked:bg-primary [&amp;[type=&#039;radio&#039;]]:checked:border-primary [&amp;[type=&#039;radio&#039;]]:checked:border-opacity-10 [&amp;[type=&#039;checkbox&#039;]]:checked:bg-primary [&amp;[type=&#039;checkbox&#039;]]:checked:border-primary [&amp;[type=&#039;checkbox&#039;]]:checked:border-opacity-10 [&amp;:disabled:not(:checked)]:bg-slate-100 [&amp;:disabled:not(:checked)]:cursor-not-allowed [&amp;:disabled:not(:checked)]:dark:bg-darkmode-800/50 [&amp;:disabled:checked]:opacity-70 [&amp;:disabled:checked]:cursor-not-allowed [&amp;:disabled:checked]:dark:bg-darkmode-800/50"
                                    id="checkbox-switch-1" value="{{ $prod->id }}" />
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="font-bold text-center text-pending border border-slate-600" colspan="10">Nomor
                                faktur belum
                                dipilih</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary" data-tw-dismiss="modal" wire:click='pilihProduk'>Pilih</button>
        <button class="btn btn-outline-danger" data-tw-dismiss="modal">Batal</button>
    </div>
</div>
