<?php

namespace App\Livewire\Admin\Permohonan\Kkprnb;

use App\Models\Kkprnb;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Detail KKPRNB')]
class KkprnbDetail extends Component
{
    public $kkprnb;

    public function render()
    {
        return view('livewire.admin.permohonan.kkprnb.kkprnb-detail');
    }

    public function mount($id)
    {
        $this->loadKkprnb($id);
    }

    public function loadKkprnb($id = null)
    {
        $targetId = $id ?? $this->kkprnb?->id;
        $this->kkprnb = Kkprnb::with(['permohonan.registrasi', 'permohonan.layanan'])->findOrFail($targetId);
    }

    #[On('refresh-kkprnb-detail')]
    public function refreshDetail()
    {
        $this->kkprnb->refresh();
        $this->kkprnb->load(['permohonan.registrasi', 'permohonan.layanan']);
    }

    public function openKeteranganBerkas($instansi = null, $proses = null)
    {
        if (!Auth::check() || Auth::user()->role !== 'superadmin') {
            return;
        }

        $this->dispatch('open-modal-posisi-berkas', permohonan_id: $this->kkprnb->permohonan_id, kkprnb_id: $this->kkprnb->id, instansi: $instansi, proses: $proses);
    }
}
