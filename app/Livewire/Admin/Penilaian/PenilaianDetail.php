<?php

namespace App\Livewire\Admin\Penilaian;

use App\Models\Penilaian;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Detail Penilaian')]
class PenilaianDetail extends Component
{
    public $penilaian;

    public function mount($id)
    {
        $this->penilaian = Penilaian::findOrFail($id);
    }

    #[Layout('layouts.app-penilaian')]
    public function render()
    {
        return view('livewire.admin.penilaian.penilaian-detail');
    }
}
