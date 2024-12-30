<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=laporan-excel.xls");
?>
<table border="1" align="center">
<thead>
    <tr>
        @foreach ($profile as $d )
        <th colspan="7" align="center">{{ $d->nama_perusahaan }}</th>
        @endforeach
    </tr>
  <tr>
    <th colspan="7" align="center">DATA SUPPLIER</th>
  </tr>
</thead>

<tbody>
    <tr>
        <th>No</th>
        <th>Kode</th>
        <th>Kode E-report</th>
        <th>Supplier</th>
        <th>Alamat</th>
        <th>NPWP</th>
        <th>No. Tlp </th>
    </tr>
        @foreach ($suplier as $sup)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $sup->kode }}</td>
                <td>{{ $sup->kode_e_report }}</td>
                <td>{{ $sup->nama_suplier }}</td>
                <td>{{ $sup->alamat }}</td>
                <td>{{ $sup->npwp }}</td>
                <td>{{ $sup->no_telepon }}</td>    
            </tr>
        @endforeach
</tbody>
  </table>