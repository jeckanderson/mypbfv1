<!DOCTYPE html>
<html>

<head>
    <style>
        @page {
            size: landscape;
        }

        .analisisorder {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        .analisisorder td,
        .analisisorder th {
            border: 1px solid #ddd;
            padding: 2px;
            font-size: 12px;
        }

        .analisisorder tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .analisisorder tr:hover {
            background-color: #ddd;
        }

        .analisisorder th {
            padding-top: 4px;
            padding-bottom: 4px;
            text-align: center;
            background-color: #221f1f;
            color: white;
        }
    </style>
</head>

<body>
    @if ($detail !== null && count($detail) > 0)
        <h1 style="text-align: center;">Lap. Detail Penjualan Per Faktur</h1>

        <h1 style="text-align: center;">PERIODE: {{ date('d/m/Y', strtotime($mulaiId)) }} s/d
            {{ date('d/m/Y', strtotime($selesaiId)) }}</h1>

        <img src="data:image/svg+xml;base64,{{ base64_encode(file_get_contents(base_path('public/dist/pbflogo.png'))) }}"
            width="120">
        <p style="font-size: 14px;">PT : {{ $detail->first()->profile->nama_perusahaan }}</p>
        <p style="font-size: 14px;">JLN: {{ $detail->first()->profile->alamat }}</p>
        <p style="font-size: 14px;">No. Telp: {{ $detail->first()->profile->no_telepon }}</p>
        <hr>


        <div class="margin-top">
            <table class="w-full">
                <tr>
                    <td class="w-half">
                        <div><strong>Tgl. Faktur :</strong></div>
                        <div><strong>No. Faktur:</strong></div>


                    </td>
                    <td class="w-half">
                        <div>{{ $detail->first()->penjualan->tgl_faktur }}</div>
                        <div>{{ $detail->first()->penjualan->no_faktur }}</div>

                    </td>
                    <td class="w-half">
                        <div><strong>Pelanggan:</strong></div>
                        <div><strong>Sales:</strong></div>

                    </td>
                    <td class="w-half">
                        <div>{{ $detail->first()->penjualan->getPelanggan->nama }}</div>
                        <div>{{ $detail->first()->penjualan->getSales->nama_pegawai }}</div>

                    </td>

                    <td class="w-half">

                        <div><strong>Pembayaran:</strong></div>
                        <div><strong>Tgl JT:</strong></div>

                    </td>
                    <td class="w-half">

                        <div>{{ $detail->first()->penjualan->kredit == 0 ? 'CASH' : 'KREDIT' }}</div>
                        <div>{{ $detail->first()->penjualan->tempo_kredit }}</div>
                    </td>
                    <td class="w-half">
                        <div><strong>No. Sp:</strong></div>
                        <div><strong>Tgl. Sp:</strong></div>


                    </td>
                    <td class="w-half">
                        <div>{{ $detail->first()->penjualan->no_sp }}</div>
                        <div>{{ $detail->first()->penjualan->sp->tgl_input }}</div>

                    </td>
                    <td class="w-half">
                        <div><strong>No. Pajak: </strong></div>
                        <div><strong>Tgl. Pajak:</strong></div>

                    </td>
                    <td class="w-half">
                        <div>{{ $detail->first()->penjualan->no_seri_pajak }}</div>
                        <div>{{ $detail->first()->penjualan->tgl_input }}</div>

                    </td>
                </tr>
            </table>
        </div>














        <table class="analisisorder">

            <tr>

                <th>No</th>
                <th>Kode</th>
                <th>Nama Produk</th>
                <th>Qty SP</th>
                <th>Satuan</th>
                <th>Batch</th>
                <th>Exp Date</th>
                <th>Qty</th>
                <th>Harga </th>
                <th>Disc 1</th>
                <th>Disc 2</th>
                <th>Total</th>
            </tr>

            <tbody>
                @foreach ($detail as $details)
                    <tr class="text-center intro-x">
                        <td class="border border-slate-600">{{ $loop->iteration }}</td>
                        <td class="border border-slate-600">{{ $details->produk->kode_obat_barang }}</td>
                        <td class="border border-slate-600">{{ $details->produk->nama_obat_barang }}</td>
                        <td class="border border-slate-600">{{ $details->qty_sp }}</td>
                        <td class="border border-slate-600">{{ $details->satuanProduk->satuan }}</td>
                        <td class="border border-slate-600">{{ $details->batch }}</td>
                        <td class="border border-slate-600">{{ $details->exp_date }}</td>
                        <td class="border border-slate-600">{{ $details->qty }}</td>
                        <td class="border border-slate-600">{{ $details->harga }}</td>
                        <td class="border border-slate-600">{{ $details->disc_1 }}</td>
                        <td class="border border-slate-600">{{ $details->disc_2 }}</td>
                        <td class="border border-slate-600">{{ $details->total }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="margin-top">
            <table class="w-full">
                <tr>
                    <td class="w-half">
                        <div><strong>Subtotal:</strong></div>
                    </td>
                    <td class="w-half">
                        <div>{{ $detail->first()->penjualan->subtotal }}</div>
                    </td>
                    <td class="w-half">
                        <div><strong>Disc %:</strong></div>
                    </td>
                    <td class="w-half">
                        <div>{{ $detail->first()->penjualan->diskon }}</div>
                    </td>

                    <td class="w-half">
                        <div><strong>DPP:</strong></div>
                    </td>
                    <td class="w-half">
                        <div>{{ $detail->first()->penjualan->dpp }}</div>
                    </td>
                    <td class="w-half">
                        <div><strong>PPN:</strong></div>
                    </td>
                    <td class="w-half">
                        <div>{{ $detail->first()->penjualan->ppn }}</div>
                    </td>

                    <td class="w-half">
                        <div><strong>Total:</strong></div>
                    </td>
                    <td class="w-half">
                        <div>{{ $detail->first()->penjualan->total }}</div>
                    </td>
                    <td class="w-half">
                        <div><strong>Biaya 1:</strong></div>
                    </td>
                    <td class="w-half">
                        <div>{{ $detail->first()->penjualan->biaya1 }}</div>
                    </td>

                    <td class="w-half">
                        <div><strong>Biaya 2:</strong></div>
                    </td>
                    <td class="w-half">
                        <div>{{ $detail->first()->penjualan->biaya2 }}</div>
                    </td>
                    <td class="w-half">
                        <div><strong>Total Tagihan:</strong></div>
                    </td>
                    <td class="w-half">
                        <div>{{ $detail->first()->penjualan->total_tagihan }}</div>
                    </td>


                    <td class="w-half">
                        <div><strong>Jumlah Bayar: </strong></div>
                    </td>
                    <td class="w-half">
                        <div>{{ $detail->first()->penjualan->jumlah_bayar }}</div>
                    </td>
                    <td class="w-half">
                        <div><strong>Total Piutang:</strong></div>
                    </td>
                    <td class="w-half">
                        <div>{{ $detail->first()->penjualan->total_hutang }}</div>
                    </td>
                    
                </tr>
            </table>

        </div>
           
            
            
            
        @else
            <p class="text-center">Belum Ada Data Masuk</p>
    @endif

</body>

</html>
