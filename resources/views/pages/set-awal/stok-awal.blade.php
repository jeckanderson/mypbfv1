@extends('layout.main')

@section('main')
    @php
        use App\Models\MutasiStok;
        use App\Models\StokOpname;
        use App\Models\DiskonKelompok;
    @endphp
    <div class="flex items-center mt-8 intro-y">
        <h2 class="mr-auto text-lg font-medium text-primary">
            Data Stok Awal
        </h2>
    </div>
    @if (session('success'))
        @include('components.alert')
    @endif
    <div class="flex justify-between mt-8">
        <div class="flex flex-wrap items-center col-span-12 mt-2 mr-auto intro-y sm:flex-nowrap">
            @can('tambah_stok_awal')
                <button class="mr-2 shadow-md btn btn-primary" data-tw-toggle="modal" data-tw-target="#modal-tambah"><i
                        data-feather="edit-3" class="w-4 h-4 mr-3"></i> Tambah</button>

                <!-- BEGIN: Modal Content -->
                @include('components.modal.modal-stok-awal', [
                    'id_modal' => 'modal-tambah',
                    'route' => 'tambah.stok-awal',
                    'id' => '',
                    'stok' => '',
                    'id_dropdown' => 'obatTambah',
                ])
                <!-- END: Modal Content -->
            @endcan

            <div data-tw-merge class="items-center block sm:flex">
                @include('components.search', [
                    'id_table' => 'tableStokAwal',
                ])
            </div>
        </div>
        <div class="flex gap-2 mt-2">
            </a>
            <a href="/stok-awal-download-excel" class="flex items-center text-white btn btn-success"><i
                    data-feather="file-text" class="w-4 h-4 mr-1"
                    value="Export Excel"onclick="window.open('laporan-excel.php')"></i>Excel
                <a href="/stok-awal-download-pdf" class="flex items-center text-white btn btn-facebook"><i
                        data-feather="printer" class="w-4 h-4 mr-1"></i>Print
                </a>
                <button class="flex items-center text-white btn btn-pending" data-tw-toggle="modal"
                    data-tw-target="#import"><i data-feather="download" class="w-4 h-4 mr-1" value="Export Excel"></i>Import
                </button>

                <!-- BEGIN: Modal Content -->
                @include('components.modal.modal-import', [
                    'id_modal' => 'import',
                    'route' => 'import.stok-awal',
                    'id' => '',
                    'filename' => 'stokAwalImport.xlsx',
                ])
        </div>
    </div>
    <!-- BEGIN: Data List -->
    <div class="col-span-12 mt-2 overflow-auto intro-y lg:overflow-visible">
        <div class="overflow-x-auto">
            <table class="table -mt-2 table-report" id="tableStokAwal">
                <thead style="background-color: #d3d3d3;">
                    <tr>
                        <th class="whitespace-nowrap">No </th>
                        <th class="whitespace-nowrap">No. Reff</th>
                        <th class="whitespace-nowrap">Nama Produk</th>
                        <th class="whitespace-nowrap">No. Batch</th>
                        <th class="whitespace-nowrap">Exp. Date</th>
                        <th class="whitespace-nowrap">Jumlah</th>
                        <th class="whitespace-nowrap">Satuan</th>
                        <th class="whitespace-nowrap">HPP</th>
                        <th class="whitespace-nowrap">Total</th>
                        <th class="whitespace-nowrap">Gudang</th>
                        <th class="whitespace-nowrap">Rak</th>
                        <th class="whitespace-nowrap">Sub Rak</th>
                        <th class="whitespace-nowrap">Tipe</th>
                        <th class="text-center whitespace-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($stoks as $stok)
                        @php
                            $hpp = str_replace('.', '', $stok->hpp);
                            $isi = DiskonKelompok::where('id_obat_barang', $stok->id_obat_barang)
                                ->where('satuan_dasar_beli', $stok->satuan)
                                ->first()->isi;
                        @endphp
                        <tr class="intro-x">
                            <td class="w-20">{{ $loop->iteration }}</td>
                            <td class="whitespace-nowrap">{{ $stok->no_reff }}</td>
                            <td class="whitespace-nowrap">{{ $stok->produk->nama_obat_barang }}</td>
                            <td class="whitespace-nowrap">{{ $stok->no_batch }}</td>
                            <td class="whitespace-nowrap">
                                {{ $stok->exp_date ? date('d-m-Y', strtotime($stok->exp_date)) : '-' }}</td>
                            <td class="whitespace-nowrap">{{ $stok->jumlah }}</td>
                            <td class="whitespace-nowrap">{{ $stok->satuanStok->satuan }}</td>
                            <td class="whitespace-nowrap">{{ number_format($hpp, 0, ',', '.') }}</td>
                            <td class="whitespace-nowrap">
                                {{ number_format($hpp * str_replace('.', '', $stok->jumlah), 0, ',', '.') }}
                            </td>
                            <td class="whitespace-nowrap">{{ $stok->gudangStok->gudang }}</td>
                            <td class="whitespace-nowrap">{{ $stok->rakStok->rak }}</td>
                            <td class="whitespace-nowrap">{{ $stok->subRak->sub_rak }}</td>
                            <td class="whitespace-nowrap">{{ $stok->produk->tipe }}</td>
                            <td class="table-report__action w-72 whitespace-nowrap">
                                <div class="flex items-center justify-center">
                                    <!-- END: Delete Confirmation Modal -->
                                    <a class="flex items-center mx-3 mr-3 text-primary"
                                        href="{{ route('setHarga', ['id' => $stok->produk->id]) }}"> <i
                                            data-feather="credit-card" class="w-4 h-4 mr-1"></i> Harga </a>
                                    <!-- BEGIN: Delete Confirmation Modal -->
                                    {{-- <a class="flex items-center mr-3 text-primary" href="javascript:;" data-tw-toggle="modal"
                                        data-tw-target="#modal-edit{{ $stok->id }}"> <i data-feather="check-square"
                                            class="w-4 h-4 mr-1"></i> Edit </a> --}}
                                    @can('aksi_stok_awal')
                                        @if (
                                            !MutasiStok::where('id_sumber', $stok->id)->where('sumber', 'stokawal')->exists() &&
                                                !StokOpname::where('sumber', 'stokawal')->where('id_sumber', $stok->id)->exists())
                                            <a class="flex items-center text-danger" href="javascript:;" data-tw-toggle="modal"
                                                data-tw-target="#delete-confirmation-modal{{ $stok->id }}"> <i
                                                    data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
                                            @include('components.modal-delete', [
                                                'id_modal' => 'delete-confirmation-modal',
                                                'id' => $stok->id,
                                                'route' => 'delete.stok-awal',
                                            ])
                                        @endif

                                        @include('components.modal.modal-stok-awal', [
                                            'id_modal' => 'modal-edit',
                                            'route' => 'edit.stok-awal',
                                            'id' => $stok->id,
                                            'id_dropdown' => 'obatEdit',
                                        ])
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="intro-x">
                            <td class="font-bold text-center text-pending" colspan="17">Belum ada data tersedia</td>
                        </tr>
                    @endforelse
                    @php
                        $sumHppTotal = $stoks
                            ->map(function ($item) {
                                $hpp = str_replace('.', '', $item->hpp);
                                $jumlah = str_replace('.', '', $item->jumlah);
                                return $hpp * $jumlah;
                            })
                            ->sum();
                    @endphp
                    <tr>
                        <td colspan="8" class="font-bold text-center border border-slate-600">Jumlah</td>
                        <td colspan="7" class="font-bold border border-slate-600" id="totalHutang">
                            {{ number_format($sumHppTotal, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        function formatRupiah(angka) {
            let numberString = angka.toFixed(2).toString();
            let splitNumber = numberString.split('.');
            let rupiah = splitNumber[0].replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
            return "Rp. " + rupiah + "," + splitNumber[1];
        }

        function selectOption() {
            let filterSelect = document.getElementById("filterSelect").value;
            let tableHutang = document.getElementById("tableHutang");
            let tr = tableHutang.getElementsByTagName("tr");
            var i, txtValue, td, hutang;
            let totalHutang = document.getElementById("totalHutang");
            let total = 0; // Inisialisasi total hutang

            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[3];
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
    </script>
    <!-- END: Data List -->
@endsection
