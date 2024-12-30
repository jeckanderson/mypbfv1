<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @page {
            size: landscape;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 20px;
        }

        .report-title {
            text-align: center;
            margin-bottom: 10px;
        }

        .header-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 10px;
        }

        .header-info p {
            margin: 0;
        }

        .table-container {
            overflow-x: auto;
        }

        .analisisorder {
            width: 100%;
            border-collapse: collapse;
        }

        .analisisorder th,
        .analisisorder td {
            border: 1px solid #ddd;
            padding: 2px;
            font-size: 8px;
            text-align: center;
        }

        .analisisorder th {
            background-color: #f2f2f2;
            color: #333;
        }

        .analisisorder tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .analisisorder tr:hover {
            background-color: #f1f1f1;
        }

        @media (max-width: 768px) {
            .header-info {
                flex-direction: column;
                align-items: flex-start;
            }

            .header-info p {
                margin-bottom: 5px;
            }

            .analisisorder th,
            .analisisorder td {
                font-size: 8px;
                padding: 4px;
            }
        }
    </style>
</head>

<body>
    @if ($penjualan !== null && count($penjualan) > 0)
        <div class="report-title">
            <h5>LAP. REKAP PENJUALAN</h5>
            <h5>Periode: {{ date('d/m/Y', strtotime($mulaiId)) }} s/d {{ date('d/m/Y', strtotime($selesaiId)) }}</h5>
        </div>

        <div class="header-info">
            <p>{{ $penjualan->first()->profile->nama_perusahaan }}</p>
            <p>{{ $penjualan->first()->profile->alamat }}</p>
            <p>No. Telp: {{ $penjualan->first()->profile->no_telepon }}</p>
        </div>

        <div class="table-container">
            <table class="analisisorder">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>No. Faktur</th>
                        <th>Pelanggan</th>
                        <th>Sales</th>
                        <th>Sub Total</th>
                        {{-- <th>Disc %</th>
                        <th>Disc Nominal</th> --}}
                        <th>DPP</th>
                        <th>PPN</th>
                        <th>Total</th>
                        <th>Biaya 1</th>
                        <th>Biaya 2</th>
                        <th>Total Tagihan</th>
                        <th>Jumlah Bayar</th>
                        <th>Piutang</th>
                        <th>Pembayaran</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penjualan as $penjualans)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ date('d-m-Y', strtotime($penjualans->tgl_input)) }}</td>
                            <td>{{ $penjualans->no_faktur }}</td>
                            <td>{{ $penjualans->getPelanggan->nama }}</td>
                            <td>{{ $penjualans->getSales->nama_pegawai }}</td>
                            <td>{{ number_format($penjualans->subtotal, 0, ',', '.') }}</td>
                            {{-- <td>{{ $penjualans->diskon }}</td>
                            <td>{{ $penjualans->hasil_diskon }}</td> --}}
                            <td>{{ number_format($penjualans->dpp, 0, ',', '.') }}</td>
                            <td>{{ number_format($penjualans->ppn, 0, ',', '.') }}</td>
                            <td>{{ number_format($penjualans->ppn + $penjualans->dpp, 0, ',', '.') }}</td>
                            <td>{{ number_format($penjualans->biaya1, 0, ',', '.') }}</td>
                            <td>{{ number_format($penjualans->biaya2, 0, ',', '.') }}</td>
                            <td>{{ number_format($penjualans->total_tagihan, 0, ',', '.') }}</td>
                            <td>{{ number_format($penjualan->sum('jumlah_bayar'), 0, ',', '.') }}</td>
                            <td>{{ number_format($penjualans->total_hutang, 0, ',', '.') }}</td>
                            <td>{{ $penjualans->kredit == 0 ? 'Cash' : 'Kredit' }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6"><strong>Total</strong></td>
                        <td>{{ number_format($penjualan->sum('dpp'), 0, ',', '.') }}</td>
                        <td>{{ number_format($penjualan->sum('ppn'), 0, ',', '.') }}</td>
                        <td>{{ number_format($penjualan->sum('ppn') + $penjualan->sum('dpp'), 0, ',', '.') }}</td>
                        <td>{{ number_format($penjualan->sum('biaya1'), 0, ',', '.') }}</td>
                        <td>{{ number_format($penjualan->sum('biaya2'), 0, ',', '.') }}</td>
                        <td>{{ number_format($penjualan->sum('total_tagihan'), 0, ',', '.') }}</td>
                        <td>{{ number_format($penjualan->sum('jumlah_bayar'), 0, ',', '.') }}</td>
                        <td>{{ number_format($penjualan->sum('total_hutang'), 0, ',', '.') }}</td>
                        <td colspan="2"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    @else
        <p class="text-center">Belum Ada Data Masuk</p>
    @endif

</body>

</html>
