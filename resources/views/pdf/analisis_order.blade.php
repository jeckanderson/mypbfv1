<!DOCTYPE html>
<html>

<head>
    <style>
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
            background-color: #0704aa;
            color: white;
        }
    </style>
</head>

<body>
    @foreach ($profile as $d)
        <h4 style="text-align: center">{{ $d->nama_perusahaan }}</h4>
    @endforeach
    <h4 style="text-align: center">Data Analisis Order
        <br>
        <p style="text-align: center">Periode :</p>
    </h4>
    <p style="text-align: center"> Analisis : 3 Bulan</p>

    <table class="analisisorder">
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Nama Produk</th>
            <th>Satuan Beli</th>
            <th>Isi</th>
            <th>Satuan Terkecil</th>
            <th>Stok Saat ini</th>
            <th>Stok Terjual</th>
            <th>Stok Ideal Perbulan</th>
            <th>Status</th>
            <th>Golongan</th>
            <th>Tipe</th>
        </tr>
        @if ($data !== null && count($data) > 0)
            @foreach ($data as $prod)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $prod->produk->kode_obat_barang }}</td>
                    <td>{{ $prod->produk->nama_obat_barang }}</td>
                    <td>{{ $prod->produk->satuanDasar->satuan }}</td>
                    <td>{{ $prod->produk->isi }}</td>
                    <td>{{ $prod->produk->satuanTerkecil->satuan }}</td>
                    <td>{{ $jumlah }}</td>
                    <td>{{ ProdukPenjualan::where('id_produk', $prod->id)->count() }}</td>
                    <td>{{ $stokIdeal }}</td>
                    @if ($prod->produk->stok_minimal <= $stokIdeal && $prod->produk->stok_maksimal >= $stokIdeal)
                        <td class="text-success">Stok Ideal</td>
                    @elseif ($prod->produk->stok_minimal > $stokIdeal)
                        <td class="text-warning">Under Stok</td>
                    @elseif ($prod->produk->stok_maksimal < $stokIdeal)
                        <td class="text-danger">Over Stok</td>
                    @endif
                    <td>{{ $prod->produk->golonganProduk->sub_golongan }}</td>
                    <td>{{ $prod->produk->tipe }}</td>

                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="12">Belum Ada Data Masuk</td>
            </tr>
        @endif
    </table>

</body>

</html>
