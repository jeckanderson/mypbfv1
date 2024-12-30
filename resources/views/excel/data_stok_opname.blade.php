<?php
header('Content-type: application/vnd-ms-excel');
header('Content-Disposition: attachment; filename=laporan-excel.xls');
?>
<table border="1" align="center">
    <thead>
        <tr>
            <th colspan="14" align="center">{{ $profile->nama_perusahaan }}</th>
        </tr>
        <tr>
            <th colspan="14" align="center">DATA STOK OPNAME</th>
        </tr>
        <tr>
            <th colspan="14" align="center">Periode :
                {{ $tgl_so ? date('d-m-Y', strtotime($tgl_so)) : 'Semua Data' }}</th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <th>No</th>
            <th>Produk</th>
            <th>No. Bacth</th>
            <th>Exp Date</th>
            <th>Satuan Terkecil</th>
            <th>Stok Tercatat</th>
            <th>Stok Real</th>
            <th>Selisih Stok</th>
            <th>Nominal Selisih</th>
            <th>Gudang</th>
            <th>Rak</th>
            <th>Sub Rak</th>
            <th>Tipe</th>
            <th>Keterangan</th>
        </tr>
        @foreach ($stokOpname as $stok)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $stok->produk->nama_obat_barang }}</td>
                <td>{{ $stok->no_batch }}</td>
                <td>{{ $stok->exp_date }}</td>
                <td>{{ $stok->produk->satuanTerkecil->satuan }}</td>
                <td>{{ $stok->stok_tercatat }}</td>
                <td>{{ $stok->stok_real }}</td>
                <td>{{ $stok->selisih_stok }}</td>
                <td>{{ number_format($stok->nominal_selisih, 0, ',', '.') }}</td>
                <td>{{ $stok->gudangStok->gudang }}</td>
                <td>{{ $stok->rakStok->rak }}</td>
                <td>{{ $stok->subRak->sub_rak }}</td>
                <td>{{ $stok->produk->tipe }}</td>
                <td>{{ $stok->keterangan }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
