<?php

namespace App\Services;

use App\Models\DocumentTemplate;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PhpOffice\PhpWord\TemplateProcessor;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DocumentTemplateService
{
    /**
     * Dapatkan instance DocumentTemplate berdasarkan kode unik atau path file lama.
     */
    public function getTemplate(string $codeOrPath, ?string $modul = null): ?DocumentTemplate
    {
        // 1. Cari langsung berdasarkan kode unik
        $template = DocumentTemplate::where('kode', $codeOrPath)->first();
        if ($template) {
            return $template;
        }

        // 2. Cari berdasarkan default_path persis
        $template = DocumentTemplate::where('default_path', $codeOrPath)->first();
        if ($template) {
            return $template;
        }

        // 3. Cari dengan prefix modul jika disediakan
        if ($modul) {
            $pathWithModul = trim($modul, '/') . '/' . ltrim($codeOrPath, '/');
            $template = DocumentTemplate::where('default_path', $pathWithModul)
                ->orWhere(function ($q) use ($modul, $codeOrPath) {
                    $q->where('modul', $modul)
                      ->where('default_path', 'like', '%' . basename($codeOrPath));
                })
                ->first();

            if ($template) {
                return $template;
            }
        }

        // 4. Cari berdasarkan nama file saja
        $basename = basename($codeOrPath);
        return DocumentTemplate::where('default_path', 'like', '%' . $basename)->first();
    }

    /**
     * Dapatkan path fisik file template aktif di server.
     */
    public function getFilePath(string $codeOrPath, ?string $modul = null): string
    {
        $template = $this->getTemplate($codeOrPath, $modul);
        if ($template) {
            return $template->getActiveFilePath();
        }

        // Fallback jika belum terdaftar di tabel document_templates
        $normalizedPath = $modul ? trim($modul, '/') . '/' . ltrim($codeOrPath, '/') : $codeOrPath;

        $privateDefault = Storage::disk('local')->path('templates/defaults/' . $normalizedPath);
        if (file_exists($privateDefault)) {
            return $privateDefault;
        }

        $publicFallback = public_path('templates/' . $normalizedPath);
        if (file_exists($publicFallback)) {
            return $publicFallback;
        }

        // Cek path langsung jika sudah absolut
        if (file_exists($codeOrPath)) {
            return $codeOrPath;
        }

        throw new \RuntimeException("File template tidak ditemukan untuk: '{$codeOrPath}' (Modul: '{$modul}')");
    }

    /**
     * Generate file Word dari template, isi data, dan kembalikan response download.
     *
     * @param string $codeOrPath Kode unik template atau nama file
     * @param array $data Data key-value untuk replace placeholder ${key}
     * @param array|null $koordinatList Array koordinat [['x' => '...', 'y' => '...']] untuk row cloning
     * @param string|null $modul Modul terkait (skrk, itr, kkprb, kkprnb, pelanggaran, registrasi)
     * @param string|null $customOutputFilename Nama file output kustom jika ada
     */
    public function generate(
        string $codeOrPath,
        array $data,
        ?array $koordinatList = null,
        ?string $modul = null,
        ?string $customOutputFilename = null
    ): BinaryFileResponse {
        $filePath = $this->getFilePath($codeOrPath, $modul);

        $templateProcessor = new TemplateProcessor($filePath);

        // Isi seluruh data key => value
        foreach ($data as $key => $value) {
            // Pastikan nilai bukan null agar tidak error di PHPWord
            $cleanValue = $value !== null ? (string) $value : '';
            $templateProcessor->setValue($key, $cleanValue);
        }

        // Tangani tabel koordinat jika koordinatList diberikan
        if ($koordinatList !== null) {
            if (!empty($koordinatList)) {
                $templateProcessor->cloneRow('x', count($koordinatList));
                foreach ($koordinatList as $i => $point) {
                    $row = $i + 1;
                    $templateProcessor->setValue("x#{$row}", $point['x'] ?? '-');
                    $templateProcessor->setValue("y#{$row}", $point['y'] ?? '-');
                }
            } else {
                $templateProcessor->cloneRow('x', 1);
                $templateProcessor->setValue('x#1', '-');
                $templateProcessor->setValue('y#1', '-');
            }
        }

        // Tentukan nama file hasil generate
        if ($customOutputFilename) {
            $fileName = Str::finish($customOutputFilename, '.docx');
        } else {
            $baseName = str_replace('.docx', '', basename($filePath));
            $nameIdentifier = $data['nama_pemohon'] 
                ?? $data['nama_pemilik_bangunan'] 
                ?? $data['nama_pelanggar'] 
                ?? $data['jenis_indikasi_pelanggaran'] 
                ?? 'dokumen';

            $sanitizedName = preg_replace('/[^A-Za-z0-9_\-]/', '_', (string) $nameIdentifier);
            $fileName = $baseName . '_' . $sanitizedName . '.docx';
        }

        // Pastikan folder temporary ada
        $tempDir = storage_path('app/private/temp');
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        $tempPath = $tempDir . DIRECTORY_SEPARATOR . Str::uuid() . '_' . $fileName;
        $templateProcessor->saveAs($tempPath);

        // Bersihkan output buffer jika ada isi sebelum stream download
        if (ob_get_contents()) {
            ob_end_clean();
        }

        return response()->download($tempPath, $fileName)->deleteFileAfterSend(true);
    }

    /**
     * Memeriksa integritas file .docx dan mengekstrak daftar variabel di dalamnya.
     */
    public function inspectFile(UploadedFile|string $file): array
    {
        try {
            $filePath = is_string($file) ? $file : $file->getRealPath();
            $processor = new TemplateProcessor($filePath);
            $variables = $processor->getVariables();

            return [
                'success' => true,
                'variables' => $variables,
                'count' => count($variables),
                'error' => null,
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'variables' => [],
                'count' => 0,
                'error' => 'Format file Word (.docx) tidak valid atau rusak: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Simpan file template kustom hasil upload admin.
     */
    public function saveCustomTemplate(DocumentTemplate $template, UploadedFile $file, int $userId): DocumentTemplate
    {
        // Validasi parse terlebih dahulu
        $inspection = $this->inspectFile($file);
        if (!$inspection['success']) {
            throw new \InvalidArgumentException($inspection['error']);
        }

        // Hapus file custom lama jika ada
        if ($template->custom_path && Storage::disk('local')->exists($template->custom_path)) {
            Storage::disk('local')->delete($template->custom_path);
        }

        // Simpan ke storage/app/private/templates/custom/{modul}/
        $folder = 'templates/custom/' . $template->modul;
        $extension = $file->getClientOriginalExtension() ?: 'docx';
        $safeFileName = $template->kode . '_' . time() . '_' . Str::random(6) . '.' . $extension;
        $savedPath = $file->storeAs($folder, $safeFileName, 'local');

        $template->update([
            'custom_path' => $savedPath,
            'original_filename' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'updated_by' => $userId,
        ]);

        return $template->fresh();
    }

    /**
     * Download template fisik yang sedang aktif untuk diedit offline oleh admin.
     */
    public function downloadActiveTemplate(DocumentTemplate $template): BinaryFileResponse
    {
        $filePath = $template->getActiveFilePath();

        if (!file_exists($filePath)) {
            throw new \RuntimeException("File fisik template tidak ditemukan di disk server.");
        }

        $downloadName = $template->original_filename 
            ?: basename($template->default_path);

        if (ob_get_contents()) {
            ob_end_clean();
        }

        return response()->download($filePath, $downloadName);
    }
}
