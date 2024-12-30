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
            margin-left: 4pc;
            margin-bottom: 0;
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
            margin-left: 4pc;
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

        .info {
            margin-top: 0;
            margin-left: 4pc;
            font-size: 12px;
        }

        .info-sub {
            margin-top: 0;
            margin-left: 4pc;
            font-size: 12px;
        }

        .info-sub span {
            margin-top: 0;
            font-size: 12px;
            color: #fff;
            background-color: rgb(9, 9, 143);
        }

        .invoice-info {
            margin-top: 0;
            margin-left: 4pc;
            font-size: 12px;
        }

        .invoice-info span {
            margin-top: 0;
            font-size: 12px;
            color: #fff;
            background-color: rgb(122, 122, 238);
        }

        .info-total {
            margin-top: 0;
            font-size: 12px;
            background-color: rgb(28, 180, 28);
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="sub-title">
            <p>PT.xxxxxxxxxxx</p>
            <p>Jl.xxxxxxxxxxxxxxx</p>
            <p>LAPORAN LABA/RUGI </p>
            <p>Periode : dd/mm/yyyy</p>
            <hr>
        </div>
        <div class="invoice-hal">
            <p>
                <b>PENDAPATAN</b>
            </p>
            <hr>
        </div>
        <div class="company-info">
            <p>
                <b>Pendapatan Penjualan</b>
            </p>
        </div>
        <div class="header">
            <div class="info">
                <p>4-0001</p>
            </div>
            <div class="info">
                <p>Rp. </p>
            </div>
        </div>
        <div class="info-sub" style="text-align: right;">
            <p>Total
                <span>Rp.xxxxxxxxxxx</span>
            </p>
        </div>

        <div class="company-info">
            <p>
                <b>Retur Penjualan</b>
            </p>
        </div>
        <div class="header">
            <div class="info">
                <p>4-0001</p>
            </div>
            <div class="info">
                <p>Rp. </p>
            </div>
        </div>
        <div class="info-sub" style="text-align: right;">
            <p>Total
                <span>Rp.xxxxxxxxxxx</span>
            </p>
        </div>
        <div class="invoice-info" style="text-align: right;">
            <p>Total Pendapatan
                <span>Rp.xxxxxxxxxxxxxxxxxxxxxxxxxx</span>
            </p>
        </div>

        <div class="company-info">
            <p>
                <b>Harga Pokok Penjualan</b>
            </p>
        </div>
        <div class="header">
            <div class="info">
                <p>4-0001</p>
            </div>
            <div class="info">
                <p>Rp. </p>
            </div>
        </div>
        <div class="info-sub" style="text-align: right;">
            <p>Total
                <span>Rp.xxxxxxxxxxx</span>
            </p>
        </div>
        <div class="invoice-info" style="text-align: right;">
            <p>Total Harga Pokok Penjualan
                <span>Rp.xxxxxxxxxxxxxxxxxxxxxxxxxx</span>
            </p>
        </div>
        <div class="info-total">
            <p>Laba/Rugi Kotor</p>
        </div>

        <div class="invoice-hal">
            <p>
                <b>BIAYA OPERASIONAL</b>
            </p>
            <hr>
        </div>
        <div class="company-info">
            <p>
                <b>Biaya</b>
            </p>
        </div>
        <div class="header">
            <div class="info">
                <p>4-0001</p>
            </div>
            <div class="info">
                <p>Rp. </p>
            </div>
        </div>
        <div class="info-sub" style="text-align: right;">
            <p>Total
                <span>Rp.xxxxxxxxxxx</span>
            </p>
        </div>
        <div class="invoice-info" style="text-align: right;">
            <p>Total Biaya Operasional
                <span>Rp.xxxxxxxxxxxxxxxxxxxxxxxxxx</span>
            </p>
        </div>
        <div class="info-total">
            <p>Laba/Rugi Kotor</p>
        </div>

        <div class="invoice-hal">
            <p>
                <b>PENDAPATAN LAIN</b>
            </p>
            <hr>
        </div>
        <div class="company-info">
            <p>
                <b>Pendapatan Lain</b>
            </p>
        </div>
        <div class="header">
            <div class="info">
                <p>4-0001</p>
            </div>
            <div class="info">
                <p>Rp. </p>
            </div>
        </div>
        <div class="info-sub" style="text-align: right;">
            <p>Total
                <span>Rp.xxxxxxxxxxx</span>
            </p>
        </div>
        <div class="invoice-info" style="text-align: right;">
            <p>Total Pendapatan Lain
                <span>Rp.xxxxxxxxxxxxxxxxxxxxxxxxxx</span>
            </p>
        </div>
        <div class="info-total">
            <p>Laba/Rugi Kotor</p>
        </div>

        <div class="invoice-hal">
            <p>
                <b>BIAYA LAIN</b>
            </p>
            <hr>
        </div>
        <div class="company-info">
            <p>
                <b>Biaya Lain</b>
            </p>
        </div>
        <div class="header">
            <div class="info">
                <p>4-0001</p>
            </div>
            <div class="info">
                <p>Rp. </p>
            </div>
        </div>
        <div class="info-sub" style="text-align: right;">
            <p>Total
                <span>Rp.xxxxxxxxxxx</span>
            </p>
        </div>
        <div class="invoice-info" style="text-align: right;">
            <p>Total Biaya Lain
                <span>Rp.xxxxxxxxxxxxxxxxxxxxxxxxxx</span>
            </p>
        </div>
        <div class="info-total">
            <p>Laba/Rugi Kotor</p>
        </div>
    </div>
</body>

</html>
