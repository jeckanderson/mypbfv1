<?php
header('Content-type: application/vnd-ms-excel');
header('Content-Disposition: attachment; filename=laporan-excel.xls');
?>
<table border="1" align="center">
    <thead>
        <tr>
            <th colspan="12" align="center">{{ $profile->nama_perusahaan }}</th>
        </tr>
        <tr>
            <th colspan="12" align="center">DATA PRODUK PRA STOK OPNAME</th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <th>No</th>
            <th>Nama Produk</th>
            <th>No. Batch</th>
            <th>Exp. Date</th>
            <th>Stok</th>
            <th>Satuan</th>
            <th>Gudang</th>
            <th>Rak</th>
            <th>Sub Rak</th>
            <th>Stok Real</th>
            <th>Keterangan</th>
        </tr>
        @php
            use App\Models\HistoryStok;
            $stokTerbaru = HistoryStok::select('id', DB::raw('MAX(id) as max_id'))
                ->where('keterangan', '!=', 'Penjualan')
                ->groupBy('id_produk', 'id_gudang', 'id_rak', 'id_sub_rak', 'no_batch')
                ->pluck('max_id');

            $stok = HistoryStok::whereIn('id', $stokTerbaru)
                ->where('keterangan', '!=', 'Penjualan')
                ->with(['produk'])
                ->get()
                ->sortBy(function ($item) {
                    return $item->produk->nama_obat_barang;
                });
        @endphp
        @php
            $counter = 1; // Counter manual untuk nomor urut
        @endphp

        @foreach ($stok as $history)
            @if (
                $history->sisaStokBatch(
                    $history->id_produk,
                    $history->no_batch,
                    $history->id_gudang,
                    $history->id_rak,
                    $history->id_sub_rak) != 0)
                <tr>
                    <td class="no">{{ $counter }}</td> <!-- Gunakan counter manual -->
                    <td class="w-auto">{{ $history->produk->nama_obat_barang }}</td>
                    <td>{{ $history->no_batch }}</td>
                    <td>{{ date('d/m/Y', strtotime($history->exp_date)) }}</td>
                    <td>{{ $history->sisaStokBatch($history->id_produk, $history->no_batch, $history->id_gudang, $history->id_rak, $history->id_sub_rak) }}
                    </td>
                    <td>{{ $history->produk->satuanTerkecil->satuan }}</td>
                    <td>{{ $history->gudang->gudang }}</td>
                    <td>{{ $history->rak->rak }}</td>
                    <td>{{ $history->subRak->sub_rak }}</td>
                    <td></td>
                    <td></td>
                </tr>
                @php
                    $counter++; // Increment counter hanya jika kondisi terpenuhi
                @endphp
            @endif
        @endforeach
    </tbody>
</table>
