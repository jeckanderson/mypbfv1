<div id="{{ $id_modal . $id }}" class="modal" tabindex="-1" aria-hidden="true">
    @php
        use App\Models\Satuan;
        use App\Models\DiskonKelompok;
    @endphp
    <div class="rounded-lg modal-dialog modal-xl">
        <div class="modal-content">
            <form action="{{ route($route, ['id' => $id]) }}" method="POST">
                @csrf
                <div class="pb-4 border-b border-gray-200 modal-header dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-900 text-primary dark:text-gray-100">Stok Awal</h2>
                </div>
                <div class="p-5 modal-body">
                    <div class="preview">
                        <div data-tw-merge class="items-center block mt-1 sm:flex">
                            <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-40">
                                Tanggal
                            </label>
                            <input data-tw-merge id="horizontal-form-1" type="date" placeholder="Auto" required
                                name="tgl_faktur" value="{{ now()->toDateString() }}" disabled
                                class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&[readonly]]:bg-slate-100 [&[readonly]]:cursor-not-allowed [&[readonly]]:dark:bg-darkmode-800/50 [&[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                        </div>
                        @php

                            $bulan = date('m');
                            $tahun = date('y');
                            $kode = $urutan . '/SA/' . date('m-y');
                        @endphp

                        <div data-tw-merge class="items-center block mt-1 sm:flex">
                            <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-40">
                                No. Reff
                            </label>
                            <input data-tw-merge id="horizontal-form-1" type="text" placeholder="Auto" name="no_reff"
                                value="{{ $stok ? $stok->no_reff : $kode }}"
                                class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                        </div>
                        <div data-tw-merge class="items-center block mt-1 sm:flex">
                            <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-40">
                                No. Batch
                            </label>
                            <input data-tw-merge id="horizontal-form-1" type="text" placeholder="" name="no_batch"
                                value="{{ $stok ? $stok->no_batch : '' }}" required
                                class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                        </div>
                        <div data-tw-merge class="items-center block mt-1 sm:flex">
                            <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-40">
                                Nama Produk
                            </label>
                            <select data-tw-merge aria-label="Default select example" name="id_obat_barang"
                                class="font-bold form-control tom-select" id="nama_barang{{ $id }}">
                                <option value="">- Pilih -</option>
                                @foreach ($barangs as $barang)
                                    <option value="{{ $barang->id }}"
                                        {{ $stok ? ($stok->id_obat_barang == $barang->id ? 'selected' : '') : '' }}>
                                        {{ $barang->barcode_produk . ' || ' . $barang->nama_obat_barang }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div data-tw-merge class="items-center block mt-1 sm:flex">
                            <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-40">
                                Satuan
                            </label>
                            <select data-tw-merge aria-label="Default select example" name="satuan"
                                class="form-control" id="satuan{{ $id }}">
                            </select>
                        </div>

                        <div data-tw-merge class="items-center block mt-1 sm:flex">
                            <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-40">
                                Isi
                            </label>
                            <div class="flex w-full gap-3 font-bold">
                                <input data-tw-merge id="isi{{ $id }}" type="number" placeholder="Auto"
                                    name="isi_satuan" class="form-control" readonly />
                                <p id="satuan_terkecil{{ $id }}" class="mt-2"></p>
                            </div>
                        </div>
                        <div data-tw-merge class="items-center block mt-1 sm:flex">
                            <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-40">
                                Jumlah
                            </label>
                            <div class="flex w-full gap-3 font-bold">
                                <input data-tw-merge id="jumlah" type="number" placeholder="" class="form-control"
                                    name="jumlah" value="{{ $stok ? $stok->jumlah : '' }}" />
                                <p class="mt-2 satuan_terpilih{{ $id }}"></p>
                            </div>
                        </div>
                        <div data-tw-merge class="items-center block mt-1 sm:flex">
                            <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-40">
                                Exp. Date
                            </label>
                            <input data-tw-merge id="exp_date{{ $id }}" type="date" placeholder="Auto"
                                class="form-control" name="exp_date"
                                value="{{ $stok ? $stok->exp_date : now()->toDateString() }}" />
                        </div>
                        <!-- Tambahkan class 'formatted-input' untuk input HPP -->
                        <div data-tw-merge class="items-center block mt-1 sm:flex">
                            <label data-tw-merge for="hpp" class="inline-block mb-2 sm:w-40">
                                HPP
                            </label>
                            <div class="flex w-full gap-3 font-bold">
                                <input data-tw-merge id="hpp{{ $id }}" type="text" placeholder=""
                                    name="hpp" value="{{ $stok ? $stok->hpp : '' }}"
                                    class="w-full text-sm transition duration-200 ease-in-out rounded-md shadow-sm hpp disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent border-slate-200 placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                                <p class="mt-2 satuan_terpilih{{ $id }}"></p>
                            </div>
                        </div>
                        <script>
                            $('.hpp').on('input', function() {
                                var formattedValue = $(this).val().replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                                $(this).val(formattedValue);
                            })
                        </script>

                        <div data-tw-merge class="items-center block mt-1 sm:flex">
                            <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-40">
                                Gudang
                            </label>
                            <select data-tw-merge aria-label="Default select example" class="form-control"
                                name="gudang">
                                @foreach ($gudangs as $gudang)
                                    <option value="{{ $gudang->id }}"
                                        {{ $stok ? ($stok->gudang == $gudang->id ? 'selected' : '') : '' }}>
                                        {{ $gudang->gudang }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div data-tw-merge class="items-center block mt-1 sm:flex">
                            <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-40">
                                Rak
                            </label>
                            <select data-tw-merge aria-label="Default select example" class="form-control"
                                name="rak">
                                @foreach ($raks as $rak)
                                    <option value="{{ $rak->id }}"
                                        {{ $stok ? ($stok->rak == $rak->id ? 'selected' : '') : '' }}>
                                        {{ $rak->rak }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div data-tw-merge class="items-center block mt-1 sm:flex">
                            <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-40">
                                Sub Rak
                            </label>
                            <select data-tw-merge aria-label="Default select example" class="form-control"
                                name="sub_rak">
                                @foreach ($sub_rak as $rak)
                                    <option value="{{ $rak->id }}"
                                        {{ $stok ? ($stok->rak == $rak->id ? 'selected' : '') : '' }}>
                                        {{ $rak->sub_rak }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div data-tw-merge class="items-center block mt-1 sm:flex">
                            <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-40">
                                Tipe
                            </label>
                            <div class="flex w-full gap-3">
                                <input data-tw-merge id="tipe{{ $id }}" type="text" placeholder="Tipe"
                                    class="form-control" disabled />
                            </div>
                        </div>
                    </div>
                </div>
                {{-- footer --}}
                <div class="modal-footer">
                    <button type="submit" class="mt-5 btn btn-primary"> Simpan </button>
                    <button class="mt-5 btn btn-outline-danger" data-tw-dismiss="modal" type="button">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function($) {
        let id_dropdown = "{{ $id }}";

        // Function to fetch and populate data when the page loads
        function fetchData(selectedOption) {
            $.ajax({
                url: '/get-nama-barang/' + selectedOption,
                type: 'GET',
                success: function(data) {
                    $("#satuan" + id_dropdown).val(data.satuan);
                    $("#isi" + id_dropdown).val(data.isi);
                    $("#satuan_terkecil" + id_dropdown).text(data.satuan_terkecil);
                    $(".satuan_terpilih" + id_dropdown).text(data.satuan_dasar);
                    $('#tipe' + id_dropdown).val(data.tipe);
                    $('#exp_date' + id_dropdown).prop('disabled', data.exp_date === '0');

                    var selectOptions = data.satuan;
                    var selectElement = $("#satuan" + id_dropdown);
                    var defaultSatuan = "{{ $stok->satuan ?? '' }}";
                    selectElement.empty();

                    $.each(selectOptions, function(index, value) {
                        var option = $('<option></option>').attr('value', value).text(data
                            .nama_satuan[index]);
                        if (defaultSatuan !== '' && value === defaultSatuan) {
                            option.prop('selected', true);
                        }
                        selectElement.append(option);
                    });

                    if (defaultSatuan !== '') {
                        selectElement.val(defaultSatuan);
                    }

                    // Trigger the change event to execute the related logic
                    selectElement.trigger('change');
                },
            });
        }

        // Event handler for product change
        $('#nama_barang' + id_dropdown).change(function() {
            let selectedOption = $(this).val();
            fetchData(selectedOption);
        });

        // Event handler for unit change
        $(document).on('change', '#satuan' + id_dropdown, function() {
            let selectedOption = $(this).val();
            $('.satuan_terpilih' + id_dropdown).text($(this).find('option:selected').text());
            let id_barang = $('#nama_barang' + id_dropdown).val();

            $.ajax({
                url: '/get-isi-barang/' + id_barang + '/' + selectedOption,
                type: 'GET',
                success: function(data) {
                    $("#isi" + id_dropdown).val(data.isi);
                },
            });
        });

        // Fetch data on page load
        fetchData($('#nama_barang' + id_dropdown).val());
    });
</script>
