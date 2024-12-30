<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bukti Cek Surat Pesanan Penjualan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
            box-sizing: border-box;
        }

        header {
            text-align: center;
            padding: 10px 0;
            margin-bottom: 10px;
        }

        header h2 {
            margin: 0;
            font-size: 18px;
        }

        header p {
            margin: 5px 0;
            font-size: 14px;
        }

        .info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .info-left {
            font-size: 14px;
        }

        table.table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th,
        table.table td {
            border-bottom: 1px solid #000;
            padding: 5px;
            text-align: center;
            font-size: 12px;
        }

        footer {
            text-align: center;
            font-size: 14px;
        }

        .signatures {
            display: flex;
            justify-content: space-around;
            margin: 20px 0;
        }

        .signatures p {
            margin: 0;
            padding: 0;
            width: 30%;
        }
    </style>
</head>

<body>
    <div class="container">
        <header>
            <div style="width: 100%; background-color: gray; padding: 4px">
                <h2>BUKTI CEK SURAT PESANAN PENJUALAN</h2>
            </div>

            <p>No. Reff: {{ $sPPenjualan->no_reff }}</p>
        </header>
        <div style="margin-left: 40px">
            <b style="font-size: 14px">Tanggal , {{ $sPPenjualan->created_at->format('d-m-Y') }}</b>
            <table style="font-size: 12px">
                <tr>
                    <td>Pelanggan</td>
                    <td>:</td>
                    <td>{{ $sPPenjualan->pelangganPenjualan->nama }}</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>:</td>
                    <td>{{ $sPPenjualan->pelangganPenjualan->alamat }} {{ $sPPenjualan->pelangganPenjualan->kabupaten }}
                        {{ $sPPenjualan->pelangganPenjualan->provinsi }}</td>
                </tr>
                <tr>
                    <td>No. SP</td>
                    <td>:</td>
                    <td>{{ $sPPenjualan->no_sp }}</td>
                </tr>
                <tr>
                    <td>Tgl. SP</td>
                    <td>:</td>
                    <td>{{ date('d-m-Y', strtotime($sPPenjualan->tgl_sp)) }}</td>
                </tr>
            </table>
        </div>
        <table class="table" style="margin-top: 12px">
            <thead>
                <tr style="background-color: gray">
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Qty SP</th>
                    <th>Satuan</th>
                    <th>No. Batch</th>
                    <th>Exp. Date</th>
                    <th>Stok Real</th>
                    <th>Terpesan</th>
                    <th>Sisa stok</th>
                    <th>Qty</th>
                    <th>Gudang</th>
                    <th>Rak</th>
                    <th>Sub Rak</th>
                    <th>Cek</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sPPenjualan->produkPenjualan as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->produk->nama_obat_barang }}</td>
                        <td>{{ $item->qty_sp }}</td>
                        <td>{{ $item->satuanProduk->satuan ?? '-' }}</td>
                        <td>{{ $item->batch }}</td>
                        <td>{{ date('d-m-Y', strtotime($item->exp_date)) }}</td>
                        <td>{{ $item->stok ?? 0 }}</td>
                        <td>{{ $item->terpesan ?? 0 }}</td>
                        <td>{{ ($item->stok ?? 0) - ($item->terpesan ?? 0) }}</td>
                        <td>{{ $item->qty ?? 0 }}</td>
                        <td>{{ $item->getGudang->gudang ?? '-' }}</td>
                        <td>{{ $item->getRak->rak ?? '-' }}</td>
                        <td>{{ $item->getSubRak->sub_rak ?? '-' }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                @endforeach

            </tbody>
        </table>
        <footer style="width: 100%;position: fixed; bottom:0">
            <table style="width: 100%">
                <tr>
                    <td>Checker</td>
                    <td>Ka. Gudang</td>
                    <td>Apoteker</td>
                </tr>
                <tr>
                    <td style="height: 100px"></td>
                    <td style="height: 100px"></td>
                    <td style="height: 100px"></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    {{-- <td>
                        Apt. Andi F noya, S. Farm <br />
                        SIPA. 097542789017639
                    </td> --}}
                </tr>
            </table>
        </footer>
    </div>
</body>

</html>
