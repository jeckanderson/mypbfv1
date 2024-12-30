<!DOCTYPE html>
<html>

<head>
    <style>
        @page {
            size: landscape;
        }

        .analisisorder {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        .analisisorder td,
        .analisisorder th {
            border: 1px solid #ddd;
            padding: 2px;
            font-size: 12px;
        }

        .analisisorder tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .analisisorder tr:hover {
            background-color: #ddd;
        }

        .analisisorder th {
            padding-top: 4px;
            padding-bottom: 4px;
            text-align: center;
            background-color: #221f1f;
            color: white;
        }
    </style>
</head>

<body>
    @if ($historys !== null && count($historys) > 0)
        <h4 style="text-align: center;">Lap. E-Report</h4>

        <h4 style="text-align: center;">PERIODE: {{ date('d/m/Y', strtotime($mulaiId)) }} s/d
            {{ date('d/m/Y', strtotime($selesaiId)) }}</h4>
        <p style="font-size: 12px;">{{ $profile->nama_perusahaan }}</p>
        <p style="font-size: 12px;">{{ $profile->alamat }}</p>
        <p style="font-size: 12px;">No. Telp: {{ $profile->no_telepon }}</p>




        <table class="table mt-5">
            <thead class="text-center">
                <tr>
                    <th rowspan="2" class="border border-slate-600 whitespace-nowrap">No</th>
                    <th rowspan="2" class="border border-slate-600 whitespace-nowrap">Kode Obat</th>
                    <th rowspan="2" class="border border-slate-600 whitespace-nowrap">Nama Obat</th>
                    <th rowspan="2" class="border border-slate-600 whitespace-nowrap">Kemasan</th>
                    <th rowspan="2" class="border border-slate-600 whitespace-nowrap">Stok Awal</th>
                    <th colspan="5" class="border border-slate-600 whitespace-nowrap">Jumlah Pemasukan</th>
                    <th colspan="10" class="border border-slate-600 whitespace-nowrap">Jumlah Pengeluaran</th>
                    <th rowspan="2" class="border border-slate-600 whitespace-nowrap">HJD</th>
                </tr>
                <tr>
                    <th class="border border-slate-600 whitespace-nowrap">Masuk IF</th>
                    <th class="border border-slate-600 whitespace-nowrap">Kode IF</th>
                    <th class="border border-slate-600 whitespace-nowrap">Masuk PBF</th>
                    <th class="border border-slate-600 whitespace-nowrap">Kode PBF</th>
                    <th class="border border-slate-600 whitespace-nowrap">Retur</th>
                    <th class="border border-slate-600 whitespace-nowrap">PBF</th>
                    <th class="border border-slate-600 whitespace-nowrap">Kode PBF</th>
                    <th class="border border-slate-600 whitespace-nowrap">RS</th>
                    <th class="border border-slate-600 whitespace-nowrap">Apotek</th>
                    <th class="border border-slate-600 whitespace-nowrap">Sarana Pemerintah</th>
                    <th class="border border-slate-600 whitespace-nowrap">Puskesmas</th>
                    <th class="border border-slate-600 whitespace-nowrap">Klinik</th>
                    <th class="border border-slate-600 whitespace-nowrap">Toko Obat</th>
                    <th class="border border-slate-600 whitespace-nowrap">Lainnya</th>
                    <th class="border border-slate-600 whitespace-nowrap">Retur</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($historys as $history)
                    <tr class="text-center intro-x">
                        <td class="border border-slate-600 whitespace-nowrap">{{ $loop->iteration }}</td>
                        <td class="border border-slate-600 whitespace-nowrap">{{ $history->produk->no_ijin_edar }}
                        </td>
                        <td class="border border-slate-600 whitespace-nowrap">
                            {{ $history->produk->nama_obat_barang }}</td>
                        <td class="border border-slate-600 whitespace-nowrap">
                            {{ $history->produk->satuanTerkecil->satuan }}</td>
                        <td class="border border-slate-600 whitespace-nowrap"></td>
                        <td class="border border-slate-600 whitespace-nowrap"></td>
                        <td class="border border-slate-600 whitespace-nowrap"></td>
                        <td class="border border-slate-600 whitespace-nowrap">
                            {{ $history->produkDiterima ? $history->produkDiterima->diterima : '' }}</td>
                        <td class="border border-slate-600 whitespace-nowrap">
                            {{ $history->produkDiterima ? $history->produkDiterima->pembelian->getSuplier->kode_e_report : '' }}
                        <td class="border border-slate-600 whitespace-nowrap">
                            {{ $history->returPembelian ? $history->returPembelian->qty_retur ?? '' : '' }}
                        </td>
                        <td class="border border-slate-600 whitespace-nowrap">
                            {{ $history->pelanggan ? ($history->pelanggan->tipe == 'PBF' ? $history->produkPenjualan->qty : '') : '' }}
                        </td>
                        <td class="border border-slate-600 whitespace-nowrap">
                            {{ $history->pelanggan ? ($history->pelanggan->tipe == 'PBF' ? $history->pelanggan->kode : '') : '' }}
                        </td>
                        <td class="border border-slate-600 whitespace-nowrap">
                            {{ $history->pelanggan && $history->pelanggan->tipe == 'RS' ? $history->produkPenjualan?->qty : '' }}
                        </td>
                        <td class="border border-slate-600 whitespace-nowrap">
                            {{ $history->pelanggan && $history->pelanggan->tipe == 'Apotek' ? $history->produkPenjualan?->qty : '' }}
                        </td>

                        <td class="border border-slate-600 whitespace-nowrap">
                            {{ $history->pelanggan && $history->pelanggan->tipe == 'Sarana Pemerintah' ? $history->produkPenjualan->qty : '' }}
                        </td>
                        <td class="border border-slate-600 whitespace-nowrap">
                            {{ $history->pelanggan && $history->pelanggan->tipe == 'Puskesmas' ? $history->produkPenjualan->qty : '' }}
                        </td>
                        <td class="border border-slate-600 whitespace-nowrap">
                            {{ $history->pelanggan && $history->pelanggan->tipe == 'Klinik' ? $history->produkPenjualan?->qty : '' }}
                        </td>
                        <td class="border border-slate-600 whitespace-nowrap">
                            {{ $history->pelanggan && $history->pelanggan->tipe == 'Toko Obat' ? $history->produkPenjualan->qty : '' }}
                        </td>
                        <td class="border border-slate-600 whitespace-nowrap">
                            {{ $history->pelanggan && $history->pelanggan->tipe == 'Lainnya' ? $history->produkPenjualan->qty : '' }}
                        </td>
                        <td class="border border-slate-600 whitespace-nowrap">
                            {{ $history->retur ? $history->retur->qty_retur : '' }}
                        </td>
                        <td class="border border-slate-600 whitespace-nowrap">
                            @php
                                $ppn = App\Models\PPN::first()->ppn / 100;
                                $hpp = '';
                                if ($history->produkPenjualan) {
                                    $hpp =
                                        $history->produkPenjualan->total_modal +
                                        $history->produkPenjualan->total_modal / (1 + $ppn);
                                }
                            @endphp
                            {{ number_format(floatVal($hpp), 0, ',', '.') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="font-bold text-center border border-slate-600" colspan="21">Belum ada
                            data
                            tersedia</td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    @else
        <p class="text-center">Belum Ada Data Masuk</p>
    @endif

</body>

</html>
