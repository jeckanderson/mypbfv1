<!DOCTYPE html>
<html>

<head>
    <style>
        .produk {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        .produk td,
        .produk th {
            border: 1px solid #ddd;
            padding: 2px;
            font-size: 8px;
        }

        .produk tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .produk tr:hover {
            background-color: #ddd;
        }

        .produk th {
            padding-top: 4px;
            padding-bottom: 4px;
            text-align: center;
            background-color: #FFFFFF;
            color: black;
        }
    </style>
</head>

<body>
    @foreach ($profile as $d)
        <h4 style="text-align: center;margin: 0;padding: 0;">{{ $d->nama_perusahaan }}</h4>
        <h5 style="text-align: center;margin: 0;padding: 0;">Data Produk</h5>
    @endforeach
    <br>
    <table class="produk">
        <tr>
            <th>Barcode</th>
            <th>Produk</th>
            {{-- <th>Kelompok</th> --}}
            {{-- <th>Golongan</th> --}}
            <th>Jenis</th>
            <th>Produsen</th>
            {{-- <th>Tipe</th> --}}
            <th>NIE</th>
            {{-- <th>Kode E-report</th> --}}
            <th>Komposisi</th>
            <th>Zat Aktif</th>
            <th>Bentuk Kekuatan</th>
            {{-- <th>Status</th> --}}
        </tr>
        @if (count($obat_barang))
            @foreach ($obat_barang->sortBy('nama_obat_barang') as $barang)
                <tr>
                    <td>{{ $barang->barcode_produk }}</td>
                    <td>{{ $barang->nama_obat_barang }}</td>
                    {{-- <td>{{ $barang->kelompok->golongan }}</td> --}}
                    {{-- <td>{{ $barang->golonganProduk->sub_golongan }}</td> --}}
                    <td>{{ $barang->jenis_obat_barang }}</td>
                    <td>{{ $barang->produsenProduk?->produsen ?? '-' }}</td>
                    {{-- <td>{{ $barang->tipe }}</td> --}}
                    <td>{{ $barang->no_ijin_edar }}</td>
                    {{-- <td>{{ $barang->kode_obat_barang }}</td> --}}
                    <td>{{ $barang->komposisi }}</td>
                    <td>{{ $barang->zat_aktif }}</td>
                    <td>{{ $barang->bentuk_kekuatan }}</td>
                    {{-- <td>{{ $barang->status == 1 ? 'Aktif' : 'Tidak Aktif' }}</td> --}}
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="11">Belum Ada Data Masuk</td>
            </tr>
        @endif
    </table>
</body>

</html>
