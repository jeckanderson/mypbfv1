<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=laporan-excel.xls");
?>
<table border="1" align="center">
<thead>
  <tr>
    @foreach ($profile as $d )
    <th colspan="6" align="center">{{ $d->nama_perusahaan }}</th>
    @endforeach
  </tr>
  <tr>
    <th colspan="6" align="center">TARGET SUPERVISOR</th>
  </tr>
  @if($target)
  <tr>
      <td colspan="6">Nama SPV : {{ $target ? $target->pegawai->nama_pegawai :'' }}</td>
  </tr>
  <tr>
    <td colspan="6">Rayon : {{ $target->area_rayon }}</td>
  </tr>
  <tr>
    <td colspan="6">Tahun : {{ $target ? $target->tahun : '' }}</td>
  </tr>
  @endif
</thead>

<tbody>
  <tr>
    <th>Bulan</th>
    <th>Target Penjualan</th>
    <th>Penjualan (A)</th>
    <th>Retur Penjualan (B)</th>
    <th>(A-B)</th>
    <th>%</th>
  </tr>
  @php
  $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
  @endphp
    @foreach ($months as $month)
    <tr>
      <td>{{ $month }}</td>
      <td>{{ $target ? $target->{'target_' . strtolower($month)} : '' }}</td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    @endforeach
</tbody>
  </table>