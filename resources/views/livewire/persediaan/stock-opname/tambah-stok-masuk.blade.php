<div class="modal-content">
    <div class="modal-header border-b border-gray-200 dark:border-gray-700 pb-4">
        <h2 class="text-lg text-primary font-semibold text-gray-900 dark:text-gray-100">Stok Opname Barang Masuk</h2>
    </div>
    <div class="p-5 modal-body">
        <div class="preview">
            <div data-tw-merge class="items-center block mt-1 sm:flex" wire:ignore>
                <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-40">
                    Nama Produk
                </label>
                <select data-tw-merge aria-label="Default select example" wire:model.live='produk'
                    class="form-control tom-select font-bold">
                    <option value="">- Pilih -</option>
                    @forelse  ($produks as $prod)
                        <option value="{{ $prod->id }}">
                            {{ $prod->barcode_produk . ' || ' . $prod->nama_obat_barang }}</option>
                    @empty
                        <option value="">Belum ada produk tersedia</option>
                    @endforelse
                </select>
            </div>
            <div data-tw-merge class="items-center block mt-1 sm:flex">
                <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-40">
                    Tipe
                </label>
                <input data-tw-merge id="horizontal-form-1" type="text" disabled wire:model='tipe'
                    class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
            </div>
            <div data-tw-merge class="items-center block mt-1 sm:flex">
                <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-40">
                    No. Batch
                </label>
                <input data-tw-merge id="horizontal-form-1" type="text" placeholder="" wire:model='batch'
                    class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
            </div>
            <div data-tw-merge class="items-center block mt-1 sm:flex">
                <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-40">
                    Exp Date
                </label>
                <input data-tw-merge id="horizontal-form-1" type="date" placeholder="" wire:model='exp_date'
                    {{ $disabled }}
                    class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
            </div>
            <div data-tw-merge class="items-center block mt-1 sm:flex">
                <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-40">
                    Tanggal SO
                </label>
                <input data-tw-merge id="horizontal-form-1" type="date" placeholder="" wire:model='tanggal_so'
                    class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
            </div>
            <div data-tw-merge class="items-center block mt-1 sm:flex">
                <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-40">
                    Satuan
                </label>
                <input data-tw-merge id="horizontal-form-1" type="text" placeholder="" wire:model='satuan' disabled
                    class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
            </div>
            <div data-tw-merge class="items-center block mt-1 sm:flex">
                <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-40">
                    Isi Satuan
                </label>
                <input data-tw-merge id="horizontal-form-1" type="text" placeholder="" wire:model='isi' disabled
                    class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
            </div>
            <div data-tw-merge class="items-center block mt-1 sm:flex">
                <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-40">
                    Sat. Terkecil
                </label>
                <input data-tw-merge id="horizontal-form-1" type="text" placeholder="" wire:model='satuan_terkecil'
                    disabled
                    class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
            </div>
            <div data-tw-merge class="items-center block mt-1 sm:flex">
                <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-40">
                    HPP
                </label>
                <div class="flex w-full gap-3">
                    <input data-tw-merge id="horizontal-form-1" type="text" placeholder="" wire:model='hpp'
                        class="hpp disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                    <p class="mt-2 mr-1 font-bold">{{ $satuan }}</p>
                </div>
            </div>
            <div data-tw-merge class="items-center block mt-1 sm:flex">
                <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-40">
                    Stok Tercatat
                </label>
                <input data-tw-merge id="horizontal-form-1" type="text" placeholder="" wire:model='stok_tercatat'
                    disabled
                    class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
            </div>
            <div data-tw-merge class="items-center block mt-1 sm:flex">
                <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-40">
                    Stok Real
                </label>
                <div class="flex w-full gap-3">
                    <input data-tw-merge id="horizontal-form-1" type="text" placeholder="" wire:model='stok_real'
                        class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                    <p class="mt-2 mr-1 font-bold">{{ $satuan_terkecil }}</p>
                </div>
            </div>
            <div data-tw-merge class="items-center block mt-1 sm:flex">
                <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-40">
                    Gudang
                </label>
                <select data-tw-merge aria-label="Default select example" class="form-control" wire:model='gudang'>
                    <option>- Pilih Gudang -</option>
                    @forelse ($gudangs as $gudang)
                        <option value="{{ $gudang->id }}">{{ $gudang->gudang }}</option>
                    @empty
                    @endforelse
                </select>
            </div>
            <div data-tw-merge class="items-center block mt-1 sm:flex">
                <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-40">
                    Rak
                </label>
                <select data-tw-merge aria-label="Default select example" class="form-control" wire:model='rak'>
                    <option>- Pilih Rak -</option>
                    @forelse ($raks as $rak)
                        <option value="{{ $rak->id }}">{{ $rak->rak }}</option>
                    @empty
                    @endforelse
                </select>
            </div>
            <div data-tw-merge class="items-center block mt-1 sm:flex">
                <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-40">
                    Sub Rak
                </label>
                <select data-tw-merge aria-label="Default select example" class="form-control" wire:model='subrak'>
                    <option>- Pilih Sub Rak -</option>
                    @forelse ($subRak as $rak)
                        <option value="{{ $rak->id }}">{{ $rak->sub_rak }}</option>
                    @empty
                    @endforelse
                </select>
            </div>
            <div data-tw-merge class="items-center block mt-1 sm:flex">
                <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-40">
                    Keterangan
                </label>
                <textarea wire:model='keterangan' id="" rows="3" class="form-control"></textarea>
            </div>
        </div>
    </div>
    {{-- footer --}}
    <div class="modal-footer">
        <button class="mt-5 btn btn-primary" data-tw-dismiss="modal" type="submit"
            wire:click='simpanDataOpname'>Simpan</button>
        <button class="mt-5 btn btn-outline-danger" data-tw-dismiss="modal">Batal</button>
    </div>
    <script>
        $('.hpp').on('input', function() {
            var formattedValue = $(this).val().replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            $(this).val(formattedValue);
        })
    </script>
</div>
