<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print</title>
    <style>
        body {
            font-family: verdana, serif;
            margin: 0;
        }

        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        .table-container {
            padding: 20px;
            box-sizing: border-box;
        }

        .logo-img {
            width: 70px;
            height: auto;
            margin-right: 10px;
        }

        .img-logo {
            width: 70px;
            height: 70px;
        }
        .title{
            text-align: center;
        }
    </style>
</head>

<body onload="print()" style="margin: 10px;">
    <!-- content  -->
    <div class="header">
        <p class="title">
            @yield('title')
            PERIODE : {{ request()->mulaiId }} s/d {{ request()->selesaiId }}
        </p>
    </div>
    <br>
    <div style="display: flex;width: 100%">
        <img src="{{ url('storage/logo_perusahaan/' . $profile->logo_perusahaan) }}" alt=""
                class="img-logo" style="margin-right: 10px">
                <p>
                    <span style="font-weight: bold; font-size: 12px">{{ $profile->nama_perusahaan }}</span><br>
                    {{ $profile->alamat }} <br>
                    {{-- No PBF :{{ $profile->no_ijin_pbf }}<br>
                    No DAK : {{ $profile->no_ijin_dak }}<br>
                    CDOB : {{ $profile->no_cdob }}<br>
                    NPWP :{{ $profile->npwp }} <br> --}}
                    Tlp :{{ $profile->no_telepon }}<br>
                </p>
    </div>
    <div style="width: 100%;height: 1px;background: #000"></div>
    <div style="width: 100%;height: 1px;background: #000;margin-top:3px"></div>
    <br>
    @yield('contents')

    <!-- end content -->
</body>
<script>
    // Mendeteksi peristiwa cetak
    window.onafterprint = function() {
        // Menutup jendela setelah mencetak
        window.close();
    };
</script>

</html>
