<?php

namespace App\Services;

use App\Models\Permohonan;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PermohonanExportService
{
    /**
     * Generate PhpSpreadsheet instance for Permohonan report.
     *
     * @param int|string|null $year
     * @return Spreadsheet
     */
    public function generate($year = null): Spreadsheet
    {
        $query = Permohonan::with(['layanan', 'registrasi', 'skrk', 'itr', 'kkprb', 'kkprnb'])
            ->orderBy('created_at', 'desc');

        if (!empty($year)) {
            $query->whereYear('created_at', $year);
        }

        $permohonans = $query->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Laporan Permohonan');

        // Page setup
        $sheet->setShowGridLines(true);

        // 1. Judul Laporan
        $sheet->mergeCells('A1:K1');
        $sheet->setCellValue('A1', 'LAPORAN DATA PERMOHONAN SIMTARU');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('1E293B'));
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getRowDimension(1)->setRowHeight(30);

        // Subtitle / Info Filter & Tanggal
        $periodeText = !empty($year) ? "Tahun: $year" : "Periode: Semua Tahun";
        $waktuCetak = "Dicetak pada: " . now()->translatedFormat('d F Y H:i:s');
        $sheet->mergeCells('A2:K2');
        $sheet->setCellValue('A2', "$periodeText | $waktuCetak | Total: " . $permohonans->count() . " Berkas");
        $sheet->getStyle('A2')->getFont()->setSize(10)->setItalic(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('64748B'));
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getRowDimension(2)->setRowHeight(20);

        // 2. Header Tabel
        $headers = [
            'A' => 'No',
            'B' => 'No. Registrasi',
            'C' => 'Jenis Layanan',
            'D' => 'Nama Pemohon',
            'E' => 'Alamat Tanah',
            'F' => 'Kelurahan',
            'G' => 'Kecamatan',
            'H' => 'Luas Permohonan (m²)',
            'I' => 'Luas Disetujui (m²)',
            'J' => 'Jenis Peruntukan Pemanfaatan Ruang',
            'K' => 'Status Berkas',
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

        foreach ($permohonans as $p) {
            $sheet->getRowDimension($row)->setRowHeight(22);

            // Jenis Layanan
            $jenisLayanan = $p->layanan->nama ?? '-';

            // Nama Pemohon
            $namaPemohon = $p->registrasi->nama ?? '-';

            // Alamat Tanah, Kelurahan, Kecamatan
            $alamatTanah = $p->registrasi->alamat_tanah ?? '-';
            $kelurahan = $p->registrasi->kel_tanah ?? '-';
            $kecamatan = $p->registrasi->kec_tanah ?? '-';

            // Luas Permohonan
            $luasPermohonan = $p->luas_tanah ?: '-';

            // Luas Disetujui
            $luasDisetujui = null;
            if ($p->skrk && !empty($p->skrk->luas_disetujui)) {
                $luasDisetujui = $p->skrk->luas_disetujui;
            } elseif ($p->itr && !empty($p->itr->luas_disetujui)) {
                $luasDisetujui = $p->itr->luas_disetujui;
            } elseif ($p->kkprb && !empty($p->kkprb->luas_disetujui)) {
                $luasDisetujui = $p->kkprb->luas_disetujui;
            } elseif ($p->kkprnb && !empty($p->kkprnb->luas_disetujui)) {
                $luasDisetujui = $p->kkprnb->luas_disetujui;
            }
            $luasDisetujui = $luasDisetujui ?: '-';

            // Jenis Peruntukan Pemanfaatan Ruang
            $peruntukan = null;
            if ($p->skrk) {
                $peruntukan = $p->skrk->pemanfaatan_ruang ?: $p->skrk->pola_ruang;
            } elseif ($p->itr) {
                $peruntukan = $p->itr->pemanfaatan_ruang ?: $p->itr->pola_ruang;
            } elseif ($p->kkprb) {
                $peruntukan = $p->kkprb->jenis_usaha ?: ($p->kkprb->jenis_kegiatan ?: $p->kkprb->pola_ruang);
            } elseif ($p->kkprnb) {
                $peruntukan = $p->kkprnb->jenis_kegiatan ?: $p->kkprnb->pola_ruang;
            }
            // Fallback ke fungsi_bangunan dari registrasi awal jika hasil kajian belum terisi
            if (empty($peruntukan)) {
                $peruntukan = $p->registrasi?->fungsi_bangunan;
            }
            $peruntukan = $peruntukan ?: '-';

            // Status Berkas
            if ($p->is_ditolak || ($p->registrasi && $p->registrasi->status === 'Berkas Ditolak')) {
                $statusBerkas = 'Berkas Ditolak';
            } elseif ($p->registrasi && $p->registrasi->status === 'Berkas Dicabut') {
                $statusBerkas = 'Berkas Dicabut';
            } elseif ($p->registrasi && $p->registrasi->status === 'Berkas Tidak Lengkap') {
                $statusBerkas = 'Berkas Tidak Lengkap';
            } elseif ($p->is_done || in_array(strtolower((string) $p->status), ['completed', 'success', 'selesai'])) {
                $statusBerkas = 'Selesai';
            } else {
                $statusBerkas = $p->status ?: 'Dalam Proses';
            }

            if ($p->posisi_berkas && !in_array($statusBerkas, ['Selesai', 'Berkas Ditolak', 'Berkas Dicabut'])) {
                $statusBerkas .= ' (' . $p->posisi_berkas . ($p->proses_berkas ? ' - ' . $p->proses_berkas : '') . ')';
            }

            // Set cell values
            $sheet->setCellValue("A{$row}", $no);
            $sheet->setCellValue("B{$row}", $p->registrasi->kode ?? '-');
            $sheet->setCellValue("C{$row}", $jenisLayanan);
            $sheet->setCellValue("D{$row}", $namaPemohon);
            $sheet->setCellValue("E{$row}", $alamatTanah);
            $sheet->setCellValue("F{$row}", $kelurahan);
            $sheet->setCellValue("G{$row}", $kecamatan);
            $sheet->setCellValue("H{$row}", $luasPermohonan);
            $sheet->setCellValue("I{$row}", $luasDisetujui);
            $sheet->setCellValue("J{$row}", $peruntukan);
            $sheet->setCellValue("K{$row}", $statusBerkas);

            // Row zebra striping
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
        $sheet->getStyle("B5:B{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("C5:G{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle("H5:I{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle("J5:J{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle("K5:K{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

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
        $filename = "Laporan_Permohonan_SIMTARU_{$filenameYear}_" . date('Ymd_His') . ".xlsx";

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
