@extends('print.template')
@yield('LAP. KARTU HUTANG')
@section('contents')
    @php
        $sum_total_tagihan = 0;
        $sum_total_bayar = 0;
        $sum_total_retur = 0;
        $sum_total_sisa_hutang = 0;
    @endphp

    <style>
        table {
            width: 100%;
            font-size: 10px;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 5px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>

    @foreach ($hutang_pengguna as $item)
        <table>
            <thead>
                <tr>
                    <th colspan="15" style="text-align: left;">{{ $item->nama_suplier }}</th>
                </tr>
                <tr>
                    <th>No</th>
                    <th>Tgl Faktur</th>
                    <th>No Faktur</th>
                    <th>Tgl Tempo</th>
                    <th>Hutang</th>
                    <th>No Reff</th>
                    <th>Tgl Bayar</th>
                    <th>Retur</th>
                    <th>Bayar</th>
                    <th>Sisa Hutang</th>
                    <th>Uang Retur</th>
                    <th>Hutang Final</th>
                    <th>Catatan</th>
                    {{-- <th>Note</th> --}}
                    {{-- <th>Keterangan</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($item->hutangs as $hutang)
                    @if (!is_null($hutang->sourceable))
                        @php
                            $total_tagihan = 0;
                            $jumlahBaris = $hutang->sourceable->hutang_pengguna()->count();
                            $total_tagihan += $hutang->sourceable->total_tagihan;
                            $sum_total_tagihan += $hutang->sourceable->total_tagihan;
                        @endphp
                        <tr>
                            <td rowspan="{{ $jumlahBaris }}">{{ $loop->iteration }}</td>
                            <td rowspan="{{ $jumlahBaris }}">{{ $hutang->sourceable->tgl_faktur->format('d/m/Y') }}</td>
                            <td rowspan="{{ $jumlahBaris }}">{{ $hutang->sourceable->no_faktur ?? '-' }}</td>
                            <td rowspan="{{ $jumlahBaris }}">{{ $hutang->sourceable->tempo_kredit->format('d/m/Y') }}</td>
                            <td rowspan="{{ $jumlahBaris }}">
                                {{ number_format($hutang->sourceable->total_tagihan ?? 0, 0, ',', '.') }}</td>

                            @php
                                $first = $hutang->sourceable->hutang_pengguna[0];
                            @endphp
                            <td>{{ $first->detailable ? $first->detailable->no_reff : '-' }}</td>
                            <td>{{ $first->detailable ? $first->detailable->created_at->format('d/m/Y') : '-' }}</td>
                            <td>{{ $first->detailable_type == \App\Models\ReturPembelian::class ? number_format($first->detailable->total, 0, ',', '.') : 0 }}
                            </td>
                            <td>{{ number_format(str_replace('.', '', $first->nominal_bayar), 0, ',', '.') }}</td>
                            <td>{{ number_format(str_replace('.', '', $first->sisa_hutang), 0, ',', '.') }}</td>
                            <td>{{ $first->detailable_type == \App\Models\ReturPembelian::class ? number_format($first->detailable->uang_retur, 0, ',', '.') : 0 }}
                            </td>
                            <td>{{ number_format(str_replace('.', '', $first->sisa_hutang), 0, ',', '.') }}</td>
                            <td>{{ ucwords(str_replace('_', ' ', \Str::snake(str_replace('App\\Models\\', '', $first->detailable_type)))) }}
                            </td>
                            {{-- <td>{{ !is_null($first->detailable->akun) ? $first->detailable->akun->nama_akun : '' }}</td>
                            <td>{{ $first->detailable->keterangan }}</td>
                        </tr> --}}

                            @foreach ($hutang->sourceable->hutang_pengguna as $pengguna)
                                @if (!$loop->first)
                        <tr>
                            <td>{{ $pengguna->detailable ? $pengguna->detailable->no_reff : '-' }}</td>
                            <td>{{ $pengguna->detailable ? $pengguna->detailable->created_at->format('d/m/Y') : '-' }}
                            </td>
                            <td>{{ $pengguna->detailable_type == \App\Models\ReturPembelian::class ? number_format($pengguna->detailable->total, 0, ',', '.') : 0 }}
                            </td>
                            <td>{{ number_format(str_replace('.', '', $pengguna->nominal_bayar), 0, ',', '.') }}
                            </td>
                            <td>{{ number_format(str_replace('.', '', $pengguna->sisa_hutang), 0, ',', '.') }}</td>
                            <td>{{ $pengguna->detailable_type == \App\Models\ReturPembelian::class ? number_format($pengguna->detailable->uang_retur, 0, ',', '.') : 0 }}
                            </td>
                            <td>{{ number_format(str_replace('.', '', $pengguna->sisa_hutang), 0, ',', '.') }}</td>
                            <td>{{ !is_null($pengguna->detailable->akun) ? $pengguna->detailable->akun->nama_akun : '' }}
                            </td>
                            {{-- <td>{{ ucwords(str_replace('_', ' ', \Str::snake(str_replace('App\\Models\\', '', $pengguna->detailable_type)))) }}
                                    </td> --}}
                            {{-- <td>{{ $pengguna->detailable->keterangan }}</td> --}}
                        </tr>
                    @endif
                @endforeach
    @endif
    @endforeach
    </tbody>
    </table>
    @endforeach
@endsection
