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

        $fotoDataUri = null;
        if (!empty($resume['foto']) && Storage::disk('public')->exists($resume['foto'])) {
            $fullPath = Storage::disk('public')->path($resume['foto']);
            $imageInfo = is_file($fullPath) && is_readable($fullPath) ? @getimagesize($fullPath) : false;
            if ($imageInfo && !empty($imageInfo['mime'])) {
                $fotoDataUri = 'data:' . $imageInfo['mime'] . ';base64,' . base64_encode(file_get_contents($fullPath));
            }
        }

        $pdf = Pdf::loadView('pdf.resume-pelanggaran', [
            'pelanggaran' => $pelanggaran,
            'resume' => $resume,
            'isHighTipologi' => $isHighTipologi,
            'fotoDataUri' => $fotoDataUri,
        ])->setPaper('a4', 'portrait');

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, $filename, [
            'Content-Type' => 'application/pdf',
        ]);
    }

    #[Layout('layouts.app-pelanggaran')]
    public function render()
    {
        return view('livewire.admin.pelanggaran.pelanggaran-detail');
    }
}
