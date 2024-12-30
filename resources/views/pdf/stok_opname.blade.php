<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
        }

        .container {
            width: 90%;
            margin: 20px auto;
            padding: 10px;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .header h4 {
            margin: 0;
            font-size: 16px;
        }

        .header h6 {
            margin: 0;
            font-size: 12px;
            color: #555;
        }

        .stokopname {
            border-collapse: collapse;
            width: 100%;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            font-size: 10px;
        }

        .stokopname th,
        .stokopname td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
        }

        .stokopname th {
            background-color: #d3d3d3;
            color: black;
            text-align: center;
        }

        .stokopname tr:nth-child(even) {
            background-color: #ffffff;
        }

        .stokopname tr:hover {
            background-color: #f1f1f1;
        }

        .stokopname .no {
            text-align: center;
            width: 30px;
        }

        .stokopname .w-60 {
            width: 60%;
        }

        /* Responsive adjustments */
        @media screen and (max-width: 768px) {

            .stokopname th,
            .stokopname td {
                padding: 4px;
                font-size: 9px;
            }

            .header h4 {
                font-size: 14px;
            }

            .header h6 {
                font-size: 10px;
            }
        }

        @media screen and (max-width: 480px) {

            .stokopname th,
            .stokopname td {
                padding: 3px;
                font-size: 8px;
            }

            .container {
                width: 100%;
            }

            .header h4 {
                font-size: 12px;
            }

            .header h6 {
                font-size: 8px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        @foreach ($profile as $d)
            <div class="header">
                <h4>{{ $d->nama_perusahaan }}</h4>
                <h6>DATA PRODUK PRA STOK OPNAME</h6>
            </div>
        @endforeach

        <table class="stokopname">
            <tr>
                <th class="no">No</th>
                <th>Nama Produk</th>
                <th>No. Batch</th>
                <th>Exp. Date</th>
                <th>Stok</th>
                <th>Satuan</th>
                <th>Gudang</th>
                <th>Rak</th>
                <th>Sub Rak</th>
                <th>Stok Real</th>
            </tr>
            @php
                use App\Models\HistoryStok;
                $stokTerbaru = HistoryStok::select('id', DB::raw('MAX(id) as max_id'))
                    ->where('keterangan', '!=', 'Penjualan')
                    ->groupBy('id_produk', 'id_gudang', 'id_rak', 'id_sub_rak', 'no_batch')
                    ->pluck('max_id');

                $stok = HistoryStok::whereIn('id', $stokTerbaru)
                    ->where('keterangan', '!=', 'Penjualan')
                    ->with(['produk'])
                    ->get()
                    ->sortBy(function ($item) {
                        return $item->produk->nama_obat_barang;
                    });
            @endphp
            @php
                $counter = 1; // Counter manual untuk nomor urut
            @endphp

            @foreach ($stok as $history)
                @if (
                    $history->sisaStokBatch(
                        $history->id_produk,
                        $history->no_batch,
                        $history->id_gudang,
                        $history->id_rak,
                        $history->id_sub_rak) != 0)
                    <tr>
                        <td class="no">{{ $counter }}</td> <!-- Gunakan counter manual -->
                        <td class="w-auto">{{ $history->produk->nama_obat_barang }}</td>
                        <td>{{ $history->no_batch }}</td>
                        <td>{{ date('d/m/Y', strtotime($history->exp_date)) }}</td>
                        <td>{{ $history->sisaStokBatch($history->id_produk, $history->no_batch, $history->id_gudang, $history->id_rak, $history->id_sub_rak) }}
                        </td>
                        <td>{{ $history->produk->satuanTerkecil->satuan }}</td>
                        <td>{{ $history->gudang->gudang }}</td>
                        <td>{{ $history->rak->rak }}</td>
                        <td>{{ $history->subRak->sub_rak }}</td>
                        <td></td>
                    </tr>
                    @php
                        $counter++; // Increment counter hanya jika kondisi terpenuhi
                    @endphp
                @endif
            @endforeach
        </table>
    </div>
</body>

</html>
