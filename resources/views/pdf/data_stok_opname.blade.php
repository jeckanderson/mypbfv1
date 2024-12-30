<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 10px;
            background-color: #ffffff;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h4 {
            margin: 5px 0;
            font-size: 14px;
            color: #333;
        }

        .header p {
            margin: 5px 0;
            font-size: 12px;
            color: #666;
        }

        .stokopname {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .stokopname th,
        .stokopname td {
            border: 1px solid #bcbcbc;
            padding: 6px;
            text-align: center;
        }

        .stokopname th {
            background-color: #d3d3d3;
            color: #000000;
            font-size: 9px;
            text-transform: none;
            /* Menghapus kapitalisasi otomatis */
        }

        .stokopname td {
            font-size: 11px;
            color: #333;
        }

        .stokopname tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .stokopname tr:hover {
            background-color: #f1f1f1;
        }

        @media (max-width: 768px) {

            .stokopname th,
            .stokopname td {
                font-size: 8px;
                padding: 4px;
            }

            .header h4 {
                font-size: 12px;
            }

            .header p {
                font-size: 10px;
            }
        }
    </style>
</head>

<body>
    <div class="container">

        <div class="header">
            <h4>{{ $profile->nama_perusahaan }}</h4>
            <h4>DATA STOK OPNAME</h4>
            <p>Tanggal SO: {{ $tgl_so ? date('d-m-Y', strtotime($tgl_so)) : 'Semua Data' }}</p>
        </div>

        <table class="stokopname">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Produk</th>
                    <th>No. Batch</th>
                    <th>Exp Date</th>
                    <th>Satuan</th>
                    <th>Ready Stok</th>
                    <th>Stok Real</th>
                    <th>Selisih Stok</th>
                    <th>Nominal Selisih</th>
                    <th>Gudang</th>
                    <th>Rak</th>
                    <th>Sub Rak</th>
                    <th>Tipe</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($stokOpname as $stok)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $stok->produk->nama_obat_barang }}</td>
                        <td>{{ $stok->no_batch }}</td>
                        <td>{{ date('d/m/Y', strtotime($stok->exp_date)) }}</td>
                        <td>{{ $stok->produk->satuanTerkecil->satuan }}</td>
                        <td>{{ $stok->stok_tercatat }}</td>
                        <td>{{ $stok->stok_real }}</td>
                        <td>{{ $stok->selisih_stok }}</td>
                        <td>{{ number_format($stok->nominal_selisih, 0, ',', '.') }}</td>
                        <td>{{ $stok->gudangStok->gudang }}</td>
                        <td>{{ $stok->rakStok->rak }}</td>
                        <td>{{ $stok->subRak->sub_rak }}</td>
                        <td>{{ $stok->produk->tipe }}</td>
                        <td>{{ $stok->keterangan }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
