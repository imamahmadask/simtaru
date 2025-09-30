<?php

namespace App\Livewire\Admin\Permohonan\Skrk\Final;

use App\Models\Skrk;
use Livewire\Component;

class FinalDetail extends Component
{
    public $skrk;

    public function render()
    {
        return view('livewire.admin.permohonan.skrk.final.final-detail');
    }

    public function mount($skrk_id)
    {
        $this->skrk = Skrk::find($skrk_id);
    }
}
