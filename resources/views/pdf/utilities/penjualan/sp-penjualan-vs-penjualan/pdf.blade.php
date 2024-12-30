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
    <h1 style="text-align: center;">Lap. SP. Penjualan VS  Penjualan</h1>

    <h1 style="text-align: center;">PERIODE: {{ date('d/m/Y', strtotime($mulaiId)) }} s/d {{ date('d/m/Y', strtotime($selesaiId)) }}</h1>

    <img src="data:image/svg+xml;base64,{{ base64_encode(file_get_contents(base_path('public/dist/pbflogo.png'))) }}"
        width="120">
        @foreach ($detail as $sppenjualans)
    <p style="font-size: 14px;">PT : {{ $sppenjualans->first()->profile->nama_perusahaan }}</p>
    <p style="font-size: 14px;">JLN: {{ $sppenjualans->first()->profile->alamat }}</p>
    <p style="font-size: 14px;">No. Telp: {{ $sppenjualans->first()->profile->no_telepon }}</p>

    


    <div class="margin-top">
        <table class="w-full">
            <tr>
                <td class="w-half">
                    <div><strong>No. Sp :</strong></div>
                    <div><strong>Tgl. Sp:</strong></div>


                </td>
                <td class="w-half">
                    <div>{{$sppenjualans->spPenjualan->no_sp}}</div>
                    <div>{{$sppenjualans->spPenjualan->tgl_sp}}</div>

                </td>
                <td class="w-half">
                    <div><strong>Pelanggan:</strong></div>
                    <div><strong>Sales:</strong></div>

                </td>
                <td class="w-half">
                    <div>{{$sppenjualans->spPenjualan->pelangganPenjualan->nama}}</div>
                    <div>{{$sppenjualans->spPenjualan->salesPenjualan->nama_pegawai}}</div>

                </td>

                <td class="w-half">

                    <div><strong>Tipe. Sp:</strong></div>
                    <div><strong>Sumber:</strong></div>

                </td>
                <td class="w-half">

                    <div>{{$sppenjualans->spPenjualan->tipe_sp}}</div>
                    <div>{{$sppenjualans->spPenjualan->sumber}}</div>
                </td>
                <td class="w-half">
                    <div><strong>Tipe. Sp:</strong></div>
                    <div><strong>Sumber:</strong></div>


                </td>
                <td class="w-half">
                    <div>{{$sppenjualans->spPenjualan->tipe_sp}}</div>
                    <div>{{$sppenjualans->spPenjualan->sumber}}</div>

                </td>
               
            </tr>
        </table>
    </div>
    <table class="analisisorder">
        <thead class="text-center">
            <tr>
                <th>No</th>
                <th>Nama Produk</th>

                <th>Satuan</th>
                <th>Qty SP</th>
                <th>Qty Jual</th>
                <th>Potensi Loss</th>
            </tr>
        </thead>
        <tbody>
           
                <tr class="text-center intro-x">
                    <td class="border border-slate-600">{{ $loop->iteration }}</td>
                    <td class="border border-slate-600">
                        {{ $sppenjualans->produk->nama_obat_barang }}
                    </td>
                    <td class="border border-slate-600">{{ $sppenjualans->satuanProduk->satuan }}</td>
                    <td class="border border-slate-600">{{ $sppenjualans->qty_sp }}</td>
                    <td class="border border-slate-600">{{ $sppenjualans->qty }}</td>
                    <td class="border border-slate-600">{{ $sppenjualans->qty_sp - $sppenjualans->qty }}</td>

                </tr>
           
        </tbody>
    </table>
    @endforeach
    @else
    <p class="text-center">Belum Ada Data Masuk</p>
    @endif

</body>

</html>
