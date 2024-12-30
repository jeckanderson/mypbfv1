<?php
header('Content-type: application/vnd-ms-excel');
header('Content-Disposition: attachment; filename=laporan-excel.xls');
?>
<table border="1" align="center">
    @foreach ($profile as $d)
        <tr>
            <th colspan="10" align="center">{{ $d->nama_perusahaan }}</th>
        </tr>
        <tr>
            <th colspan="10" align="center">KARTU STOK</th>
        </tr>
    @endforeach
    @if ($historys)
        <thead align="left">
            <tr>
                <td colspan="10">Nama Produk : {{ $historys->first()->produk->nama_obat_barang }}</td>
            </tr>
            <tr>
                <td colspan="10">Gudang : {{ $historys->first()->gudang->gudang }}</td>
            </tr>
            <tr>
                <td colspan="10">Rak : {{ $historys->first()->rak->rak }}</td>
            </tr>
            <tr>
                <td colspan="10">Sub Rak : {{ $historys->first()->subRak->sub_rak }}</td>
            </tr>
            <tr>
                <td colspan="10">Tipe : {{ $historys->first()->produk->tipe }}</td>
            </tr>
            <tr>
                <td colspan="10">Satuan Terkecil : {{ $historys->first()->produk->satuanTerkecil->satuan }}</td>
            </tr>
            <tr>
                <td colspan="10">Satuan : {{ $historys->first()->produk->ket_satuan }}</td>
            </tr>
    @endif
    </thead>

    <tbody>

        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>No. Reff</th>
            <th>No. Faktur</th>
            <th>Supplier / Pelanggan</th>
            <th>No. Bacth</th>
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
                {{-- <td>{{ $histori->stok_masuk - $histori->stok_keluar }}</td>
                <td>{{ $historys->first()->gudang->gudang }}</td> --}}
                <td>{{ $histori->keterangan }}</td>
            </tr>
        @endforeach
        <tr class="font-bold text-center">
            <td colspan="7">Total</td>
            <td>{{ $historys->sum('stok_masuk') }}</td>
            <td>{{ $historys->sum('stok_keluar') }}
            </td>
            <td></td>
        </tr>
        <tr class="font-bold text-center">
            <td colspan="7">Sisa Stok Tersedia</td>
            <td>
                {{ $historys->sum('stok_masuk') - $historys->sum('stok_keluar') }}</td>
        </tr>
    </tbody>
</table>
