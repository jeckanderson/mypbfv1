@extends('layout.main')

@section('main')
    <div class="flex items-center mt-8 intro-y">
        <h2 class="mr-auto text-lg font-medium text-primary">
            Saldo Awal
        </h2>
        <div>
            {{-- <a href="/saldo-awal-download-excel" class="flex items-center btn btn-outline-primary btn-sm"
                style="position: fixed; right: 120px;"><i data-feather="file-text" class="w-4 h-4 mr-1"
                    value="Export Excel"onclick="window.open('laporan-excel.php')"></i>Excel
            </a>
            <a href="/saldo-awal-download-pdf" class="flex items-center btn btn-outline-primary btn-sm" style="position: fixed; right: 50px;"><i
                    data-feather="printer" class="w-4 h-4 mr-1"></i>Print
            </a> --}}
        </div>
    </div>
    <div class="grid grid-cols-12 gap-2 mt-8">
        <div class="flex flex-wrap items-center col-span-12 mt-2 intro-y sm:flex-nowrap">
            {{-- <a href="/tambah-saldo-awal"><button class="mr-2 shadow-md btn btno-outline-primary" data-tw-toggle="modal"
                    data-tw-target="#basic-modal-preview">Tambah
                    Saldo Awal +</button> --}}
        </div>
    </div>
    <div class="grid-cols-2 gap-4 sm:grid">
        <div class="mt-2 intro-y box">
            <div class="flex flex-col items-center p-2 border-b sm:flex-row border-slate-200/60 dark:border-darkmode-400">
                <h2 class="mr-auto text-base font-bold">
                    AKTIVA
                </h2>
            </div>
            <div id="vertical-form" class="p-2">
                <table class="table border border-slate-600">
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
                        <tr>
                            <td class="text-white border border-slate-600 bg-primary">Kode</td>
                            <td class="text-white border border-slate-600 bg-primary">Akun</td>
                            <td class="text-white border border-slate-600 bg-primary">Saldo</td>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalAktiva = 0;
                        @endphp
                        @forelse ($akunAktiva as $item)
                            <tr>
                                <td class="border border-slate-600">{{ $item->kode }}</td>
                                <td class="border border-slate-600">{{ $item->nama_akun }}</td>
                                <td class="border border-slate-600">
                                    Rp. {{ number_format($item->saldoAwal->saldo ?? 0, 0, ',', '.') }}
                                </td>
                            </tr>
                            @php
                                $totalAktiva += $item->saldoAwal->saldo ?? 0;
                            @endphp
                        @empty
                            <tr>
                                <p>Belum tersedia data</p>
                            </tr>
                        @endforelse
                        <tr>
                            <td class="font-bold text-center border border-slate-600 bg-secondary" colspan="2">Total</td>
                            <td class="font-bold border border-slate-600">
                                {{ 'Rp. ' . number_format($totalAktiva, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-2 intro-y box">
            <div class="flex flex-col items-center p-2 border-b sm:flex-row border-slate-200/60 dark:border-darkmode-400">
                <h2 class="mr-auto text-base font-bold">
                    PASIVA
                </h2>
            </div>
            <div id="vertical-form" class="p-2">
                <table class="table border border-slate-600">
                    <thead>
                        <tr>
                            <td class="text-white border border-slate-600 bg-primary">Kode</td>
                            <td class="text-white border border-slate-600 bg-primary">Akun</td>
                            <td class="text-white border border-slate-600 bg-primary">Saldo</td>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalPasiva = 0;
                        @endphp
                        @foreach ($akunPasiva as $itemPasiva)
                            <tr>
                                <td class="border border-slate-600">{{ $itemPasiva->kode }}</td>
                                <td class="border border-slate-600">{{ $itemPasiva->nama_akun }}</td>
                                <td class="border border-slate-600">
                                    Rp. {{ number_format($itemPasiva->saldoAwal->saldo ?? 0, 0, ',', '.') }}
                                </td>
                            </tr>
                            @php
                                $totalPasiva += $itemPasiva->saldoAwal->saldo ?? 0;
                            @endphp
                        @endforeach
                        <tr>
                            <td colspan="2" class="font-bold text-center border border-slate-600 bg-secondary">Total</td>
                            <td class="font-bold border border-slate-600">
                                {{ 'Rp. ' . number_format($totalPasiva, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
