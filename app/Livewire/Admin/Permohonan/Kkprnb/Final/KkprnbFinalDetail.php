<?php

namespace App\Livewire\Admin\Permohonan\Kkprnb\Final;

use App\Models\Kkprnb;
use Livewire\Attributes\On;
use Livewire\Component;

class KkprnbFinalDetail extends Component
{
    public $kkprnb;
    public $berkas_final;

    public function render()
    {
        return view('livewire.admin.permohonan.kkprnb.final.kkprnb-final-detail');
    }

    public function mount($kkprnb_id)
    {
        $this->kkprnb = Kkprnb::find($kkprnb_id);
        $this->berkas_final = $this->kkprnb->permohonan->berkas->where('versi', 'final');
    }

    #[On('refresh-kkprnb-final-list')]
    public function refresh()
    {
        $this->kkprnb->refresh();
        $this->berkas_final = $this->kkprnb->permohonan->berkas->where('versi', 'final');
    }
}
