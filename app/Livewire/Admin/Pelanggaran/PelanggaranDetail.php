<?php

namespace App\Livewire\Admin\Pelanggaran;

use App\Models\Pelanggaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Detail Pelanggaran')]
class PelanggaranDetail extends Component
{
    public $pelanggaran;

    public function mount($id)
    {
        $this->pelanggaran = Pelanggaran::findOrFail($id);
    }

    #[On('refresh-pelanggaran-analis-list')]
    public function refresh()
    {
        $this->pelanggaran->refresh();
    }

    public function downloadResumePdf()
    {
        $pelanggaran = $this->pelanggaran->fresh() ?? $this->pelanggaran;
        $resume = $pelanggaran->resume();
        $isHighTipologi = ($resume['tipologi'] ?? null) === 'Pelanggaran Tinggi';
        $safeNoKasus = preg_replace('/[^A-Za-z0-9_-]+/', '-', (string) ($pelanggaran->no_pelanggaran ?? 'kasus'));
        $filename = 'Resume_Pelanggaran_' . trim($safeNoKasus, '-') . '.pdf';

        $fotoDataUri = !empty($resume['foto']) ? $this->imagePathToDataUri($resume['foto']) : null;

        $petaDeliniasiDataUris = [];
        foreach ((array) ($resume['peta_deliniasi'] ?? []) as $petaPath) {
            $uri = $this->imagePathToDataUri($petaPath);
            if ($uri !== null) {
                $petaDeliniasiDataUris[] = $uri;
            }
        }

        $pdf = Pdf::loadView('pdf.resume-pelanggaran', [
            'pelanggaran' => $pelanggaran,
            'resume' => $resume,
            'isHighTipologi' => $isHighTipologi,
            'fotoDataUri' => $fotoDataUri,
            'petaDeliniasiDataUris' => $petaDeliniasiDataUris,
        ])->setPaper('a4', 'portrait');

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, $filename, [
            'Content-Type' => 'application/pdf',
        ]);
    }

    private function imagePathToDataUri(?string $relativePath): ?string
    {
        if (empty($relativePath) || !Storage::disk('public')->exists($relativePath)) {
            return null;
        }

        $fullPath = Storage::disk('public')->path($relativePath);
        if (!is_file($fullPath) || !is_readable($fullPath)) {
            return null;
        }

        $imageInfo = @getimagesize($fullPath);
        if (!$imageInfo || empty($imageInfo['mime'])) {
            return null;
        }

        // Konversi WebP ke PNG agar DomPDF selalu dapat merender dengan aman
        if ($imageInfo['mime'] === 'image/webp' && function_exists('imagecreatefromwebp')) {
            $img = @imagecreatefromwebp($fullPath);
            if ($img) {
                ob_start();
                imagepng($img);
                $pngData = ob_get_clean();
                imagedestroy($img);
                if ($pngData !== false && $pngData !== '') {
                    return 'data:image/png;base64,' . base64_encode($pngData);
                }
            }
        }

        return 'data:' . $imageInfo['mime'] . ';base64,' . base64_encode(file_get_contents($fullPath));
    }

    #[Layout('layouts.app-pelanggaran')]
    public function render()
    {
        return view('livewire.admin.pelanggaran.pelanggaran-detail');
    }
}
