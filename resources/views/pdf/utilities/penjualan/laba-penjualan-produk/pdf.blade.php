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
    <h1 style="text-align: center;">LAP. LABA PENJUALAN PER PRODUK</h1>

    <h1 style="text-align: center;">PERIODE: {{ date('d/m/Y', strtotime($mulaiId)) }} s/d {{ date('d/m/Y', strtotime($selesaiId)) }}</h1>

    <img src="data:image/svg+xml;base64,{{ base64_encode(file_get_contents(base_path('public/dist/pbflogo.png'))) }}"
        width="120">
    <p style="font-size: 14px;">PT : {{ $detail->first()->profile->nama_perusahaan }}</p>
    <p style="font-size: 14px;">JLN: {{ $detail->first()->profile->alamat }}</p>
    <p style="font-size: 14px;">No. Telp: {{ $detail->first()->profile->no_telepon }}</p>

   
    <table class="analisisorder">
        <thead class="text-center">
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>No. Faktur</th>
                <th>Pelanggan</th>
                <th>Sales</th>
                <th>Kode</th>
                <th>Nama Produk</th>
                <th>Satuan</th>
                <th>Qty </th>
                <th>Harga</th>
                <th>Disc 1</th>
                <th>Disc 2</th>
                <th>Total</th>
                <th>Modal</th>
                <th>Margin</th>
                <th>% </th>
               
            </tr>
        </thead>
        <tbody>
            @foreach ($detail as $details)
                <tr class="text-center intro-x">
               
                        <td class="border border-slate-600">{{ $loop->iteration }}</td>
                        <td class="border border-slate-600">{{ $details->penjualan->tgl_input }}</td>
                        <td class="border border-slate-600">{{ $details->penjualan->no_faktur }}</td>
                        <td class="border border-slate-600">{{ $details->penjualan->getPelanggan->nama }}</td>
                        <td class="border border-slate-600">{{ $details->penjualan->getSales->nama_pegawai }}</td>
                        <td class="border border-slate-600">{{ $details->produk->kode_obat_barang }}</td>
                        <td class="border border-slate-600">{{ $details->produk->nama_obat_barang }}</td>
                        <td class="border border-slate-600">{{ $details->produk->satuanTerkecil->satuan }}</td>
                        <td class="border border-slate-600">{{ $details->qty_sp }}</td>
                        <td class="border border-slate-600">{{ $details->harga }}</td>
                        <td class="border border-slate-600">{{ $details->disc_1 }}</td>
                        <td class="border border-slate-600">{{ $details->disc_2 }}</td>
                        <td class="border border-slate-600">{{ $details->total }}</td>
                        <td class="border border-slate-600">{{ $details->total_modal }}</td>
                        <td class="border border-slate-600">{{ $details->total - $details->total_modal }}</td>
                        <td class="border border-slate-600">{{ ($details->total - $details->total_modal) / $details->total }}</td>
                       
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
