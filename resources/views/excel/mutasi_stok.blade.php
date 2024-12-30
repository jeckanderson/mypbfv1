<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=laporan-excel.xls");
?>
<table border="1" align="center">
<thead>
    @foreach ($profile as $d )
    <tr>
        <th colspan="15" align="center">{{ $d->nama_perusahaan }}</th>
    </tr>
    <tr>
        <th colspan="15" align="center">DATA MUTASI STOK</th>
    </tr>
    <tr>
        <th colspan="15" align="center">Periode : </th>
    </tr>
    @endforeach
</thead>

<tbody>
    <tr>
        <th rowspan="2">No Reff</th>
        <th rowspan="2">Tanggal</th>
        <th rowspan="2">Nama Produk</th>
        <th rowspan="2">No Batch</th>
        <th rowspan="2">Exp Date</th>
        <th rowspan="2">Satuan Terkecil</th>
        <th rowspan="2">Ket. Satuan</th>
        <th rowspan="2">Jumlah</th>
        <th colspan="3">Lokasi Sebelum</th>
        <th colspan="3">Lokasi Sesudah</th>
        <th rowspan="2">Keterangan</th>
    </tr>
    <tr>
        <th>Gudang</th>
        <th>Rak</th>
        <th>Sub Rak</th>
        <th>Gudang</th>
        <th>Rak</th>
        <th>Sub Rak</th>
    </tr>
    @foreach ($mutasiStok as $mutasi)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    {{ \Carbon\Carbon::parse($mutasi->created_at)->format('d-m-Y') }}</td>
                <td>
                    {{ $mutasi->produk->nama_obat_barang }}</td>
                <td>{{ $mutasi->stokAwal->no_batch }}
                </td>
                <td>{{ $mutasi->stokAwal->exp_date }}
                </td>
                <td>
                    {{ $mutasi->produk->satuanTerkecil->satuan }}</td>
                <td>
                    {{ $mutasi->produk->ket_satuan }}</td>
                <td>
                    {{ $mutasi->stokAwal->jumlah * $mutasi->produk->isi }} </td>
                <td>
                    {{ $mutasi->gudangSebelum->gudang }}</td>
                <td>
                    {{ $mutasi->rakSebelum->rak }}</td>
                <td>
                    {{ $mutasi->subRakSebelum->sub_rak }}</td>
                <td>
                    {{ $mutasi->gudangSesudah->gudang }}</td>
                <td>
                    {{ $mutasi->rakSesudah->rak }}</td>
                <td>
                    {{ $mutasi->subRakSesudah->sub_rak }}</td>
                <td>{{ $mutasi->keterangan }}</td>
            </tr>
        @endforeach
</tbody>
  </table>