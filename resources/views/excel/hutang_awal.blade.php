<?php
header('Content-type: application/vnd-ms-excel');
header('Content-Disposition: attachment; filename=laporan-excel.xls');
?>
<table border="1" align="center">
    <thead>
        @foreach ($profile as $d)
            <tr>
                <th colspan="8" align="center">{{ $d->nama_perusahaan }}</th>
            </tr>
            <tr>
                <th colspan="8" align="center">HUTANG AWAL</th>
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
            <th>Supplier</th>
            <th>Jatuh Tempo</th>
            <th>Jenis Piutang</th>
            <th>Jumlah Piutang</th>
        </tr>
        @php
            $totalHutang = 0; // Inisialisasi totalHutang
        @endphp

        @foreach ($hutangAwals as $hutangAwal)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $hutangAwal->no_reff }}</td>
                <td>{{ $hutangAwal->no_faktur }}</td>
                <td>{{ date('d-m-Y', strtotime($hutangAwal->tgl_faktur)) }}</td>
                <td>{{ $hutangAwal->getSuplier->nama_suplier }}</td>
                <td>{{ date('d-m-Y', strtotime($hutangAwal->tgl_jth_tempo)) }}</td>
                <td>{{ $hutangAwal->jns_hutang }}</td>
                <td>{{ number_format($hutangAwal->jmlh_hutang, 0, ',', '.') }}</td>
            </tr>
            @php
                // Menghitung totalHutang
                $totalHutang += floatval(str_replace(['Rp ', '.', ','], '', $hutangAwal->jmlh_hutang));
            @endphp
        @endforeach

        <tr>
            <td colspan="4">Jumlah</td>
            <td colspan="4" id="totalHutang">{{ number_format($totalHutang, 0, ',', '.') }}</td>
        </tr>

        <script>
            function formatRupiah(angka) {
                let numberString = angka.toFixed(2).toString();
                let splitNumber = numberString.split('.');
                let rupiah = splitNumber[0].replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
                return "" + rupiah + "," + splitNumber[1];
            }

            // Fungsi untuk menghitung total hutang
            function hitungTotalHutang() {
                let tableHutang = document.getElementById("tableHutang");
                let tr = tableHutang.getElementsByTagName("tr");
                let total = 0;

                for (let i = 0; i < tr.length; i++) {
                    let hutangCell = tr[i].getElementsByTagName("td")[7];
                    if (hutangCell) {
                        let hutangText = hutangCell.textContent || hutangCell.innerText;
                        let hutangCleaned = parseFloat(hutangText.replace(/[^\d,]/g, '').replace(',', '.'));
                        total += hutangCleaned;
                    }
                }

                document.getElementById("totalHutang").textContent = formatRupiah(total);
            }

            // Panggil fungsi hitungTotalHutang untuk menginisialisasi total saat halaman dimuat
            hitungTotalHutang();
        </script>
    </tbody>
</table>
