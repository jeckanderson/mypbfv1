<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=laporan-excel.xls");
use App\Models\Sales;
use App\Models\Profile;
?>
<table border="1" align="center">
  <tr>
    @foreach (Profile::get() as $d )
    <th colspan="5" align="center">{{ $d->nama_perusahaan }}</th>
    @endforeach
  </tr>
  <tr>
    <th colspan="5">DATA SALES</th>
  </tr>
  <tr>
    <th>No</th>
    <th>Nama Supervisor</th>
    <th>Sales</th>
    <th>Area Rayon</th>
    <th>Sub Rayon</th>
  </tr>
    @foreach (Sales::where('id_perusahaan', Auth::user()->id_perusahaan)->get() as $item)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item->supervisor }}</td>
        <td>{{ $item->sales }}</td>
        <td>{{ $item->area_rayon }}</td>
        <td>{{ $item->sub_rayon }}</td>
      </tr>
    @endforeach

  </table>