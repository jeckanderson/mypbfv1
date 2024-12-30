<div class="modal-content">
    <div class="flex justify-left text-lg font-bold text-primary modal-header align-left">
        Cek Barcode Produk
    </div>
    <div class="p-5 modal-body">
        <div data-tw-merge class="items-center block mt-2 sm:flex">
            <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                Barcode
            </label>
            <input data-tw-merge id="horizontal-form-1" type="text" placeholder="" wire:model.live.debounce.150ms='kode'
                class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
        </div>
        <div data-tw-merge class="items-center block mt-2 sm:flex">
            <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                Nama Produk
            </label>
            <div class="w-full">
                <input data-tw-merge id="horizontal-form-1" type="text" placeholder="" wire:model='nama_produk'
                    readonly
                    class="font-bold text-success disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                <p class="mt-2 text-danger">{{ $warning }}</p>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        @if ($nama_produk)
            <button class="btn btn-primary" wire:click='masukan' wire:loading.remove>Masukan</button>
            <button class="btn btn-primary" disabled wire:loading>Menambahkan...</button>
        @endif
        <button class="btn btn-outline-danger" data-tw-dismiss="modal">Batal</button>

    </div>
</div>
