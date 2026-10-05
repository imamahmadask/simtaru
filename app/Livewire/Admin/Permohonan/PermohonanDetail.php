<?php

namespace App\Livewire\Admin\Permohonan;

use App\Models\Permohonan;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Detail Permohonan')]
class PermohonanDetail extends Component
{
    public $permohonan;
    public $satu_a, $satu_b, $dua_a, $dua_b, $tiga, $empat;

    public function render()
    {
        return view('livewire.admin.permohonan.permohonan-detail');
    }

    public function mount($id)
    {
        $this->loadPermohonan($id);
        $this->satu_a = 'templates/skrk/1A. FORM ISIAN PEMERIKSAAN LAPANGAN.docx';
        $this->satu_b = 'templates/skrk/1B. BA PEMERIKSAAN LAPANGAN SKRK.docx';
        $this->dua_a = 'templates/skrk/2A. BA Rapat FPR (Bila Ada) SKRK.docx';
        $this->dua_b = 'templates/skrk/2B. Notulensi Rapat FPR SKRK (Bila Ada).docx';
        $this->tiga = 'templates/skrk/3. KAJIAN SKRK.docx';
        $this->empat = 'templates/skrk/4. Dokumen SKRK.docx';
    }

    public function loadPermohonan($id = null)
    {
        $targetId = $id ?? $this->permohonan?->id;
        $this->permohonan = Permohonan::with([
            'registrasi.riwayat.user',
            'layanan',
            'skrk',
            'itr',
            'kkprb',
            'kkprnb',
            'berkas.persyaratan',
        ])->findOrFail($targetId);
    }

    #[On('refresh-permohonan-detail')]
    public function refreshDetail()
    {
        $this->permohonan->refresh();
        $this->permohonan->load([
            'registrasi.riwayat.user',
            'layanan',
            'skrk',
            'itr',
            'kkprb',
            'kkprnb',
            'berkas.persyaratan',
        ]);
    }

    public function openKeteranganBerkas($instansi = null, $proses = null)
    {
        if (!Auth::check() || Auth::user()->role !== 'superadmin') {
            return;
        }

        if ($this->permohonan?->layanan?->kode === 'ITR') {
            return;
        }

        $this->dispatch('open-modal-posisi-berkas', permohonan_id: $this->permohonan->id, instansi: $instansi, proses: $proses);
    }
}
