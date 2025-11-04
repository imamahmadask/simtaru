<?php

namespace App\Livewire\Admin\Permohonan\Itr;

use App\Models\Itr;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Detail ITR')]
class ItrDetail extends Component
{
    public $itr;

    public function render()
    {
        return view('livewire.admin.permohonan.itr.itr-detail');
    }

    public function mount($id)
    {
        $this->itr = Itr::findOrFail($id);
    }
}
