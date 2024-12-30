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
            <h4 style="text-decoration-line: underline;">BUKTI INPUT TERIMA BARANG</h4>
            <div class="sub-title">
                <p style="margin: 0; padding: 0">No. Reff : {{ $terima->no_reff }}</p>
                <p style="margin: 0; padding: 0">Tanggal : {{ date('d-m-Y', strtotime($terima->tanggal)) }}</p>
            </div>
        </div>
        <div class="header">
            <div class="company-info">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="width: 20%;">Nama Supplier</td>
                        <td style="width: 80%;">: {{ $terima->pembelian->getSuplier->nama_suplier }}</td>
                    </tr>
                    <tr>
                        <td style="width: 20%;">No. Faktur</td>
                        <td style="width: 80%;">: {{ $terima->pembelian->no_faktur }}</td>
                    </tr>
                    <tr>
                        <td style="width: 20%;">Tgl Faktur</td>
                        <td style="width: 80%;">: {{ date('d-m-Y', strtotime($terima->pembelian->tgl_faktur)) }}</td>
                    </tr>
                    <tr>
                        <td style="width: 20%;">Tgl Tempo</td>
                        <td style="width: 80%;">: {{ date('d-m-Y', strtotime($terima->pembelian->tempo_kredit)) }}</td>
                    </tr>
                </table>
            </div>
        </div>
        <br>
        <table class="table">
            <table style="width: 100%; font-size: 8px;"></table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Satuan</th>
                    <th>Qty Faktur</th>
                    <th>Qty Diterima</th>
                    <th>No. Batch</th>
                    <th>Exp Date</th>
                    <th>Gudang</th>
                    <th>Rak</th>
                    <th>Sub Rak</th>
                </tr>
            </thead>
            <tbody>
                <!-- Detail pemesanan -->
                @foreach ($terima->produkDiterima as $item)
                    <tr style="width: 100%; text-align: center; font-size: 8px;">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->produk->nama_obat_barang }}</td>
                        <td>{{ $item->produk->satuanDasar->satuan }}</td>
                        <td>{{ $item->diterimaToPembelian->order->jumlah_order }}</td>
                        <td>{{ $item->diterima }}</td>
                        <td>{{ $item->no_batch }}</td>
                        <td>{{ date('d-m-Y', strtotime($item->tgl_exp_date)) }}</td>
                        <td>{{ $item->gudangStok->gudang }}</td>
                        <td>{{ $item->rakStok->rak }}</td>
                        <td>{{ $item->subRak->sub_rak }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <p style="font-size: 12px">Jumlah : {{ $terima->produkDiterima->count() }}</p>
        <p style="font-size: 12px">Keterangan : {{ $terima->keterangan }}</p>
        <table style="width: 100%; text-align: center; font-size: 12px;">
            <tr>
                <td style="padding-bottom: 50px;">Dibuat Oleh</td>
                <td style="padding-bottom: 50px;">Mengetahui</td>
                <td style="padding-bottom: 50px;">Apoteker</td>
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
