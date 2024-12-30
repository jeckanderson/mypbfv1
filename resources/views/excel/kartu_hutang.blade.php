@php
    $sum_total_tagihan = 0;
    $sum_total_bayar = 0;
    $sum_total_retur = 0;
    $sum_total_sisa_hutang = 0;
@endphp

@foreach ($hutang_pengguna as $item)
    @php $s = 0; @endphp

    @foreach ($item->hutangs as $c)
        @if (!is_null($c->sourceable))
            @php
                $w = 0;
            @endphp

            @foreach ($c->sourceable->hutang_pengguna as $d)
                @php
                    $w = str_replace('.', '', $d->sisa_hutang);
                @endphp
            @endforeach

            @php $s += $w; @endphp
        @endif
    @endforeach

    <table style="width: 100%;">
        <thead>
            <tr>
                <th colspan="15" style="text-align: left;">{{ $item->nama_suplier }}</th>
            </tr>
            <tr style="font-weight: bold; text-align: center;">
                <th>No</th>
                <th>Tgl Faktur</th>
                <th>No Reff</th>
                <th>No Faktur</th>
                <th>Tgl Tempo</th>
                <th>Hutang</th>
                <th>No Reff</th>
                <th>Tanggal Bayar</th>
                <th>Retur</th>
                <th>Bayar</th>
                <th>Sisa Hutang</th>
                <th>Uang Retur</th>
                <th>Hutang Final</th>
                <th>Note</th>
                <th>Kas/Bank</th>
                {{-- <th>Keterangan</th> --}}
            </tr>

        </thead>
        <tbody>
            @foreach ($item->hutangs as $hutang)
                @if (!is_null($hutang->sourceable))
                    @php
                        $total_tagihan = 0;
                        $bayar = 0;
                        $retur = 0;
                        $sisa_hutang = 0;
                        $jumlahBaris = $hutang->sourceable->hutang_pengguna()->count();
                        $total_tagihan += $hutang->sourceable->total_tagihan;
                        $sum_total_tagihan += $hutang->sourceable->total_tagihan;
                    @endphp

                    <tr>
                        <td rowspan="{{ $jumlahBaris }}">{{ $loop->iteration }}</td>
                        <td rowspan="{{ $jumlahBaris }}">{{ $hutang->sourceable->tgl_faktur->format('d/m/Y') }}</td>
                        <td rowspan="{{ $jumlahBaris }}">{{ $hutang->sourceable->no_reff ?? '-' }}</td>
                        <td rowspan="{{ $jumlahBaris }}">{{ $hutang->sourceable->no_faktur ?? '-' }}</td>
                        <td rowspan="{{ $jumlahBaris }}">{{ $hutang->sourceable->tempo_kredit->format('d/m/Y') }}</td>
                        <td rowspan="{{ $jumlahBaris }}">
                            {{ $hutang->sourceable->total_tagihan ?? 0 }}</td>

                        @php $first = $hutang->sourceable->hutang_pengguna[0]; @endphp

                        <td>{{ $first->detailable ? $first->detailable->no_reff : '-' }}</td>
                        <td>{{ $first->detailable ? $first->detailable->created_at->format('d/m/Y') : '-' }}</td>
                        <td>{{ $first->detailable_type == \App\Models\ReturPembelian::class ? $first->detailable->total : 0 }}
                        </td>
                        <td>{{ str_replace('.', '', $first->nominal_bayar) }}</td>
                        <td>{{ str_replace('.', '', $first->sisa_hutang) }}</td>
                        <td>{{ $first->detailable_type == \App\Models\ReturPembelian::class ? $first->detailable->uang_retur : 0 }}
                        </td>
                        <td>{{ str_replace('.', '', $first->sisa_hutang) }}</td>
                        <td>{{ ucwords(str_replace('_', ' ', \Str::snake(str_replace('App\\Models\\', '', $first->detailable_type)))) }}
                        </td>
                        <td>{{ !is_null($first->detailable->akun) ? $first->detailable->akun->nama_akun : '' }}</td>
                        {{-- <td>{{ $first->detailable->keterangan }}</td> --}}
                    </tr>

                    @foreach ($hutang->sourceable->hutang_pengguna as $item)
                        @if ($loop->first)
                            @continue
                        @endif

                        @php
                            $bayar += str_replace('.', '', $item->nominal_bayar);
                            $sisa_hutang += str_replace('.', '', $item->sisa_hutang);
                            $sum_total_sisa_hutang += str_replace('.', '', $item->sisa_hutang);
                            if ($item->detailable_type == \App\Models\ReturPembelian::class) {
                                $retur += str_replace('.', '', $item->detailable->total);
                                $sum_total_retur += $retur;
                            }
                        @endphp

                        <tr>
                            <td>{{ $item->detailable ? $item->detailable->no_reff : '-' }}</td>
                            <td>{{ $item->detailable ? $item->detailable->created_at->format('d/m/Y') : '-' }}</td>
                            <td>{{ $item->detailable_type == \App\Models\ReturPembelian::class ? $item->detailable->total : 0 }}
                            </td>
                            <td>{{ str_replace('.', '', $item->nominal_bayar) }}</td>
                            <td>{{ str_replace('.', '', $item->sisa_hutang) }}</td>
                            <td>{{ $item->detailable_type == \App\Models\ReturPembelian::class ? $item->detailable->uang_retur : 0 }}
                            </td>
                            <td>{{ str_replace('.', '', $item->sisa_hutang) }}</td>
                            <td>{{ ucwords(str_replace('_', ' ', \Str::snake(str_replace('App\\Models\\', '', $item->detailable_type)))) }}
                            </td>
                            <td>{{ !is_null($item->detailable->akun) ? $item->detailable->akun->nama_akun : '' }}</td>
                            {{-- <td>{{ $item->detailable->keterangan }}</td> --}}
                        </tr>
                    @endforeach
                @endif
            @endforeach
        </tbody>
    </table>
@endforeach
