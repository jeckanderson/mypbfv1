<!DOCTYPE html>
<html>

<head>
    <style>
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
        <h1 style="text-align: center;">Lap. Retur Penjualan</h1>

        <h1 style="text-align: center;">PERIODE: {{ date('d/m/Y', strtotime($mulaiId)) }} s/d
            {{ date('d/m/Y', strtotime($selesaiId)) }}</h1>

        <img src="data:image/svg+xml;base64,{{ base64_encode(file_get_contents(base_path('public/dist/pbflogo.png'))) }}"
            width="120">
        @foreach ($detail as $retur)
            <p style="font-size: 14px;">PT : {{ $retur->first()->profile->nama_perusahaan }}</p>
            <p style="font-size: 14px;">JLN: {{ $retur->first()->profile->alamat }}</p>
            <p style="font-size: 14px;">No. Telp: {{ $retur->first()->profile->no_telepon }}</p>



            <div class="margin-top">
                <table class="w-full">
                    <tr>
                        <td class="w-half">
                            <div><strong>Tgl. Retur :</strong></div>
                            <div><strong>No. Reff:</strong></div>


                        </td>
                        <td class="w-half">
                            <div>{{ $detail->first()->tgl_faktur }}</div>
                            <div>{{ $detail->first()->no_reff }}</div>

                        </td>
                        <td class="w-half">
                            <div><strong>Pelanggan:</strong></div>
                            <div><strong>Sales:</strong></div>

                        </td>
                        <td class="w-half">
                            <div>{{ $detail->first()->getPelanggan->nama }}</div>
                            <div>{{ $detail->first()->getSales->nama_pegawai }}</div>

                        </td>

                        <td class="w-half">

                            <div><strong>No. Faktur:</strong></div>
                            <div><strong>No. Pajak:</strong></div>

                        </td>
                        <td class="w-half">

                            <div>{{ $detail->first()->no_faktur }}</div>
                            <div>{{ $detail->first()->no_seri_pajak }}</div>
                        </td>

                    </tr>
                </table>
            </div>

            <table class="analisisorder">
                <thead class="text-center">
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama Produk</th>
                        <th>Satuan</th>
                        <th>Batch</th>
                        <th>Exp Date</th>
                        <th>Qty Retur</th>
                    </tr>
                </thead>
                <tbody>

                    <tr class="text-center intro-x">
                        <td class="border border-slate-600">{{ $loop->iteration }}</td>


                        <td class="border border-slate-600"> {{ $retur->history->produk->kode_obat_barang }}</td>
                        <td class="border border-slate-600"> {{ $retur->history->produk->nama_obat_barang }}</td>
                        <td class="border border-slate-600"> {{ $retur->history->produk->satuanTerkecil->satuan }}
                        </td>
                        <td class="border border-slate-600">{{ $retur->history->no_batch }}</td>
                        <td class="border border-slate-600">{{ $retur->history->exp_date }}</td>
                        <td class="border border-slate-600">{{ $retur->uang_retur }}</td>
                    </tr>
        @endforeach
        </tbody>
        </table>
        <div class="margin-top">
            <table class="w-full">
                <tr>
                    <td class="w-half">
                        <div><strong>DPP :</strong></div>
                        


                    </td>
                    <td class="w-half">
                        <div>{{ $detail->first()->dpp }}</div>
                        

                    </td>
                    <td class="w-half">
                        <div><strong>PPN:</strong></div>
                       

                    </td>
                    <td class="w-half">
                       
                        <div>{{ $detail->first()->ppn }}</div>

                    </td>

                    <td class="w-half">

                      
                        <div><strong>Total:</strong></div>

                    </td>
                    <td class="w-half">

                        <div>{{ $detail->first()->total }}</div>
                        
                    </td>

                </tr>
            </table>
        </div>
    @else
        <p class="text-center">Belum Ada Data Masuk</p>
    @endif

</body>

</html>
