<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $sale->no_faktur }}</title>
    <style>
        body {
            font-size: 9px;
        }

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
            font-size: 4px;
            margin: 0;
        }

        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
            font-size: 8px;
        }

        .table-container {
            padding: 20px;
            box-sizing: border-box;
        }

        .logo-img {
            width: 70px;
            height: auto;
            margin-right: 10px;
        }

        @media print {
            body.continuous_form {
                width: 138mm;
            }

            body.continuous_form.landscape {
                width: 218mm;
            }

            body {
                font-size: 9px;
                /* Ubah ukuran font untuk cetak */
            }

            .img-logo {
                width: 10px;
                height: 10px;
            }

            table {
                margin-right: 25px;
            }

            table,
            th,
            td {
                border: 1px solid black;
                border-collapse: collapse;
                font-size: 9px;
            }

            .tfoot-container-wrap {
                margin-right: 25px;
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
            width: 70px;
            height: 70px;
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
            <div style="display: flex; justify-content: space-between; padding-left: 0px; padding-right: 0px;">
                <div id="company" style="display: flex; height: auto;width: 30%">

                    {{-- <img src="{{ url('storage/logo_perusahaan/' . $profile->logo_perusahaan) }}" alt=""
                        class="img-logo"> --}}
                    {{-- <div style="text-align: left;">
                        <p>
                            <span style="font-weight: bold; font-size: 12px">{{ $profile->nama_perusahaan }}</span><br>
                            {{ $profile->alamat }} <br>
                            No PBF :{{ $profile->no_ijin_pbf }}<br>
                            No DAK : {{ $profile->no_ijin_dak }}<br>
                            CDOB : {{ $profile->no_cdob }}<br>
                            NPWP :{{ $profile->npwp }} <br>
                            Tlp :{{ $profile->no_telepon }}<br>
                        </p>
                    </div> --}}
                    <div style="text-align: left; margin: 0; padding: 0;">
                        <span
                            style="font-weight: bold; font-size: 13px; display: block; margin-bottom: 4px; margin-top: 10px; width: 100%;">
                            {{ $profile->nama_perusahaan }}
                        </span>
                        <table style="border-collapse: collapse; width: 100%; table-layout: auto; border: none;">
                            <tr>
                                <td colspan="2" style="padding: 0px 6px; font-size: 9px; border: none;">
                                    {{ $profile->alamat }}
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 1px 6px; width: 30%; font-size: 9px; border: none;">Ijin PBF</td>
                                <td style="padding: 1px 6px; width: 70%; font-size: 9px; border: none;">:
                                    {{ $profile->no_ijin_pbf }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 1px 6px; width: 30%; font-size: 9px; border: none;">DAK</td>
                                <td style="padding: 1px 6px; width: 80%; font-size: 9px; border: none;">:
                                    {{ $profile->no_ijin_dak }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 1px 6px; width: 30%; font-size: 9px; border: none;">CDOB</td>
                                <td style="padding: 1px 6px; width: 70%; font-size: 9px; border: none;">:
                                    {{ $profile->no_cdob }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 1px 6px; width: 30%; font-size: 9px; border: none;">NPWP</td>
                                <td style="padding: 1px 6px; width: 70%; font-size: 9px; border: none;">:
                                    {{ $profile->npwp }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 1px 6px; width: 30%; font-size: 9px; border: none;">Tlp</td>
                                <td style="padding: 1px 6px; width: 70%; font-size: 9px; border: none;">:
                                    {{ $profile->no_telepon }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                {{-- <div id="sales" style="margin: 8px">
                    <div style="border: 0.5px solid #000;padding: 8px">
                        <center>
                            <div class="barcode">{!! $generator->getBarcode($sale->no_faktur, $generator::TYPE_CODE_128) !!}</div>
                            {{-- <img src="" alt="" style="width: 400px; height: 40px;"> --}}
                {{-- <br> --}}
                {{-- <span style="font-weight: bold; text-align: center; margin-top: 7px;">FAKTUR
                    PENJUALAN</span><br>
                </center> --}}
                {{-- <p style="padding-top: 5px;">
                            NO. Faktur : {{ $sale->no_faktur }} <br>
                            Np. Pajak : {{ $sale->no_seri_pajak ?? '-' }} <br>
                            Tempo : {{ $sale->tempo_kredit->diffInDays($sale->tgl_faktur) }} Hari <br>
                            Tgl JT : {{ $sale->tempo_kredit->format('d-m-Y') }}
                        </p>
                    </div>
                </div> --}}
                <div id="sales" style="margin: 8px; text-align: center;"><br><br>
                    <span
                        style="font-weight: bold; font-size: 12px; display: block; margin-top: 2px; border-bottom: 1px solid black; padding-bottom: 5px;">
                        FAKTUR PENJUALAN
                    </span>
                    <div style="padding: 0; width: auto; margin: auto;">
                        {{-- <div class="barcode" style="margin-bottom: 6px; max-height: 30px;">
                                {!! $generator->getBarcode($sale->no_faktur, $generator::TYPE_CODE_128) !!}
                            </div> --}}
                        </span>
                        <p style="padding: 0; margin: 0; font-size: 11px; font-weight: normal;">
                            No. Faktur: {{ $sale->no_faktur }}<br>
                            No. FP: {{ $sale->no_seri_pajak ?? '-' }}<br>
                            Tempo: {{ $sale->tempo_kredit->diffInDays($sale->tgl_faktur) }} Hari<br>
                            Tgl JT: {{ $sale->tempo_kredit->format('d-m-Y') }}
                        </p>

                    </div>

                </div>


                <div id="customer"><br><br><br>
                    <span style="font-weight: bold; font-size: 12px">
                        Tgl : {{ $sale->tgl_faktur->format('d-m-Y') }}
                    </span>
                    <div style="text-align: left;">
                        <table style="border-collapse: collapse; width: 100%; border: none; margin: 0; padding: 0;">
                            <tr style="border: none;">
                                <td style="width: 20%; padding: 1px; border: none; font-weight: normal;">Pelanggan</td>
                                <td style="padding: 1px; border: none; font-weight: bold; width: 100%;">:
                                    {{ $sale->customer->nama }}
                                </td>
                            </tr>
                            <tr style="border: none;">
                                <td colspan="2" style="padding: 1px; border: none; font-weight: normal;">
                                    {{ $sale->customer->alamat }}, <br>{{ $sale->customer->kabupaten }}
                                    {{ $sale->customer->provinsi }}
                                </td>
                            </tr>
                            <tr style="border: none;">
                                <td style="width: 15%; padding: 1px; border: none; font-weight: normal;">NPWP</td>
                                <td style="padding: 1px; border: none; font-weight: normal;">
                                    :{{ $sale->customer->npwp }}
                                </td>
                            </tr>
                            <tr style="border: none;">
                                <td style="width: 15%; padding: 1px; border: none; font-weight: normal;">Sales</td>
                                <td style="padding: 1px; border: none; font-weight: normal;">:
                                    {{ $sale->sp->salesPenjualan->nama_pegawai }}
                                </td>
                            </tr>
                            <tr style="border: none;">
                                <td style="width: 15%; padding: 1px; border: none; font-weight: normal;">Status</td>
                                <td style="padding: 1px; border: none; font-weight: normal;">:
                                    {{ $sale->kredit == 1 ? 'Kredit' : 'Cash' }}
                                </td>
                            </tr>
                            <tr style="border: none;">
                                <td style="width: 15%; padding: 1px; border: none; font-weight: normal;">Lembar</td>
                                <td style="padding: 1px; border: none; font-weight: normal;">:{{ $pages }}/
                                    {{ $halaman }}
                                </td>
                            </tr>
                        </table>
                    </div>

                </div>
            </div>
            <br>
            <table style="width: 100%;" id="foo">
                <thead style="background-color: white;">
                    <tr>
                        <th>No</th>
                        <th>Produk</th>
                        <th>No Batch</th>
                        <th>ED</th>
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
                            <td align="center" style="font-size: 9px; border: none;">{{ $no }}</td>
                            <td style="font-size: 11px; border: none;">{{ $produk->produk->nama_obat_barang }}</td>
                            <td style="font-size: 9px; border: none;">{{ $produk->batch }}</td>
                            <td align="center" style="font-size: 9px; border: none;">
                                {{ $produk->exp_date != '-' ? date('d/m/Y', strtotime($produk->exp_date)) : '-' }}</td>
                            <td align="left" style="font-size: 9px; border: none;">
                                {{ $produk->satuanProduk->satuan }}</td>
                            <td align="center" style="font-size: 9px; border: none;">{{ $produk->qty }}</td>
                            <td align="right" style="font-size: 11px; border: none;">
                                {{ number_format($produk->harga, 0, ',', '.') }}</td>
                            <td align="center" style="font-size: 9px; border: none;">{{ $produk->disc_1 }}</td>
                            <td align="center" style="font-size: 9px; border: none;">{{ $produk->disc_2 }}</td>
                            <td style="font-size: 11px; text-align: right; border: none;">
                                {{ number_format(str_replace('.', '', $produk->total), 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="tfoot-container-wrap" style="margin-top: -10px;margin-bottom: 10px; width: 100%">
            <table>
                <tfoot>
                    <tr>
                        <td colspan="5"><i>Terbilang : {{ $terbilang }} Rupiah</i></td>
                    </tr>
                    <tr>
                        <td colspan="5">Keterangan : {{ $sale->keterangan }}</td>
                        {{-- <td style="font-weight: bold;" style="width: 10%">Subtotal</td>
                        <td align="right" style="width: 10%">{{ number_format($sale->subtotal, 0, ',', '.') }}</td> --}}
                    </tr>
                    <tr>
                        <td style="font-weight; width: 20%; text-align: center;">
                            <div>Penerima</div>
                            <div>Nama, TTD, Stempel</div>
                        </td>
                        <td style="font-weight; width: 15%">
                            <center>Note</center>
                        </td>
                        <td style="font-weight; width: 27%">
                            <center> Apoteker </center>
                        </td>
                        <td style="font-weight: bold;" style="width: 10%">DPP</td>
                        <td align="right" style="font-size: 10px; width: 10%">
                            {{ number_format($sale->subtotal, 0, ',', '.') }}</td>
                        {{-- <td style="font-weight: bold;" style="width: 10%">DPP</td>
                        <td align="right">{{ number_format($sale->dpp, 0, ',', '.') }}</td> --}}
                    </tr>
                    <!-- Untuk TTD -->
                    <tr>
                        <td rowspan="6" style="text-align: center; vertical-align: middle;">
                            <!-- Konten di sini -->
                        </td>
                        <td rowspan="6" style="text-align: left; vertical-align: middle;">
                            {{ $footer }}
                        </td>
                        <td rowspan="5" style="text-align: center; vertical-align: middle;">
                            <!-- Konten di sini -->
                        </td>
                    </tr>


                    <!-- Untuk TTD -->
                    <tr>
                        <td style="font-weight: bold;" style="width: 5%">PPN</td>
                        <td align="right" style="font-size: 10px">
                            {{ number_format($sale->ppn, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;" style="width: 5%">Biaya 1</td>
                        <td align="right">
                            {{ number_format(str_replace('.', '', $sale->biaya1), 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;" style="width: 5%">Biaya 2</td>
                        <td align="right">{{ number_format(str_replace('.', '', $sale->biaya2), 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;" style="width: 5%">Bayar</td>
                        <td align="right">{{ $sale->jumlah_bayar }}</td>
                    </tr>
                    <tr>
                        <td align="center">
                            {{ $profile->apoteker }}<br>
                            {{ $profile->sipa }}
                        </td>
                        <td style="font-weight: bold; width: 5%;">TOTAL</td>
                        <td align="right"
                            style="font-size: medium; font-weight: bold; border-right-style: hidden; border-bottom-style: hidden;">
                            {{ number_format($sale->total_hutang, 0, ',', '.') }}
                        </td>
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
