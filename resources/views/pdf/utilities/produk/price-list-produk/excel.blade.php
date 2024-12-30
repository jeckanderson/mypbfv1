@php
    use App\Models\HistoryStok;

    // Sort the $setharga collection by the product name
    $setharga = $setharga->sortBy(function ($sethargas) {
        return $sethargas->produk->nama_obat_barang;
    });
@endphp

@if ($setharga !== null && count($setharga) > 0)

    <h1 class="title text-center">PRICE LIST PRODUK</h1>
    <p class="kelompok-info">Kelompok: {{ $setharga->first()->kelompok->kelompok }}</p>

    <table class="pricelist">
        <tr>
            <th style="width: 30px;">No</th>
            <th>Nama Produk</th>
            <th>Produsen</th>
            <th>Satuan</th>
            <th>Stok</th>
            <th>Harga</th>
            <th>Disc 1%</th>
            <th>Disc 2%</th>
            <th>HNA</th>
            <th>HNA + PPN</th>
        </tr>

        @foreach ($setharga as $sethargas)
            <tr>
                <td align="center">{{ $loop->iteration }}</td>
                <td>{{ $sethargas->produk->nama_obat_barang }}</td>
                <td>{{ $sethargas->produk->produsenProduk->produsen }}</td>
                <td align="center">{{ $sethargas->satuanProduk->satuan }}</td>
                <td align="center">
                    {{ (HistoryStok::where('id_produk', $sethargas->id_produk)->sum('stok_masuk') - HistoryStok::where('id_produk', $sethargas->id_produk)->sum('stok_keluar')) / $sethargas->isi }}
                </td>
                <td align="right">
                    {{ number_format($sethargas->hasil_laba, 0) }}
                </td>
                <td align="center">{{ $sethargas->disc_1 }}</td>
                <td align="center">{{ $sethargas->disc_2 }}</td>
                <td align="right">{{ number_format($sethargas->harga_jual, 0) }}</td>
                <td align="right">
                    {{ number_format($sethargas->harga_jual * (1 + $setharga->first()->profile->Ppn->ppn / 100), 0) }}
                </td>
            </tr>
        @endforeach
    </table>
@else
    <p>Belum Ada Data Masuk</p>
@endif
