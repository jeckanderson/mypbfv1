<!DOCTYPE html>
<html>

<head>
    <style>
        .analisispareto {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        .analisispareto td,
        .analisispareto th {
            border: 1px solid #ddd;
            padding: 2px;
            font-size: 10px;
        }

        .analisispareto tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .analisispareto tr:hover {
            background-color: #ddd;
        }

        .analisispareto th {
            padding-top: 4px;
            padding-bottom: 4px;
            text-align: center;
        }
    </style>
</head>

<body>
    @php
        use App\Models\ProdukPenjualan;
        use App\Models\RencanaPengadaan;
        use App\Models\ObatBarang;
    @endphp
    @foreach ($profile as $d)
        <h4 style="text-align: center; margin: 0; padding: 0">{{ $d->nama_perusahaan }}</h4>
    @endforeach
    <br>
    <h4 style="text-align: center; margin: 0; padding: 0">Data Analisis ABC</h4>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Periode</title>
        <style>
            body {
                font-family: 'Arial', sans-serif;
            }

            .periode-text {
                text-align: center;
                margin: 0;
                padding: 0;
                font-size: 0.8em;
                font-weight: bold;
                color: #333;
                letter-spacing: 0.5px;
            }
        </style>
    </head>

    <body>
        <p class="periode-text">
            Periode:
            {{ \Carbon\Carbon::parse($tanggalMulai)->translatedFormat('j-m-Y') }}
            s/d
            {{ \Carbon\Carbon::parse($tanggalAkhir)->translatedFormat('j-m-Y') }}
        </p>
    </body>

    <br>

    <table class="analisispareto">
        <tr>
            <th class="whitespace-nowrap">No</th>
            <th class="whitespace-nowrap">Barcode</th>
            <th class="whitespace-nowrap">Produk</th>
            <th class="whitespace-nowrap">Satuan</th>
            <th class="whitespace-nowrap">Golongan</th>
            <th class="whitespace-nowrap">Tipe</th>
            <th class="whitespace-nowrap">Harga Jual</th>
            <th class="whitespace-nowrap">Jumlah Terjual</th>
            <th class="whitespace-nowrap">Nilai Penjualan</th>
            <th class="whitespace-nowrap">Persentase</th>
            <th class="whitespace-nowrap">Kumulatif</th>
            <th class="whitespace-nowrap">Kelas</th>
        </tr>
        @php
            $cumulativePercentage = 0;
        @endphp

        @forelse ($produkPenjualan as $key => $prod)
            @php
                $jumlahProduk = ProdukPenjualan::where('id_produk', $prod->produk->id)->count();
                $totalHarga = ProdukPenjualan::where('id_produk', $prod->produk->id)->sum('total_modal');
                $hargaJual = $jumlahProduk != 0 && $totalHarga != 0 ? $totalHarga / $jumlahProduk : 0;
                if ($hargaJual != 0) {
                    $persentase = round(
                        ($totalHarga /
                            ProdukPenjualan::where('id_perusahaan', Auth::user()->id_perusahaan)->sum('total_modal')) *
                            100,
                    );
                } else {
                    $persentase = 0;
                }

                $jumlahProduk = ProdukPenjualan::where('id_produk', $prod->id_produk)->count();
                $jumlahIsi = $prod->produk->isi * $jumlahProduk;

                $cumulativePercentage += $persentase;
            @endphp
            <tr class="intro-x">
                <td class="">{{ $loop->iteration }}</td>
                <td class="">{{ $prod->produk->barcode_produk }}</td>
                <td class="">{{ $prod->produk->nama_obat_barang }}</td>
                <td class="">{{ $prod->produk->satuanTerkecil->satuan }}</td>
                <td class="">{{ $prod->produk->golonganProduk->sub_golongan }}</td>
                <td class="">{{ $prod->produk->tipe }}</td>
                <td style="text-align: right">
                    {{ number_format(($hargaJual != 0 ? $hargaJual : '-') / $jumlahIsi, 0, ',', '.') }}
                </td>
                <td style="text-align: center">
                    {{ $jumlahIsi }}
                </td>
                <td style="text-align: right">
                    {{ number_format($hargaJual * $jumlahProduk, 0, ',', '.') }}
                </td>
                <td style="text-align: center">
                    {{ $persentase }}%
                </td>
                <td style="text-align: center">
                    {{ $cumulativePercentage }}%
                </td>
                <td style="text-align: center">
                    @if ($cumulativePercentage <= 80)
                        A
                    @elseif($cumulativePercentage > 80 && $cumulativePercentage <= 95)
                        B
                    @else
                        C
                    @endif
                </td>
            </tr>
        @empty
            <tr class="intro-x">
                <td class="font-bold text-center" colspan="13">Belum ada data penjualan tersedia</td>
            </tr>
        @endforelse

        <tr>
            <td colspan="8" class="font-bold text-center">Total</td>
            <td style="text-align: right">
                {{ number_format(ProdukPenjualan::where('id_perusahaan', Auth::user()->id_perusahaan)->sum('total_modal'), 0, ',', '.') }}
            </td>
            <td style="text-align: center">100%</td>
            <td colspan="3" class="font-bold"></td>
        </tr>
    </table>

</body>

</html>
