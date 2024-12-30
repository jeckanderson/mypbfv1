<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=laporan-excel.xls");
?>
<table border="1" align="center">
<thead>
    @foreach ($profile as $d )
    <tr>
        <th colspan="3" align="center">{{ $d->nama_perusahaan }}</th>
    </tr>
    <tr>
        <th colspan="3" align="center">DATA NERAC AWAL</th>
    </tr>
    <tr>
        <th colspan="3" align="center">Periode : {{ $d->tgl_neraca_awal }}</th>
    </tr>
    @endforeach
</thead>

<tbody>
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
    <br>
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