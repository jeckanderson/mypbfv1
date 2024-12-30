@extends('print.template')
@yield('LAP. KARTU PIUTANG')
@section('contents')
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
        }

        .box {
            background-color: white;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .text-lg {
            font-size: 1.2em;
        }

        .text-primary {
            color: #007bff;
        }

        .text-white {
            color: white;
        }

        .font-bold {
            font-weight: bold;
        }

        .bg-primary {
            background-color: #007bff;
        }

        .bg-pending {
            background-color: #ffc107;
        }

        .bg-success {
            background-color: #28a745;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #e0e0e0;
        }

        .text-right {
            text-align: right;
        }

        .header-gray {
            background-color: #e0e0e0;
        }

        .mt-5 {
            margin-top: 20px;
        }

        .ml-5 {
            margin-left: 20px;
        }

        .px-3 {
            padding-left: 12px;
            padding-right: 12px;
        }

        .p-5 {
            padding: 20px;
        }

        hr {
            border: 0;
            border-top: 1px solid #ddd;
            margin: 10px 0;
        }

        .w-full {
            width: 100%;
        }
    </style>
     <div class="p-5 mt-5 box">
        <div class="">
            <p class="text-lg text-primary font-bold">PENDAPATAN</p>
            <hr>
            <div class="mt-5 ml-5">
                <table class="w-full">
                    <style>
                        .border {
                            border: 1px solid #bbb;
                            /* Contoh warna abu-abu untuk border */
                        }

                        .header-gray {
                            background-color: #e0e0e0;
                            /* Contoh warna abu-abu */
                            color: black;
                            /* Warna teks hitam */
                        }
                    </style>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            margin: 20px;
                        }

                        table {
                            width: 100%;
                            border-collapse: collapse;
                            margin: 20px 0;
                        }

                        th,
                        td {
                            padding: 3px;
                            text-align: left;
                        }

                        .border {
                            border: 1px solid #bbb;
                            /* Contoh warna abu-abu untuk border */
                        }

                        .header-gray {
                            background-color: #e0e0e0;
                            /* Contoh warna abu-abu */
                            color: black;
                            /* Warna teks hitam */
                        }

                        th {
                            font-weight: bold;
                            text-align: center;
                        }

                        td {
                            font-size: 1em;
                        }
                    </style>
                    <thead>
                        <tr class="header-gray">
                            <p class="text-lg font-bold">Pendapatan Penjualan</p>
                            @forelse ($pendapatanPenjualan as $pendapatan)
                        <tr class="mt-3">
                            <td>{{ $pendapatan->kode_akun }} | {{ $pendapatan->akun->nama_akun }}</td>
                            <td class="text-right">Rp.
                                {{ number_format($pendapatan->debet ?? $pendapatan->kredit, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr class="mt-3">
                            <td>Belum tersedia</td>
                            <td class="text-right">Rp. 0</td>
                        </tr>
                        @endforelse
                        <tr>
                            <td class="px-3 font-bold text-right">Total</td>
                            <td class="px-3 font-bold text-right text-white bg-primary">Rp.
                                {{ number_format($totalPendapatanPenjualan, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>
                                <p class="text-lg font-bold">Retur Penjualan</p>
                            </td>
                        </tr>
                        @forelse ($returPenjualan as $retur)
                            <tr class="mt-3">
                                <td>4-1002 | {{ $retur->akun->nama_akun }}</td>
                                <td class="text-right">Rp.
                                    {{ number_format($retur->debet ?? $retur->kredit, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr class="mt-3">
                                <td>Belum Tersedia</td>
                                <td class="text-right">Rp. 0</td>
                            </tr>
                        @endforelse
                        <tr>
                            <td class="px-3 font-bold text-right">Total</td>
                            <td class="px-3 font-bold text-right text-white bg-primary">Rp.
                                {{ number_format($totalReturPenjualan, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="px-3 font-bold text-right">Total Pendapatan</td>
                            <td class="px-3 font-bold text-right text-white bg-pending">Rp.
                                {{ number_format($totalPendapatanPenjualan - $totalReturPenjualan, 0, ',', '.') }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p class="text-lg font-bold">Harga Pokok Penjualan</p>
                            </td>
                        </tr>
                        @forelse ($hppPenjualan as $hpp)
                            <tr class="mt-3">
                                <td>{{ $hpp->kode_akun }} | {{ $hpp->akun->nama_akun }}</td>
                                <td class="text-right">Rp.
                                    {{ number_format($hpp->debet - $hpp->kredit, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr class="mt-3">
                                <td>Belum tersedia</td>
                                <td class="text-right">Rp. 0</td>
                            </tr>
                        @endforelse
                        <tr>
                            <td class="px-3 font-bold text-right">Total Harga Pokok Penjualan</td>
                            <td class="px-3 font-bold text-right text-white bg-primary">Rp.
                                {{ number_format($totalHppPenjualan, 0, ',', '.') }}</td>
                        </tr>
                </table>
            </div>
            <table class="w-full">
                <tr class="p-5 font-bold text-white bg-pending">
                    <td class="px-3">Laba / Rugi Kotor</td>
                    <td class="px-3 text-right">Rp.
                        {{ number_format($totalLabaRugiKotor, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>
        <div class="mt-5">
            <p class="text-lg text-primary font-bold">BIAYA OPERASIONAL</p>
            <hr>
            <div class="mt-5 ml-5">
                <table class="w-full">
                    <tr>
                        <td>
                            <p class="text-lg font-bold">Biaya</p>
                        </td>
                    </tr>
                    @forelse ($biayaOperasional as $biaya)
                        <tr class="mt-3">
                            <td>{{ $biaya->kode_akun }} | {{ $biaya->akun->nama_akun }}</td>
                            <td class="text-right">Rp.
                                {{ number_format($biaya->debet ?? $biaya->kredit, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr class="mt-3">
                            <td>Belum tersedia</td>
                            <td class="text-right">Rp. 0</td>
                        </tr>
                    @endforelse
                    <tr>
                        <td class="px-3 font-bold text-right">Total</td>
                        <td class="px-3 font-bold text-right text-white bg-primary">Rp.
                            {{ number_format($totalBiayaOperasional, 0, ',', '.') }}
                        </td>
                    </tr>
                </table>
            </div>
            <table class="w-full">
                <tr class="p-5 font-bold text-white bg-success">
                    <td class="px-3">Laba / Rugi Bersih Operasional</td>
                    <td class="px-3 text-right">Rp.
                        {{ number_format($labaRugiBersihOperasional, 0, ',', '.') }}
                    </td>
                </tr>
            </table>
        </div>
        <div class="mt-5">
            <p class="text-lg text-primary font-bold">PENDAPATAN LAIN</p>
            <hr>
            <div class="mt-5 ml-5">
                <table class="w-full">
                    <tr>
                        <td>
                            <p class="text-lg font-bold">Pendapatan Lain</p>
                        </td>
                    </tr>
                    @forelse ($pendapatanLain->groupBy('kode_akun') as $kodeAkun => $items)
                        @php
                            $itemPertama = $items->first();
                        @endphp

                        <tr class="mt-3">
                            <td>{{ $kodeAkun }} | {{ $itemPertama->akun->nama_akun }}</td>
                            <td class="text-right">Rp.
                                {{ number_format(abs($items->sum(function ($item) {return $item->debet - $item->kredit;})),0,',','.') }}
                            </td>
                        </tr>
                    @empty
                        <tr class="mt-3">
                            <td>Belum tersedia</td>
                            <td class="text-right">Rp. 0</td>
                        </tr>
                    @endforelse

                    <tr>
                        <td class="px-3 font-bold text-right">Total Pendapatan Lain</td>
                        <td class="px-3 font-bold text-right text-white bg-primary">Rp.
                            {{ number_format($totalPendapatanLain, 0, ',', '.') }}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="mt-5">
            <p class="text-lg text-primary font-bold">BIAYA LAIN</p>
            <hr>
            <div class="mt-5 ml-5">
                <table class="w-full">
                    <tr>
                        <td>
                            <p class="text-lg font-bold">Biaya Lain</p>
                        </td>
                    </tr>
                    @forelse ($biayaLain as $biaya)
                        <tr class="mt-3">
                            <td>{{ $biaya->kode_akun }} | {{ $biaya->akun->nama_akun }}</td>
                            <td class="text-right">Rp.
                                {{ number_format($biaya->debet ?? $biaya->kredit, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr class="mt-3">
                            <td>Belum tersedia</td>
                            <td class="text-right">Rp. 0</td>
                        </tr>
                    @endforelse
                    <tr>
                        <td class="px-3 font-bold text-right">Total Biaya Lain</td>
                        <td class="px-3 font-bold text-right text-white bg-primary">Rp.
                            {{ number_format($totalBiayaLain, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>
            <table class="w-full">
                <tr class="p-5 font-bold text-white bg-success">
                    <td class="px-3">Laba / Rugi Bersih</td>
                    <td class="px-3 text-right">Rp.
                        {{ number_format($labaRugiBersih, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection
