<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Kontrabon</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 10px;
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
            border: 1px solid #000000;
            padding: 8px;
            text-align: left;
            font-size: 10px;
        }

        .table th {
            background-color: rgb(221, 221, 221);
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

        p {
            font-size: 12px
        }

        .barcode {
            text-align: center;
            margin-left: 21%
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
            <h2 style="text-decoration: underline; margin-bottom: 1;">SURAT KONTRABON</h2>
        </div>
        <div class="title">
            <h4 style="text-decoration: margin-top: 1;">TANDA TERIMA FAKTUR</h4>
        </div>

        <div class="barcode">
            @if ($kontrabon->no_reff)
                {!! $generator->getBarcode($kontrabon->no_reff, $generator::TYPE_CODE_128) !!}
            @endif
        </div>
        <div class="sub-title">
            <p>No. Reff : {{ $kontrabon->no_reff }}</p>
            <p>Tanggal : {{ date('d-m-Y', strtotime($kontrabon->tgl_input)) }}</p>
            <img src="" alt="barcode" style="max-width: 70%;margin-left: 20pc;">
        </div>
        <div>
            <div class="header">
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
                        <tr>
                            <td style="font-weight: bold">Pelanggan</td>
                            <td>: {{ $kontrabon->getPelanggan->nama }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Alamat </td>
                            <td style="white-space: nowrap">: {{ $kontrabon->getPelanggan->alamat }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold">No. Tlp </td>
                            <td>: {{ $kontrabon->getPelanggan->nomor }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <table class="table" style="font-size: 12px;">
                <thead>
                    <tr style="background-color: #f0f0f0;">
                        <th style="width: 5%;">No</th>
                        <th>No. Faktur</th>
                        <th>Tgl. Faktur</th>
                        <th>Tgl. JT</th>
                        <th>Umur | Hari</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Detail pemesanan -->
                    @foreach (PiutangPengguna::whereIn('id', json_decode($kontrabon->id_piutang))->get() as $item)
                        @php
                            $tglJT = !is_null($item->penjualan)
                                ? $item->penjualan->tempo_kredit
                                : (!is_null($item->piutangAwal)
                                    ? $item->piutangAwal->tgl_jth_tempo
                                    : null);

                            // Konversi tanggal jatuh tempo menjadi objek Carbon
                            $tglJTCarbon = $tglJT ? \Carbon\Carbon::parse($tglJT) : null;

                            // Hitung selisih hari dengan tanggal sekarang
                            $umurHari = $tglJTCarbon ? $tglJTCarbon->diffInDays(now(), false) : '';
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ !is_null($item->penjualan) ? $item->penjualan->no_faktur : (!is_null($item->piutangAwal) ? $item->piutangAwal->no_faktur : '') }}
                            </td>
                            <td>{{ date('d-m-Y', strtotime(!is_null($item->penjualan) ? $item->penjualan->tgl_faktur : (!is_null($item->piutangAwal) ? $item->piutangAwal->tgl_faktur : ''))) }}
                            </td>
                            <td>{{ date('d-m-Y', strtotime($tglJT)) }}</td>
                            <td>{{ $umurHari }} Hari</td>
                            <td>{{ number_format($item->sisa_hutang, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="5" style="text-align: center;"><b>Total</b></td>
                        <td>{{ number_format(PiutangPengguna::whereIn('id', json_decode($kontrabon->id_piutang))->get()->sum('sisa_hutang'),0,',','.') }}
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="company-info">
                <p><b>Keterangan : {{ $kontrabon->keterangan }}</b></p>
            </div>
            <br>
            <table style="width: 100%; text-align: center; font-size: 12px;">
                <tr>
                    <td style="padding-bottom: 50px;">Penerima</td>
                    <td style="padding-bottom: 50px;">Petugas</td>
                    <td style="padding-bottom: 50px;">Bag Keuangan</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>
