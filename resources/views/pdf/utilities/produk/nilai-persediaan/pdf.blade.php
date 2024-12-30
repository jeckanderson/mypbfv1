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
    @if ($historystok !== null && count($historystok) > 0)
        <h1 style="text-align: center;">NILAI PERSEDIAAN</h1>

        <h1 style="text-align: center;">PERIODE: {{ date('d/m/Y', strtotime($mulaiId)) }} s/d
            {{ date('d/m/Y', strtotime($selesaiId)) }}</h1>

        <img src="data:image/svg+xml;base64,{{ base64_encode(file_get_contents(base_path('public/dist/pbflogo.png'))) }}"
            width="120">
        <p style="font-size: 14px;">PT : {{ $historystok->first()->profile->nama_perusahaan }}</p>
        <p style="font-size: 14px;">JLN: {{ $historystok->first()->profile->alamat }}</p>
        <p style="font-size: 14px;">No. Telp: {{ $historystok->first()->profile->no_telepon }}</p>


        <table class="analisisorder">
            <thead class="text-center">
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama Produk</th>
                    <th>Produsen</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Satuan</th>
                    <th>Batch</th>
                    <th>Exp Date</th>
                    {{-- <th>HPP</th> --}}

                    <th>Gudang</th>
                    <th>Rak</th>
                    <th>Sub Rak</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($historystok as $historystoks)
                    <tr class="text-center intro-x">
                        <td class="border border-slate-600">{{ $loop->iteration }}</td>
                        <td class="border border-slate-600">{{ $historystoks->produk->kode_obat_barang }}</td>
                        <td class="border border-slate-600">{{ $historystoks->produk->nama_obat_barang }}</td>
                        <td class="border border-slate-600">{{ $historystoks->produk->produsenProduk->produsen }}</td>
                        <td class="border border-slate-600">{{ $historystoks->produk->kelompok->golongan }}</td>
                        <td class="border border-slate-600">{{ $historystoks->stok_akhir }}</td>
                        <td class="border border-slate-600">{{ $historystoks->produk->satuanTerkecil->satuan }}</td>
                        <td class="border border-slate-600">{{ $historystoks->no_batch }}</td>
                        <td class="border border-slate-600">{{ $historystoks->exp_date }}</td>
                        {{-- <td class="border border-slate-600">?</td> --}}

                        <td class="border border-slate-600">{{ $historystoks->gudang->gudang }}</td>
                        <td class="border border-slate-600">{{ $historystoks->rak->rak }}</td>
                        <td class="border border-slate-600">{{ $historystoks->subRak->sub_rak }}</td>
                    </tr>
                @endforeach
                {{-- <tr>
                <td colspan="13" class="border border-slate-600">TOTAL</td>
                <td class="border border-slate-600">?</td>
                <td colspan="2" class="border border-slate-600">result</td>
                
                <td class="border border-slate-600">?</td>
            </tr> --}}
            </tbody>
            {{-- <tfoot>
                <tr class="text-center">
                    <td colspan="9" class="border border-slate-600">Total</td>


                    <td class="border border-slate-600">?</td>
                    <td colspan="7" class="border border-slate-600"></td>
                </tr>
            </tfoot> --}}
        </table>
    @else
        <p>Belum Ada Data Masuk</p>
    @endif
</body>

</html>
