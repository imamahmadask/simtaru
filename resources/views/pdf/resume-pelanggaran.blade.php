<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Resume Pelanggaran — {{ $pelanggaran->no_pelanggaran }}</title>
    <style>
        @page {
            size: a4 portrait;
            margin: 14mm 15mm;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #1e293b;
            margin: 0;
            padding: 0;
        }

        .rc-card {
            border: 1.5px solid #475569;
            border-radius: 10px;
            overflow: hidden;
            background: #ffffff;
        }

        .rc-header {
            padding: 12px 16px;
            text-align: center;
            color: #ffffff;
            font-weight: bold;
            font-size: 13px;
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
            height: 210px;
            background: #f1f5f9;
            border-bottom: 1.5px solid #cbd5e1;
            text-align: center;
            overflow: hidden;
        }

        .rc-photo-box img {
            width: 100%;
            height: 210px;
            object-fit: cover;
        }

        .rc-photo-placeholder {
            padding: 58px 20px;
            color: #475569;
            text-align: center;
            background: #e2e8f0;
            height: 94px;
        }

        .rc-table {
            width: 100%;
            border-collapse: collapse;
        }

        .rc-table th,
        .rc-table td {
            border-bottom: 1px solid #cbd5e1;
            padding: 11px 14px;
            vertical-align: middle;
        }

        .rc-table tr:last-child th,
        .rc-table tr:last-child td {
            border-bottom: none;
        }

        .rc-table th {
            width: 28%;
            text-align: left;
            font-weight: bold;
            font-size: 11px;
            color: #1e293b;
            border-right: 1px solid #cbd5e1;
            background: #ffffff;
        }

        .rc-table td {
            width: 72%;
            font-size: 11px;
            line-height: 1.45;
            background: #ffffff;
        }

        .rc-inner-table {
            width: 100%;
            border-collapse: collapse;
        }

        .rc-inner-table td {
            border: none !important;
            padding: 0 !important;
            vertical-align: middle;
        }

        .rc-pill-col {
            width: 100px;
            padding-right: 10px !important;
        }

        .rc-pill {
            display: inline-block;
            border-radius: 14px;
            padding: 4px 14px;
            font-weight: bold;
            font-size: 10.5px;
            color: #ffffff;
            text-align: center;
            min-width: 62px;
        }

        .rc-pill-wide {
            padding: 5px 16px;
            font-size: 11px;
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
            padding: 3px 9px;
            border-radius: 5px;
            background: #e2e8f0;
            color: #1e293b;
            font-weight: bold;
            font-size: 10px;
        }

        .rc-sub-title {
            font-weight: bold;
            margin-bottom: 3px;
        }

        .rc-muted {
            color: #475569;
            font-size: 10px;
        }

        .rc-list {
            margin: 3px 0 0 15px;
            padding: 0;
        }

        .rc-list li {
            margin-bottom: 2px;
        }

        .rc-note-box {
            margin-top: 12px;
            background: #fffcf2;
            border: 1.5px solid #e0a84b;
            border-radius: 8px;
            padding: 9px 14px;
            text-align: center;
            font-size: 10.5px;
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
                    <div style="font-weight: bold; font-size: 13px; color: #1e293b;">
                        {{ $pelanggaran->nama_pelanggar ?? 'Lokasi Kasus Pelanggaran' }}
                    </div>
                    <div style="margin-top: 5px; font-size: 10.5px;">
                        {{ $pelanggaran->alamat_pelanggaran ?? '-' }}
                        @if ($pelanggaran->kel_pelanggaran)
                            , Kel. {{ $pelanggaran->kel_pelanggaran }}
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <table class="rc-table">
            <tr>
                <th>Kasus</th>
                <td>{{ $resume['kasus'] }}</td>
            </tr>
            <tr>
                <th>Delik Pelanggaran</th>
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
                            <td>
                                <div>{{ $resume['dampak_text'] }}</div>
                                @if (!empty($resume['skala_label']) || !empty($resume['riwayat_label']))
                                    <div class="rc-muted" style="margin-top: 4px;">
                                        @if (!empty($resume['skala_label']))
                                            <div><strong>Skala:</strong> {{ $resume['skala_label'] }}</div>
                                        @endif
                                        @if (!empty($resume['riwayat_label']))
                                            <div><strong>Riwayat:</strong> {{ $resume['riwayat_label'] }}</div>
                                        @endif
                                    </div>
                                @endif
                            </td>
                        </tr>
                    </table>
                </td>
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
                <th>Arah Penanganan</th>
                <td>{{ $resume['arah'] }}</td>
            </tr>
        </table>
    </div>

    <div class="rc-note-box">
        <strong style="color: #dc2626;">Catatan:</strong> arah penanganan mengacu pada pedoman sanksi administratif; ketentuan final mengikuti hasil akhir kajian.
    </div>
</body>

</html>
