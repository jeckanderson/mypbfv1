<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=laporan-excel.xls");
?>
<table border="1" align="center">
<thead>
    @foreach ($profile as $d )
    <tr>
        <th colspan="8" align="center">{{ $d->nama_perusahaan }}</th>
    </tr>
    <tr>
        <th colspan="8" align="center">DATA PIUTANG AWAL</th>
    </tr>
    <tr>
        <th colspan="8" align="center">Periode : {{ $d->tgl_neraca_awal }}</th>
    </tr>
    @endforeach
</thead>

<tbody>
    <tr>
        <th>No</th>
        <th>No. Reff</th>
        <th>No Faktur</th>
        <th>Tanggal Faktur</th>
        <th>Pelanggan</th>
        <th>Jatuh Tempo</th>
        <th>Jenis Piutang</th>
        <th>Jumlah Piutang</th>
    </tr>
    @php
    $totalPiutang = 0; // Inisialisasi variabel totalPiutang
    @endphp

    @foreach ($piutangAwals as $piutangAwal)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $piutangAwal->no_reff }}</td>
            <td>{{ $piutangAwal->no_faktur }}</td>
            <td>{{ date('d-m-Y', strtotime($piutangAwal->tgl_faktur)) }}</td>
            <td>{{ $piutangAwal->pelanggan }}</td>
            <td>{{ date('d-m-Y', strtotime($piutangAwal->tgl_jth_tempo)) }}</td>
            <td>{{ $piutangAwal->jns_piutang }}</td>
            <td>{{ 'Rp .' . number_format($piutangAwal->jmlh_piutang, 2, ',', '.') }}</td>
        </tr>
        @php
            // Menghitung totalPiutang
            $totalPiutang += floatval(str_replace(['Rp ', '.', ','], '', $piutangAwal->jmlh_piutang));
        @endphp
    @endforeach

        <tr>
            <td colspan="4">Jumlah</td>
            <td colspan="4" id="totalPiutang">Rp. {{ number_format($totalPiutang, 2, ',', '.') }}</td>           
        </tr>
    <script>
        function formatRupiah(angka) {
            let numberString = angka.toFixed(2).toString();
            let splitNumber = numberString.split('.');
            let rupiah = splitNumber[0].replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
            return "Rp. " + rupiah + "," + splitNumber[1];
        }

        // Fungsi untuk menghitung total piutang
        function hitungTotalPiutang() {
            let tablePiutang = document.getElementById("tablePiutang");
            let tr = tablePiutang.getElementsByTagName("tr");
            let total = 0;

            for (let i = 0; i < tr.length; i++) {
                let piutangCell = tr[i].getElementsByTagName("td")[7];
                if (piutangCell) {
                    let piutangText = piutangCell.textContent || piutangCell.innerText;
                    let piutangCleaned = parseFloat(piutangText.replace(/[^\d,]/g, '').replace(',', '.'));
                    total += piutangCleaned;
                }
            }

            document.getElementById("totalPiutang").textContent = formatRupiah(total);
        }
        
        // Panggil fungsi hitungTotalPiutang untuk menginisialisasi total saat halaman dimuat
        hitungTotalPiutang();
    </script>

</tbody>
  </table>