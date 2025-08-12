<?php

namespace App\Livewire\Admin\Permohonan;

use App\Models\Permohonan;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Detail Permohonan')]
class PermohonanDetail extends Component
{
    public $permohonan;
    public function render()
    {
        return view('livewire.admin.permohonan.permohonan-detail');
    }

    public function mount($id)
    {
        $this->permohonan = Permohonan::findOrFail($id);

    }
}
