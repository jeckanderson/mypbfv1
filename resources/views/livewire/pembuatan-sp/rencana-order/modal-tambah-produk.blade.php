<div class="modal-content">
    @php
        use App\Models\HistoryStok;
    @endphp
    <form wire:submit.prevent="tambahProduk">
        <div class="modal-header border-b border-gray-200 dark:border-gray-700 pb-4">
            <h2 class="text-lg text-primary font-semibold text-gray-900 dark:text-gray-100">
                Tambah Produk Ke {{ $nama_suplier }}
            </h2>
        </div>
        <div class="p-2 modal-body">
            <div data-tw-merge class="items-center block mt-1 sm:flex" wire:ignore>
                <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 ml-5 sm:w-32">
                    Nama Produk
                </label>
                <select data-tw-merge aria-label="Default select example" name="id_obat_barang" required
                    wire:model.live="nama_produk" class="tom-select form-control font-bold ">
                    <option value="">- Pilih -</option>z
                    {{-- <option value="0">- Pilih -</option>z --}}
                    @foreach ($produks as $produk)
                        <option value="{{ $produk->id }}">
                            {{ $produk->nama_obat_barang }}</option>
                    @endforeach
                </select>
            </div>
            <input type="hidden" wire:model='id' value="{{ $id }}">
            <div data-tw-merge class="flex items-center mt-1">
                <label data-tw-merge for="horizontal-form-1" class="inline-block mt-2 mb-2 ml-5 sm:w-32">
                    Satuan Beli
                </label>
                <input type="text" class="form-control" disabled required
                    value="{{ $obatBarangDetail && $obatBarangDetail->satuanDasar ? $obatBarangDetail->satuanDasar->satuan : '' }}">
            </div>
            <div data-tw-merge class="flex items-center mt-1">
                <label data-tw-merge for="horizontal-form-1" class="inline-block mt-2 mb-2 ml-5 sm:w-32">
                    Isi
                </label>
                <input type="text" class="form-control" disabled
                    value="{{ $obatBarangDetail ? $obatBarangDetail->isi : '' }}">
            </div>
            <div data-tw-merge class="flex items-center mt-1">
                <label data-tw-merge for="horizontal-form-1" class="inline-block mt-2 mb-2 ml-5 sm:w-32">
                    Sat Terkecil
                </label>
                <input type="text" class="form-control" disabled
                    value="{{ $obatBarangDetail && $obatBarangDetail->satuanTerkecil ? $obatBarangDetail->satuanTerkecil->satuan : '' }}">

            </div>
            <div data-tw-merge class="flex items-center mt-1">
                <label data-tw-merge for="horizontal-form-1" class="inline-block mt-2 mb-2 ml-5 sm:w-32">
                    Stok Tersedia
                </label>
                <div class="flex w-full gap-3">
                    @php
                        if ($obatBarangDetail) {
                            $jumlah =
                                HistoryStok::where('id_produk', $obatBarangDetail->id)
                                    ->where('id_perusahaan', Auth::user()->id_perusahaan)
                                    ->sum('stok_masuk') -
                                HistoryStok::where('id_produk', $obatBarangDetail->id)
                                    ->where('id_perusahaan', Auth::user()->id_perusahaan)
                                    ->sum('stok_keluar');
                        }
                    @endphp
                    <input required type="text" class="font-bold text-primary text-center form-control "
                        placeholder="" value="{{ $obatBarangDetail ? $jumlah : 0 }}" disabled>
                    <p class="mt-2 font-bold">
                        {{ $obatBarangDetail && $obatBarangDetail->satuanTerkecil ? $obatBarangDetail->satuanTerkecil->satuan : '' }}
                    </p>
                </div>
            </div>
            <div data-tw-merge class="flex items-center mt-1">
                <label data-tw-merge for="horizontal-form-1" class="inline-block mt-2 mb-2 ml-5 sm:w-32">
                    Stok Min
                </label>
                <div class="flex w-full gap-3">
                    <input type="text" class="font-bold text-pending text-center form-control"
                        placeholder="Satuan Terkecil" disabled
                        value="{{ $obatBarangDetail ? $obatBarangDetail->stok_minimal : '' }}">
                    <p class="mt-2 font-bold">
                        {{ $obatBarangDetail && $obatBarangDetail->satuanTerkecil ? $obatBarangDetail->satuanTerkecil->satuan : '' }}
                    </p>
                </div>
            </div>
            <div data-tw-merge class="flex items-center mt-1">
                <label data-tw-merge for="horizontal-form-1" class="inline-block mt-2 mb-2 ml-5 sm:w-32">
                    Stok Maksimal
                </label>
                <div class="flex w-full gap-3">
                    <input type="text" class="font-bold text-danger text-center form-control"
                        placeholder="Satuan Terkecil" disabled
                        value="{{ $obatBarangDetail ? $obatBarangDetail->stok_maksimal : '' }}">
                    <p class="mt-2 font-bold">
                        {{ $obatBarangDetail && $obatBarangDetail->satuanTerkecil ? $obatBarangDetail->satuanTerkecil->satuan : '' }}
                    </p>
                </div>
            </div>
            <div data-tw-merge class="flex items-center mt-1">
                <label data-tw-merge for="horizontal-form-1" class="inline-block mt-2 mb-2 ml-5 sm:w-32">
                    Golongan
                </label>
                <input type="text" class="form-control" disabled
                    value="{{ $obatBarangDetail && $obatBarangDetail->golonganProduk ? $obatBarangDetail->golonganProduk->sub_golongan : '' }}">
            </div>
            <div data-tw-merge class="flex items-center mt-1">
                <label data-tw-merge for="horizontal-form-1" class="inline-block mt-2 mb-2 ml-5 sm:w-32">
                    Jenis Produk
                </label>
                <input type="text" class="form-control" disabled
                    value="{{ $obatBarangDetail ? $obatBarangDetail->jenis_obat_barang : '' }}">
            </div>
            <div data-tw-merge class="flex items-center mt-1">
                <label data-tw-merge for="horizontal-form-1" class="inline-block mt-2 mb-2 ml-5 sm:w-32">
                    Tipe
                </label>
                <input type="text" class="form-control" disabled
                    value="{{ $obatBarangDetail ? $obatBarangDetail->tipe : '' }}">
            </div>
            <div data-tw-merge class="flex items-center mt-1">
                <label data-tw-merge for="horizontal-form-1" class="inline-block mt-2 mb-2 ml-5 sm:w-32">
                    Jumlah Order
                </label>
                <div class="flex w-full gap-3">
                    <input type="text" required class="font-bold text-center form-control" wire:model="jumlah_order"
                        placeholder="Masukan jumlah order yang diinginkan">
                    <p class="mt-2 font-bold">
                        {{ $obatBarangDetail && $obatBarangDetail->satuanDasar ? $obatBarangDetail->satuanDasar->satuan : '' }}
                    </p>
                </div>
            </div>
            <div data-tw-merge class="flex items-center mt-1">
                <label data-tw-merge for="horizontal-form-1" class="inline-block mt-2 mb-2 ml-5 sm:w-32">
                    Keterangan
                </label>
                <textarea type="text" wire:model="keterangan" class="form-control" placeholder="Masukan keterangan" rows="5"></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" data-tw-dismiss="modal" wire:loading.remove type="submit">Simpan</button>
            <button wire:loading class="btn btn-primary">
                Menyimpan...
            </button>
            <button class="mt-5 btn btn-outline-danger" data-tw-dismiss="modal" type="button"> Batal </button>
        </div>
    </form>
</div>
