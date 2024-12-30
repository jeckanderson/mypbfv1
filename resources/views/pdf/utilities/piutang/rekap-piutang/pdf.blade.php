<!DOCTYPE html>
<html>

<head>
    <style>
        @page {
            size: landscape;
        }

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
    @if ($detail !== null && count($detail) > 0)
        <h1 style="text-align: center;">Lap. Rekap Piutang (Piutang Awal & Penjualan)</h1>

        <h1 style="text-align: center;">PERIODE: {{ date('d/m/Y', strtotime($mulaiId)) }} s/d
            {{ date('d/m/Y', strtotime($selesaiId)) }}</h1>

        <img src="data:image/svg+xml;base64,{{ base64_encode(file_get_contents(base_path('public/dist/pbflogo.png'))) }}"
            width="120">
        @foreach ($detail as $piutangs)
            <p style="font-size: 14px;">PT : {{ $piutangs->first()->profile->nama_perusahaan }}</p>
            <p style="font-size: 14px;">JLN: {{ $piutangs->first()->profile->alamat }}</p>
            <p style="font-size: 14px;">No. Telp: {{ $piutangs->first()->profile->no_telepon }}</p>

            <table class="analisisorder">
                <thead class="text-center">
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama Pelanggan</th>
                        <th>Jumlah Piutang</th>
                        <th>Pembayaran</th>
                        <th>Sisa Piutang</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-center intro-x">
                        <td class="border border-slate-600">{{ $loop->iteration }}</td>
                        <td class="border border-slate-600">{{ $piutangs->getPelanggan->kode }}</td>
                        <td class="border border-slate-600">{{ $piutangs->getPelanggan->nama }}</td>
                        <td class="border border-slate-600">{{ $piutangs->total_hutang }}</td>
                        <td class="border border-slate-600">{{ $piutangs->sumber }}</td>
                        <td class="border border-slate-600">{{ $piutangs->sisa_hutang }}</td>
                    </tr>
                </tbody>
            </table>
        @endforeach
    @else
        <p class="text-center">Belum Ada Data Masuk</p>
    @endif
</body>

</html>
