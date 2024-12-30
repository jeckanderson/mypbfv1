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
            <h4>BUKTI INPUT PEMBELIAN</h4>
        </div>
        <div class="sub-title">
            <p style="margin: 0; padding: 0">No. Reff : {{ $pembelian->no_reff }}</p>
            <p style="margin: 0; padding: 0">Tanggal : {{ date('d-m-Y', strtotime($pembelian->tgl_input)) }}</p>
        </div>
        <div class="header">
            <div class="company-info">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="width: 20%;">Nama Supplier</td>
                        <td style="width: 80%;">: {{ $pembelian->getSuplier->nama_suplier }}</td>
                    </tr>
                    <tr>
                        <td style="width: 20%;">No. Faktur</td>
                        <td style="width: 80%;">: {{ $pembelian->no_faktur }}</td>
                    </tr>
                    <tr>
                        <td style="width: 20%;">Tgl Faktur</td>
                        <td style="width: 80%;">: {{ date('d-m-Y', strtotime($pembelian->tgl_faktur)) }}</td>
                    </tr>
                    <tr>
                        <td style="width: 20%;">Tgl Tempo</td>
                        <td style="width: 80%;">: {{ date('d-m-Y', strtotime($pembelian->tempo_kredit)) }}</td>
                    </tr>
                </table>
            </div>

        </div>
        <table class="table">
            <thead>
                <tr>
                    <th style="text-align: center">No</th>
                    <th style="text-align: center">Nama Produk</th>
                    <th style="text-align: center">Satuan</th>
                    <th style="text-align: center">Qty SP</th>
                    <th style="text-align: center">Qty Faktur</th>
                    <th style="text-align: center">Harga</th>
                    <th style="text-align: center">Disc 1</th>
                    <th style="text-align: center">Disc 2</th>
                    <th style="text-align: center">Total</th>
                </tr>
            </thead>
            <tbody>
                <!-- Detail pemesanan -->
                @foreach ($pembelian->produkPembelian as $prod)
                    <tr>
                        <td style="text-align: center">{{ $loop->iteration }}</td>
                        <td>{{ $prod->produk->nama_obat_barang }}</td>
                        <td style="text-align: center">{{ $prod->produk->satuanDasar->satuan }}</td>
                        <td style="text-align: center">{{ $prod->order->jumlah_order }}</td>
                        <td style="text-align: center">{{ $prod->qty_faktur }}</td>
                        <td style="text-align: right">{{ $prod->harga }}</td>
                        <td style="text-align: center">{{ $prod->disc_1 }}</td>
                        <td style="text-align: center">{{ $prod->disc_2 }}</td>
                        <td style="text-align: right">{{ number_format($prod->total, 0, ',', '.') }}</td>
                    </tr>
                @endforeach

            </tbody>
        </table>
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="border: 0; font-size: 11px">Sub total:
                    {{ number_format($pembelian->subtotal, 0, ',', '.') }}
                </td>
                <td style="border: 0;font-size: 11px">Disc: {{ number_format($pembelian->diskon, 0, ',', '.') }}</td>
                <td style="border: 0;font-size: 11px">PPN: {{ number_format($pembelian->ppn, 0, ',', '.') }}</td>
                <td style="border: 0;font-size: 11px">Biaya 1: {{ $pembelian->biaya1 }}</td>
                <td style="border: 0;font-size: 11px">Biaya 2: {{ $pembelian->biaya2 }}</td>
                <td style="border: 0;font-size: 11px">Bayar: {{ $pembelian->jumlah_bayar }}</td>
                <td style="border: 0;font-size: 11px">Total:
                    {{ number_format($pembelian->total_tagihan, 0, ',', '.') }}</td>
            </tr>
        </table>
        <br>
        <table style="width: 100%; text-align: center; font-size: 12px;">
            <tr>
                <td style="padding-bottom: 50px;">Dibuat Oleh</td>
                <td style="padding-bottom: 50px;">Mengetahui</td>
                <td style="padding-bottom: 50px;">Apoteker</td>
            </tr>
            <tr>
                <td>{{ Auth::user()->name }}</td>
                <td>Bagian Keuangan</td>
                <td>{{ $profile->apoteker }}</td>
            </tr>
        </table>

    </div>
</body>

</html>
