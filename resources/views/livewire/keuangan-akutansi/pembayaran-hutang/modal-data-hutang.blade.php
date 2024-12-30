<div class="modal-content">
    <div class="flex justify-center text-lg font-bold text-white modal-header bg-primary align-center">
        Data Hutang (xxxxxx)
    </div>
    <div class="p-5 modal-body">
        <div class="overflow-auto">
            <div data-tw-merge class="flex items-center block gap-2 mt-3 mb-3">
                <label data-tw-merge for="horizontal-form-1" class="inline-block mt-2 mb-2 sm:w-32">
                    Filter
                </label>
                <select data-tw-merge aria-label="Default select example" class="form-control">
                    <option>- Pilih -</option>
                    <option>Box</option>
                    <option>Botol</option>
                </select>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th class="border border-slate-600">No</th>
                        <th class="border border-slate-600">Tgl. Faktur</th>
                        <th class="border border-slate-600">Tgl. Input</th>
                        <th class="border border-slate-600">No. Faktur</th>
                        <th class="border border-slate-600">Tgl. Jatuh Tempo</th>
                        <th class="border border-slate-600">Total Hutang</th>
                        <th class="border border-slate-600">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border border-slate-600">Contoh Data</td>
                        <td class="border border-slate-600">Contoh Data</td>
                        <td class="border border-slate-600">Contoh Data</td>
                        <td class="border border-slate-600">Contoh Data</td>
                        <td class="border border-slate-600">Contoh Data</td>
                        <td class="border border-slate-600">Contoh Data</td>
                        <td class="border border-slate-600">
                            <input data-tw-merge type="checkbox"
                                class="transition-all duration-100 ease-in-out shadow-sm border-slate-200 cursor-pointer rounded focus:ring-4 focus:ring-offset-0 focus:ring-primary focus:ring-opacity-20 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&amp;[type=&#039;radio&#039;]]:checked:bg-primary [&amp;[type=&#039;radio&#039;]]:checked:border-primary [&amp;[type=&#039;radio&#039;]]:checked:border-opacity-10 [&amp;[type=&#039;checkbox&#039;]]:checked:bg-primary [&amp;[type=&#039;checkbox&#039;]]:checked:border-primary [&amp;[type=&#039;checkbox&#039;]]:checked:border-opacity-10 [&amp;:disabled:not(:checked)]:bg-slate-100 [&amp;:disabled:not(:checked)]:cursor-not-allowed [&amp;:disabled:not(:checked)]:dark:bg-darkmode-800/50 [&amp;:disabled:checked]:opacity-70 [&amp;:disabled:checked]:cursor-not-allowed [&amp;:disabled:checked]:dark:bg-darkmode-800/50"
                                id="checkbox-switch-1" value="" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" class="font-bold text-center border border-slate-600">Total</td>
                        <td class="font-bold text-center border border-slate-600"></td>
                        <td class="font-bold text-center border border-slate-600"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-secondary" data-tw-dismiss="modal">Batal</button>
        <button class="btn btn-primary">Pilih</button>
    </div>
</div>
