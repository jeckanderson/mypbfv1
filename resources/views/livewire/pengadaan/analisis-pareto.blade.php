<div>
    @php
        use App\Models\ProdukPenjualan;
        use App\Models\RencanaPengadaan;
        use App\Models\ObatBarang;
    @endphp

    <div class="grid grid-cols-12 gap-2 mt-5">
        <div class="flex flex-wrap items-center justify-between col-span-12 gap-2 mt-3 mb-3 intro-y sm:flex-nowrap">
            <div class="flex items-center gap-2 mr-auto">
                <div class="flex justify-end gap-3">
                    <button class="btn btn-primary" wire:click='sendDefecta'
                        wire:confirm='Apakah anda yakin akan mengirimkan ke defecta?'>
                        <i data-feather="edit-3" class="w-4 h-4 mr-3"></i> Defecta
                    </button>
                    @include('components.search', [
                        'id_table' => 'myTable',
                    ])
                </div>
                <div class="items-center block sm:flex">
                    <select id="kelas-select" class="form-control">
                        <option value="">- Pilih Kelas -</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                    </select>
                </div>
            </div>
            <div class="items-center block sm:flex">
                {{-- <a href="/analisis-pareto-download-excel" class="flex items-center mr-2 text-white btn btn-success"
                    wire:ignore><i data-feather="file-text" class="w-4 h-4 mr-1"></i>Excel
                </a> --}}
                <a href="{{ route('export_analisis_pareto_pdf', ['tanggalMulai' => $tanggalMulai, 'tanggalAkhir' => $tanggalAkhir]) }}"
                    class="flex items-center mr-2 btn btn-facebook" wire:ignore><i data-feather="printer"
                        class="w-4 h-4 mr-1"></i>Print
                </a>
                <button class="btn btn-pending" wire:ignore data-tw-toggle="modal" data-tw-target="#modal-informasi">
                    <i data-feather="alert-triangle" class="w-4 h-4 mr-1"></i> Informasi
                </button>
            </div>
        </div>
    </div>

    <!-- BEGIN: Data List -->
    <div class="col-span-12 overflow-auto intro-y lg:overflow-visible">
        <table class="table -mt-2 table-report" id="myTable">
            <thead style="background-color: #d3d3d3;">
                <tr>
                    <th class="whitespace-nowrap">No</th>
                    <th class="whitespace-nowrap">Barcode</th>
                    <th class="whitespace-nowrap">Produk</th>
                    <th class="whitespace-nowrap">Satuan</th>
                    <th class="whitespace-nowrap">Golongan</th>
                    <th class="text-center whitespace-nowrap">Tipe</th>
                    <th class="whitespace-nowrap">Harga Jual</th>
                    <th class="text-center whitespace-nowrap">Jumlah Terjual</th>
                    <th class="whitespace-nowrap">Nilai Penjualan</th>
                    <th class="text-center whitespace-nowrap">% Pendapatan</th>
                    <th class="text-center whitespace-nowrap">% Kumulatif</th>
                    <th class="text-center whitespace-nowrap">Kelas</th>
                    <th class="text-center whitespace-nowrap">
                        <input type="checkbox" id="checkbox-switch-1" value="" wire:model.live="selectAll" />
                    </th>
                </tr>
            </thead>
            <tbody>
                @php
                    // Ambil semua data produk penjualan
                    $getProdukJual = ProdukPenjualan::with(['produk', 'produk.satuanTerkecil', 'produk.golonganProduk'])
                        ->groupBy('id_produk')
                        ->where('id_penjualan', '!=', null);
                    if ($this->tanggalMulai && $this->tanggalAkhir) {
                        $getProdukJual->whereBetween('updated_at', [$this->tanggalMulai, $this->tanggalAkhir]);
                    }
                    $produkPenjualan = $getProdukJual->get();

                    // Proses data produk penjualan
                    $produkData = [];
                    foreach ($produkPenjualan as $prod) {
                        $totalHarga = ProdukPenjualan::where('id_produk', $prod->produk->id)
                            ->where('id_penjualan', '!=', null)
                            ->sum('total_modal');

                        $jum = ProdukPenjualan::where('id_produk', $prod->produk->id)
                            ->where('id_penjualan', '!=', null)
                            ->get();

                        $jumlahProduk = 0;
                        foreach ($jum as $value) {
                            $isi =
                                \App\Models\DiskonKelompok::where('id_obat_barang', $value->id_produk)
                                    ->where('satuan_dasar_beli', $value->satuan)
                                    ->first()->isi * $value->qty;
                            $jumlahProduk += $isi;
                        }

                        $hargaJual = $totalHarga / $jumlahProduk;
                        $nilaiPenjualan = $hargaJual * $jumlahProduk;

                        if ($hargaJual != 0) {
                            $persentase = round(
                                ($nilaiPenjualan /
                                    ProdukPenjualan::where('id_perusahaan', Auth::user()->id_perusahaan)->sum(
                                        'total_modal',
                                    )) *
                                    100,
                            );
                        } else {
                            $persentase = 0;
                        }

                        $produkData[] = [
                            'prod' => $prod,
                            'hargaJual' => $hargaJual,
                            'jumlahProduk' => $jumlahProduk,
                            'nilaiPenjualan' => $nilaiPenjualan,
                            'persentase' => $persentase,
                        ];
                    }

                    // Urutkan berdasarkan nilaiPenjualan dari terbesar ke terkecil
                    usort($produkData, function ($a, $b) {
                        return $b['nilaiPenjualan'] <=> $a['nilaiPenjualan'];
                    });

                    $cumulativePercentage = 0;
                @endphp

                @foreach ($produkData as $data)
                    @php
                        $prod = $data['prod'];
                        $hargaJual = $data['hargaJual'];
                        $jumlahProduk = $data['jumlahProduk'];
                        $nilaiPenjualan = $data['nilaiPenjualan'];
                        $persentase = $data['persentase'];
                        $cumulativePercentage += $persentase;

                        // Determine the Kelas based on cumulativePercentage
                        $kelas =
                            $cumulativePercentage <= 80
                                ? 'A'
                                : ($cumulativePercentage > 80 && $cumulativePercentage <= 95
                                    ? 'B'
                                    : 'C');
                    @endphp
                    <tr class="intro-x" data-kelas="{{ $kelas }}">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $prod->produk->barcode_produk }}</td>
                        <td>{{ $prod->produk->nama_obat_barang }}</td>
                        <td>{{ $prod->produk->satuanTerkecil->satuan }}</td>
                        <td>{{ $prod->produk->golonganProduk->sub_golongan }}</td>
                        <td class="text-center">{{ $prod->produk->tipe }}</td>
                        <td>{{ number_format($hargaJual != 0 ? $hargaJual : '-', 0, ',', '.') }}</td>
                        <td class="text-center">{{ $jumlahProduk }}</td>
                        <td>{{ number_format($nilaiPenjualan, 0, ',', '.') }}</td>
                        <td class="font-bold text-center">{{ $persentase }}%</td>
                        <td class="font-bold text-center"> {{ $cumulativePercentage }}%</td>
                        <td class="font-bold text-center">{{ $kelas }}</td>
                        <td class="text-center table-report__action">
                            @if (RencanaPengadaan::where('id_perusahaan', Auth::user()->id_perusahaan)->where('tanggal', now()->toDateString())->where('sumber', 'pareto')->where('id_produk', $prod->produk->id)->first())
                                <p class="font-bold text-success">Sudah Terkirim</p>
                            @else
                                <input type="checkbox" wire:model='selectedProduk' id="checkbox-switch-1"
                                    value="{{ $prod->produk->id }}" />
                            @endif
                        </td>
                    </tr>
                @endforeach

                {{-- <tr>
                    <td colspan="8" class="font-bold text-center">Total</td>
                    <td class="font-bold">
                        {{ number_format(ProdukPenjualan::where('id_perusahaan', Auth::user()->id_perusahaan)->sum('total_modal'), 0, ',', '.') }}
                    </td>
                    <td class="font-bold">100%</td>
                    <td colspan="3" class="font-bold"></td>
                </tr> --}}
            </tbody>
        </table>
    </div>
    <!-- END: Data List -->
</div>


<script>
    document.getElementById('kelas-select').addEventListener('change', function() {
        var selectedKelas = this.value;
        var tableRows = document.querySelectorAll('#myTable tbody tr');

        tableRows.forEach(function(row) {
            var kelas = row.getAttribute('data-kelas');
            if (selectedKelas === "" || kelas === selectedKelas) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });
</script>
