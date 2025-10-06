<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Tanda Terima Permohonan - A5</title>
    <style>
        /* A5 = 148mm x 210mm (portrait) */
        @page {
            size: A5 portrait;
            margin: 12mm;
        }

        /* Page container sized for screen preview */
        .page {
            width: 148mm;
            height: 210mm;
            margin: 10px auto;
            padding: 12mm;
            box-sizing: border-box;
            background: #fff;
            color: #111;
            font-family: "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            font-size: 12px;
            line-height: 1.25;
        }

        header {
            text-align: center;
            margin-bottom: 8px;
        }

        .agency {
            font-weight: 700;
            font-size: 13px;
            letter-spacing: 0.6px;
        }

        .sub-agency {
            font-size: 11px;
        }

        .contact {
            font-size: 10px;
            margin-top: 4px;
        }

        h1.title {
            font-size: 14px;
            margin: 12px 0;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .fields {
            width: 100%;
            margin-top: 6px;
            border-collapse: collapse;
        }

        .fields td.label {
            width: 32%;
            vertical-align: top;
            padding: 6px 8px;
            font-weight: 600;
        }

        .fields td.value {
            padding: 6px 8px;
            border-bottom: 1px dashed #aaa;
        }

        /* multi-line value box */
        .value.multiline {
            min-height: 36px;
        }

        .service-list {
            margin-top: 8px;
            padding-left: 0;
            list-style: none;
        }

        .signatures {
            margin-top: 18px;
            display: flex;
            justify-content: space-between;
            gap: 12px;
        }

        .sig-box {
            width: 48%;
            text-align: center;
            min-height: 70px;
        }

        .sig-line {
            display: block;
            margin-top: 40px;
            border-top: 1px solid #000;
            width: 80%;
            margin-left: auto;
            margin-right: auto;
        }

        .note {
            font-size: 10px;
            margin-top: 10px;
        }

        a.link {
            color: #0b66c3;
            text-decoration: none;
            word-break: break-all;
        }

        /* Print friendly */
        @media print {
            body {
                margin: 0;
                background: none;
            }

            .page {
                box-shadow: none;
                margin: 0;
            }
        }
    </style>
</head>

<body>
    <div class="page" role="document">
        <header>
            <div class="agency">PEMERINTAH KOTA MATARAM</div>
            <div class="agency">DINAS PEKERJAAN UMUM DAN PENATAAN RUANG</div>
            <div class="sub-agency">
                Jalan Semanggi Nomor 19 Mataram, Nusa Tenggara Barat<br />
                Telepon: (0370) 633095, 646670 &nbsp; | &nbsp; Posel: pu.mataram@gmail.com
            </div>
        </header>

        <h1 class="title">TANDA TERIMA PERMOHONAN KESESUAIAN PEMANFAATAN RUANG</h1>

        <table class="fields" aria-label="Form fields">
            <tr>
                <td class="label">Nomor Register</td>
                <td class="value"></td>
            </tr>
            <tr>
                <td class="label">Nama Pemohon</td>
                <td class="value"></td>
            </tr>
            <tr>
                <td class="label">Alamat Persil</td>
                <td class="value multiline"></td>
            </tr>
            <tr>
                <td class="label">Fungsi Bangunan</td>
                <td class="value"></td>
            </tr>
            <tr>
                <td class="label">Tanggal Permohonan</td>
                <td class="value"></td>
            </tr>
            <tr>
                <td class="label">Jenis Layanan</td>
                <td class="value"></td>
            </tr>
        </table>

        <div style="margin-top:12px;">
            <strong>Petugas Penerima Berkas</strong>
            <div class="signatures" style="margin-top:8px;">
                <div class="sig-box">
                    <div style="height:28px"></div>
                    <span class="sig-line"></span>
                </div>
                <div class="sig-box">
                    <div style="height:28px"></div>
                    <span class="sig-line"></span>
                </div>
            </div>
        </div>

        <div class="note">
            <strong>Ket:</strong><br />
            Pemohon dapat melihat proses penyelesaian berkas melalui website.<br />
            Pemohon dapat berkonsultasi terkait pelayanan penerbitan dokumen kesesuaian pemanfaatan ruang melalui WA:
            <strong>0895 3267 53064</strong> atau melalui link:
            <div style="margin-top:6px;">
                <a class="link" href="#" target="_blank" rel="noopener noreferrer">https://...</a>
            </div>
        </div>

        <!-- Source note (from uploaded document) -->
        <footer style="position: absolute; bottom: 12mm; left: 12mm; right: 12mm; font-size:10px; text-align:right;">
            <!-- citation woven into the response -->
            Dokumen sumber: TANDA TERIMA.docx. :contentReference[oaicite:1]{index=1}
        </footer>
    </div>
</body>

</html>
