<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=laporan-excel.xls");
?>
<table border="1" align="center">
<thead>
    @foreach ($profile as $d )
    <tr>
        <th colspan="11" align="center">{{ $d->nama_perusahaan }}</th>
    </tr>
    <tr>
        <th colspan="11" align="center">DATA ANALISIS ORDER</th>
    </tr>
    <tr>
        <th colspan="11" align="center">Periode : </th>
    </tr>
    <tr>
        <th colspan="11" align="center">Analisis : 3 Bulan</th>
    </tr>
    @endforeach
</thead>

<tbody>
    <tr>
        <th>No</th>
        <th>Kode</th>
        <th>Produk</th>
        <th>Satuan Terkecil</th>
        <th>Golongan</th>
        <th>Tipe</th>
        <th>Harga Jual</th>
        <th>Item Terjual</th>
        <th>Nilai Penjualan</th>
        <th>% Komulatif</th>
        <th>Kelas</th>
    </tr>
    @if($data !== null && count($data) > 0)
        @foreach ($data as $prod)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $prod->produk->kode_obat_barang }}</td>
                <td>{{ $prod->produk->nama_obat_barang }}</td>
                <td>{{ $prod->produk->satuanTerkecil->satuan }}</td>
                <td>{{ $prod->produk->golonganProduk->sub_golongan }}</td>
                <td>{{ $prod->produk->tipe }}</td>
                <td>{{ $hargaJual != 0 ? number_format($hargaJual) : '-' }}</td>
                <td>{{ number_format(ProdukPenjualan::where('id_produk', $prod->id)->count()) }}</td>
                <td>{{ number_format($hargaJual * $jumlahProduk) }}</td>
                <td>{{ $persentase }}%</td>
                <td>@if ($persentase <= 80)
                    A
                @elseif($persentase > 80 && $persentase <= 95)
                    B
                @else
                    C
                @endif</td>

            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="11" align="center">Belum Ada Data Masuk</td>
        </tr>
    @endif
</tbody>
  </table>