<?php

namespace App\Livewire\Admin\Permohonan\Kkprb;

use App\Models\Kkprb;
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
        $this->kkprb = Kkprb::findOrFail($id);
    }
}
