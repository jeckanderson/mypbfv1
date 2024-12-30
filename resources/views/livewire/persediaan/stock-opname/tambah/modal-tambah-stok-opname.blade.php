<div class="modal-content p-5 bg-white rounded-lg shadow-lg dark:bg-gray-800">
    <div class="modal-header border-b border-gray-200 dark:border-gray-700 pb-4">
        <h2 class="text-lg text-primary font-semibold text-gray-900 dark:text-gray-100">Stok Opname</h2>
    </div>
    <form wire:submit="simpanStokOpname">
        <div class="modal-body space-y-4 mt-2">
            @include('components.alert')
            <div class="space-y-4">
                <!-- Field: Nama Produk -->
                <div class="flex flex-col sm:flex-row items-center">
                    <label for="nama-produk"
                        class="w-full sm:w-60 mb-2 sm:mb-0 text-sm font-medium text-gray-700 dark:text-gray-300">Nama
                        Produk</label>
                    <input id="nama-produk" type="text" placeholder="" wire:model='produk' disabled
                        class="w-full font-bold text-sm border-gray-300 rounded-md shadow-sm placeholder-gray-400 dark:bg-gray-700 dark:border-transparent dark:text-gray-200 dark:placeholder-gray-500 focus:ring-2 focus:ring-primary focus:border-primary" />
                </div>

                <!-- Field: Tipe -->
                <div class="flex flex-col sm:flex-row items-center mt-1">
                    <label for="tipe"
                        class="w-full sm:w-60 mb-2 sm:mb-0 text-sm font-medium text-gray-700 dark:text-gray-300">Tipe</label>
                    <input id="tipe" type="text" placeholder="" wire:model='tipe' disabled
                        class="w-full text-sm border-gray-300 rounded-md shadow-sm placeholder-gray-400 dark:bg-gray-700 dark:border-transparent dark:text-gray-200 dark:placeholder-gray-500 focus:ring-2 focus:ring-primary focus:border-primary" />
                </div>

                <!-- Field: No. Batch -->
                <div class="flex flex-col sm:flex-row items-center mt-1 ">
                    <label for="no-batch"
                        class="w-full sm:w-60 mb-2 sm:mb-0 text-sm font-medium text-gray-700 dark:text-gray-300">No.
                        Batch</label>
                    <input id="no-batch" type="text" placeholder="" wire:model='no_batch' disabled
                        class="w-full text-sm border-gray-300 rounded-md shadow-sm placeholder-gray-400 dark:bg-gray-700 dark:border-transparent dark:text-gray-200 dark:placeholder-gray-500 focus:ring-2 focus:ring-primary focus:border-primary" />
                </div>

                <!-- Field: Exp. Date -->
                <div class="flex flex-col sm:flex-row items-center mt-1">
                    <label for="exp-date"
                        class="w-full sm:w-60 mb-2 sm:mb-0 text-sm font-medium text-gray-700 dark:text-gray-300">Exp.
                        Date</label>
                    <input id="exp-date" type="date" placeholder="" wire:model='exp_date' disabled
                        class="w-full text-sm border-gray-300 rounded-md shadow-sm placeholder-gray-400 dark:bg-gray-700 dark:border-transparent dark:text-gray-200 dark:placeholder-gray-500 focus:ring-2 focus:ring-primary focus:border-primary" />
                </div>

                <!-- Field: Tanggal SO -->
                <div class="flex flex-col sm:flex-row items-center mt-1">
                    <label for="tanggal-so"
                        class="w-full sm:w-60 mb-2 sm:mb-0 text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal
                        SO</label>
                    <input id="tanggal-so" type="date" placeholder="" wire:model='tanggal_so'
                        class="w-full text-sm border-gray-300 rounded-md shadow-sm placeholder-gray-400 dark:bg-gray-700 dark:border-transparent dark:text-gray-200 dark:placeholder-gray-500 focus:ring-2 focus:ring-primary focus:border-primary" />
                </div>

                <!-- Field: Stok Tercatat -->
                <div class="flex flex-col sm:flex-row items-center mt-1">
                    <label for="stok-tercatat"
                        class="w-full sm:w-60 mb-2 sm:mb-0 text-sm font-medium text-gray-700 dark:text-gray-300">Stok
                        Tercatat</label>
                    <input id="stok-tercatat" type="text" placeholder="" wire:model='stok_tercatat' disabled
                        class="w-full text-sm border-gray-300 rounded-md shadow-sm placeholder-gray-400 dark:bg-gray-700 dark:border-transparent dark:text-gray-200 dark:placeholder-gray-500 focus:ring-2 focus:ring-primary focus:border-primary" />
                </div>

                <!-- Field: Stok Real -->
                <div class="flex flex-col sm:flex-row items-center mt-1">
                    <label for="stok-real"
                        class="w-full sm:w-60 mb-2 sm:mb-0 text-sm font-medium text-gray-700 dark:text-gray-300">Stok
                        Real</label>
                    <input id="stok-real" type="number" placeholder="" wire:model='stok_real' required
                        class="w-full text-sm border-gray-300 rounded-md shadow-sm placeholder-gray-400 dark:bg-gray-700 dark:border-transparent dark:text-gray-200 dark:placeholder-gray-500 focus:ring-2 focus:ring-primary focus:border-primary" />
                </div>

                <!-- Field: Satuan -->
                <div class="flex flex-col sm:flex-row items-center mt-1">
                    <label for="satuan"
                        class="w-full sm:w-60 mb-2 sm:mb-0 text-sm font-medium text-gray-700 dark:text-gray-300">Satuan</label>
                    <input id="satuan" type="text" placeholder="" wire:model='satuan_terkecil' disabled
                        class="w-full text-sm border-gray-300 rounded-md shadow-sm placeholder-gray-400 dark:bg-gray-700 dark:border-transparent dark:text-gray-200 dark:placeholder-gray-500 focus:ring-2 focus:ring-primary focus:border-primary" />
                </div>

                <!-- Field: Gudang -->
                <div class="flex flex-col sm:flex-row items-center mt-1">
                    <label for="gudang"
                        class="w-full sm:w-60 mb-2 sm:mb-0 text-sm font-medium text-gray-700 dark:text-gray-300">Gudang</label>
                    <input id="gudang" type="text" placeholder="" wire:model='gudang' disabled
                        class="w-full text-sm border-gray-300 rounded-md shadow-sm placeholder-gray-400 dark:bg-gray-700 dark:border-transparent dark:text-gray-200 dark:placeholder-gray-500 focus:ring-2 focus:ring-primary focus:border-primary" />
                </div>

                <!-- Field: Rak -->
                <div class="flex flex-col sm:flex-row items-center mt-1">
                    <label for="rak"
                        class="w-full sm:w-60 mb-2 sm:mb-0 text-sm font-medium text-gray-700 dark:text-gray-300">Rak</label>
                    <input id="rak" type="text" placeholder="" wire:model='rak' disabled
                        class="w-full text-sm border-gray-300 rounded-md shadow-sm placeholder-gray-400 dark:bg-gray-700 dark:border-transparent dark:text-gray-200 dark:placeholder-gray-500 focus:ring-2 focus:ring-primary focus:border-primary" />
                </div>

                <!-- Field: Sub Rak -->
                <div class="flex flex-col sm:flex-row items-center mt-1">
                    <label for="sub-rak"
                        class="w-full sm:w-60 mb-2 sm:mb-0 text-sm font-medium text-gray-700 dark:text-gray-300">Sub
                        Rak</label>
                    <input id="sub-rak" type="text" placeholder="" wire:model='subRak' disabled
                        class="w-full text-sm border-gray-300 rounded-md shadow-sm placeholder-gray-400 dark:bg-gray-700 dark:border-transparent dark:text-gray-200 dark:placeholder-gray-500 focus:ring-2 focus:ring-primary focus:border-primary" />
                </div>

                <!-- Field: Keterangan -->
                <div class="flex flex-col sm:flex-row items-center mt-1">
                    <label for="keterangan"
                        class="w-full sm:w-60 mb-2 sm:mb-0 text-sm font-medium text-gray-700 dark:text-gray-300">Keterangan</label>
                    <textarea id="keterangan" wire:model='keterangan' required rows="3"
                        class="w-full text-sm border-gray-300 rounded-md shadow-sm placeholder-gray-400 dark:bg-gray-700 dark:border-transparent dark:text-gray-200 dark:placeholder-gray-500 focus:ring-2 focus:ring-primary focus:border-primary"></textarea>
                </div>
            </div>
        </div>
        <div class="modal-footer gap-2 flex justify-end space-x-3 mt-4">
            <button
                class="btn btn-primary px-4 py-2 text-white bg-blue-500 rounded-md shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                type="submit" wire:loading.remove>Simpan</button>
            <button
                class="btn btn-primary px-4 py-2 text-white bg-blue-500 rounded-md shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                disabled wire:loading>Menyimpan...</button>
            <button
                class="btn btn-outline-danger px-4 py-2 border border-red-500 text-red-500 rounded-md shadow-md hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50"
                data-tw-dismiss="modal" type="button"> Batal </button>
        </div>
    </form>
</div>
