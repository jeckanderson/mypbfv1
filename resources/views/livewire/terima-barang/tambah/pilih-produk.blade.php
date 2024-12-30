<div class="modal-content">
    @php
        use App\Models\ProdukDiterima;
    @endphp
    <div class="flex justify-center text-lg font-bold text-white modal-header bg-primary align-center">
        Daftar Produk Pembelian
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
                        <th class="border border-slate-600">Kode</th>
                        <th class="border border-slate-600">Nama Produk</th>
                        <th class="border border-slate-600">Jumlah</th>
                        <th class="border border-slate-600">Tersedia</th>
                        <th class="border border-slate-600">Diterima</th>
                        <th class="border border-slate-600">
                            <input data-tw-merge type="checkbox" wire:model.live='selectAll'
                                class="transition-all duration-100 ease-in-out shadow-sm border-slate-200 cursor-pointer rounded focus:ring-4 focus:ring-offset-0 focus:ring-primary focus:ring-opacity-20 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&amp;[type=&#039;radio&#039;]]:checked:bg-primary [&amp;[type=&#039;radio&#039;]]:checked:border-primary [&amp;[type=&#039;radio&#039;]]:checked:border-opacity-10 [&amp;[type=&#039;checkbox&#039;]]:checked:bg-primary [&amp;[type=&#039;checkbox&#039;]]:checked:border-primary [&amp;[type=&#039;checkbox&#039;]]:checked:border-opacity-10 [&amp;:disabled:not(:checked)]:bg-slate-100 [&amp;:disabled:not(:checked)]:cursor-not-allowed [&amp;:disabled:not(:checked)]:dark:bg-darkmode-800/50 [&amp;:disabled:checked]:opacity-70 [&amp;:disabled:checked]:cursor-not-allowed [&amp;:disabled:checked]:dark:bg-darkmode-800/50"
                                id="checkbox-switch-6" />
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($produks as $index => $prod)
                        <tr>
                            <td class="border border-slate-600">{{ $prod->order->produk->kode_obat_barang }}</td>
                            <td class="border border-slate-600">{{ $prod->order->produk->nama_obat_barang }}</td>
                            <td class="border border-slate-600">{{ $prod->qty_faktur }}</td>
                            <td class="border border-slate-600">
                                @php
                                    $qtyFaktur = intval($prod->qty_faktur);
                                    $reduction = isset($mengurang[$index]) ? intval($mengurang[$index]) : 0;
                                    $produkDiterima = ProdukDiterima::where('id_pembelian', $prod->id_pembelian)
                                        ->where('id_produk', $prod->order->produk->id)
                                        ->sum('diterima');

                                    $hasil[$index] = $qtyFaktur - $reduction - $produkDiterima;
                                @endphp

                                {{ $hasil[$index] ?? $qtyFaktur }}
                            </td>
                            <td class="border border-slate-600">
                                <input wire:model.live='mengurang.{{ $index }}' type="number"
                                    class="form-control">
                            </td>
                            <td class="border border-slate-600">
                                @if (isset($mengurang[$index]) && $hasil[$index] >= 0 && $mengurang[$index] != null)
                                    <input data-tw-merge type="checkbox" value="{{ $prod->order->id }}"
                                        wire:model='selectedProduk'
                                        class="transition-all duration-100 ease-in-out shadow-sm border-slate-200 cursor-pointer rounded focus:ring-4 focus:ring-offset-0 focus:ring-primary focus:ring-opacity-20 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&amp;[type=&#039;radio&#039;]]:checked:bg-primary [&amp;[type=&#039;radio&#039;]]:checked:border-primary [&amp;[type=&#039;radio&#039;]]:checked:border-opacity-10 [&amp;[type=&#039;checkbox&#039;]]:checked:bg-primary [&amp;[type=&#039;checkbox&#039;]]:checked:border-primary [&amp;[type=&#039;checkbox&#039;]]:checked:border-opacity-10 [&amp;:disabled:not(:checked)]:bg-slate-100 [&amp;:disabled:not(:checked)]:cursor-not-allowed [&amp;:disabled:not(:checked)]:dark:bg-darkmode-800/50 [&amp;:disabled:checked]:opacity-70 [&amp;:disabled:checked]:cursor-not-allowed [&amp;:disabled:checked]:dark:bg-darkmode-800/50"
                                        id="checkbox-switch" />
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="font-bold text-center border border-slate-600" colspan="6">Belum ada pembelian
                                yang dipilih</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-outline-Danger" data-tw-dismiss="modal">Batal</button>
        <button class="btn btn-outline-primary" data-tw-dismiss="modal" wire:click='selectProduk'>Pilih</button>
    </div>
</div>
