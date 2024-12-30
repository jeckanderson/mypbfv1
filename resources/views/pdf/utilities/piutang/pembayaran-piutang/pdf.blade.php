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
    <h1 style="text-align: center;">LAP. PEMBAYARAN PIUTANG</h1>

    <h1 style="text-align: center;">PERIODE: {{ date('d/m/Y', strtotime($mulaiId)) }} s/d
        {{ date('d/m/Y', strtotime($selesaiId)) }}</h1>

    <img src="data:image/svg+xml;base64,{{ base64_encode(file_get_contents(base_path('public/dist/pbflogo.png'))) }}"
        width="120">
    <p style="font-size: 14px;">PT : {{ $profile->nama_perusahaan }}</p>
    <p style="font-size: 14px;">JLN: {{ $profile->alamat }}</p>
    <p style="font-size: 14px;">No. Telp: {{ $profile->no_telepon }}</p>




    <table class="analisisorder">
        <thead class="text-center">
            <tr>
                <th>No</th>
                <th>Tgl. Faktur</th>
                <th>No. Faktur</th>
                <th>Tgl. Bayar</th>
                <th>No. Reff</th>
                <th>Akun Bayar</th>
                <th>Jumlah Bayar</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($detail as $piutangs)
                <tr class="text-center intro-x">

                    <td class="border border-slate-600">{{ $loop->iteration }}</td>
                    <td class="border border-slate-600">{{ $piutangs->penjualan->tgl_faktur }}</td>

                    <td class="border border-slate-600">
                        {{ $piutangs->penjualan->no_faktur }}</td>
                    <td class="border border-slate-600">{{ $piutangs->penjualan->tgl_input }}</td>
                    <td class="border border-slate-600">{{ $piutangs->bayar->no_reff }}</td>
                    <td class="border border-slate-600">{{ $piutangs->bayar->akun->jenis_akun }}</td>
                    <td class="border border-slate-600">{{ $piutangs->nominal_bayar }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
