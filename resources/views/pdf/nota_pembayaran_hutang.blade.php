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

        .note {
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
            font-size: 12px;
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
        use App\Models\HutangPengguna;
        function terbilang($nilai)
        {
            $nilai = abs($nilai);
            $huruf = [
                '',
                'satu',
                'dua',
                'tiga',
                'empat',
                'lima',
                'enam',
                'tujuh',
                'delapan',
                'sembilan',
                'sepuluh',
                'sebelas',
            ];
            $temp = '';
            if ($nilai < 12) {
                $temp = ' ' . $huruf[$nilai];
            } elseif ($nilai < 20) {
                $temp = terbilang($nilai - 10) . ' belas';
            } elseif ($nilai < 100) {
                $temp = terbilang($nilai / 10) . ' puluh' . terbilang($nilai % 10);
            } elseif ($nilai < 200) {
                $temp = ' seratus' . terbilang($nilai - 100);
            } elseif ($nilai < 1000) {
                $temp = terbilang($nilai / 100) . ' ratus' . terbilang($nilai % 100);
            } elseif ($nilai < 2000) {
                $temp = ' seribu' . terbilang($nilai - 1000);
            } elseif ($nilai < 1000000) {
                $temp = terbilang($nilai / 1000) . ' ribu' . terbilang($nilai % 1000);
            } elseif ($nilai < 1000000000) {
                $temp = terbilang($nilai / 1000000) . ' juta' . terbilang($nilai % 1000000);
            } elseif ($nilai < 1000000000000) {
                $temp = terbilang($nilai / 1000000000) . ' milyar' . terbilang(fmod($nilai, 1000000000));
            } elseif ($nilai < 1000000000000000) {
                $temp = terbilang($nilai / 1000000000000) . ' trilyun' . terbilang(fmod($nilai, 1000000000000));
            }
            return ucwords($temp);
        }
    @endphp
    <div class="container">
        <div class="header">
            <div class="company-info" style="margin-right: 17pc;">
                <h3 style="font-size: 14px;">{{ $profile->nama_perusahaan }}</h3>
                <h4 style="margin: 0; padding: 0; font-weight: bold">Alamat</h4>
                <h4 style="margin: 0; padding: 0">{{ $profile->alamat }}</h4>
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
                    </table>
                </div>
            </div>
            <div class="company-info">
                <p><b>
                        {{ $profile->getKabupaten->name }}, {{ date('d-m-Y', strtotime($bayar->tgl_input)) }}
                    </b></p>
                <p>No. Reff : {{ $bayar->no_reff }}</p>
            </div>
        </div>
        <div class="title">
            <h2>NOTA PEMBAYARAN HUTANG</h2>
        </div>
        <div class="note">
            <table>
                <tr>
                    <td>Sudah diterimakan Kepada</td>
                    <td>: {{ $bayar->getSuplier->nama_suplier }}</td>
                </tr>
                <tr>
                    <td>Uang Sejumlah</td>
                    <td>: Rp. {{ number_format($bayar->total_bayar, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Terbilang</td>
                    <td><b>: <i>{{ terbilang($bayar->total_bayar) }} Rupiah</i></b></td>
                </tr>
                <tr>
                    <td>Untuk Pembayaran nomor faktur:</td>
                    <td>:
                        @foreach (HutangPengguna::where('id_bh', $bayar->id)->get() as $item)
                            {{ $item->sourceable ? $item->sourceable->no_faktur : '-' ?? '-' }}
                            @if (!$loop->last)
                                ,
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td>Keterangan</td>
                    <td>: {{ $bayar->keterangan }}</td>
                </tr>
            </table>

        </div>
        <br>
        <table style="width: 100%; text-align: center; font-size: 12px;">
            <tr>
                <td style="padding-bottom: 50px;">Penerima</td>
                <td style="padding-bottom: 50px;">Bag Keuangan</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
            </tr>
        </table>
    </div>
</body>

</html>