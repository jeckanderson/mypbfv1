<?php
header('Content-type: application/vnd-ms-excel');
header('Content-Disposition: attachment; filename=laporan-excel.xls');
?>
<table border="1" align="center">
    <thead>
        <tr>
            @foreach ($profile as $d)
                <th colspan="13" align="center">{{ $d->nama_perusahaan }}</th>
            @endforeach
        </tr>
        <tr>
            <th colspan="13" align="center">DATA PELANGGAN</th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Kode E-report</th>
            <th>Supplier</th>
            <th>No. SIA</th>
            <th>ED SIA</th>
            <th>No. Tlp </th>
            <th>Apoteker </th>
            <th>No. SIPA</th>
            <th>ED SIPA</th>
            <th>Kelompok</th>
            <th>Batas Piutang</th>
            <th>Jumlah Piutang</th>
        </tr>
        @foreach ($pelanggans as $pelanggan)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $pelanggan->kode }}</td>
                <td>{{ $pelanggan->kode_e_report }}</td>
                <td></td>
                <td>{{ $pelanggan->no_sia }}</td>
                <td>{{ date('d-m-Y', strtotime($pelanggan->exp_date_sia)) }}</td>
                <td>{{ $pelanggan->nomor }}</td>
                <td>{{ $pelanggan->apoteker }}</td>
                <td>{{ $pelanggan->no_sipa }}</td>
                <td>{{ date('d-m-Y', strtotime($pelanggan->exp_date_sipa)) }}</td>
                <td>{{ $pelanggan->kelompokPelanggan->kelompok }}</td>
                <td>{{ $pelanggan->batas_piutang }}</td>
                <td>{{ $pelanggan->jumlah_piutang }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
