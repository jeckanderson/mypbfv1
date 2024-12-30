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
  .note {
    flex-grow: 1;
    font-size: 12px;
    margin-left: 8pc;
  }

  .title {
    text-align: center;
    font-size: 12px;
    margin-bottom: 0;
    background-color: rgb(175, 177, 177);
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
    margin-left: 12pc;
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
    <div class="logo">
        <img src="" alt="Logo" style="max-width: 100%;">
    </div>
    <div class="header">
      <div class="company-info" style="margin-right: 17pc;">
        <h3 style="font-size: 14px;">PT.xxxxx</h3>
        <p>Alamat : </p>
        <p>No. Telepon : </p>
        <p>No. Izin PBF : </p>
      </div>
      <div class="company-info">
        <p><b>
            Semarang, 10 Februari 2024
        </b></p>
        <p>No. Reff : xxxxxxxxxxxxx</p>
      </div>
    </div>
    <div class="title">
        <h2>NOTA PEMBAYARAN PIUTANG</h2>
    </div>
      <div class="note">
        <p>Sudah diterimakan dari : [Nama Pelanggan]</p>
        <p>Uang Sejumlah : Rp.150.000</p>
        <p>Terbilang : <b><i>
            Seratus lima puluh ribu rupiah
        </i></b></p>
        <p>Untuk Pembayaran nomor faktur : </p>
        <p>Keterangan :</p>
      </div>
      <div class="invoice-signature">
        <div class="signature-box">
          <p style="margin-bottom: 70px;">Pimpinan</p>
          <p>xxxxxxxxxxxxx</p>
        </div>
        <div class="signature-box">
            <p style="margin-bottom: 70px;">Bag Keuangan</p>
            <p>xxxxxxxxxxxxxx</p>
        </div>
      </div>
  </div>
</body>
</html>
