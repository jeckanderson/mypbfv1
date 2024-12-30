<div class="modal-content">
    <div class="flex justify-center text-white modal-header bg-primary align-center">
        <h2 class="text-lg font-bold">Entri Saldo</h2>
    </div>
    <div class="p-10 modal-body">
        <div class="preview">
            <div data-tw-merge class="items-center block mt-3 sm:flex" wire:ignore>
                <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-40">
                    Akun
                </label>
                <select data-tw-merge aria-label="Default select example" class="form-control tom-select"
                    wire:model='id_akun'>
                    <option value="">- Pilih -</option>
                    @forelse ($akuns as $akun)
                        <option value="{{ $akun->id }}">{{ $akun->kode . ' | ' . $akun->nama_akun }}</option>
                    @empty
                    @endforelse
                </select>
            </div>
            <div data-tw-merge class="items-center block mt-3 sm:flex">
                <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-40">
                    Saldo
                </label>
                <input data-tw-merge id="horizontal-form-1" type="text" placeholder="" oninput="formatNumber(this)"
                    wire:model='saldo'
                    class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
            </div>
            <div data-tw-merge class="items-center block mt-3 sm:flex">
                <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-40">
                    Tipe Saldo
                </label>
                <select data-tw-merge aria-label="Default select example" class="form-control" wire:model='tipeSaldo'>
                    <option value="bertambah">Saldo Bertambah</option>
                    <option value="berkurang">Saldo Berkurang</option>
                </select>
            </div>
        </div>
    </div>
    {{-- footer --}}
    <div class="modal-footer">
        <button class="mt-5 btn btn-secondari" data-tw-dismiss="modal">Batal</button>
        <button class="mt-5 btn btn-primary" data-tw-dismiss="modal" wire:click='masukanSaldo'>Simpan</button>
    </div>
    <script>
        function formatNumber(input) {
            input.value = input.value.replace(/[^\d.]/g, '');

            let number = parseFloat(input.value.replace(/\./g, '').replace(',', '.')).toFixed(0);
            input.value = isNaN(number) ? '0' : new Intl.NumberFormat('id-ID').format(number);
        }
    </script>
</div>
