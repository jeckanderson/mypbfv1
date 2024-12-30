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
            border: 1px solid #ddd;
            /* Add border to the table */
        }

        .analisisorder td,
        .analisisorder th {
            border: 1px solid #ddd;
            /* Border for table cells */
            padding: 8px;
            /* Increase padding for better readability */
            font-size: 12px;
            text-align: center;
            /* Center align text */
        }

        .analisisorder thead th {
            background-color: #221f1f;
            color: white;
        }

        .analisisorder tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .analisisorder tr:hover {
            background-color: #ddd;
        }
    </style>
</head>

<body>
    @if ($detail !== null && count($detail) > 0)
        <h4 style="text-align: center;">Lap. Ewas Penerimaan</h4>
        <h4 style="text-align: center;">PERIODE: {{ date('d/m/Y', strtotime($mulaiId)) }}</h4>
        {{-- <img src="data:image/svg+xml;base64,{{ base64_encode(file_get_contents(base_path('public/dist/pbflogo.png'))) }}"
            width="120"> --}}
        <p style="font-size: 14px;">PT : {{ $detail->first()->profile->nama_perusahaan }}</p>
        <p style="font-size: 14px;">JLN: {{ $detail->first()->profile->alamat }}</p>
        <p style="font-size: 14px;">No. Telp: {{ $detail->first()->profile->no_telepon }}</p>

        <table class="analisisorder">
            <thead>
                <tr>
                    <th rowspan="2" class="border border-slate-600">No</th>
                    <th rowspan="2" class="border border-slate-600">Jenis Transaksi</th>
                    <th rowspan="2" class="border border-slate-600">Tanggal Masukan</th>
                    <th rowspan="2" class="border border-slate-600">Kode Obat Jadi</th>
                    <th rowspan="2" class="border border-slate-600">Jumlah Obat Jadi</th>
                    <th rowspan="2" class="border border-slate-600">Batch Obat Jadi</th>
                    <th rowspan="2" class="border border-slate-600">Tanggal Expired</th>
                    <th rowspan="2" class="border border-slate-600">Nomor Faktur</th>
                    <th rowspan="2" class="border border-slate-600">Sumber</th>
                    <th rowspan="2" class="border border-slate-600">Alamat</th>


                    <th rowspan="2" class="border border-slate-600">Keterangan/Peruntukan</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($detail as $kass)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>Dalam Negeri</td>
                        <td>{{ \Carbon\Carbon::parse($kass->pembelian->tgl_input)->format('Y-m-d') }}</td>
                        <td>{{ $kass->produk->kode_obat_bpom }}</td>
                        <td>{{ $kass->qty_faktur }}</td>
                        <td>{{ $kass->produk->kemasan }}</td>
                        <td>{{ \Carbon\Carbon::parse($kass->pembelian->tgl_faktur)->format('Y-m-d') }}</td>
                        <td>{{ $kass->pembelian->no_faktur }}</td>
                        <td>{{ $kass->pembelian->getSuplier->nama_suplier }}</td>
                        <td>{{ $kass->Pembelian->keterangan }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-center">Belum Ada Data Masuk</p>
    @endif

</body>

</html>
