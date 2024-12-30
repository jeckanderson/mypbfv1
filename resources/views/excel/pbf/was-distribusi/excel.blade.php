<!DOCTYPE html>
<html>

<head>
    <style>
        @page {
            size: landscape;
        }

        .ditribusi {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #ddd;
            /* Add border to the table */
        }

        .ditribusi td,
        .ditribusi th {
            border: 1px solid #ddd;
            /* Border for table cells */
            padding: 8px;
            /* Increase padding for better readability */
            font-size: 12px;
            text-align: center;
            /* Center align text */
        }

        .ditribusi thead th {
            background-color: #221f1f;
            color: white;
        }

        .ditribusi tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .ditribusi tr:hover {
            background-color: #ddd;
        }
    </style>
</head>

<body>
    @if ($detail !== null && count($detail) > 0)
        <h4 style="text-align: center;">Lap. Ewas Distribusi</h4>
        <h4 style="text-align: center;">PERIODE: {{ date('d/m/Y', strtotime($mulaiId)) }}</h4>
        {{-- <img src="data:image/svg+xml;base64,{{ base64_encode(file_get_contents(base_path('public/dist/pbflogo.png'))) }}" width="120"> --}}
        <p style="font-size: 12px;">{{ $detail->first()->profile->nama_perusahaan }}</p>
        <p style="font-size: 12px;">{{ $detail->first()->profile->alamat }}</p>
        <p style="font-size: 12px;">No. Telp: {{ $detail->first()->profile->no_telepon }}</p>

        <table class="ditribusi">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jenis Distribusi</th>
                    <th>Tanggal Distribusi</th>
                    <th>Kode Obat Jadi</th>
                    <th>Jumlah Obat Jadi</th>
                    <th>Batch Obat Jadi</th>
                    <th>Tanggal Expired</th>
                    <th>Nomor Faktur</th>
                    <th>Tujuan</th>
                    <th>Alamat</th>
                    <th>Keterangan/Peruntukan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($detail as $kass)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>Dalam Negeri</td>
                        <td>
                            {{ $kass->penjualan ? \Carbon\Carbon::parse($kass->penjualan->tgl_input)->format('Y-m-d') : '-' }}
                        </td>
                        <td>{{ $kass->produk->kode_obat_bpom }}</td>
                        <td>{{ $kass->qty }}</td>
                        <td>{{ $kass->batch }}</td>
                        <td>{{ $kass->exp_date }}</td>
                        <td>{{ $kass->penjualan?->no_faktur }}</td>
                        <td>{{ $kass->penjualan?->getPelanggan->nama }}</td>
                        <td>{{ $kass->penjualan?->getPelanggan->alamat }}</td>
                        <td>{{ $kass->Penjualan?->keterangan }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-center">Belum Ada Data Masuk</p>
    @endif
</body>

</html>
