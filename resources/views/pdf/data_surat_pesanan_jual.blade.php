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
            background-color: rgb(175, 177, 177);
        }

        .sub-title {
            text-align: center;
            font-size: 12px;
        }

        .invoice-details {
            font-size: 12px;
        }

        .invoice-hal {
            font-size: 12px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
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

        p {
            margin: 0;
            padding: 0
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="company-info">
                <table>
                    <tr>
                        <td>Nama Pelanggan</td>
                        <td>: {{ $sp->pelangganPenjualan->nama }}</td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>: {{ $sp->pelangganPenjualan->alamat }}</td>
                    </tr>
                    <tr>
                        <td>No. Telepon</td>
                        <td>: {{ $sp->pelangganPenjualan->nomor }}</td>
                    </tr>
                    <tr>
                        <td>SIA</td>
                        <td>: {{ $sp->pelangganPenjualan->no_sia }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="title">
            <h2>BUKTI SURAT PESANAN PELANGGAN</h2>
        </div>
        <div class="sub-title">
            <p>No. SP : {{ $sp->no_sp }}</p>
            <p>Tanggal SP : {{ date('d-m-Y', strtotime($sp->tgl_sp)) }}</p>
        </div>
        <div class="header">
            <div class="company-info" style="margin-right: 17pc;">
                <table>
                    <tr>
                        <td><b>Kepada</b></td>
                    </tr>
                    <tr>
                        <td style="white-space: nowrap">Nama Perusahaan</td>
                        <td>: {{ $profile->nama_perusahaan }}</td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>: {{ $profile->alamat }}</td>
                    </tr>
                    <tr>
                        <td>No. Telepon</td>
                        <td>: {{ $profile->no_telepon }}</td>
                    </tr>
                    <tr>
                        <td>No. Izin PBF</td>
                        <td>: {{ $profile->no_ijin_pbf }}</td>
                    </tr>
                </table>
            </div>

            <div class="company-info" style="margin-top: 20px;">
                <table>
                    <tr>
                        <td>Rayon</td>
                        <td>: {{ $sp->ketSales->rayon->area_rayon }}</td>
                    </tr>
                    <tr>
                        <td>Sub Rayon</td>
                        <td>: {{ $sp->ketSales->subRayon->sub_rayon }}</td>
                    </tr>
                    <tr>
                        <td>Sales</td>
                        <td>: {{ $sp->salesPenjualan->nama_pegawai }}</td>
                    </tr>
                    <tr>
                        <td>Tipe SP</td>
                        <td>: {{ $sp->tipe_sp }}</td>
                    </tr>
                </table>
            </div>

        </div>
        <br>
        <div class="invoice-hal">
            <p>Mohon dikirimkan produk dibawah ini :</p>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Jumlah</th>
                    <th>Satuan</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <!-- Detail pemesanan -->
                @foreach ($sp->produkPenjualan as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->produk->nama_obat_barang }}</td>
                        <td>{{ $item->qty_sp }}</td>
                        <td>{{ $item->satuanProduk->satuan }}</td>
                        <td>{{ $sp->keterangan ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <br>
        <table style="width: 100%; text-align: center; font-size: 12px;">
            <tr>
                <td style="padding-bottom: 50px;">Cheker</td>
                <td style="padding-bottom: 50px;">Ka Gudang</td>
                <td style="padding-bottom: 50px;">Apoteker</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>{{ $profile->apoteker }}</td>
            </tr>
        </table>
    </div>
</body>

</html>
