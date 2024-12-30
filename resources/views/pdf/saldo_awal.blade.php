<!DOCTYPE html>
<html>
<head>
<style>
.saldoawal {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

.saldoawal td, .saldoawal th {
  border: 1px solid #ddd;
  padding: 2px;
  font-size: 12px;
}

.saldoawal tr:nth-child(even){background-color: #f2f2f2;}

.saldoawal tr:hover {background-color: #ddd;}

.saldoawal th {
  padding-top: 4px;
  padding-bottom: 4px;
  text-align: center;
  background-color: #0704aa;
  color: white;
}
</style>
</head>
<body>
@foreach ($profile as $d)
<h4 style="text-align: center">{{ $d->nama_perusahaan }}</h4>
<h4 style="text-align: center">DATA NERAC AWAL
    <br> <p style="text-align: center">Periode : {{ $d->tgl_neraca_awal }}</p>
</h4>
@endforeach

<table class="saldoawal">
    <thead>
        <tr>
            <th colspan="3" style="background-color: #d8d8e4;text-align: left; color:black;"><strong>AKTIVA</strong></th>
        </tr>
        <tr>
            <th>Kode</th>
            <th>Nama Akun</th>
            <th>Saldo</th>
        </tr>
        @php
            $totalAktiva = 0;
        @endphp
        @foreach ($akunAktiva as $item)
                <tr>
                    <td>{{ $item->kode }}</td>
                    <td>{{ $item->nama_akun }}</td>
                    <td>Rp. {{ number_format($item->saldoAwal->saldo ?? 0) }}</td>
                </tr>
            @php
                $totalAktiva += $item->saldoAwal->saldo ?? 0;
            @endphp
        @endforeach
        <tr>
            <td colspan="2"> Total</td>
            <td>{{ 'Rp. ' . number_format($totalAktiva) }}</td>
        </tr>
    </thead>
    <br>
    <tbody>
        <tr>
            <th colspan="3" style="background-color: #d8d8e4;text-align: left; color:black;"><strong>PASIVA</strong></th>
        </tr>
        <tr>
            <th>Kode</th>
            <th>Nama Akun</th>
            <th>Saldo</th>
        </tr>
        @php
            $totalPasiva = 0;
        @endphp
        @foreach ($akunPasiva as $itemPasiva)
                <tr>
                    <td>{{ $itemPasiva->kode }}</td>
                    <td>{{ $itemPasiva->nama_akun }}</td>
                    <td>Rp. {{ number_format($itemPasiva->saldoAwal->saldo ?? 0) }}</td>
                </tr>
            @php
                $totalPasiva += $itemPasiva->saldoAwal->saldo ?? 0;
            @endphp
        @endforeach
            <tr>
                <td colspan="2"> Total</td>
                <td>{{ 'Rp. ' . number_format($totalPasiva) }}</td>
            </tr>
    </tbody>
</table>

</body>
</html>
