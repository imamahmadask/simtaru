<?php

namespace App\Livewire\Admin\Permohonan\Skrk\Final;

use App\Models\Skrk;
use Livewire\Component;

class FinalDetail extends Component
{
    public $skrk;
    public $berkas_final;

    public function render()
    {
        return view('livewire.admin.permohonan.skrk.final.final-detail');
    }

    public function mount($skrk_id)
    {
        $this->skrk = Skrk::find($skrk_id);
        $this->berkas_final = $this->skrk->permohonan->berkas->where('versi', 'final');
    }
}
