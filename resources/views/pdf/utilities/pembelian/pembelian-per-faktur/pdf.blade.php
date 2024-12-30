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
    @if ($detail !== null && count($detail) > 0)

        <h1 style="text-align: center;">Lap. Pembelian Per Faktur</h1>

        <h1 style="text-align: center;">PERIODE: {{ date('d/m/Y', strtotime($mulaiId)) }} s/d
            {{ date('d/m/Y', strtotime($selesaiId)) }}</h1>

        <img src="data:image/svg+xml;base64,{{ base64_encode(file_get_contents(base_path('public/dist/pbflogo.png'))) }}"
            width="120">
       
            <p style="font-size: 14px;">PT : {{ $detail->first()->profile->nama_perusahaan }}</p>
            <p style="font-size: 14px;">JLN: {{ $detail->first()->profile->alamat }}</p>
            <p style="font-size: 14px;">No. Telp: {{ $detail->first()->profile->no_telepon }}</p>




            <table class="analisisorder">
                <thead class="text-center">
                    <tr>
                        <th>No</th>

                        <th>Tanggal</th>

                        <th>No. Faktur</th>

                        <th>supplier</th>
                        <th>Pembayaran</th>
                        <th>DPP</th>
                        <th>PPN</th>

                        <th>Total</th>

                    </tr>
                </thead>
                @foreach ($detail as $produks)
                <tbody>

                    <tr class="text-center intro-x">

                        <td class="border border-slate-600">{{ $loop->iteration }}</td>
                        <td class="border border-slate-600">{{ $produks->pembelian->tgl_input }}</td>
                        <td class="border border-slate-600">{{ $produks->pembelian->no_faktur }}</td>
                        <td class="border border-slate-600">
                            {{ $produks->pembelian->getSuplier->nama_suplier }}</td>
                        <td class="border border-slate-600">
                            {{ $produks->pembelian->kredit == 1 ? 'CASH' : 'KREDIT' }}
                        </td>

                        <td class="border border-slate-600">{{ $produks->pembelian->dpp }}</td>
                        <td class="border border-slate-600">{{ $produks->pembelian->ppn }}</td>

                        <td class="border border-slate-600">{{ $produks->pembelian->total_tagihan }}</td>


                    </tr>

                    </tr>
        @endforeach
        </tbody>
        </table>
    @else
        <p class="text-center">Belum Ada Data Masuk</p>
    @endif

</body>

</html>
