<!DOCTYPE html>
<html>
<head>
<style>
#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 2px;
  font-size: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
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
<h4 style="text-align: center;margin:0;padding:0">Data Sales</h4>

<table id="customers">
  <tr>
    <th>No</th>
    <th>Nama Supervisor</th>
    <th>Sales</th>
    <th>Area Rayon</th>
    <th>Sub Rayon</th>
  </tr>
  @if(count($sales))
    @foreach ($sales as $item)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item->pegawai_supervisor->nama_pegawai }}</td>
        <td>{{ $item->pegawai_sales->nama_pegawai }}</td>
        <td>{{ $item->rayon->area_rayon }}</td>
        <td>{{ $item->sub->sub_rayon }}</td>
      </tr>
    @endforeach
  @else
  <tr>
    <td colspan="5">Belum Ada Data Masuk</td>
  </tr>
  @endif
</table>

</body>
</html>