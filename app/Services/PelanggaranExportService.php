<?php

namespace App\Services;

use App\Models\Pelanggaran;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PelanggaranExportService
{
    /**
     * Generate PhpSpreadsheet instance for Pelanggaran report.
     *
     * @param int|string|null $year
     * @param array<string, mixed> $filters
     * @return Spreadsheet
     */
    public function generate($year = null, array $filters = []): Spreadsheet
    {
        if (!empty($year) && empty($filters['year'])) {
            $filters['year'] = $year;
        }
        $activeYear = $filters['year'] ?? null;

        $pelanggarans = Pelanggaran::query()
            ->applyFilters($filters)
            ->orderBy('tgl_laporan', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Laporan Pelanggaran');

        // Page setup
        $sheet->setShowGridLines(true);

        // 1. Judul Laporan
        $sheet->mergeCells('A1:M1');
        $sheet->setCellValue('A1', 'LAPORAN DATA KASUS PELANGGARAN PEMANFAATAN RUANG (SIMTARU)');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(15)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('1E293B'));
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getRowDimension(1)->setRowHeight(30);

        // Subtitle / Info Filter & Tanggal
        $periodeText = !empty($activeYear) ? "Tahun: $activeYear" : "Periode: Semua Tahun";
        $waktuCetak = "Dicetak pada: " . now()->translatedFormat('d F Y H:i:s');
        $sheet->mergeCells('A2:M2');
        $sheet->setCellValue('A2', "$periodeText | $waktuCetak | Total: " . $pelanggarans->count() . " Kasus");
        $sheet->getStyle('A2')->getFont()->setSize(10)->setItalic(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('64748B'));
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getRowDimension(2)->setRowHeight(20);

        // 2. Header Tabel
        $headers = [
            'A' => 'No',
            'B' => 'No. Kasus',
            'C' => 'Tgl Pengawasan',
            'D' => 'Sumber',
            'E' => 'Nama',
            'F' => 'Alamat',
            'G' => 'Kelurahan',
            'H' => 'Kecamatan',
            'I' => 'Jenis Indikasi Pelanggaran',
            'J' => 'Hasil Temuan Pelanggaran',
            'K' => 'Klasifikasi Pelanggaran',
            'L' => 'Tindak Lanjut',
            'M' => 'Status Berkas',
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
        $sheet->getStyle("A{$headerRow}:M{$headerRow}")->applyFromArray($headerStyle);

        // 3. Isi Data
        $row = 5;
        $no = 1;

        foreach ($pelanggarans as $p) {
            $sheet->getRowDimension($row)->setRowHeight(22);

            // Format Tanggal Pengawasan
            $tglPengawasan = $p->tanggal_pengawasan
                ? Carbon::parse($p->tanggal_pengawasan)->format('d-m-Y')
                : ($p->tgl_laporan ? Carbon::parse($p->tgl_laporan)->format('d-m-Y') : '-');

            $klasifikasi = $p->klasifikasi_pelanggaran
                ?: ($p->temuan_pelanggaran === 'Tidak Ada Pelanggaran' ? 'Tidak Ada' : '-');

            // Nilai kolom
            $sheet->setCellValue("A{$row}", $no);
            $sheet->setCellValue("B{$row}", $p->no_pelanggaran ?? '-');
            $sheet->setCellValue("C{$row}", $tglPengawasan);
            $sheet->setCellValue("D{$row}", $p->sumber_informasi_pelanggaran ?? '-');
            $sheet->setCellValue("E{$row}", $p->nama_pelanggar ?? '-');
            $sheet->setCellValue("F{$row}", $p->alamat_pelanggaran ?? '-');
            $sheet->setCellValue("G{$row}", $p->kel_pelanggaran ?? '-');
            $sheet->setCellValue("H{$row}", $p->kec_pelanggaran ?? '-');
            $sheet->setCellValue("I{$row}", $p->jenis_indikasi_pelanggaran ? $p->indikasi_full_text : '-');
            $sheet->setCellValue("J{$row}", $p->temuan_pelanggaran ?: '-');
            $sheet->setCellValue("K{$row}", $klasifikasi);
            $sheet->setCellValue("L{$row}", $p->tindak_lanjut ?: '-');
            $sheet->setCellValue("M{$row}", $p->status ?: '-');

            // Zebra striping
            if ($row % 2 == 0) {
                $sheet->getStyle("A{$row}:M{$row}")->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('F8FAFC');
            }

            $row++;
            $no++;
        }

        $lastRow = max($row - 1, $headerRow);

        // Alignment per kolom
        $sheet->getStyle("A5:A{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("B5:C{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("D5:J{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle("K5:K{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("L5:L{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle("M5:M{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Vertical center semua data cell
        $sheet->getStyle("A5:M{$lastRow}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        // Borders
        $dataBorderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'E2E8F0'],
                ],
            ],
        ];
        $sheet->getStyle("A{$headerRow}:M{$lastRow}")->applyFromArray($dataBorderStyle);

        // Auto size columns
        foreach (range('A', 'M') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        return $spreadsheet;
    }

    /**
     * Download as Excel stream response.
     *
     * @param int|string|null $year
     * @param array<string, mixed> $filters
     * @return StreamedResponse
     */
    public function download($year = null, array $filters = []): StreamedResponse
    {
        $spreadsheet = $this->generate($year, $filters);
        $activeYear = !empty($year) ? $year : ($filters['year'] ?? null);
        $filenameYear = !empty($activeYear) ? $activeYear : 'Semua_Tahun';
        $filename = "Laporan_Pelanggaran_SIMTARU_{$filenameYear}_" . date('Ymd_His') . ".xlsx";

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'max-age=0, no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
        ]);
    }
}
