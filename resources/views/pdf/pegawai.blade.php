<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
<meta charset="utf-8">
    <link href="data:image/svg+xml;base64,{{ base64_encode(file_get_contents(base_path('public/dist/pbflogo.png'))) }}" rel="shortcut icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="My PBf, sistem akutansi dan management PBF">
    <meta name="keywords" content="My PBF, member pbf, akutansi pbf, aplikasi pbf, web app">
    <meta name="author" content="Yasa Maulana">

    <title>MYPbf - Pegawai</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
    #pegawai {
      font-family: Arial, Helvetica, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }

    #pegawai td,
    #pegawai th {
      border: 1px solid #ddd;
      padding: 2px;
      font-size: 8px;
    }


    #pegawai th {
      padding-top: 5px;
      padding-bottom: 5px;
      text-align: left;
      background-color: #FFFFFF;
      color: black;
    }
  </style>
</head>

<body>
  @php
  $perusahaan = App\Models\Profile::where('id', Auth::user()->id_perusahaan)->first()->nama_perusahaan;

  @endphp
  <h4 style="text-align: center;margin:0;padding:0">{{ $perusahaan }}</h4>
  <h5 style="text-align: center;margin:0;padding:0">Data Pegawai</h5>
  <br>
  <table id="pegawai">
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
    @if($pegawais)
    @foreach ($pegawais as $pegawai)
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
    @else
    <tr>
      <td colspan="9">Belum Ada Data Masuk</td>
    </tr>
    @endif
  </table>

</body>

</html>