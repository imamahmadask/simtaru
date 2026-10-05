<?php

namespace App\Livewire\Admin\Permohonan\Kkprb;

use App\Models\Kkprb;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Detail KKPRB')]
class KkprbDetail extends Component
{
    public $kkprb;

    public function render()
    {
        return view('livewire.admin.permohonan.kkprb.kkprb-detail');
    }

    public function mount($id)
    {
        $this->loadKkprb($id);
    }

    public function loadKkprb($id = null)
    {
        $targetId = $id ?? $this->kkprb?->id;
        $this->kkprb = Kkprb::with(['permohonan.registrasi', 'permohonan.layanan'])->findOrFail($targetId);
    }

    #[On('refresh-kkprb-detail')]
    public function refreshDetail()
    {
        $this->kkprb->refresh();
        $this->kkprb->load(['permohonan.registrasi', 'permohonan.layanan']);
    }

    public function openKeteranganBerkas($instansi = null, $proses = null)
    {
        if (!Auth::check() || Auth::user()->role !== 'superadmin') {
            return;
        }

        $this->dispatch('open-modal-posisi-berkas', permohonan_id: $this->kkprb->permohonan_id, kkprb_id: $this->kkprb->id, instansi: $instansi, proses: $proses);
    }
}
