<!DOCTYPE html>
<html>

<head>
    <style>
        .piutangawal {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        .piutangawal td,
        .piutangawal th {
            border: 1px solid #ddd;
            padding: 2px;
            font-size: 10px;
        }

        .piutangawal tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .piutangawal tr:hover {
            background-color: #ddd;
        }

        .piutangawal th {
            padding-top: 4px;
            padding-bottom: 4px;
            text-align: center;
        }
    </style>
</head>

<body>
    @foreach ($profile as $d)
        <h4 style="text-align: center; margin: 0; padding: 0">{{ $d->nama_perusahaan }}</h4>
        <h4 style="text-align: center; margin: 0; padding: 0">Data Piutang Awal
            <br>
            <p style="text-align: center">Periode : {{ $d->tgl_neraca_awal }}</p>
        </h4>
    @endforeach

    <table class="piutangawal">
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
                <td>{{ $piutangAwal->getPelanggan->nama }}</td>
                <td>{{ date('d-m-Y', strtotime($piutangAwal->tgl_jth_tempo)) }}</td>
                <td>{{ $piutangAwal->jns_piutang }}</td>
                <td style="text-align: right">{{ number_format($piutangAwal->jmlh_piutang, 0, ',', '.') }}</td>
            </tr>
            @php
                // Menghitung totalPiutang
                $totalPiutang += floatval(str_replace(['Rp ', '.', ','], '', $piutangAwal->jmlh_piutang));
            @endphp
        @endforeach

        <tr>
            <td colspan="7">Jumlah</td>
            <td colspan="4" id="totalPiutang" style="text-align: right">{{ number_format($totalPiutang, 0, ',', '.') }}
            </td>
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

    </table>

</body>

</html>
