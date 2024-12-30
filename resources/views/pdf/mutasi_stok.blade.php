<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 20px;
            color: #333;
        }

        h5 {
            text-align: center;
            margin: 5px 0;
            padding: 0;
            font-weight: normal;
            font-size: 16px;
        }

        #mutasistok {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        #mutasistok th,
        #mutasistok td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 10px;
        }

        #mutasistok th {
            background-color: #f4f4f4;
            text-align: left;
            padding-top: 10px;
            padding-bottom: 10px;
        }

        #mutasistok tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        #mutasistok tr:hover {
            background-color: #eaeaea;
        }
    </style>
</head>

<body>
    @foreach ($profile as $d)
        <h5>{{ $d->nama_perusahaan }}</h5>
        <h5>Data Mutasi Stok</h5>
        <h5>
            Periode: {{ \Carbon\Carbon::parse($tanggalMulai)->translatedFormat('j-m-Y') }}
            s/d {{ \Carbon\Carbon::parse($tanggalAkhir)->translatedFormat('j-m-Y') }}
        </h5>
    @endforeach

    <table id="mutasistok">
        <thead>
            <tr>
                <th rowspan="2">No Reff</th>
                <th rowspan="2">Tanggal</th>
                <th rowspan="2">Nama Produk</th>
                <th rowspan="2">No Batch</th>
                <th rowspan="2">Exp Date</th>
                <th rowspan="2">Satuan Terkecil</th>
                <th rowspan="2">Ket. Satuan</th>
                <th rowspan="2">Jumlah</th>
                <th colspan="3">Lokasi Sebelum</th>
                <th colspan="3">Lokasi Sesudah</th>
                <th rowspan="2">Keterangan</th>
            </tr>
            <tr>
                <th>Gudang</th>
                <th>Rak</th>
                <th>Sub Rak</th>
                <th>Gudang</th>
                <th>Rak</th>
                <th>Sub Rak</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($mutasiStok->sortBy('produk.nama_obat_barang') as $mutasi)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($mutasi->created_at)->format('d-m-Y') }}</td>
                    <td>{{ $mutasi->produk->nama_obat_barang }}</td>
                    <td>{{ $mutasi->history->no_batch }}</td>
                    <td>{{ $mutasi->history->exp_date }}</td>
                    <td>{{ $mutasi->produk->satuanTerkecil->satuan }}</td>
                    <td>{{ $mutasi->produk->ket_satuan }}</td>
                    <td>{{ $mutasi->jumlah_mutasi }}</td>
                    <td>{{ $mutasi->gudangSebelum->gudang }}</td>
                    <td>{{ $mutasi->rakSebelum->rak }}</td>
                    <td>{{ $mutasi->subRakSebelum->sub_rak }}</td>
                    <td>{{ $mutasi->gudangSesudah->gudang }}</td>
                    <td>{{ $mutasi->rakSesudah->rak }}</td>
                    <td>{{ $mutasi->subRakSesudah->sub_rak }}</td>
                    <td>{{ $mutasi->keterangan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
