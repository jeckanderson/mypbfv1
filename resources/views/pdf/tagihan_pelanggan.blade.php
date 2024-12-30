<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Tagihan Pelanggan</title>
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
            border: 0.1px solid #000000;
            padding: 5px;
            text-align: left;
            font-size: 10px;
        }

        .table th {
            background-color: rgb(221, 221, 221);
        }

        .footer {
            margin-top: 50px;
            margin-bottom: 30px;
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
            text-align: center;
            margin-left: 21%
        }

        p {
            font-size: 12px
        }
    </style>
</head>

<body>
    @php
        use Picqer\Barcode\BarcodeGeneratorHTML;
        $generator = new BarcodeGeneratorHTML();
        use App\Models\PiutangPengguna;
    @endphp
    <div class="container">
        <div class="title">
            <h2 style="text-decoration-line: underline;">SURAT TAGIHAN PELANGGAN</h2>
        </div>
        <div class="barcode">
            @if ($tagihan->no_reff)
                {!! $generator->getBarcode($tagihan->no_reff, $generator::TYPE_CODE_128) !!}
            @endif
        </div>
        <div class="sub-title">
            <p>No. Reff : {{ $tagihan->no_reff }}</p>
            <p>Tanggal : {{ date('d-m-Y', strtotime($tagihan->tgl_input)) }}</p>
            <img src="" alt="barcode" style="max-width: 100%;margin-left: 20pc;">
        </div>
        <div>
            <div class="header">
                <h3 style="text-align: center; font-size: 12px;">{{ $profile->nama_perusahaan }}</h3>
                <p style="margin: 0; padding: 0; font-weight: bold">Alamat :</p>
                <p style="margin: 0; padding: 0">{{ $profile->alamat }}</p>
                <div class="company-info" style="font-size: 12px;">
                    <table>
                        <tr>
                            <td style="font-weight: bold">No. Tlp</td>
                            <td>: {{ $profile->no_telepon }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold">No. Izin PBF</td>
                            <td>: {{ $profile->no_ijin_pbf }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold">Kolektor</td>
                            <td>: {{ $tagihan->getKolektor->nama_pegawai }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Area Rayon </td>
                            <td style="white-space: nowrap">: {{ $tagihan->areaRayon->area_rayon }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <table class="table" style="font-size: 12px;">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>No. Faktur</th>
                        <th>Tgl. Faktur</th>
                        <th>Tgl. JT</th>
                        <th>Umur | Hari</th>
                        <th>Pelanggan</th>
                        <th>Sales</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach (PiutangPengguna::whereIn('id', json_decode($tagihan->id_piutang))->get() as $item)
                        @php
                            $tglJt = !is_null($item->penjualan)
                                ? $item->penjualan->tempo_kredit
                                : (!is_null($item->piutangAwal)
                                    ? $item->piutangAwal->tgl_jth_tempo
                                    : null);
                            $umurHari = $tglJt ? (strtotime(date('Y-m-d')) - strtotime($tglJt)) / 86400 : 0;
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ !is_null($item->penjualan) ? $item->penjualan->no_faktur : (!is_null($item->piutangAwal) ? $item->piutangAwal->no_faktur : '') }}
                            </td>
                            <td>{{ date('d-m-Y', strtotime(!is_null($item->penjualan) ? $item->penjualan->tgl_faktur : (!is_null($item->piutangAwal) ? $item->piutangAwal->tgl_faktur : ''))) }}
                            </td>
                            <td>{{ date('d-m-Y', strtotime($tglJt)) }}</td>
                            <td>{{ round($umurHari) }} Hari</td>
                            <td>{{ $item->getPelanggan->nama }}</td>
                            <td>{{ $item->getPelanggan->salesPelanggan->nama_pegawai }}</td>
                            <td>{{ number_format($item->sisa_hutang, 0, ',', '.') ?? '-' }}</td>
                            <td></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="company-info">
                <p><b>Keterangan : {{ $tagihan->keterangan }}</b></p>
            </div>
            <table style="width: 100%; text-align: center; font-size: 12px;">
                <tr>
                    <td style="padding-bottom: 50px;">Dibuat Oleh</td>
                    <td style="padding-bottom: 50px;">Kolektor</td>
                    <td style="padding-bottom: 50px;">Bag Keuangan</td>
                    <td style="padding-bottom: 50px;">Aprove Tagihan</td>
                </tr>
                <tr>
                    <td>{{ Auth::user()->name }}</td>
                    <td>{{ $tagihan->getKolektor->nama_pegawai }}</td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
        </div>
</body>

</html>
