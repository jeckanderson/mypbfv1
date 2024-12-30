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
    font-size: 14px; /* Ukuran font 14px */
  }

  .container {
    max-width: 800px;
    margin: 0 auto;
    border: 1px solid #ccc;
    padding: 20px;
    position: relative; /* Menambahkan posisi relatif untuk .container */
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

  .table th, .table td {
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
            <p>PT.xxxxxxxxxxx</p>
            <p>Jl.xxxxxxxxxxxxxxx</p>
            <p>LAPORAN NERACA </p>
            <p>Periode : dd/mm/yyyy s/d dd/mm/yyyy</p>
            <hr>
        </div>
        <div class="invoice-hal">
            <p>
                <b>AKTIVA</b>
            </p>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Akun</th>
                    <th>Saldo</th>
                </tr>
            </thead>
            <tbody>
                <!-- Detail transaksi -->
                <tr>
                    <td>1</td>
                    <td>aan</td>
                    <td>Rp. </td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: right;">Total</td>
                    <td>Rp. </td>
                </tr>
                <tr>
                    <td colspan="2"><b>
                        TOTAL AKTIVA
                    </b></td>
                    <td>
                        <b>Rp.xxxxxxxxxxxxxxxxxxxxxx</b>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="invoice-hal">
            <p>
                <b>PASIVA</b>
            </p>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Akun</th>
                    <th>Saldo</th>
                </tr>
            </thead>
            <tbody>
                <!-- Detail transaksi -->
                <tr>
                    <td>1</td>
                    <td>aan</td>
                    <td>Rp. </td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: right;">Total</td>
                    <td>Rp. </td>
                </tr>
                <tr>
                    <td colspan="2"><b>
                        TOTAL PASIVA
                    </b></td>
                    <td>
                        <b>Rp.xxxxxxxxxxxxxxxxxxxxxx</b>
                    </td>
                </tr>
            </tbody>
        </table>
  </div>
</body>
</html>
