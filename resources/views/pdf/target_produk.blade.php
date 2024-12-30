<!DOCTYPE html>
<html>

<head>
    <style>
        #targetproduk {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #targetproduk td,
        #targetproduk th {
            border: 1px solid #ddd;
            padding: 2px;
            font-size: 10px;
        }

        #targetproduk tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #targetproduk tr:hover {
            background-color: #ddd;
        }



        #targetproduk p {
            font-size: 12px;
            /* Menetapkan font size paragraf menjadi 12px */
        }
    </style>
</head>

<body>
    <h4 style="text-align: center;margin: 0;padding: 0;">{{ $profile->nama_perusahaan }}</h4>
    <h4 style="text-align: center;margin: 0;padding: 0;">Target Produk</h4>


    <table id="targetproduk">
        @if ($targetProduk)
            <tr>
                <td>Bulan: {{ $targetProduk->bulan }}</td>
                <td>Tahun: {{ $targetProduk->tahun }}</td>
            </tr>
        @endif

        <tr>
            <td class="border border-slate-600 whitespace-nowrap">Barcode</td>
            <td class="border border-slate-600 whitespace-nowrap">Nama Produk</td>
            <td class="border border-slate-600 whitespace-nowrap">Satuan Terkecil</td>
            <td class="border border-slate-600 whitespace-nowrap">Status Aktif</td>
            <td class="border border-slate-600 whitespace-nowrap">Tipe</td>
            <td class="border border-slate-600 whitespace-nowrap">Target</td>
            <td class="border border-slate-600 whitespace-nowrap">Penjualan (A)</td>
            <td class="border border-slate-600 whitespace-nowrap">Retur Penjualan (B)</td>
            <td class="border border-slate-600 whitespace-nowrap">(A-B)</td>

            <td class="border border-slate-600 whitespace-nowrap">%</td>

        </tr>
        @foreach ($obatBarangs as $obatBarang)
            @php
                $penjualan = $obatBarang->produkPenjualan->count();
                $retur = $obatBarang->produkReturPenjualan->count();
                $hasil = $penjualan - $retur;
                $persentase = ($hasil / $targetProduk->target) * 100;
            @endphp
            <tr>
                <td class="border border-slate-600">
                    {{ $obatBarang->barcode_produk }}
                </td>
                <td class="border border-slate-600">{{ $obatBarang->nama_obat_barang }}</td>
                <td class="border border-slate-600">
                    {{ $obatBarang->satuanTerkecil->satuan }}
                </td>
                <td class="border border-slate-600">
                    {{ $obatBarang->status == 1 ? 'Aktif' : 'Non Aktif' }}
                </td>
                <td class="border border-slate-600">{{ $obatBarang->tipe }}</td>
                <td class="border border-slate-600">
                    {{ $targetProduk->target }}
                </td>
                <td class="border border-slate-600">
                    {{ $penjualan }}
                </td>
                <td class="border border-slate-600">
                    {{ $retur }}
                </td>
                <td class="border border-slate-600">
                    {{ $hasil }}
                </td>
                <td class="border border-slate-600 whitespace-nowrap">
                    {{ number_format($persentase, 2, ',', '.') }} %
                </td>
            </tr>
        @endforeach
    </table>

</body>

</html>
