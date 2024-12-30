@extends('layout.main')

@section('main')
    <div class="flex items-center mt-8 intro-y">
        <h2 class="mr-auto text-lg font-medium text-primary ">
            Data Hutang Awal
        </h2>
    </div>
    @if (session('success'))
        @include('components.alert')
    @endif
    <div class="flex justify-between mt-8">
        <div class="flex flex-wrap items-center col-span-12 mt-2 mr-auto intro-y sm:flex-nowrap">
            @can('tambah_hutang_awal')
                <button class="mr-2 shadow-md btn btn-primary" data-tw-toggle="modal" data-tw-target="#tambah-hutang-awal"><i
                        data-feather="edit-3" class="w-4 h-4 mr-3"></i> Tambah</button>

                <!-- BEGIN: Modal Content -->
                @include('components.modal.modal-hutang-awal', [
                    'id_modal' => 'tambah-hutang-awal',
                    'route' => 'tambah.hutang-awal',
                    'id' => '',
                    'hutangAwal' => '',
                ])
                <!-- END: Modal Content -->
            @endcan

            <div data-tw-merge class="items-center block sm:flex ">
                @include('components.search', [
                    'id_table' => 'tableHutang',
                ])
            </div>

            <div data-tw-merge class="items-center block ml-2 sm:flex ">
                <select data-tw-merge aria-label="Default select example" class="form-control" name="selectedOption"
                    id="filterSelect" onchange="selectOption()">
                    <option value="">- Semua Jenis -</option>
                    <option value="Hutang Dagang">Hutang Dagang</option>
                    <option value="Hutang Konsinyasi">Hutang Konsinyasi</option>
                </select>
            </div>
        </div>
        <div class="flex gap-2 mt-2">
            <a href="#" onclick="downloadExcel()" class="flex items-center text-white shadow-md btn btn-success">
                <i data-feather="file-text" class="w-4 h-4 mr-1"></i>Excel
            </a>
            <a href="#" onclick="downloadPDF()" class="flex items-center text-white shadow-md btn btn-facebook">
                <i data-feather="printer" class="w-4 h-4 mr-1"></i>Print
            </a>
            <button class="flex items-center text-white shadow-md btn btn-pending" data-tw-toggle="modal"
                data-tw-target="#import"><i data-feather="download" class="w-4 h-4 mr-1" value="Export Excel"></i>Import
            </button>

            <!-- BEGIN: Modal Content -->
            @include('components.modal.modal-import', [
                'id_modal' => 'import',
                'route' => 'import.hutang-awal',
                'id' => '',
                'filename' => 'importHutang.xlsx',
            ])
        </div>
    </div>
    <!-- BEGIN: Data List -->
    <div class="col-span-12 mt-2 overflow-auto intro-y lg:overflow-visible" id="filterResults">
        <table class="table -mt-2 table-report" id="tableHutang">
            <thead style="background-color: #d3d3d3;">
                <tr>
                    <th class="whitespace-nowrap">No</th>
                    <th class="whitespace-nowrap">No. Reff</th>
                    <th class="whitespace-nowrap">No. Faktur</th>
                    <th class="whitespace-nowrap">Tgl. Faktur</th>
                    <th class="whitespace-nowrap">Supplier</th>
                    <th class="whitespace-nowrap">Jatuh Tempo</th>
                    <th class="whitespace-nowrap">Jumlah Hutang</th>
                    <th class="whitespace-nowrap">Jenis Hutang</th>
                    <th class="text-center whitespace-nowrap">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($hutangAwals as $hutangAwal)
                    <tr class="intro-x">
                        <td class="w-30">{{ $loop->iteration }}</td>
                        <td class="">{{ $hutangAwal->no_reff }}</td>
                        <td class="">{{ $hutangAwal->no_faktur }}</td>
                        <td class="">{{ date('d-m-Y', strtotime($hutangAwal->tgl_faktur)) }}</td>
                        <td class="">{{ $hutangAwal->getSuplier->nama_suplier }}</td>
                        <td class="">{{ date('d-m-Y', strtotime($hutangAwal->tgl_jth_tempo)) }}</td>
                        <td class="">{{ number_format($hutangAwal->jmlh_hutang, 0, ',', '.') }}
                        </td>
                        <td class="">{{ $hutangAwal->jns_hutang }}</td>
                        <td class="w-56 table-report__action">
                            @can('aksi_hutang_awal')
                                <div class="flex items-center justify-center">
                                    {{-- <a class="flex items-center mr-3 text-primary" href="javascript:;" data-tw-toggle="modal"
                                    data-tw-target="#edit-hutang-awal{{ $hutangAwal->id }}"> <i data-feather="check-square"
                                        class="w-4 h-4 mr-1"></i> Edit </a> --}}
                                    <a class="flex items-center text-danger" href="javascript:;" data-tw-toggle="modal"
                                        data-tw-target="#delete-confirmation-modal{{ $hutangAwal->id }}"> <i
                                            data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
                                    <!-- BEGIN: Delete Confirmation Modal -->
                                    @include('components.modal-delete', [
                                        'id_modal' => 'delete-confirmation-modal',
                                        'id' => $hutangAwal->id,
                                        'route' => 'delete.hutang-awal',
                                    ])
                                    <!-- END: Delete Confirmation Modal -->

                                    {{-- edit modal --}}
                                    @include('components.modal.modal-hutang-awal', [
                                        'id_modal' => 'edit-hutang-awal',
                                        'route' => 'edit.hutang-awal',
                                        'id' => $hutangAwal->id,
                                        'hutangAwal' => $hutangAwal,
                                    ])
                                </div>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr class="intro-x">
                        <td colspan="13" class="font-bold text-center text-pending">Belum ada data tersedia</td>
                    </tr>
                @endforelse

                <tr>
                    <td colspan="6" class="font-bold text-center border border-slate-600">Jumlah</td>
                    <td colspan="5" class="font-bold border border-slate-600" id="totalHutang">
                        {{ number_format($totalHutang, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- END: Data List -->
    <script>
        function formatRupiah(angka) {
            let numberString = Math.floor(angka).toString(); // Menghapus angka di belakang koma
            let rupiah = numberString.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1."); // Menambahkan titik sebagai pemisah ribuan
            return rupiah; // Mengembalikan hasil dalam format Rupiah tanpa angka desimal
        }


        function selectOption() {
            let filterSelect = document.getElementById("filterSelect").value;
            let tableHutang = document.getElementById("tableHutang");
            let tr = tableHutang.getElementsByTagName("tr");
            var i, txtValue, td, hutang;
            let totalHutang = document.getElementById("totalHutang");
            let total = 0; // Inisialisasi total hutang

            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[7];
                hutang = tr[i].getElementsByTagName("td")[6];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase() === filterSelect.toUpperCase() || filterSelect === "") {
                        tr[i].style.display = "";

                        // Bersihkan nilai hutang dari karakter non-numerik dan ganti koma dengan titik
                        let hutangText = hutang.textContent.replace(/[^\d,]/g, '').replace(',', '.');
                        let hutangCleaned = parseFloat(hutangText);

                        total += hutangCleaned;
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }

            // Setel total hutang setelah menghitung nilai dalam format yang diinginkan
            totalHutang.textContent = formatRupiah(total);
        }

        function downloadExcel() {
            let filter = document.getElementById('filterSelect').value;
            window.location.href = '/hutang-awal-download-excel?filter=' + filter;
        }

        function downloadPDF() {
            let filter = document.getElementById('filterSelect').value;
            window.location.href = '/hutang-awal-download-pdf?filter=' + filter;
        }
    </script>
@endsection
