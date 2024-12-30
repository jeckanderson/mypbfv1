<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=laporan-excel.xls");
use App\Models\Pegawai;
use App\models\Profile;
?>
<table border="1" align="center">
  <tr>
    @foreach (Profile::get() as $d )
    <th colspan="9" align="center">{{ $d->nama_perusahaan }}</th>
    @endforeach
  </tr>
  <tr>
    <th colspan="9">DATA PEGAWAI</th>
  </tr>
    <tr>
      <th>No</th>
      <th>NIP</th>
      <th>Nama Pegawai</th>
      <th>No BPJS TK</th>
      <th>Alamat</th>
      <th>No. Telepon</th>
      <th>Jenis Kelamin</th>
      <th>Jabatan</th>
      <th>Status Pegawai</th>
    </tr>
      @foreach (Pegawai::where('id_perusahaan', Auth::user()->id_perusahaan)->get() as $pegawai)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $pegawai->nip }}</td>
            <td>{{ $pegawai->nama_pegawai }}</td>
            <td>{{ $pegawai->no_bpjs_tk }}</td>
            <td>{{ $pegawai->alamat }}</td>
            <td>{{ $pegawai->no_telepon }}</td>
            <td>{{ $pegawai->jenis_kelamin }}</td>
            <td>{{ $pegawai->jabatan }}</td>
            <td>{{ $pegawai->status == 'on' ? 'Aktif' : 'Tidak Aktif' }}</td>
        </tr>
      @endforeach
  </table>