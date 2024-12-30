@extends('print.template')
@yield('LAP. KARTU PIUTANG')
@section('contents')
    @php
        $sum_total_tagihan = 0;
        $sum_total_bayar = 0;
        $sum_total_retur = 0;
        $sum_total_sisa_hutang = 0;
        $dd = 0;
    @endphp

    @foreach ($hutang_pengguna as $item)
        @php $s = 0; @endphp

        @foreach ($item->piutang as $c)
            @if (!is_null($c->sourceable))
                @php $w = 0; @endphp
                @foreach ($c->sourceable->piutang_pengguna as $d)
                    @php $w = str_replace('.', '', $d->sisa_hutang); @endphp
                @endforeach
                @php $s += $w; @endphp
            @endif
        @endforeach

        <table style="width: 100%; font-size: 9px; border-collapse: collapse;">
            <thead>
                <tr>
                    <th colspan="17" style="text-align: left;">{{ $item->nama }}</th>
                </tr>
                <tr style="background-color: #f0f0f0; text-align: center;">
                    <th>No</th>
                    <th>Tgl Input</th>
                    <th>No. Reff</th>
                    <th>Tgl Faktur</th>
                    <th>No Faktur</th>
                    <th>Tgl JT</th>
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
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($item->piutang as $hutang)
                    @if (!is_null($hutang->sourceable))
                        @php
                            $total_tagihan = 0;
                            $bayar = 0;
                            $retur = 0;
                            $sisa_hutang = 0;
                            $jumlahBaris = $hutang->sourceable->piutang_pengguna()->count();
                            $total_tagihan += $hutang->sourceable->total_tagihan;
                            $sum_total_tagihan += $hutang->total_hutang;
                        @endphp

                        <tr style="text-align: center;">
                            <td rowspan="{{ $jumlahBaris }}">{{ $loop->iteration }}</td>
                            <td rowspan="{{ $jumlahBaris }}">{{ $hutang->created_at->format('d-m-Y') ?? '-' }}</td>
                            <td rowspan="{{ $jumlahBaris }}">{{ $hutang->sourceable->no_reff ?? '-' }}</td>
                            <td rowspan="{{ $jumlahBaris }}">{{ $hutang->sourceable->tgl_faktur->format('d-m-Y') }}</td>
                            <td rowspan="{{ $jumlahBaris }}">{{ $hutang->sourceable->no_faktur ?? '-' }}</td>
                            <td rowspan="{{ $jumlahBaris }}">{{ $hutang->sourceable->tempo_kredit->format('d-m-Y') }}
                            </td>
                            <td rowspan="{{ $jumlahBaris }}">
                                {{ number_format($hutang->sourceable->total_tagihan ?? 0, 0, ',', '.') }}</td>
                            @php $first = $hutang->sourceable->piutang_pengguna[0]; @endphp
                            <td>{{ $first->detailable ? $first->detailable->no_reff : '-' }}</td>
                            <td>{{ $first->detailable ? $first->detailable->created_at->format('d-m-Y') : '-' }}</td>
                            <td>{{ $first->detailable_type == \App\Models\ReturPenjualan::class ? number_format($first->detailable->total, 0, ',', '.') : 0 }}
                            </td>
                            <td>{{ $first->detailable_type != \App\Models\ReturPenjualan::class ? number_format(str_replace('.', '', $first->nominal_bayar), 0, ',', '.') : 0 }}
                            </td>
                            <td>{{ number_format(str_replace('.', '', $first->sisa_hutang), 0, ',', '.') }}</td>
                            <td>{{ $first->detailable_type == \App\Models\ReturPenjualan::class ? number_format($first->detailable->uang_retur, 0, ',', '.') : 0 }}
                            </td>
                            <td>{{ number_format(str_replace('.', '', $first->sisa_hutang), 0, ',', '.') }}</td>
                            <td>{{ ucwords(str_replace('_', ' ', \Str::snake(str_replace('App\\Models\\', '', $first->detailable_type)))) }}
                            </td>
                            <td>{{ $first->akun ? $first->akun->nama_akun : (!is_null($first->detailable->akun) ? $first->detailable->akun->nama_akun : '') }}
                            </td>
                            <td>{{ $first->detailable->keterangan }}</td>
                        </tr>

                        @foreach ($hutang->sourceable->piutang_pengguna as $item)
                            @if ($loop->first)
                                @continue
                            @endif

                            @php
                                $bayar += str_replace('.', '', $item->nominal_bayar);
                                $sisa_hutang += str_replace('.', '', $item->sisa_hutang);
                                $sum_total_sisa_hutang += str_replace('.', '', $item->sisa_hutang);
                                if ($item->detailable_type == \App\Models\ReturPenjualan::class) {
                                    $retur += str_replace('.', '', $item->detailable->total);
                                    $sum_total_retur += $retur;
                                }
                            @endphp

                            <tr style="text-align: center;">
                                <td>{{ $item->detailable ? $item->detailable->no_reff : '-' }}</td>
                                <td>{{ $item->detailable ? $item->detailable->created_at->format('d-m-Y') : '-' }}</td>
                                <td>{{ $item->detailable_type == \App\Models\ReturPenjualan::class ? number_format($item->detailable->total, 0, ',', '.') : 0 }}
                                </td>
                                <td>{{ number_format(str_replace('.', '', $item->nominal_bayar), 0, ',', '.') }}</td>
                                <td>{{ number_format(str_replace('.', '', $item->sisa_hutang), 0, ',', '.') }}</td>
                                <td>{{ $item->detailable_type == \App\Models\ReturPenjualan::class ? number_format($item->detailable->uang_retur, 0, ',', '.') : 0 }}
                                </td>
                                <td>{{ number_format(str_replace('.', '', $item->sisa_hutang), 0, ',', '.') }}</td>
                                <td>{{ ucwords(str_replace('_', ' ', \Str::snake(str_replace('App\\Models\\', '', $item->detailable_type)))) }}
                                </td>
                                <td>{{ $item->akun ? $item->akun->nama_akun : (!is_null($item->detailable->akun) ? $item->detailable->akun->nama_akun : '') }}
                                </td>
                                <td>{{ $item->detailable->keterangan }}</td>
                            </tr>
                        @endforeach
                    @endif
                @endforeach
            </tbody>
        </table>
    @endforeach
@endsection
