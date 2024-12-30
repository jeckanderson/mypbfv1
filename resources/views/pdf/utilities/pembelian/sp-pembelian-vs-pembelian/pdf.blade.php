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

        <h1 style="text-align: center;">Lap. SP. Pembelian VS Pembelian</h1>

        <h1 style="text-align: center;">PERIODE: {{ date('d/m/Y', strtotime($mulaiId)) }} s/d
            {{ date('d/m/Y', strtotime($selesaiId)) }}</h1>

        <img src="data:image/svg+xml;base64,{{ base64_encode(file_get_contents(base_path('public/dist/pbflogo.png'))) }}"
            width="120">
       
            <p style="font-size: 14px;">PT : {{ $detail->first()->profile->nama_perusahaan }}</p>
            <p style="font-size: 14px;">JLN: {{ $detail->first()->profile->alamat }}</p>
            <p style="font-size: 14px;">No. Telp: {{ $detail->first()->profile->no_telepon }}</p>



            {{-- <p>No. Sp : {{ $pembelian->sp->no_sp }}</p>
                    <p>Tgl. Sp : {{ $pembelian->sp->tgl_sp }}</p>
                    <p>Supplier : {{ $pembelian->suplier->nama_suplier }}</p>
                    <p>Tipe Sp : {{ $pembelian->sp->tipe_sp }}</p> --}}

            <table class="analisisorder">
                <thead class="text-center">
                    <tr>
                        <th class="border border-slate-600">No</th>
                        <th class="border border-slate-600">Nama Produk</th>
                        <th class="border border-slate-600">Satuan</th>
                        <th class="border border-slate-600">Qty SP</th>

                        <th class="border border-slate-600">Qty Beli</th>

                        <th class="border border-slate-600">Potensi Loss</th>
                    </tr>
                </thead>
                <tbody>
 @foreach ($detail as $details)
                    <tr class="text-center intro-x">

                        <td class="border border-slate-600">{{ $loop->iteration }}</td>
                        <td class="border border-slate-600">{{ $details->produk->nama_obat_barang }}
                        </td>
                        <td class="border border-slate-600">{{ $details->produk->satuanTerkecil->satuan }}
                        </td>
                        <td class="border border-slate-600">
                            {{ $details->rencanaOrders[0]->jumlah_order }}</td>
                        <td class="border border-slate-600">{{ $details->qty_faktur }}</td>
                        <td class="border border-slate-600">
                            {{ $details->rencanaOrders[0]->jumlah_order - $details->qty_faktur }}
                        </td>


                    </tr>

                    </tr>
        @endforeach
        </tbody>
        </table>
    @else
        <p class="text-center">Belum Ada Data Masuk</p>
    @endif

</body>

</html>
