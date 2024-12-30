<!DOCTYPE html>
<html>

<head>
    <style>
        .hutangawal {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        .hutangawal td,
        .hutangawal th {
            border: 1px solid #ddd;
            padding: 2px;
            font-size: 10px;
        }

        .hutangawal tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .hutangawal tr:hover {
            background-color: #ddd;
        }

        .hutangawal th {
            padding-top: 4px;
            padding-bottom: 4px;
            text-align: center;
            background-color: #fff;
            color: black;
        }
    </style>
</head>

<body>
    @foreach ($profile as $d)
        <h4 style="text-align: center;margin:0;padding:0">{{ $d->nama_perusahaan }}</h4>
        <h5 style="text-align: center;margin:0;padding:0">Data Hutang Awal</h5>
        <br>
        <h5 style="text-align: center;margin:0;padding:0">Periode : {{ $d->tgl_neraca_awal }}</h5>
    @endforeach
    <br>
    <table class="hutangawal">
        <tr>
            <th>No</th>
            <th>No. Reff</th>
            <th>No Faktur</th>
            <th>Tanggal Faktur</th>
            <th>Supplier</th>
            <th>Jatuh Tempo</th>
            <th>Jenis Hutang</th>
            <th>Jumlah Hutang</th>
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
                <td style="text-align: right">{{ number_format($hutangAwal->jmlh_hutang, 0, ',', '.') }}</td>
            </tr>
            @php
                // Menghitung totalHutang
                $totalHutang += floatval(str_replace(['Rp ', '.', ','], '', $hutangAwal->jmlh_hutang));
            @endphp
        @endforeach

        <tr>
            <td colspan="7">Jumlah</td>
            <td colspan="4" id="totalHutang" style="text-align: right">{{ number_format($totalHutang, 0, ',', '.') }}
            </td>
        </tr>

        <script>
            function formatRupiah(angka) {
                let numberString = angka.toFixed(2).toString();
                let splitNumber = numberString.split('.');
                let rupiah = splitNumber[0].replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
                return "Rp. " + rupiah + "," + splitNumber[1];
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

    </table>

</body>

</html>
