<div id="{{ $id_modal . $id }}" class="modal" tabindex="-1" aria-hidden="true">
    <div class="rounded-lg modal-dialog modal-xl">
        <form action="{{ route($route, ['id' => $id]) }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header border-b border-gray-200 dark:border-gray-700 pb-4">
                    <h2 class="text-lg text-primary font-semibold text-gray-900 dark:text-gray-100">Supplier</h2>
                </div>
                <div class="p-5 modal-body">
                    <div class="preview">
                        <div data-tw-merge class="items-center block mt-1 sm:flex ">
                            <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-32">
                                Kode
                            </label>
                            <input data-tw-merge id="horizontal-form-1" type="number" placeholder="Auto"
                                value="{{ $sup ? $sup->kode : rand(pow(10, 10), pow(10, 11) - 1) }}" name="kode"
                                class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                        </div>
                        <div data-tw-merge class="items-center block mt-1 sm:flex">
                            <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-32">
                                Kode E-Report
                            </label>
                            <input data-tw-merge id="horizontal-form-1" type="text" name="kode_e_report"
                                value="{{ $sup ? $sup->kode_e_report : '' }}" required
                                class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                        </div>
                        <div data-tw-merge class="items-center block mt-1 sm:flex">
                            <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-32">
                                Nama Supplier
                            </label>
                            <input data-tw-merge id="horizontal-form-1" type="text" name="nama_suplier"
                                value="{{ $sup ? $sup->nama_suplier : '' }}" required
                                class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                        </div>
                        <div data-tw-merge class="items-center block mt-1 sm:flex">
                            <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-32">
                                Alamat
                            </label>
                            <textarea id="" rows="2" name="alamat" class="form-control"required>{{ $sup ? $sup->alamat : '' }}</textarea>
                        </div>
                        <div data-tw-merge class="items-center block mt-1 sm:flex ">
                            <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-32">
                                No. NPWP
                            </label>
                            <input data-tw-merge id="horizontal-form-1" type="text" name="npwp"
                                value="{{ $sup ? $sup->npwp : '' }}"
                                class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                        </div>
                        <div data-tw-merge class="items-center block mt-1 sm:flex">
                            <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-32">
                                No. Telp
                            </label>
                            <input data-tw-merge id="horizontal-form-1" type="number" name="no_telepon"
                                value="{{ $sup ? $sup->no_telepon : '' }}"
                                class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                        </div>
                    </div>
                </div>
                {{-- footer --}}
                <div class="modal-footer">
                    <button type="submit" class="mt-5 btn btn-primary">Simpan</button>
                    <button class="mt-5 btn btn-outline-danger" data-tw-dismiss="modal" type="button"> Batal </button>
                </div>
            </div>
        </form>
    </div>
</div>
