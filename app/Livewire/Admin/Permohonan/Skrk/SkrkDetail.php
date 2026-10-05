<?php

namespace App\Livewire\Admin\Permohonan\Skrk;

use App\Models\Skrk;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Detail SKRK')]
class SkrkDetail extends Component
{
    public $skrk;

    public function render()
    {
        return view('livewire.admin.permohonan.skrk.skrk-detail');
    }

    public function mount($id)
    {
        $this->loadSkrk($id);
    }

    public function loadSkrk($id = null)
    {
        $targetId = $id ?? $this->skrk?->id;
        $this->skrk = Skrk::with(['permohonan.registrasi', 'permohonan.layanan'])->findOrFail($targetId);
    }

    #[On('refresh-skrk-detail')]
    public function refreshDetail()
    {
        $this->skrk->refresh();
        $this->skrk->load(['permohonan.registrasi', 'permohonan.layanan']);
    }

    public function openKeteranganBerkas($instansi = null, $proses = null)
    {
        if (!\Illuminate\Support\Facades\Auth::check() || \Illuminate\Support\Facades\Auth::user()->role !== 'superadmin') {
            return;
        }

        $this->dispatch('open-modal-posisi-berkas', permohonan_id: $this->skrk->permohonan_id, skrk_id: $this->skrk->id, instansi: $instansi, proses: $proses);
    }
}
