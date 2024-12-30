<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 14px;
            /* Ukuran font 14px */
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #ccc;
            padding: 20px;
            position: relative;
            /* Menambahkan posisi relatif untuk .container */
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .logo {
            max-width: 100px;
            border: 1px solid #ccc;
            padding: 5px;

        }

        .company-info {
            flex-grow: 1;
            font-size: 12px;
        }

        .title {
            text-align: center;
            font-size: 12px;
            margin-bottom: 0;
        }

        .sub-title {
            text-align: center;
            font-size: 12px;
            margin-bottom: 30px;
        }

        .invoice-details {
            margin-bottom: 30px;
            font-size: 12px;
        }

        .invoice-hal {
            margin-bottom: 10px;
            font-size: 12px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
            font-size: 10px;
        }

        .table th {
            background-color: rgb(175, 177, 177);
        }

        .footer {
            margin-top: 50px;
            margin-bottom: 60px;
            text-align: right;
            font-size: 12px;
            margin-right: 50px;
        }

        .ttd {
            font-size: 12px;
            text-align: center;
            margin-right: 20px;
        }

        .ttd-position {
            text-align: right;
            font-size: 12px;
            margin-left: 385px;
        }

        .invoice-signature {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }

        .signature-box {
            width: 45%;
            text-align: center;
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="title">
            <h2>{{ $profile->nama_perusahaan }}</h2>
            <h4 style="text-decoration-line: underline;">BUKTI INPUT RETUR PENJUALAN</h4>
        </div>
        <div class="sub-title">
            <p style="margin: 0; padding: 0">No. Reff : {{ $retur->no_reff }}</p>
            <p style="margin: 0; padding: 0">Tanggal : {{ date('d-m-Y', strtotime($retur->tgl_input)) }}</p>
        </div>
        <div class="header">
            <div class="company-info">
                <table>
                    <tr>
                        <td>Nama Pelanggan</td>
                        <td>: {{ $retur->getPelanggan->nama }}</td>
                    </tr>
                    <tr>
                        <td>No. Faktur</td>
                        <td>: {{ $retur->no_faktur }}</td>
                    </tr>
                    <tr>
                        <td>Tgl Faktur</td>
                        <td>: {{ date('d-m-Y', strtotime($retur->tgl_input)) }}</td>
                    </tr>
                    <tr>
                        <td>Tgl Tempo</td>
                        <td>: {{ date('d-m-Y', strtotime($retur->penjualan->tempo_kredit)) }}</td>
                    </tr>
                </table>
            </div>

        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Satuan</th>
                    <th>No. Batch</th>
                    <th>Exp Date</th>
                    <th>Qty Retur</th>
                    <th>Gudang</th>
                    <th>Rak</th>
                    <th>Sub Rak</th>
                </tr>
            </thead>
            <tbody>
                <!-- Detail pemesanan -->
                @foreach ($retur->produk_retur_penjualan as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->produk->nama_obat_barang }}</td>
                        <td>{{ $item->produkPenjualan->satuanProduk->satuan }}</td>
                        <td>{{ $item->produkPenjualan->batch }}</td>
                        <td>{{ date('d-m-Y', strtotime($item->produkPenjualan->exp_date)) }}</td>
                        <td>{{ $item->qty_retur }}</td>
                        <td>{{ $item->produkPenjualan->getGudang->gudang }}</td>
                        <td>{{ $item->produkPenjualan->getRak->rak }}</td>
                        <td>{{ $item->produkPenjualan->getSubRak->sub_rak }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="2"style="border: 0;"><b>DPP : {{ number_format($retur->dpp, 0, ',', '.') }}</b>
                    </td>
                    <td colspan="2"style="border: 0;"><b>PPN : {{ number_format($retur->ppn, 0, ',', '.') }}</b>
                    </td>
                    <td colspan="2"style="border: 0;"><b>Total : {{ number_format($retur->total, 0, ',', '.') }}</b>
                    </td>
                    <td colspan="3"style="border: 0;"><b>No. Pajak : {{ $retur->no_seri_pajak }}</b></td>
                </tr>
            </tbody>
        </table>
        <table style="width: 100%; text-align: center; font-size: 12px;">
            <tr>
                <td style="padding-bottom: 50px;">Dibuat Oleh</td>
                <td style="padding-bottom: 50px;">Mengetahui</td>
                <td style="padding-bottom: 50px;">Mengetahui</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>Apoteker</td>
            </tr>
            <tr>
                <td>{{ Auth::user()->name }}</td>
                <td>Ka. Gudang</td>
                <td>{{ $profile->apoteker }}</td>
            </tr>
        </table>
    </div>
</body>

</html>
