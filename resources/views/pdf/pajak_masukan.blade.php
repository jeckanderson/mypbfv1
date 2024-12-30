<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 14px;
            /* Ukuran font 14px */
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #ccc;
            padding: 20px;
            position: relative;
            /* Menambahkan posisi relatif untuk .container */
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .logo {
            max-width: 100px;
            border: 1px solid #ccc;
            padding: 5px;

        }

        .company-info {
            flex-grow: 1;
            font-size: 12px;
        }

        .title {
            text-align: center;
            font-size: 12px;
            margin-bottom: 0;
        }

        .sub-title {
            text-align: center;
            font-size: 12px;
            margin-bottom: 30px;
        }

        .invoice-details {
            margin-bottom: 30px;
            font-size: 12px;
        }

        .invoice-hal {
            margin-bottom: 10px;
            font-size: 12px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
            font-size: 12px;
        }

        .table th {
            background-color: rgb(175, 177, 177);
        }

        .footer {
            margin-top: 50px;
            margin-bottom: 60px;
            text-align: right;
            font-size: 12px;
            margin-right: 50px;
        }

        .ttd {
            font-size: 12px;
            text-align: center;
            margin-right: 20px;
        }

        .ttd-position {
            text-align: right;
            font-size: 12px;
            margin-left: 385px;
        }

        .invoice-signature {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }

        .signature-box {
            width: 45%;
            text-align: center;
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="sub-title">
            <p>PT.xxxxxxxxxx</p>
            <p>Jl.xxxxxxxxxxxxxxxxxxxx</p>
            <p>LAPORAN PAJAK MASUKAN</p>
            <p>Priode : dd/mm/yyyy s/d dd/mm/yyyy</p>
        </div>
        <div>
            <table class="table">
                <thead>
                    <tr class="header-gray">
                        <th rowspan="2" class="border border-slate-600">No</th>
                        <th rowspan="2" class="border border-slate-600">Tanggal</th>
                        <th rowspan="2" class="border border-slate-600">No. Faktur</th>
                        <th rowspan="2" class="border border-slate-600">Supplier</th>
                        <th colspan="3" class="border border-slate-600">Pajak</th>
                        <th rowspan="2" class="border border-slate-600">DPP</th>
                        <th rowspan="2" class="border border-slate-600">PPN</th>
                        <th rowspan="2" class="border border-slate-600">Total</th>
                    </tr>
                    <tr class="header-gray">
                        <th class="border border-slate-600">No. Seri </th>
                        <th class="border border-slate-600">Tanggal</th>
                        <th class="border border-slate-600">Kompensasi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pembelians as $pembelian)
                        <tr class="text-center intro-x">
                            <td class="border border-slate-600 ">{{ $loop->iteration }}</td>
                            <td class="border border-slate-600 ">{{ $pembelian->tgl_faktur->format('d-m-Y') }}</td>
                            <td class="border border-slate-600 ">{{ $pembelian->no_faktur }}</td>
                            <td class="border border-slate-600 ">{{ $pembelian->getSuplier->nama_suplier }}</td>
                            <td class="border border-slate-600 ">{{ $pembelian->no_faktur_pajak }}</td>
                            <td class="border border-slate-600 ">
                                {{ date('d-m-Y', strtotime($pembelian->tgl_faktur_pajak)) }}</td>
                            <td class="border border-slate-600 ">
                                {{ date('d-m-Y', strtotime($pembelian->kompensasi_pajak)) }}</td>
                            <td class="border border-slate-600 ">{{ number_format($pembelian->dpp, 0, ',', '.') }}</td>
                            <td class="border border-slate-600 ">{{ number_format($pembelian->ppn, 0, ',', '.') }}</td>
                            <td class="border border-slate-600 ">
                                {{ number_format($pembelian->dpp + $pembelian->ppn, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr class="intro-x">
                            <td class="font-bold text-center border text-pending border-slate-600" colspan="9">Belum
                                ada data
                                tersedia</td>
                    @endforelse
                    <tr>
                        <td class="font-bold text-center border border-slate-600" colspan="7">Total</td>
                        <td class="font-bold text-left border border-slate-600">
                            {{ number_format($pembelians->sum('dpp'), 0, ',', '.') }}</td>
                        <td class="font-bold text-left border border-slate-600">
                            {{ number_format($pembelians->sum('ppn'), 0, ',', '.') }}</td>
                        <td class="font-bold text-left border border-slate-600">
                            {{ number_format($pembelians->sum('ppn') + $pembelians->sum('dpp'), 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
</body>

</html>
