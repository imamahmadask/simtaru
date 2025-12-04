<?php

namespace App\Livewire\Admin\Permohonan\Kkprnb;

use App\Models\Kkprnb;
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
        $this->kkprnb = Kkprnb::findOrFail($id);
    }
}
