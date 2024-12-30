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
    @php
    use App\Models\AkunAkutansi;
    use App\Models\Jurnal;
    @endphp
    <div class="container">
        <div class="sub-title">
            <h3 style="font-size: 14px; margin: 0; padding: 0">{{ $profile->nama_perusahaan }}</h3>
            <p style="margin: 0; padding: 0">{{ $profile->alamat }}</p>
            <br>
            <h3 style="margin: 0; padding: 0">LAPORAN BUKU BESAR </h3>
            <p style="margin: 0; padding: 0">Periode:
                {{ \Carbon\Carbon::parse($dari)->translatedFormat('j-m-Y') }}
                s/d
                {{ \Carbon\Carbon::parse($sampai)->translatedFormat('j-m-Y') }}
            </p>
            <hr>
        </div>
        @forelse ($akuns as $akun)
        <div class="invoice-hal">
            <p>
                <b>{{ $akun->kode }} | {{ $akun->nama_akun }}</b>
            </p>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th rowspan="2">No. Reff</th>
                    <th rowspan="2">Tanggal</th>
                    <th rowspan="2">Keterangan</th>
                    <th colspan="2" style="text-align: center;">Saldo</th>
                </tr>
                <tr>
                    <th>Debet</th>
                    <th>Kredit</th>
                </tr>
            </thead>
            <tbody>
                @php
                $jurnals = Jurnal::where('kode_akun', $akun->kode)
                ->where('id_perusahaan', Auth::user()->id_perusahaan)
                ->whereBetween('created_at', [$dari, $sampai])
                ->get();
                @endphp
                <!-- Detail transaksi -->
                @forelse ($jurnals as $jurnal)
                <tr class="text-center">
                    <td>{{ $jurnal->no_reff }}</td>
                    <td>{{ $jurnal->created_at->format('d-m-Y') }}</td>
                    <td>{{ $jurnal->keterangan }}</td>
                    <td>{{ $jurnal->debet != 0 ? number_format(round($jurnal->debet), 0, ',', '.') : '-' }}</td>
                    <td>{{ $jurnal->kredit != 0 ? number_format(round($jurnal->kredit), 0, ',', '.') : '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Tidak ada data</td>
                </tr>
                @endforelse
                <!-- Baris total -->
                <tr>
                    <td colspan="3" style="text-align: center;"><b>Total</b></td>
                    <td>{{ number_format(round($jurnals->sum('debet')), 0, ',', '.') }}</td>
                    <td>{{ number_format(round($jurnals->sum('kredit')), 0, ',', '.') }}</td>
                </tr>
                <!-- Baris saldo akhir -->
                <tr>
                    <td colspan="3" style="text-align: center;"><b>Saldo Akhir</b></td>
                    @php
                    $debetSum = round($jurnals->sum('debet'));
                    $kreditSum = round($jurnals->sum('kredit'));
                    $saldoAkhir = $debetSum - $kreditSum;
                    @endphp
                    <td>{{ number_format($saldoAkhir, 0, ',', '.') }}</td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        @endforeach
    </div>
</body>

</html>