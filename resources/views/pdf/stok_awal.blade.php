<!DOCTYPE html>
<html>

<head>
    <style>
        .stokawal {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        .stokawal td,
        .stokawal th {
            border: 1px solid #ddd;
            padding: 2px;
            font-size: 10px;
        }

        .stokawal tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .stokawal tr:hover {
            background-color: #ddd;
        }

        .stokawal th {
            padding-top: 4px;
            padding-bottom: 4px;
            text-align: center;
        }
    </style>
</head>

<body>
    @php
        use App\Models\DiskonKelompok;
    @endphp
    @foreach ($profile as $d)
        <h4 style="text-align: center">{{ $d->nama_perusahaan }}</h4>
        <h4 style="text-align: center">Data Stok Awal</h4>
    @endforeach

    <table class="stokawal">
        <tr>
            <th>No</th>
            <th>No. Reff</th>
            <th>Produk</th>
            <th>No. Batch</th>
            <th>Exp Date</th>
            <th>Satuan</th>
            <th>Jumlah</th>
            <th>HPP</th>
            <th>Total</th>
            <th>Gudang</th>
            <th>Rak</th>
            <th>Sub Rak</th>
            <th>Tipe</th>
        </tr>
        @php
            $totalStokAwal = 0; // Inisialisasi totalStokAwal
        @endphp
        @foreach ($stoks as $stokAwal)
            @php
                $hpp = str_replace('.', '', $stokAwal->hpp);
                $isi = DiskonKelompok::where('id_obat_barang', $stokAwal->id_obat_barang)
                    ->where('satuan_dasar_beli', $stokAwal->satuan)
                    ->first()->isi;
            @endphp
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $stokAwal->no_reff }}</td>
                <td>{{ $stokAwal->produk->nama_obat_barang }}</td>
                <td>{{ $stokAwal->no_batch }}</td>
                <td>{{ date('d-m-Y', strtotime($stokAwal->exp_date)) }}</td>
                <td>{{ $stokAwal->satuanStok->satuan }}</td>
                <td>{{ $stokAwal->jumlah }}</td>
                <td style="text-align: right">{{ $stokAwal->hpp }}</td>
                <td style="text-align: right">
                    {{ number_format($hpp * str_replace('.', '', $stokAwal->jumlah), 0, ',', '.') }}</td>
                <td>{{ $stokAwal->gudangStok->gudang }}</td>
                <td>{{ $stokAwal->rakStok->rak }}</td>
                <td>{{ $stokAwal->subRak->sub_rak }}</td>
                <td>{{ $stokAwal->produk->tipe }}</td>
            </tr>
            @php

                // Menghitung totalStokAwal
                $totalStokAwal += $stokAwal->jumlah * $stokAwal->hpp;
            @endphp
            @php
                $sumHppTotal = $stoks
                    ->map(function ($item) {
                        $hpp = str_replace('.', '', $item->hpp);
                        $jumlah = str_replace('.', '', $item->jumlah);
                        return $hpp * $jumlah;
                    })
                    ->sum();
            @endphp
        @endforeach
        <tr>
            <td colspan="8" align="center">TOTAL</td>
            <td style="text-align: right" id="totalStokAwal">{{ number_format($sumHppTotal, 0, ',', '.') }}</td>
            <td colspan="4"></td>
        </tr>
    </table>

</body>

</html>
