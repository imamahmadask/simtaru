<?php

namespace App\Livewire\Admin\Permohonan\Skrk;

use App\Models\Skrk;
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
        $this->skrk = Skrk::findOrFail($id);
    }


}
