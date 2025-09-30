<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <style>
        @page {
            size: a4;
            margin: 1cm;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
        }

        .header {
            text-align: center;
        }

        .image {
            text-align: center;
            width: 100%
        }

        .content {
            margin-top: 30px;
        }

        .label {
            width: 150px;
            display: inline-block;
        }

        .signature {
            margin-top: 50px;
            margin-left: 500px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="{{ public_path('assets/img/logo/kop.jpg') }}" class="image" alt="">
    </div>

    <h3 style="text-align: center; margin-top: 20px; text-decoration: underline; font-size: 16px">
        TANDA TERIMA PERMOHONAN {{ $data['layanan']['nama'] }}
    </h3>

    <div class="content">
        <p>
            <span class="label">Permohonan A.n</span>:
            {{ $data['nama'] ?? '................................' }}
        </p>
        <p>
            <span class="label">Alamat Persil</span>:
            {{ $data['alamat_tanah'] . ', ' . $data['kel_tanah'] . ', ' . $data['kec_tanah'] . ', Kota Mataram' ?? '................................' }}
        </p>
        <p>
            <span class="label">Fungsi Bangunan</span>:
            {{ $data['fungsi_bangunan'] ?? '................................' }}
        </p>
        <p>
            <span class="label">Tanggal</span>:
            {{ date('d-m-Y', strtotime($data['tanggal'])) ?? now()->format('d-m-Y') }}
        </p>
        <p>
            <span class="label">No. Register</span>: {{ $data['kode'] ?? '................................' }}
        </p>
    </div>

    <div class="signature">
        <p>Yang Menerima</p>
        <br><br><br>
        <p style="font-weight: bold">{{ Auth::user()->where('id', $data['created_by'])->first()->name }}</p>
    </div>
</body>

</html>
