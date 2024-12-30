@extends('print.template')
@yield('LAP. Neraca')
@section('contents')
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
    <table class="w-full table-auto">
        <thead>
            <tr>
                <th class="text-left p-3 text-lg font-bold text-primary">AKTIVA</th>
                <th class="text-left p-3 text-lg font-bold text-primary">PASIVA</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <!-- AKTIVA Section -->
                <td class="align-top p-3">
                    <table class="w-full text-lg">
                        @foreach ($dataActiva as $akun)
                            <tr class="mt-3">
                                <td>{{ $akun['kode'] }}</td>
                                <td>{{ $akun['nama_akun'] }}</td>
                                <td class="text-right">
                                    {{ number_format(round($akun['total']), 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="2" class="px-3 font-bold text-right">Total</td>
                            <td class="px-3 font-bold text-right text-white bg-primary">
                                {{ number_format(round($totalSaldoAkunAktiva), 0, ',', '.') }}
                            </td>
                        </tr>
                    </table>
                </td>

                <!-- PASIVA Section -->
                <td class="align-top p-3">
                    <table class="w-full text-lg">
                        @foreach ($dataPasiva as $akun)
                            <tr class="mt-3">
                                <td>{{ $akun['kode'] }}</td>
                                <td>{{ $akun['nama_akun'] }}</td>
                                <td class="text-right">
                                    {{ number_format(round($akun['total']), 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="2" class="px-3 font-bold text-right">Total</td>
                            <td class="px-3 font-bold text-right text-white bg-primary">
                                {{ number_format(round($totalSaldoAkunKewajiban), 0, ',', '.') }}
                            </td>
                        </tr>
                        @foreach ($dataModal as $akun)
                            <tr class="mt-3">
                                <td>{{ $akun['kode'] }}</td>
                                <td>{{ $akun['nama_akun'] }}</td>
                                <td class="text-right">
                                    {{ number_format(round($akun['total']), 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="2" class="px-3 font-bold text-right">Total</td>
                            <td class="px-3 font-bold text-right text-white bg-primary">
                                {{ number_format(round($totalSaldoAkunModal + $labaRugi), 0, ',', '.') }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td class="p-3 text-right font-bold text-lg text-white bg-pending">TOTAL AKTIVA :
                    {{ number_format(round($totalSaldoAkunAktiva), 0, ',', '.') }}
                </td>
                <td class="p-3 text-right font-bold text-lg text-white bg-pending">TOTAL PASIVA :
                    {{ number_format(round($totalSaldoAkunModal + $totalSaldoAkunKewajiban + $labaRugi), 0, ',', '.') }}
                </td>
            </tr>
        </tbody>
    </table>
@endsection
