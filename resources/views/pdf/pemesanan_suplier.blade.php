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
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo-container {
            display: flex;
            align-items: center;
        }

        .logo {
            max-width: 100px;
            border: 1px solid #ccc;
            padding: 5px;
            margin-right: 20px;
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
            font-size: 10px;
            margin-right: 50px;
        }

        .ttd {
            font-size: 10px;
            text-align: center;
            margin-right: 0px;
        }

        .ttd-position {
            text-align: right;
            font-size: 10px;
            margin-left: 385px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="company-info">
                <h3 style="font-size: 14px;">{{ $profile->nama_perusahaan }}</h3>
                <div style="font-size: 12px; padding: 0; margin: 0">
                    <p style="padding: 0; margin: 0">Alamat : {{ $profile->alamat }}</p>
                    <p style="padding: 0; margin: 0">No. Telepon : {{ $profile->no_telepon }}</p>
                    <p style="padding: 0; margin: 0">No. Izin PBF : {{ $profile->no_ijin_pbf }}</p>
                </div>
            </div>
        </div>
        <div class="title">
            <h4>SURAT PESANAN</h4>
        </div>
        @if ($surat)
            <div style="font-size: 12px; text-align: center; padding: 0; margin: 0">
                <p style="padding: 0; margin: 0">No. SP : {{ $surat->no_sp }}</p>
                <p style="padding: 0; margin: 0">Tanggal SP : {{ $surat->tgl_sp }}</p>
            </div>
            <div class="invoice-details">
                <p><strong>Kepada</strong></p>
                <p>{{ $surat->suplier->nama_suplier }}</p>
                <p style="padding: 0; margin: 0">{{ $surat->suplier->alamat }}</p>
                <p style="padding: 0; margin: 0">No.Tlp : {{ $surat->suplier->no_telepon }}</p>
            </div>
            <div class="invoice-hal">
                <p>Mohon dikirimkan produk dibawah ini :</p>
            </div>
            <table class="table text-center">
                <thead>
                    <tr>
                        <th style="text-align: center">No</th>
                        <th style="text-align: center">Nama Produk</th>
                        <th style="text-align: center">Jumlah</th>
                        <th style="text-align: center">Satuan</th>
                        <th style="text-align: center">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rencanaOrder as $item)
                        <tr>
                            <td style="text-align: center">{{ $loop->iteration }}</td>
                            <td>{{ $item->produk->nama_obat_barang }}</td>
                            <td style="text-align: center">{{ $item->jumlah_order }}</td>
                            <td style="text-align: center">{{ $item->produk->satuanDasar->satuan }}</td>
                            <td>{{ $item->keterangan }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Gagal dalam pengambilan data</td>
                        </tr>
                    @endforelse
                    <!-- Detail pemesanan -->
                </tbody>
            </table>
        @endif
        <div class="footer">
            <p>Apoteker Penanggung Jawab</p>
        </div>
        <br>
        <br>
        <br>
        <div class="ttd-position">
            <div class="ttd">
                <p>{{ $profile->apoteker }}</p>
                <p>SIPA. {{ $profile->sipa }}</p>
            </div>
        </div>
    </div>
</body>

</html>
