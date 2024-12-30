<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=laporan-excel.xls");
?>
<table border="1" align="center">
<thead>
  <tr>
    @foreach ($profile as $d )
    <th colspan="13" align="center">{{ $d->nama_perusahaan }}</th>
    @endforeach
  </tr>
  <tr>
    <th colspan="13" align="center">STOK AWAL</th>
  </tr>
</thead>

<tbody>
    <tr>
        <th>No</th>
        <th>No. Reff</th>
        <th>Produk</th>
        <th>No. Batch</th>
        <th>Exp Date</th>
        <th>Satuan</th>
        <th>Jumlah</th>
        <th>HPP</th>
        <th>Total</th>
        <th>Gudang</th>
        <th>Rak</th>
        <th>Sub Rak</th>
        <th>Tipe</th>
      </tr>
      @php
      $totalStokAwal = 0; // Inisialisasi totalStokAwal
  @endphp
  @foreach ($stoks as $stokAwal)
      <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $stokAwal->no_reff }}</td>
          <td>{{ $stokAwal->produk->nama_obat_barang }}</td>
          <td>{{ $stokAwal->no_batch }}</td>
          <td>{{ date('d-m-Y', strtotime($stokAwal->exp_date)) }}</td>
          <td>{{ $stokAwal->satuanStok->satuan }}</td>
          <td>{{ $stokAwal->jumlah }}</td>
          <td>{{ $stokAwal->hpp }}</td>
          <td>{{ $stokAwal->jumlah * $stokAwal->hpp }}</td>
          <td>{{ $stokAwal->gudangStok->gudang }}</td>
          <td>{{ $stokAwal->rakStok->rak }}</td>
          <td>{{ $stokAwal->subRak->sub_rak }}</td>
          <td>{{ $stokAwal->produk->tipe }}</td>
      </tr>
      @php
          // Menghitung totalStokAwal
          $totalStokAwal += $stokAwal->jumlah * $stokAwal->hpp;
      @endphp
  @endforeach
  <tr>
      <td colspan="8" align="center">TOTAL</td>
      <td align="center" id="totalStokAwal">{{ $totalStokAwal }}</td>
      <td colspan="4"></td>
  </tr>
</tbody>
  </table>