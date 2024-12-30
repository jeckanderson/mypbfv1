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
    </style>
</head>

<body>
    @php
        use App\Models\Jurnal;
    @endphp
    <div class="container">
        <div class="sub-title">
            <h3 style="font-size: 14px; margin: 0; padding: 0">{{ $profile->nama_perusahaan }}</h3>
            <p style="margin: 0; padding: 0">{{ $profile->alamat }}</p>
            <br>
            <h3 style="margin: 0; padding: 0">LAPORAN JURNAL UMUM </h3>
            <p style="margin: 0; padding: 0">Periode:
                {{ \Carbon\Carbon::parse($dari)->translatedFormat('j-m-Y') }}
                s/d
                {{ \Carbon\Carbon::parse($sampai)->translatedFormat('j-m-Y') }}</p>
            <hr>
        </div>
        @forelse ($jurnals->groupBy('no_reff')->orderBy('created_at','desc')->paginate(10) as $get)
            <div class="invoice-hal">
                <p>
                    <b>No. Reff : {{ $get->no_reff }}</b>
                </p>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th rowspan="2">Tanggal</th>
                        <th rowspan="2">Kode Akun</th>
                        <th rowspan="2">Nama Akun</th>
                        <th rowspan="2">Keterangan</th>
                        <th colspan="2" style="text-align: center;">Saldo</th>
                    </tr>
                    <tr>
                        <th>Debet</th>
                        <th>Kredit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (Jurnal::where('id_perusahaan', Auth::user()->id_perusahaan)->where('no_reff', $get->no_reff)->get() as $jurnal)
                        <tr>
                            <td>
                                @if ($jurnal->sumber == 'Hutang Awal' || $jurnal->sumber == 'Piutang Awal' || $jurnal->sumber == 'Stok Awal')
                                    {{ $tglNeraca }}
                                @elseif($jurnal->sumber == 'Jurnal Akun')
                                    {{ DateTime::createFromFormat('Y-m-d H:i:s', $jurnal->jurnalAkun->tgl_input)->format('d-m-Y') }}
                                @elseif($jurnal->sumber == 'Mutasi Saldo')
                                    {{ DateTime::createFromFormat('Y-m-d H:i:s', $jurnal->mutasiSaldo->tgl_input)->format('d-m-Y') }}
                                @else
                                    {{ $jurnal->created_at->format('d-m-Y') }}
                                @endif
                            </td>
                            <td>{{ $jurnal->kode_akun }}</td>
                            <td>{{ $jurnal->akun->nama_akun }}</td>
                            <td>{{ $jurnal->keterangan }}</td>
                            <td>
                                {{ $jurnal->debet != 0 ? number_format(round($jurnal->debet), 0, ',', '.') : '-' }}
                            </td>
                            <td>
                                {{ $jurnal->kredit != 0 ? number_format(round($jurnal->kredit), 0, ',', '.') : '-' }}
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="4" style="text-align: center;"><b>Total</b></td>
                        <td> {{ number_format(round(Jurnal::where('id_perusahaan', Auth::user()->id_perusahaan)->where('no_reff', $get->no_reff)->sum('debet')),0,',','.') }}
                        </td>
                        <td> {{ number_format(round(Jurnal::where('id_perusahaan', Auth::user()->id_perusahaan)->where('no_reff', $get->no_reff)->sum('kredit')),0,',','.') }}
                        </td>
                    </tr>
                </tbody>
            </table>
        @endforeach
    </div>
</body>

</html>
