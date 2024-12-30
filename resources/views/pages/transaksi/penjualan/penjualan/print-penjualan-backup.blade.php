<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $sale->no_faktur }}</title>
    <style>
        @page {
            size: continuous_form;
            margin: 0mm;
        }

        body.continuous_form .sheet {
            width: 138mm;
            height: 218mm;
        }

        body.continuous_form.landscape .sheet {
            width: 218mm;
            height: 138mm;
        }

        body {
            font-family: verdana, serif;
            font-size: 12px;
            margin: 0;
        }

        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
            font-size: 12px;
        }

        .table-container {
            padding: 20px;
            box-sizing: border-box;
        }

        .logo-img {
            width: 100px;
            height: auto;
            margin-right: 20px;
        }

        @media print {
            body.continuous_form {
                width: 138mm;
            }

            body.continuous_form.landscape {
                width: 218mm;
            }

            body {
                font-size: 3px;
                /* Ubah ukuran font untuk cetak */
            }

            .img-logo {
                width: 25px;
                height: 25px;
            }

            .barcode {
                visibility: hidden;
            }

            table,
            th,
            td {
                border: 1px solid black;
                border-collapse: collapse;
                font-size: 6px;
            }
        }


        .container {
            display: flex;
            flex-wrap: wrap;
        }

        .tfoot-container-wrap {
            display: flex;
            position: fixed;
            bottom: 0;
            left: 0;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            padding: 20px 20px;
            box-sizing: border-box;
        }

        .tfoot-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 20px 20px;
            box-sizing: border-box;
        }

        .tfoot-container table {
            width: 100%;

        }

        .tfoot-container-wrap table {
            width: 100%;
        }

        .img-logo {
            width: 100px;
            height: 100px;
        }
    </style>
</head>

<body onload="print()" class="continuous_form landscape">
    @php
        use Picqer\Barcode\BarcodeGeneratorHTML;
        $generator = new BarcodeGeneratorHTML();
        $pages = 1;
        $no = 0;
    @endphp
    <!-- content  -->
    @foreach ($details as $key => $item)
        <div class="table-container">
            <div style="display: flex; justify-content: space-between; padding-left: 20px; padding-right: 20px;">
                <div id="company" style="display: flex; height: auto;">

                    <img src="{{ url('storage/logo_perusahaan/' . $profile->logo_perusahaan) }}" alt=""
                        class="img-logo">
                    <div style="text-align: left;">
                        <p>
                            <span style="font-weight: bold;">{{ $profile->nama_perusahaan }}</span><br>
                            {{ $profile->alamat }} <br>
                            No. {{ $profile->no_ijin_pbf }}<br>
                            No. {{ $profile->no_ijin_dak }}<br>
                            CDOB : {{ $profile->no_cdob }}<br>
                            NPWP :{{ $profile->npwp }} <br>
                            Tlp :{{ $profile->no_telepon }}<br>
                        </p>
                    </div>
                </div>
                <div id="sales">
                    <div style="border: 1px solid #000">
                        <center><span style="font-weight: bold; text-align: center; margin-top: 5px;">FAKTUR
                                PENJUALAN</span><br>
                            <div class="barcode">{!! $generator->getBarcode($sale->no_faktur, $generator::TYPE_CODE_128) !!}</div>
                            <img src="" alt="" style="width: 300px; height: 50px;">
                        </center>
                        <p style="padding-top: 5px;">
                            NO. {{ $sale->no_faktur }} <br>
                            Np. Pajak : {{ $sale->no_seri_pajak ?? '-' }} <br>
                            PO : {{ $sale->tempo_kredit->diffInDays($sale->tgl_faktur) }} Hari <br>
                            Tgl JT : {{ $sale->tempo_kredit->format('d/m/Y') }}
                        </p>
                    </div>
                </div>
                <div id="customer">
                    <p>
                        <center>{{ $sale->tgl_faktur->format('d F Y') }}</center>
                        Pelanggan : {{ $sale->customer->nama }}<br>
                        {{ $sale->customer->alamat }},{{ $sale->customer->kabupaten }} <br>
                        {{ $sale->customer->provinsi }}<br>
                        NPWP : {{ $sale->customer->npwp }}<br>
                        Sales : {{ $sale->sp->salesPenjualan->nama_pegawai }}<br>
                        Status : {{ $sale->kredit == 1 ? 'Kredit' : 'Cash' }} <br>
                        Lembar : {{ $pages }}/ {{ $halaman }}
                    </p>
                </div>
            </div>
            <br><br>
            <table style="width: 100%; margin: 0 auto;" id="foo">
                <thead style="background-color: white;">
                    <tr>
                        <th>No</th>
                        <th>Produk</th>
                        <th>No Batch</th>
                        <th>Expired</th>
                        <th>Satuan</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Disc 1</th>
                        <th>Disc 2</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($item as $produk)
                        @php
                            $no++;
                        @endphp
                        <tr>
                            <td>{{ $no }}</td>
                            <td>{{ $produk->produk->nama_obat_barang }}</td>
                            <td>{{ $produk->batch }}</td>
                            <td>{{ date('d-m-Y', strtotime($produk->exp_date)) }}</td>
                            <td>{{ $produk->satuanProduk->satuan }}</td>

                            <td>{{ $produk->qty }}</td>
                            <td align="left">{{ number_format($produk->harga, 0, ',', '.') }}</td>
                            <td>{{ $produk->disc_1 }}</td>
                            <td>{{ $produk->disc_2 }}</td>
                            <td align="left">{{ number_format(str_replace('.', '', $produk->total), 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="tfoot-container-wrap">
            <table>
                <tfoot>
                    <tr>
                        <td colspan="10">Terbilang : {{ $terbilang }}</td>
                    </tr>
                    <tr>
                        <td rowspan="2" colspan="8">Keterangan : {{ $sale->keterangan }}</td>
                        <td style="font-weight: bold;">Subtotal</td>
                        <td align="right">{{ number_format($sale->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Disc</td>
                        <td align="right">{{ $sale->diskon }}%</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <center>Penerima</center>
                        </td>
                        <td colspan="3" style="width: 20%">
                            <center>Note</center>
                        </td>
                        <td colspan="3" style="width: 20%">
                            <center>Penanggung Jawab Apoteker </center>
                        </td>
                        <td style="font-weight: bold;">DPP</td>
                        <td align="right">{{ number_format($sale->dpp, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" rowspan="6"><br></td>
                    </tr>
                    <tr>
                        <td colspan="3" style="border-bottom-style: hidden;"></td>
                        <td colspan="3" style="border-bottom-style: hidden;"></td>
                        <td style="font-weight: bold;">PPN</td>
                        <td align="right">{{ number_format($sale->ppn, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td colspan="3" rowspan="2" style="border-bottom-style: hidden;"><br></td>
                        <td colspan="3" rowspan="2" style="border-bottom-style: hidden;"><br></td>
                        <td style="font-weight: bold;">Biaya 1</td>
                        <td align="right">{{ number_format(str_replace('.', '', $sale->biaya1), 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Biaya 2</td>
                        <td align="right">{{ number_format(str_replace('.', '', $sale->biaya2), 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td colspan="3" style="border-bottom-style: hidden;"></td>
                        <td colspan="3" style="border-bottom-style: hidden;">
                            <center>{{ $profile->apoteker }}</center>
                        </td>
                        <td style="font-weight: bold;">Bayar</td>
                        <td align="right">{{ $sale->jumlah_bayar }}</td>
                    </tr>
                    <tr>
                        <td colspan="3"><br></td>
                        <td colspan="3">
                            <center>{{ $profile->sipa }}</center>
                        </td>
                        <td style="font-weight: bold;">Total</td>
                        <td align="right"
                            style="font-size: large; font-weight: bold; border-right-style: hidden; border-bottom-style: hidden;">
                            {{ number_format($sale->total_hutang, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        @php
            $pages++;
        @endphp
        <div style="page-break-after: always"></div>
    @endforeach
    <!-- end content -->
</body>
<script>
    // Mendeteksi peristiwa cetak
    window.onafterprint = function() {
        // Menutup jendela setelah mencetak
        window.close();
    };
</script>

</html>
