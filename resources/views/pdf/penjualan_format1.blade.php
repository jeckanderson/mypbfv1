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
    margin-right: 15px;

  }

  .company-info {
    flex-grow: 1;
    font-size: 12px; 
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
    display: flex;
    justify-content: space-between;
  }
  .signature-box {
    width: 45%;
    text-align: center;
    font-family: Arial, sans-serif;
    font-size: 12px;
  }
  .info {
    border: 1px solid black;
    padding: 5px 6px;
    width: 200px;
  }
</style>
</head>
<body>
  <div class="container">
    <div class="header">
        <div class="logo">
            <img src="" alt="Logo" style="max-width: 100%;">
        </div>
      <div class="company-info">
        <p>PT.xxxxxxxxxx</p>
        <p>Jl.xxxxxxxxxxx</p>
        <p>No. PBF : </p>
        <p>CDOB : </p>
        <p>NPWP : </p>
        <P>No. Telepon : </P>
      </div>
      <div class="company-info">
        <div class="info">
            <h1 style="font-size: 14px;text-align: center;"><b>FAKTUR PENJUALAN</b></h1>
            <img src="" alt="qr barcode" style="text-align: center;">
            <p>No. xxxxxxxxx</p>
            <p>No. Pajak : xxxxx</p>
            <p>PO : 21 Hari</p>
            <p>Tgl JT :</p>
        </div>
      </div>
      <div class="company-info">
        <p style="text-align: center;">7 Februari 2024</p>
        <p>Pelanggan :</p>
        <p>Jl.xxxxxxx</p>
        <p>NPWP :</p>
        <p>Sales :</p>
        <p>Status Kredit</p>
        <p>Lembar : 1/1</p>
      </div>
    </div>
      <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Produk</th>
                <th>No. Batch</th>
                <th>Expired</th>
                <th>Satuan</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Disc 1</th>
                <th>Disc 2</th>
                <th>Total</th>
              </tr>
        </thead>
        <tbody>
          <!-- Detail pemesanan -->
          <tr>
            <td>1</td>
            <td>Item 1</td>
            <td>Deskripsi Item 1</td>
            <td>1</td>
            <td>100</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td colspan="10">Terbilang</td>
          </tr>
          <tr>
            <td rowspan="3" colspan="8">Keterangan :</td>
            <tr>
                <td colspan="2">Sub total</td>
            </tr>
            <tr>
                <td colspan="2">Disc</td>
            </tr>
          </tr>
          <tr>
            <td colspan="2" style="text-align: center;">Penerima</td>
            <td colspan="3" style="text-align: center;">Note</td>
            <td colspan="3" style="text-align: center;">Apoteker Penanggung Jawab</td>
            <td colspan="2">DPP</td>
          </tr>
          <tr>
            <td rowspan="6" colspan="2" style="text-align: center;"></td>
            <td rowspan="6" colspan="3" style="text-align: center;"></td>
            <td rowspan="6" colspan="3" style="text-align: center;">Nama Apoteker</td>
            <tr>
                <td colspan="2">PPN</td>
            </tr>
            <tr>
                <td colspan="2">Biaya 1</td>
            </tr>
            <tr>
                <td colspan="2">Biaya 2</td>
            </tr>
            <tr>
                <td colspan="2">Bayar</td>
            </tr>
            <tr>
                <td colspan="2"><b>Total</b></td>
            </tr>
          </tr>
      </tbody>
      </table>
  </div>
</body>
</html>
