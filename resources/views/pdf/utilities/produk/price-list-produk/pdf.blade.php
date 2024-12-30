@php
    use App\Models\HistoryStok;

    // Sort the $setharga collection by the product name
    $setharga = $setharga->sortBy(function ($sethargas) {
        return $sethargas->produk->nama_obat_barang;
    });
@endphp
<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
        }

        .pricelist {
            border-collapse: collapse;
            width: 100%;
        }

        .pricelist td,
        .pricelist th {
            border: 1px solid #ddd;
            padding: 4px;
            font-size: 10px;
        }

        .pricelist tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .pricelist tr:hover {
            background-color: #ddd;
        }

        .pricelist th {
            text-align: center;
            background-color: #ffffff;
            color: #000000;
        }

        .header-table td {
            vertical-align: top;
        }

        .header-table img {
            width: 80px;
        }

        .title {
            text-align: center;
            font-size: 12px;
            margin-top: 0;
        }

        .kelompok-info {
            font-size: 12px;
            text-align: left;
        }
    </style>
</head>

<body>
    @if ($setharga !== null && count($setharga) > 0)
        <table style="width: 96%; margin: auto" class="header-table">
            <tr>
                <td align="center" style="width: 100px">
                    <img
                        src="data:image/svg+xml;base64,{{ base64_encode(file_get_contents(base_path('public/storage/logo_perusahaan/' . $setharga->first()->profile->logo_perusahaan))) }}">
                </td>
                <td align="left">
                    <p style="font-weight: bold; margin: 0;">
                        {{ $setharga->first()->profile->nama_perusahaan }}
                    </p>
                    <p style="margin: 0;">
                        {{ $setharga->first()->profile->alamat }}
                    </p>
                    <p style="margin: 0;">
                        No. Telp: {{ $setharga->first()->profile->no_telepon }}
                    </p>
                    <p style="margin: 0;">
                        ijin PBF: {{ $setharga->first()->profile->no_ijin_pbf }}
                    </p>
                </td>
            </tr>
        </table>

        <h1 class="title">PRICE LIST PRODUK</h1>
        <p class="kelompok-info">Kelompok: {{ $setharga->first()->kelompok->kelompok }}</p>

        <table class="pricelist">
            <tr>
                <th style="width: 30px;">No</th>
                {{-- <th>Kode</th> --}}
                <th>Nama Produk</th>
                <th>Produsen</th>
                <th>Satuan</th>
                <th>Stok</th>
                <th>Harga</th>
                <th>Disc 1</th>
                <th>Disc 2</th>
                <th>HNA</th>
                <th>HNA + PPN</th>
            </tr>

            @foreach ($setharga as $sethargas)
                <tr>
                    <td align="center">{{ $loop->iteration }}</td>
                    {{-- <td align="center">{{ $sethargas->produk->barcode_produk }}</td> --}}
                    <td>{{ $sethargas->produk->nama_obat_barang }}</td>
                    <td>{{ $sethargas->produk->produsenProduk->produsen }}</td>
                    <td align="center">{{ $sethargas->satuanProduk->satuan }}</td>
                    <td align="center">
                        {{ number_format((HistoryStok::where('id_produk', $sethargas->id_produk)->sum('stok_masuk') - HistoryStok::where('id_produk', $sethargas->id_produk)->sum('stok_keluar')) / $sethargas->isi) }}
                    </td>
                    <td align="right">
                        {{ number_format($sethargas->hasil_laba, 0, ',', '.') }}
                    </td>
                    <td align="center">{{ $sethargas->disc_1 }} %</td>
                    <td align="center">{{ $sethargas->disc_2 }} %</td>
                    <td align="right">{{ number_format($sethargas->harga_jual, 0, ',', '.') }}</td>
                    <td align="right">
                        {{ number_format($sethargas->harga_jual * (1 + $setharga->first()->profile->Ppn->ppn / 100), 0, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        </table>
    @else
        <p>Belum Ada Data Masuk</p>
    @endif
</body>

</html>
