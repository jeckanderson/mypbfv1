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

        .note {
            flex-grow: 1;
            font-size: 12px;
            margin-left: 8pc;
        }

        .title {
            text-align: center;
            font-size: 12px;
            margin-bottom: 0;
            background-color: rgb(175, 177, 177);
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
            border: 0;
            padding: 8px;
            text-align: left;
            font-size: 10px;
        }

        .table th,
        .table td {
            border-bottom: 1px solid black;
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
        <div class="header">
            <div class="company-info" style="margin-right: 17pc;">
                <h3 style="font-size: 14px;">{{ $profile->nama_perusahaan }}</h3>
                <p style="margin: 0; padding: 0; font-weight: bold">Alamat</p>
                <p style="margin: 0; padding: 0">{{ $profile->alamat }}</p>
                <div class="company-info">
                    <table>
                        <tr>
                            <td style="font-weight: bold">No. Telepon</td>
                            <td>: {{ $profile->no_telepon }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold">No. Izin PBF</td>
                            <td>: {{ $profile->no_ijin_pbf }}</td>
                        </tr>
                        <br>
                        <p><b>
                                {{ $profile->getKabupaten->name }},
                                {{ date('d-m-Y', strtotime($jurnal->tgl_input)) }}
                            </b></p>
                        <tr>
                            <td>No. Reff </td>
                            <td>: {{ $jurnal->no_reff }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="title">
                <h2>BUKTI JURNAL UMUM</h2>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Akun</th>
                        <th>Debet</th>
                        <th>Kredit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jurnal->detail_jurnal_akun as $item)
                        <tr>
                            <td>{{ $item->akun->kode }}</td>
                            <td>{{ $item->akun->nama_akun }}</td>
                            <td>Rp. {{ number_format($item->debet, 0, ',', '.') }}</td>
                            <td>Rp. {{ number_format($item->kredit, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="2" style="text-align: center;"><b>Total</b></td>
                        <td>Rp. {{ number_format($jurnal->detail_jurnal_akun->sum('debet'), 0, ',', '.') }}</td>
                        <td>Rp. {{ number_format($jurnal->detail_jurnal_akun->sum('kredit'), 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="invoice-hal">
                <p>
                    <b>Keterangan : {{ $jurnal->keterangan }}</b>
                </p>
            </div>
            <table style="width: 100%; text-align: center; font-size: 12px;">
                <tr>
                    <td style="padding-bottom: 50px;">Dibuat Oleh</td>
                    <td style="padding-bottom: 50px;">Pimpinan</td>
                    <td style="padding-bottom: 50px;">Bag Keuangan</td>
                </tr>
                <tr>
                    <td>{{ Auth::user()->name }}</td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
        </div>
</body>

</html>
