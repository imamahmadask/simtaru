<?php

namespace App\Services;

use App\Models\Penilaian;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PenilaianExportService
{
    /**
     * List of official kecamatan in Kota Mataram.
     */
    protected static array $kecamatans = [
        'Ampenan', 'Cakranegara', 'Mataram', 'Sandubaya', 'Sekarbela', 'Selaparang'
    ];

    /**
     * Mapping of kelurahan to its parent kecamatan in Kota Mataram.
     */
    protected static array $kelurahanToKecamatanMap = [
        // Ampenan
        'Ampenan Selatan' => 'Ampenan',
        'Ampenan Tengah' => 'Ampenan',
        'Ampenan Utara' => 'Ampenan',
        'Banjar' => 'Ampenan',
        'Bintaro' => 'Ampenan',
        'Dayen Peken' => 'Ampenan',
        'Kebun Sari' => 'Ampenan',
        'Pejeruk' => 'Ampenan',
        'Taman Sari' => 'Ampenan',

        // Cakranegara
        'Cakranegara Barat' => 'Cakranegara',
        'Cakranegara Selatan' => 'Cakranegara',
        'Cakranegara Selatan Baru' => 'Cakranegara',
        'Cakranegara Timur' => 'Cakranegara',
        'Cakranegara Utara' => 'Cakranegara',
        'Cilinaya' => 'Cakranegara',
        'Karang Taliwang' => 'Cakranegara',
        'Mayura' => 'Cakranegara',
        'Sapta Marga' => 'Cakranegara',
        'Sayang-Sayang' => 'Cakranegara',

        // Mataram
        'Mataram Barat' => 'Mataram',
        'Mataram Timur' => 'Mataram',
        'Pagesangan' => 'Mataram',
        'Pagesangan Barat' => 'Mataram',
        'Pagesangan Timur' => 'Mataram',
        'Pagutan' => 'Mataram',
        'Pagutan Barat' => 'Mataram',
        'Pagutan Timur' => 'Mataram',
        'Pejanggik' => 'Mataram',
        'Punia' => 'Mataram',

        // Sandubaya
        'Abian Tubuh Baru' => 'Sandubaya',
        'Babakan' => 'Sandubaya',
        'Bertais' => 'Sandubaya',
        'Dasan Cermen' => 'Sandubaya',
        'Mandalika' => 'Sandubaya',
        'Selagalas' => 'Sandubaya',
        'Turida' => 'Sandubaya',

        // Sekarbela
        'Jempong Baru' => 'Sekarbela',
        'Karang Pule' => 'Sekarbela',
        'Kekalik Jaya' => 'Sekarbela',
        'Tanjung Karang' => 'Sekarbela',
        'Tanjung Karang Permai' => 'Sekarbela',

        // Selaparang
        'Dasan Agung' => 'Selaparang',
        'Dasan Agung Baru' => 'Selaparang',
        'Gomong' => 'Selaparang',
        'Karang Baru' => 'Selaparang',
        'Monjok' => 'Selaparang',
        'Monjok Barat' => 'Selaparang',
        'Monjok Timur' => 'Selaparang',
        'Rembiga' => 'Selaparang',
        'Selaparang' => 'Selaparang',
    ];

    /**
     * Generate PhpSpreadsheet instance for Penilaian report.
     *
     * @param int|string|null $year
     * @return Spreadsheet
     */
    public function generate($year = null): Spreadsheet
    {
        $query = Penilaian::query()
            ->orderBy('tanggal_penilaian', 'desc')
            ->orderBy('id', 'desc');

        if (!empty($year)) {
            $query->whereYear('tanggal_penilaian', $year);
        }

        $penilaians = $query->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Laporan Penilaian');

        // Page setup
        $sheet->setShowGridLines(true);

        // 1. Judul Laporan
        $sheet->mergeCells('A1:K1');
        $sheet->setCellValue('A1', 'LAPORAN DATA PENILAIAN PEMANFAATAN RUANG (SIMTARU)');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(15)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('1E293B'));
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getRowDimension(1)->setRowHeight(30);

        // Subtitle / Info Filter & Tanggal
        $periodeText = !empty($year) ? "Tahun: $year" : "Periode: Semua Tahun";
        $waktuCetak = "Dicetak pada: " . now()->translatedFormat('d F Y H:i:s');
        $sheet->mergeCells('A2:K2');
        $sheet->setCellValue('A2', "$periodeText | $waktuCetak | Total: " . $penilaians->count() . " Data");
        $sheet->getStyle('A2')->getFont()->setSize(10)->setItalic(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('64748B'));
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getRowDimension(2)->setRowHeight(20);

        // 2. Header Tabel
        $headers = [
            'A' => 'No',
            'B' => 'No. Registrasi',
            'C' => 'Tgl Penilaian',
            'D' => 'Jenis Penilaian',
            'E' => 'Nama Pelaku Usaha',
            'F' => 'Nama Usaha',
            'G' => 'Jenis Kegiatan',
            'H' => 'Alamat',
            'I' => 'Kelurahan',
            'J' => 'Kecamatan',
            'K' => 'Hasil Analisa Penilaian',
        ];

        $headerRow = 4;
        $sheet->getRowDimension($headerRow)->setRowHeight(28);

        foreach ($headers as $col => $title) {
            $sheet->setCellValue("{$col}{$headerRow}", $title);
        }

        // Style Header
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 11,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '1E3A8A'], // Navy Blue
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'CBD5E1'],
                ],
            ],
        ];
        $sheet->getStyle("A{$headerRow}:K{$headerRow}")->applyFromArray($headerStyle);

        // 3. Isi Data
        $row = 5;
        $no = 1;

        foreach ($penilaians as $p) {
            $sheet->getRowDimension($row)->setRowHeight(22);

            // Format Tanggal Penilaian
            $tglPenilaian = $p->tanggal_penilaian
                ? Carbon::parse($p->tanggal_penilaian)->format('d-m-Y')
                : '-';

            // Ekstraksi Kelurahan & Kecamatan dari alamat
            $kelurahan = $this->extractKelurahan($p->alamat_lokasi_usaha, $p->alamat_pelaku_usaha);
            $kecamatan = $this->extractKecamatan($p->alamat_lokasi_usaha, $p->alamat_pelaku_usaha, $kelurahan);

            // Nilai kolom
            $sheet->setCellValue("A{$row}", $no);
            $sheet->setCellValue("B{$row}", $p->nomor_dokumen ?: '-');
            $sheet->setCellValue("C{$row}", $tglPenilaian);
            $sheet->setCellValue("D{$row}", $p->jenis_penilaian ?: '-');
            $sheet->setCellValue("E{$row}", $p->nama_pelaku_usaha ?: '-');
            $sheet->setCellValue("F{$row}", $p->nama_usaha ?: '-');
            $sheet->setCellValue("G{$row}", $p->jenis_kegiatan_usaha ?: '-');
            $sheet->setCellValue("H{$row}", $p->alamat_lokasi_usaha ?: '-');
            $sheet->setCellValue("I{$row}", $kelurahan);
            $sheet->setCellValue("J{$row}", $kecamatan);
            $sheet->setCellValue("K{$row}", $p->analisa_penilaian ?: '-');

            // Zebra striping
            if ($row % 2 == 0) {
                $sheet->getStyle("A{$row}:K{$row}")->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('F8FAFC');
            }

            $row++;
            $no++;
        }

        $lastRow = max($row - 1, $headerRow);

        // Styling data cells
        $sheet->getStyle("A5:A{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("B5:D{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("E5:H{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle("I5:J{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle("K5:K{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        // Vertical center for all data cells
        $sheet->getStyle("A5:K{$lastRow}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        // Borders for all data cells
        $dataBorderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'E2E8F0'],
                ],
            ],
        ];
        $sheet->getStyle("A{$headerRow}:K{$lastRow}")->applyFromArray($dataBorderStyle);

        // Auto size columns with padding
        foreach (range('A', 'K') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        return $spreadsheet;
    }

    /**
     * Download as Excel stream response.
     *
     * @param int|string|null $year
     * @return StreamedResponse
     */
    public function download($year = null): StreamedResponse
    {
        $spreadsheet = $this->generate($year);
        $filenameYear = !empty($year) ? $year : 'Semua_Tahun';
        $filename = "Laporan_Penilaian_SIMTARU_{$filenameYear}_" . date('Ymd_His') . ".xlsx";

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'max-age=0, no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
        ]);
    }

    /**
     * Extract Kelurahan from address text.
     */
    protected function extractKelurahan(?string $textLokasi, ?string $textPelaku = null): string
    {
        $kelurahans = array_keys(static::$kelurahanToKecamatanMap);
        usort($kelurahans, fn($a, $b) => strlen($b) - strlen($a));

        foreach ([$textLokasi, $textPelaku] as $text) {
            if (empty($text)) {
                continue;
            }

            // 1. Look for explicit "Kelurahan <name>" or "Kel. <name>" or "Desa <name>"
            if (preg_match('/(?:kelurahan|kel\.?|desa(?:\/kelurahan)?)\s+([a-zA-Z\s\-]+)/i', $text, $matches)) {
                $after = trim($matches[1]);
                foreach ($kelurahans as $kel) {
                    if (stripos($after, $kel) !== false) {
                        return $kel;
                    }
                }
            }

            // 2. Direct name match in string
            foreach ($kelurahans as $kel) {
                if (stripos($text, $kel) !== false) {
                    return $kel;
                }
            }
        }

        return '-';
    }

    /**
     * Extract Kecamatan from address text or fallback to Kelurahan map.
     */
    protected function extractKecamatan(?string $textLokasi, ?string $textPelaku = null, string $kelurahan = '-'): string
    {
        foreach ([$textLokasi, $textPelaku] as $text) {
            if (empty($text)) {
                continue;
            }

            // 1. Explicit "Kecamatan <name>" or "Kec. <name>"
            if (preg_match('/(?:kecamatan|kec\.?)\s+([a-zA-Z]+)/i', $text, $matches)) {
                $word = trim($matches[1]);
                foreach (static::$kecamatans as $kec) {
                    if (strcasecmp($word, $kec) === 0 || (strcasecmp($kec, 'Selaparang') === 0 && strcasecmp($word, 'Selaprang') === 0)) {
                        return $kec;
                    }
                }
            }

            // 2. Non-Mataram kecamatan names directly in text
            $specificKec = ['Sekarbela', 'Cakranegara', 'Selaparang', 'Sandubaya', 'Ampenan'];
            foreach ($specificKec as $kec) {
                $pattern = strtolower($kec) === 'selaparang' ? '/\b(selaparang|selaprang)\b/i' : '/\b' . preg_quote($kec, '/') . '\b/i';
                if (preg_match($pattern, $text)) {
                    return $kec;
                }
            }

            // 3. Mataram (distinct from 'Kota Mataram')
            if (preg_match('/(?:kecamatan|kec\.?)\s+mataram\b/i', $text) || (!preg_match('/kota\s+mataram/i', $text) && preg_match('/\bmataram\b/i', $text))) {
                return 'Mataram';
            }
        }

        // 4. Fallback: Deducing from detected kelurahan if available
        if ($kelurahan !== '-' && isset(static::$kelurahanToKecamatanMap[$kelurahan])) {
            return static::$kelurahanToKecamatanMap[$kelurahan];
        }

        return '-';
    }
}
