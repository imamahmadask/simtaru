<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Resume Pelanggaran — {{ $pelanggaran->no_pelanggaran }}</title>
    <style>
        @page {
            size: a4 portrait;
            margin: 11mm 13mm;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10.2px;
            color: #1e293b;
            margin: 0;
            padding: 0;
        }

        .rc-card {
            border: 1.5px solid #475569;
            border-radius: 8px;
            overflow: hidden;
            background: #ffffff;
        }

        .rc-header {
            padding: 10px 14px;
            text-align: center;
            color: #ffffff;
            font-weight: bold;
            font-size: 12.5px;
            letter-spacing: 0.4px;
            text-transform: uppercase;
        }

        .rc-header-navy {
            background: #132238;
        }

        .rc-header-crimson {
            background: #bf3916;
        }

        .rc-photo-box {
            width: 100%;
            height: 175px;
            background: #f1f5f9;
            border-bottom: 1.5px solid #cbd5e1;
            text-align: center;
            overflow: hidden;
        }

        .rc-photo-box img {
            width: 100%;
            height: 175px;
            object-fit: cover;
        }

        .rc-photo-placeholder {
            padding: 46px 18px;
            color: #475569;
            text-align: center;
            background: #e2e8f0;
            height: 83px;
        }

        .rc-table {
            width: 100%;
            border-collapse: collapse;
        }

        .rc-table tr {
            page-break-inside: avoid;
        }

        .rc-table > tbody > tr > th,
        .rc-table > tbody > tr > td {
            border-bottom: 1px solid #cbd5e1;
            padding: 8px 12px;
            vertical-align: top;
        }

        .rc-table > tbody > tr:last-child > th,
        .rc-table > tbody > tr:last-child > td {
            border-bottom: none;
        }

        .rc-table > tbody > tr > th {
            width: 31%;
            text-align: left;
            font-weight: bold;
            font-size: 10.2px;
            color: #1e293b;
            border-right: 1px solid #cbd5e1;
            background: #f8fafc;
        }

        .rc-table > tbody > tr > td {
            width: 69%;
            font-size: 10.2px;
            line-height: 1.4;
            background: #ffffff;
        }

        .rc-subtable {
            width: 100%;
            border-collapse: collapse;
        }

        .rc-subtable td {
            border: none !important;
            border-bottom: 1px dashed #e2e8f0 !important;
            padding: 3px 0 !important;
            font-size: 9.8px;
            vertical-align: top;
        }

        .rc-subtable tr:last-child td {
            border-bottom: none !important;
        }

        .rc-sub-lbl {
            width: 48%;
            color: #475569;
            font-weight: bold;
            padding-right: 8px !important;
        }

        .rc-sub-val {
            width: 52%;
            color: #0f172a;
        }

        .rc-inner-table {
            width: 100%;
            border-collapse: collapse;
        }

        .rc-inner-table td {
            border: none !important;
            padding: 0 !important;
            vertical-align: top;
        }

        .rc-pill-col {
            width: 92px;
            padding-right: 10px !important;
        }

        .rc-pill {
            display: inline-block;
            border-radius: 14px;
            padding: 3px 12px;
            font-weight: bold;
            font-size: 9.8px;
            color: #ffffff;
            text-align: center;
            min-width: 58px;
        }

        .rc-pill-wide {
            padding: 4px 14px;
            font-size: 10.2px;
        }

        .rc-pill-low {
            background-color: #688f1c;
        }

        .rc-pill-med {
            background-color: #f5a623;
        }

        .rc-pill-high {
            background-color: #ef2323;
        }

        .rc-pill-safe {
            background-color: #16a34a;
        }

        .rc-pill-neutral {
            background-color: #64748b;
        }

        .rc-score-badge {
            display: inline-block;
            margin-left: 8px;
            padding: 2px 8px;
            border-radius: 4px;
            background: #e2e8f0;
            color: #1e293b;
            font-weight: bold;
            font-size: 9.5px;
        }

        .rc-sub-title {
            font-weight: bold;
            margin-bottom: 2px;
        }

        .rc-muted {
            color: #475569;
            font-size: 9.5px;
        }

        .rc-list {
            margin: 3px 0 0 15px;
            padding: 0;
        }

        .rc-list li {
            margin-bottom: 2px;
        }

        .rc-peta-wrap {
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            background: #f8fafc;
            padding: 6px;
            text-align: center;
            margin-bottom: 6px;
        }

        .rc-peta-wrap:last-child {
            margin-bottom: 0;
        }

        .rc-peta-wrap img {
            max-width: 100%;
            max-height: 240px;
            width: auto;
            height: auto;
        }

        .rc-note-box {
            margin-top: 10px;
            background: #fffcf2;
            border: 1.5px solid #e0a84b;
            border-radius: 7px;
            padding: 8px 12px;
            text-align: center;
            font-size: 9.8px;
            color: #1e293b;
        }
    </style>
</head>

<body>
    @php
        $pillClass = fn (?string $level) => match ($level) {
            'Rendah', 'Pelanggaran Rendah' => 'rc-pill-low',
            'Sedang', 'Pelanggaran Sedang' => 'rc-pill-med',
            'Tinggi', 'Pelanggaran Tinggi' => 'rc-pill-high',
            'Tidak Ada Pelanggaran' => 'rc-pill-safe',
            default => 'rc-pill-neutral',
        };
        $profil = $resume['profil_lokasi'] ?? [];
        $petaDeliniasiDataUris = $petaDeliniasiDataUris ?? [];
    @endphp

    <div class="rc-card">
        <div class="rc-header {{ $isHighTipologi ? 'rc-header-crimson' : 'rc-header-navy' }}">
            RESUME PELANGGARAN — {{ $pelanggaran->no_pelanggaran }}
        </div>

        <div class="rc-photo-box">
            @if ($fotoDataUri)
                <img src="{{ $fotoDataUri }}" alt="Foto Kasus {{ $pelanggaran->no_pelanggaran }}">
            @else
                <div class="rc-photo-placeholder">
                    <div style="font-weight: bold; font-size: 12.5px; color: #1e293b;">
                        {{ $pelanggaran->nama_pemilik_display !== '-' ? $pelanggaran->nama_pemilik_display : 'Lokasi Kasus Pelanggaran' }}
                    </div>
                    <div style="margin-top: 4px; font-size: 10px;">
                        {{ $pelanggaran->alamat_pelanggaran ?? '-' }}
                        @if ($pelanggaran->kel_pelanggaran)
                            , Kel. {{ $pelanggaran->kel_pelanggaran }}
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <table class="rc-table">
            <tbody>
                <tr>
                    <th>Penjelasan Singkat Kasus</th>
                    <td>
                        <div>{{ $resume['kasus'] }}</div>
                        @if (!empty($resume['pasal_aturan_dilanggar']))
                            <div class="rc-muted" style="margin-top: 4px;">
                                <strong style="color: #1e293b;">Pasal &amp; Aturan Dilanggar:</strong>
                                {{ $resume['pasal_aturan_dilanggar'] }}
                            </div>
                        @endif
                        @if (!empty($resume['penjelasan_lainnya']))
                            <div class="rc-muted" style="margin-top: 3px;">
                                <strong style="color: #1e293b;">Penjelasan Lainnya:</strong>
                                {{ $resume['penjelasan_lainnya'] }}
                            </div>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Profil Lokasi Indikasi Pelanggaran</th>
                    <td>
                        <table class="rc-subtable">
                            <tr>
                                <td class="rc-sub-lbl">Nama Pemilik/Perusahaan</td>
                                <td class="rc-sub-val">{{ $profil['nama_pemilik_perusahaan'] ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="rc-sub-lbl">Alamat Lokasi Pelanggaran</td>
                                <td class="rc-sub-val">{{ $profil['alamat_pelanggaran'] ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="rc-sub-lbl">Kelurahan Lokasi Pelanggaran</td>
                                <td class="rc-sub-val">{{ $profil['kel_pelanggaran'] ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="rc-sub-lbl">Kecamatan Lokasi Pelanggaran</td>
                                <td class="rc-sub-val">{{ $profil['kec_pelanggaran'] ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="rc-sub-lbl">Peruntukan Pemanfaatan Ruang dalam RTR</td>
                                <td class="rc-sub-val">{{ $profil['peruntukan_rtr'] ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="rc-sub-lbl">Pemanfaatan Ruang Eksisting</td>
                                <td class="rc-sub-val">{{ $profil['pemanfaatan_ruang_eksisting'] ?? '-' }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <th>Jenis dan Sub Pelanggaran</th>
                    <td>
                        <table class="rc-inner-table">
                            <tr>
                                @if ($resume['delik_level'])
                                    <td class="rc-pill-col">
                                        <span class="rc-pill {{ $pillClass($resume['delik_level']) }}">{{ $resume['delik_level'] }}</span>
                                    </td>
                                @endif
                                <td>
                                    @if (!empty($resume['delik_sub']))
                                        <div class="rc-sub-title">{{ $resume['delik_sub'] }}</div>
                                    @endif
                                    @if (!empty($resume['delik_items']) && count($resume['delik_items']) > 1)
                                        <ul class="rc-list rc-muted">
                                            @foreach ($resume['delik_items'] as $dItem)
                                                <li>{{ $dItem }}</li>
                                            @endforeach
                                        </ul>
                                    @elseif (!empty($resume['delik_items']))
                                        <div class="rc-muted">{{ $resume['delik_items'][0] }}</div>
                                    @elseif (empty($resume['delik_sub']))
                                        <span>{{ $resume['delik_text'] }}</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <th>Dampak</th>
                    <td>
                        <table class="rc-inner-table">
                            <tr>
                                @if ($resume['dampak_level'])
                                    <td class="rc-pill-col">
                                        <span class="rc-pill {{ $pillClass($resume['dampak_level']) }}">{{ $resume['dampak_level'] }}</span>
                                    </td>
                                @endif
                                <td>{{ $resume['dampak_text'] }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <th>Skala dan Intensitas Pelanggaran</th>
                    <td>{{ $resume['skala_label'] ?: '-' }}</td>
                </tr>
                <tr>
                    <th>Riwayat Pelanggaran</th>
                    <td>{{ $resume['riwayat_label'] ?: '-' }}</td>
                </tr>
                <tr>
                    <th>Hasil Tipologi</th>
                    <td>
                        @if ($resume['tipologi'])
                            <span class="rc-pill rc-pill-wide {{ $pillClass($resume['tipologi']) }}">{{ $resume['tipologi'] }}</span>
                        @else
                            <span class="rc-muted" style="font-style: italic;">Belum ditetapkan</span>
                        @endif
                        @if ($resume['skor_total'] !== null)
                            <span class="rc-score-badge">
                                Skor: {{ rtrim(rtrim(number_format((float) $resume['skor_total'], 2, '.', ''), '0'), '.') }}
                            </span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Rekomendasi Penanganan</th>
                    <td>{{ $resume['rekomendasi_penanganan'] ?? $resume['arah'] }}</td>
                </tr>
                <tr>
                    <th>Petugas Analis</th>
                    <td style="font-weight: bold;">{{ $resume['petugas_analis'] ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Peta Deliniasi</th>
                    <td>
                        @if (!empty($petaDeliniasiDataUris))
                            @foreach ($petaDeliniasiDataUris as $petaUri)
                                <div class="rc-peta-wrap">
                                    <img src="{{ $petaUri }}" alt="Peta Deliniasi {{ $pelanggaran->no_pelanggaran }}">
                                </div>
                            @endforeach
                        @else
                            <span class="rc-muted" style="font-style: italic;">Belum ada peta deliniasi yang diunggah.</span>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="rc-note-box">
        <strong style="color: #dc2626;">Catatan:</strong> rekomendasi penanganan mengacu pada pedoman sanksi administratif; ketentuan final mengikuti hasil akhir kajian.
    </div>
</body>

</html>
