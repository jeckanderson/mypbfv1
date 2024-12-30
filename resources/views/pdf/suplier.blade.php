<!DOCTYPE html>
<html>
<head>
<style>
.suplier {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

.suplier td, .suplier th {
  border: 1px solid #ddd;
  padding: 2px;
  font-size: 10px;
}

.suplier tr:nth-child(even){background-color: #f2f2f2;}

.suplier tr:hover {background-color: #ddd;}


</style>
</head>
<body>
@foreach ($profile as $d )
    <h4 style="text-align: center;margin: 0;padding: 0;">{{ $d->nama_perusahaan }}</h4>
@endforeach
<h5 style="text-align: center;margin: 0;padding: 0;">Data Supplier</h5>
<br>
<table class="suplier">
    <tr>
    <th class="whitespace-nowrap">Kode</th>
                        <th class="whitespace-nowrap">Kode E-Report</th>
                        <th class="whitespace-nowrap">Nama Supplier</th>
                        <th class="whitespace-nowrap">NPWP</th>
                        <th class="whitespace-nowrap">No. Telp</th>
                        <th class="whitespace-nowrap">Hutang</th>
    </tr>
    @if(count($suplier))
        @foreach ($suplier as $sup)
            <tr>
            <td class="">{{ $sup->kode }}</td>
                            <td class="">{{ $sup->kode_e_report }}</td>
                            <td class="">{{ $sup->nama_suplier }}</td>
                            <td class="">{{ $sup->npwp }}</td>
                            <td class="">{{ $sup->no_telepon }}</td>
                            <td class="">Rp. {{ number_format($sup->hutangs->sum('sisa_hutang'), 0, ',', '.') }}</td>
                               
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="7">Belum Ada Data Masuk</td>
        </tr>
    @endif
</table>

</body>
</html>
