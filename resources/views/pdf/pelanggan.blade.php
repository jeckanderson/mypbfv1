<!DOCTYPE html>
<html>

<head>
    <style>
        .pelanggan {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        .pelanggan td,
        .pelanggan th {
            border: 1px solid #ddd;
            padding: 2px;
            font-size: 10px;
        }

        .pelanggan tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .pelanggan tr:hover {
            background-color: #ddd;
        }
    </style>
</head>

<body>
    @foreach ($profile as $d)
        <h4 style="text-align: center;margin: 0;padding: 0;">{{ $d->nama_perusahaan }}</h4>
    @endforeach
    <h5 style="text-align: center;margin: 0;padding: 0;">Data Pelanggan</h5>
    <br>
    <table class="pelanggan">
        <tr>
            <th class="whitespace-nowrap">Kode</th>
            <th class="whitespace-nowrap">Nama Pelanggan</th>
            <th class="whitespace-nowrap">No. SIA</th>
            <th class="whitespace-nowrap">ED. SIA</th>
            <th class="whitespace-nowrap">No. Tlp</th>
            <th class="whitespace-nowrap">Apoteker</th>
            <th class="whitespace-nowrap">No. SIPA</th>
            <th class="whitespace-nowrap">ED. SIPA</th>
            <th class="whitespace-nowrap">Kelompok</th>
            <th class="whitespace-nowrap">Batas Piutang</th>
            <th class="whitespace-nowrap">Piutang</th>
        </tr>
        @if (count($pelanggans))
            @foreach ($pelanggans as $pelanggan)
                <tr>
                    <td class="">{{ $pelanggan->kode }}</td>
                    <td class="">{{ $pelanggan->nama }}</td>
                    <td class="">{{ $pelanggan->no_sia }}</td>
                    <td class="">{{ date('d-m-Y', strtotime($pelanggan->exp_date_sia)) }}</td>
                    <td class="">{{ $pelanggan->nomor }}</td>
                    <td class="">{{ $pelanggan->apoteker }}</td>
                    <td class="">{{ $pelanggan->no_sipa }}</td>
                    <td class="">{{ date('d-m-Y', strtotime($pelanggan->exp_date_sipa)) }}
                    </td>
                    <td class="">{{ $pelanggan->kelompokPelanggan->kelompok }}</td>
                    <td class="">{{ $pelanggan->batas_piutang }}</td>
                    <td class="">
                        @if ($pelanggan->piutang->isNotEmpty())
                            {{ number_format($pelanggan->piutang->last()->sisa_hutang, 0, ',', '.') }}
                        @else
                            0
                        @endif
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="13">Belum Ada Data Masuk</td>
            </tr>
        @endif
    </table>

</body>

</html>
