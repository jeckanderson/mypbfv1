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

        .barcode {
            display: inline-block;
        }
    </style>
</head>

<body>
    @php
        use Picqer\Barcode\BarcodeGeneratorHTML;
        $generator = new BarcodeGeneratorHTML();
    @endphp
    <div class="container">
        <div class="title">
            <h2 style="text-decoration-line: underline;">
                @if (request()->get('status') == 'true')
                    TANDA TERIMA
                @endif SURAT JALAN
            </h2>
            <div class="barcode">
                @if ($surat->no_reff)
                    {!! $generator->getBarcode($surat->no_reff, $generator::TYPE_CODE_128) !!}
                @endif
            </div>
        </div>
        <div class="sub-title">
            <p>No. Reff : {{ $surat->no_reff }}</p>
            <p>Tanggal : {{ date('d-m-Y', strtotime($surat->tanggal)) }}</p>
            <img src="" alt="barcode" style="max-width: 100%;">
        </div>
        <div class="header">
            <div class="company-info" style="margin-right: 17pc;">
                <table>
                    <tr>
                        <td colspan="2">
                            <h3 style="font-size: 14px;">{{ $profile->nama_perusahaan }}</h3>
                        </td>
                    </tr>
                    <p style="margin: 0; padding: 0; font-weight: bold">Alamat</p>
                    <p style="margin: 0; padding: 0">{{ $profile->alamat }}</p>
                    <br>
                    <tr>
                        <td style="font-weight: bold">No. Telepon</td>
                        <td>: {{ $profile->no_telepon }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold">No. Izin PBF</td>
                        <td>: {{ $profile->no_ijin_pbf }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold">Pengirim</td>
                        <td>: {{ $surat->getSales->nama_pegawai }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Ekspedisi </td>
                        <td style="white-space: nowrap">: {{ $surat->getEkspedisi->nama_ekspedisi }} |
                            {{ $surat->getEkspedisi->nomor }}</td>
                    </tr>
                </table>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No. Faktur</th>
                    <th>Tgl. Faktur</th>
                    <th>Pelanggan</th>
                    <th>Sales</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <!-- Detail pemesanan -->
                @foreach ($surat->detailSuratJalan as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->penjualan->no_faktur }}</td>
                        <td>{{ date('d-m-Y', strtotime($item->penjualan->tgl_faktur)) }}</td>
                        <td>{{ $item->penjualan->getPelanggan->nama }}</td>
                        <td>{{ $item->penjualan->getSales->nama_pegawai }}</td>
                        <td>{{ number_format($item->penjualan->total_tagihan, 0, ',', '.') }}</td>
                        <td>
                            @if (request()->get('status') == 'true')
                                {{ $item->status == 1 ? 'Terkirim' : 'Tidak Terkirim' }}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="company-info">
            <p><b>Keterangan : {{ $surat->keterangan }}</b></p>
        </div>
        <br>
        <table style="width: 100%; text-align: center; font-size: 12px;">
            <tr>
                <td style="padding-bottom: 50px;">Dibuat Oleh</td>
                <td style="padding-bottom: 50px;">Pengirim</td>
                <td style="padding-bottom: 50px;">Apoteker</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>{{ Auth::user()->name }}</td>
                <td>{{ $surat->getSales->nama_pegawai }}</td>
                <td>{{ $profile->apoteker }}</td>
            </tr>
        </table>
    </div>
</body>

</html>
