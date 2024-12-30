<!DOCTYPE html>
<html>

<head>
    <style>
        .analisisorder {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        .analisisorder td,
        .analisisorder th {
            border: 1px solid #ddd;
            padding: 2px;
            font-size: 12px;
        }

        .analisisorder tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .analisisorder tr:hover {
            background-color: #ddd;
        }

        .analisisorder th {
            padding-top: 4px;
            padding-bottom: 4px;
            text-align: center;
            background-color: #221f1f;
            color: white;
        }
    </style>
</head>

<body>
    @if ($penjualan !== null && count($penjualan) > 0)
        <h1 style="text-align: center;">Lap. Penjualan Per Faktur</h1>

        <h1 style="text-align: center; margin-bottom: 20px;">
            PERIODE: {{ date('d/m/Y', strtotime($mulaiId)) }} s/d {{ date('d/m/Y', strtotime($selesaiId)) }}
        </h1>
        
        <img src="data:image/svg+xml;base64,{{ base64_encode(file_get_contents(base_path('public/dist/pbflogo.png'))) }}"
            width="120">
        <p style="font-size: 14px;">PT : {{ $penjualan->first()->profile->nama_perusahaan }}</p>
        <p style="font-size: 14px;">JLN: {{ $penjualan->first()->profile->alamat }}</p>
        <p style="font-size: 14px;">No. Telp: {{ $penjualan->first()->profile->no_telepon }}</p>


        <table class="analisisorder">
            <thead class="text-center">
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>No. Faktur</th>
                    <th>Pelanggan</th>
                    <th>Sales</th>

                    <th>DPP </th>
                    <th>PPN</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($penjualan as $penjualans)
                    <tr class="text-center intro-x">
                        <td class="border border-slate-600">{{ $loop->iteration }}</td>
                        <td class="border border-slate-600">{{ $penjualans->tgl_input }}</td>
                        <td class="border border-slate-600">{{ $penjualans->no_faktur }}</td>
                        <td class="border border-slate-600">{{ $penjualans->getPelanggan->nama }}</td>
                        <td class="border border-slate-600">{{ $penjualans->getSales->nama_pegawai }}</td>

                        <td class="border border-slate-600">{{ $penjualans->dpp }}</td>
                        <td class="border border-slate-600">{{ $penjualans->ppn }}</td>
                        <td class="border border-slate-600">
                            {{ number_format($penjualans->ppn + $penjualans->dpp, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="text-center">
                    <td colspan="5" class="border border-slate-600">Total</td>


                    <td class="border border-slate-600">{{ $penjualan->sum('dpp') }}</td>
                    <td class="border border-slate-600">{{ $penjualan->sum('ppn') }}</td>
                    <td class="border border-slate-600">
                        {{ number_format($penjualans->ppn + $penjualans->dpp, 0, ',', '.') }}</td>

                    <td colspan="7" class="border border-slate-600"></td>
                </tr>
            </tfoot>

        </table>
    @else
        <p class="text-center">Belum Ada Data Masuk</p>
    @endif

</body>

</html>
