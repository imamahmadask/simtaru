<?php

namespace App\Livewire\Admin\Permohonan\Skrk;

use App\Models\Skrk;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Detail SKRK')]
class SkrkDetail extends Component
{
    public $skrk;
    public $satu_a, $satu_b, $dua_a, $dua_b, $tiga, $empat;

    public function render()
    {
        return view('livewire.admin.permohonan.skrk.skrk-detail');
    }

    public function mount()
    {
        $this->skrk = Skrk::first();

        $this->satu_a = 'templates/skrk/1A. FORM ISIAN PEMERIKSAAN LAPANGAN.docx';
        $this->satu_b = 'templates/skrk/1B. BA PEMERIKSAAN LAPANGAN SKRK.docx';
        $this->dua_a = 'templates/skrk/2A. BA Rapat FPR (Bila Ada) SKRK.docx';
        $this->dua_b = 'templates/skrk/2B. Notulensi Rapat FPR SKRK (Bila Ada).docx';
        $this->tiga = 'templates/skrk/3. KAJIAN SKRK.docx';
        $this->empat = 'templates/skrk/4. Dokumen SKRK.docx';
    }
}
