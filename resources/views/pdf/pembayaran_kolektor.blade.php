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
    <div class="title">
        <h2 style="text-decoration-line: underline;">BUKTI PEMBAYARAN PIUTANG</h2>
    </div>
        <div class="sub-title">
            <p>No. Reff : </p>
            <p>Tanggal : (tanggal input)</p>
            <img src="" alt="barcode" style="margin-left: 18pc;">
        </div>
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
        <p>Kolektor :</p>
      </div>
    </div>
    <div class="invoice-hal">
        <p>
            <b>Akun Bayar : Kas Besar</b>
        </p>
    </div>
      <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Pelanggan</th>
                <th>Tgl. Faktur</th>
                <th>No. Faktur</th>
                <th>Total Piutang</th>
                <th>Total Bayar</th>
                <th>Sisa Piutang</th>
              </tr>
        </thead>
        <tbody>
          <!-- Detail pemesanan -->
          <tr>
            <td>1</td>
            <td>aan</td>
            <td>Item 1</td>
            <td>Deskripsi Item 1</td>
            <td>1</td>
            <td>100</td>
            <td>100</td>
          </tr>
          <tr>
            <td colspan="4" style="text-align: center;"><b>Total</b></td>
            <td>xxxxxxxxx</td>
            <td>xxxxxxxx</td>
            <td>xxxxxxxxxxx</td>
          </tr>
      </tbody>
      </table>
      <div class="invoice-hal">
        <p>
            <b>Keterangan :</b>
        </p>
      </div>
      <div class="invoice-signature">
        <div class="signature-box">
          <p style="margin-bottom: 70px;">Dibuat Oleh</p><br>
          <p>Nama User</p>
        </div>
        <div class="signature-box">
          <p>Pimpinan</p>
        </div>
        <div class="signature-box">
            <p>Bag Keuangan</p>
          </div>
      </div>
  </div>
</body>
</html>
