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
            margin-right: 20px;
            position: absolute;
            /* Menambahkan posisi absolut */
            top: 20px;
            /* Atur jarak dari atas */
            right: 20px;
            /* Atur jarak dari kanan */
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
                <h3 style="font-size: 14px;">{{ $profile->nama_perusahaan }}</h3>
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="width: 20%;">Alamat</td>
                        <td style="width: 80%;">: {{ $profile->alamat }}</td>
                    </tr>
                    <tr>
                        <td style="width: 20%;">No. Telepon</td>
                        <td style="width: 80%;">: {{ $profile->no_telepon }}</td>
                    </tr>
                    <tr>
                        <td style="width: 20%;">No. Izin PBF</td>
                        <td style="width: 80%;">: {{ $profile->no_ijin_pbf }}</td>
                    </tr>
                </table>
            </div>

        </div>
        <div class="title">
            <h4>SURAT PESANAN OBAT MENGANDUNG OBAT-OBAT TERTENTU</h4>
        </div>
        <div class="sub-title">
            <p>No. SP : {{ $surat->no_sp }}</p>
        </div>
        <div class="invoice-details">
            <p>Yang bertanda tangan dibawah ini:</p>
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="width: 20%;">Nama</td>
                    <td style="width: 80%;">: {{ $profile->apoteker }}</td>
                </tr>
                <tr>
                    <td style="width: 20%;">Jabatan</td>
                    <td style="width: 80%;">: Apoteker Penanggung Jawab</td>
                </tr>
                <tr>
                    <td style="width: 20%;">No. SIPA</td>
                    <td style="width: 80%;">: {{ $profile->sipa }}</td>
                </tr>
                <tr>
                    <td colspan="2">Mengajukan pesanan obat mengandung Obat-Obat tertentu kepada:</td>
                </tr>
                <tr>
                    <td style="width: 20%;">Nama PBF</td>
                    <td style="width: 80%;">: {{ $rencanaOrder->first()->suplier->nama_suplier }}</td>
                </tr>
                <tr>
                    <td style="width: 20%;">Alamat</td>
                    <td style="width: 80%;">: {{ $rencanaOrder->first()->suplier->alamat }}</td>
                </tr>
                <tr>
                    <td style="width: 20%;">No. Telepon</td>
                    <td style="width: 80%;">: {{ $rencanaOrder->first()->suplier->no_telepon }}</td>
                </tr>
            </table>
        </div>

        <br>
        <div class="invoice-hal">
            <p>Jenis Obat mengandung Obat-Obat Tertentu yang dipesan adalah :</p>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th style="text-align: center">No</th>
                    <th style="text-align: center">Nama Obat</th>
                    <th style="text-align: center">Zat Aktif</th>
                    <th style="text-align: center">Bentuk dan Kekuatan</th>
                    <th style="text-align: center">Jumlah</th>
                    <th style="text-align: center">Satuan</th>
                    <th style="text-align: center">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <!-- Detail pemesanan -->
                @forelse ($rencanaOrder as $item)
                    <tr style="">
                        <td style="text-align: center">{{ $loop->iteration }}</td>
                        <td>{{ $item->produk->nama_obat_barang }}</td>
                        <td>{{ $item->produk->zat_aktif }}</td>
                        <td>{{ $item->produk->bentuk_kekuatan }}</td>
                        <td style="text-align: center">{{ $item->jumlah_order }}</td>
                        <td style="text-align: center">{{ $item->produk->satuanDasar->satuan }}</td>
                        <td>{{ $item->keterangan }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Gagal dalam pengambilan data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <br>
        <div class="invoice-details">
            <p>Obat yang mengandung Obat-Obat tertentu tersebut akan digunakan untuk memenuhi kebutuhan:</p>
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="width: 20%;">Nama PBF</td>
                    <td style="width: 80%;">: {{ $profile->nama_perusahaan }}</td>
                </tr>
                <tr>
                    <td style="width: 20%;">Alamat Lengkap</td>
                    <td style="width: 80%;">: {{ $profile->alamat }}</td>
                </tr>
                <tr>
                    <td style="width: 20%;">No. Izin PBF</td>
                    <td style="width: 80%;">: {{ $profile->no_ijin_pbf }}</td>
                </tr>
                <tr>
                    <td style="width: 20%;">No. Telepon</td>
                    <td style="width: 80%;">: {{ $profile->no_telepon }}</td>
                </tr>
            </table>
        </div>

        <div class="footer">
            <p>{{ $profile->getKabupaten->name }}, {{ date('d-m-Y', strtotime($surat->tgl_sp)) }}</p>
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
        <!-- Letakkan logo di luar .container -->
        <div class="logo">
            <img src="" alt="Logo" style="max-width: 100%;">
        </div>
    </div>
</body>

</html>
