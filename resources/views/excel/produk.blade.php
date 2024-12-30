<?php
header('Content-type: application/vnd-ms-excel');
header('Content-Disposition: attachment; filename=laporan-excel.xls');
?>
<table border="1" align="center">
    <thead>
        <tr>
            @foreach ($profile as $d)
                <th colspan="16" align="center">{{ $d->nama_perusahaan }}</th>
            @endforeach
        </tr>
        <tr>
            <th colspan="16" align="center">DATA PRODUK</th>
        </tr>
        <tr>
            <th>Barcode</th>
            <th>Produk</th>
            <th>Kategori</th>
            <th>Golongan</th>
            <th>Jenis Produk</th>
            <th>Satuan Beli</th>
            <th>Isi</th>
            <th>Satuan Terkecil</th>
            <th>Produsen</th>
            <th>Tipe</th>
            <th>NIE</th>
            <th>Kode E-report</th>
            <th>Komposisi</th>
            <th>Zat Aktif</th>
            <th>Bentuk Kekuatan</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($obat_barang->sortBy('nama_obat_barang') as $barang)
            <tr>
                <td>{{ $barang->barcode_produk }}</td>
                <td>{{ $barang->nama_obat_barang }}</td>
                <td>{{ $barang->kelompok->golongan }}</td>
                <td>{{ $barang->golonganProduk->sub_golongan }}</td>
                <td>{{ $barang->jenis_obat_barang }}</td>
                <td>{{ $barang->satuanDasar->satuan }}</td>
                <td>{{ $barang->isi }}</td>
                <td>{{ $barang->satuanTerkecil->satuan }}</td>
                <td>{{ $barang->produsenProduk->produsen }}</td>
                <td>{{ $barang->tipe }}</td>
                <td>{{ $barang->no_ijin_edar }}</td>
                <td>{{ $barang->kode_obat_barang }}</td>
                <td>{{ $barang->komposisi }}</td>
                <td>{{ $barang->zat_aktif }}</td>
                <td>{{ $barang->bentuk_kekuatan }}</td>
                <td>{{ $barang->status == 1 ? 'Aktif' : 'Tidak Aktif' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
