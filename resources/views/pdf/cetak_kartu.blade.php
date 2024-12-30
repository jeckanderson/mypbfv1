<!DOCTYPE html>
<html>

<head>
    <style>
        .cetakkartu {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        p {
            margin: 0;
            padding: 0;
            font-size: 12px;
        }

        .cetakkartu td,
        .cetakkartu th {
            border: 1px solid #ddd;
            padding: 2px;
            font-size: 10px;
        }

        .cetakkartu tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .cetakkartu tr:hover {
            background-color: #ddd;
        }

        .cetakkartu th {
            padding: 2px;
            text-align: center;
        }

        h4 {
            margin: 0;
            padding: 0;
            text-align: center;
        }
    </style>
</head>

<body>
    @foreach ($profile as $d)
        <h4>{{ $d->nama_perusahaan }}</h4>
        <h4>KARTU STOK</h4>
    @endforeach
    <br>
    @if ($historys)
        <p><span style="display:inline-block; width:150px;">Nama Produk</span>:
            {{ $historys->first()->produk->nama_obat_barang }}</p>
        <p><span style="display:inline-block; width:150px;">Gudang</span>: {{ $historys->first()->gudang->gudang }}</p>
        <p><span style="display:inline-block; width:150px;">Rak</span>: {{ $historys->first()->rak->rak }}</p>
        <p><span style="display:inline-block; width:150px;">Sub Rak</span>: {{ $historys->first()->subRak->sub_rak }}</p>
        <p><span style="display:inline-block; width:150px;">Tipe</span>: {{ $historys->first()->produk->tipe }}</p>
        <p><span style="display:inline-block; width:150px;">Satuan</span>:
            {{ $historys->first()->produk->satuanTerkecil->satuan }}</p>
        <p><span style="display:inline-block; width:150px;">Ket Satuan</span>:
            {{ $historys->first()->produk->ket_satuan }}
        </p>
    @endif

    <br>

    <table class="cetakkartu">
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>No. Reff</th>
            <th>No. Faktur</th>
            <th>Supplier/Pelanggan</th>
            <th>No. Batch</th>
            <th>Exp Date</th>
            <th>Stok Masuk</th>
            <th>Stok Keluar</th>
            {{-- <th>Sisa Stok</th> --}}
            {{-- <th>Gudang</th> --}}
            <th>Keterangan</th>
        </tr>
        @foreach ($historys as $histori)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $histori->created_at->format('d-m-Y') }}</td>
                <td>{{ $histori->no_reff }}</td>
                <td>{{ $histori->no_faktur }}</td>
                <td>
                    @if ($histori->keterangan == 'Pembelian')
                        {{ $histori->suplier->nama_suplier }}
                    @elseif($histori->keterangan == 'Penjualan')
                        {{ $histori->pelanggan->nama }}
                    @elseif($histori->keterangan == 'Retur Pembelian')
                        {{ $histori->suplier->nama_suplier }}
                    @elseif($histori->keterangan == 'Retur Penjualan')
                        {{ $histori->pelanggan->nama }}
                    @else
                        -
                    @endif
                </td>
                <td>{{ $histori->no_batch }}</td>
                <td>{{ $histori->exp_date }}</td>
                <td>{{ $histori->stok_masuk }}</td>
                <td>{{ $histori->stok_keluar }}</td>
                {{-- <td>{{ $histori->stok_masuk - $histori->stok_keluar }}</td> --}}
                {{-- <td>{{ $historys->first()->gudang->gudang }}</td> --}}
                <td>{{ $histori->keterangan }}</td>
            </tr>
        @endforeach
        <tr class="font-bold text-center">
            <td class="border border-slate-600" colspan="7">Total</td>
            <td class="border border-slate-600 total-stok-masuk">{{ $historys->sum('stok_masuk') }}</td>
            <td class="border border-slate-600 total-stok-masuk">{{ $historys->sum('stok_keluar') }}
            </td>
            <td class="border border-slate-600"></td>
        </tr>
        <tr class="font-bold text-center">
            <td class="border border-slate-600" colspan="7">Sisa Stok Tersedia</td>
            <td class="border border-slate-600" colspan="3">
                {{ $historys->sum('stok_masuk') - $historys->sum('stok_keluar') }}</td>
        </tr>
    </table>

</body>

</html>
