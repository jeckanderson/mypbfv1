<!DOCTYPE html>
<html>

<head>
    <style>
        #targetsales {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #targetsales td,
        #targetsales th {
            border: 1px solid #ddd;
            padding: 2px;
            font-size: 10px;
        }

        #targetsales tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #targetsales tr:hover {
            background-color: #ddd;
        }



        #targetsales p {
            font-size: 12px;
            /* Menetapkan font size paragraf menjadi 12px */
        }
    </style>
</head>

<body>
    @foreach ($profile as $d)
        <h4 style="text-align: center;margin: 0;padding: 0;">{{ $d->nama_perusahaan }}</h4>
    @endforeach
    <h5 style="text-align: center;margin: 0;padding: 0;">Target Sales</h5>


    <table id="targetsales">

        @if ($target)
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="padding: 2px; text-align: left; width: 150px;">Nama Sales</td>
                    <td style="padding: 2px; text-align: left;">{{ $target->getSales->nama_pegawai }}</td>
                </tr>
                <tr>
                    <td style="padding: 2px; text-align: left;">Nama SPV</td>
                    <td style="padding: 2px; text-align: left;">{{ $target->getSupervisor->nama_pegawai }}</td>
                </tr>
                <tr>
                    <td style="padding: 2px; text-align: left;">Rayon</td>
                    <td style="padding: 2px; text-align: left;">{{ $target->rayon->area_rayon }}</td>
                </tr>
                <tr>
                    <td style="padding: 2px; text-align: left;">Sub Rayon</td>
                    <td style="padding: 2px; text-align: left;">{{ $target->subRayon->sub_rayon }}</td>
                </tr>
                <tr>
                    <td style="padding: 2px; text-align: left;">Tahun</td>
                    <td style="padding: 2px; text-align: left;">{{ $target->tahun }}</td>
                </tr>
            </table>
        @endif
        <br>
        <tr>
            <th>Bulan</th>
            <th>Target Penjualan</th>
            <th>Penjualan (A)</th>
            <th>Retur Penjualan (B)</th>
            <th>(A-B)</th>
            <th>%</th>
        </tr>
        @php
            $months = [
                'Januari',
                'Februari',
                'Maret',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Agustus',
                'September',
                'Oktober',
                'November',
                'Desember',
            ];
        @endphp
        @foreach ($months as $key => $month)
            @php
                $penjualan = $penjualans
                    ->where('sales', $target->getSales->id)
                    ->filter(function ($item) use ($key, $target) {
                        return $item->created_at->month === $key + 1 && $item->created_at->year == $target->tahun ?? '';
                    })
                    ->sum(function ($item) {
                        $cleanedTotal = str_replace('.', '', $item->total);
                        return (int) $cleanedTotal;
                    });

                $retur = $returPenjualan
                    ->where('sales', $target->getSales->id)
                    ->filter(function ($item) use ($key, $target) {
                        return $item->created_at->month === $key + 1 && $item->created_at->year == $target->tahun ?? '';
                    })
                    ->sum('dpp');

                $thisTarget = $target ? str_replace('.', '', $target->{'target_' . strtolower($month)}) : '';

                $hasil = $penjualan - $retur;
            @endphp
            <tr>
                <td>{{ $month }}</td>
                <td style="text-align: right;">
                    {{ $target ? $target->{'target_' . strtolower($month)} : '' }}
                </td>
                <td style="text-align: right;">
                    {{ number_format($penjualan, 0, ',', '.') }}
                </td>
                <td style="text-align: right;">
                    {{ number_format($retur, 0, ',', '.') }}
                </td>
                <td style="text-align: right;">
                    {{ number_format($hasil, 0, ',', '.') }}
                </td>
                <td style="text-align: center;">
                    @if ($target)
                        @if ($thisTarget > 0)
                            {{ number_format(($hasil / $thisTarget) * 100, 2, ',', '.') }}%
                        @else
                            0%
                        @endif
                    @endif
                </td>
            </tr>
        @endforeach
    </table>

</body>

</html>
