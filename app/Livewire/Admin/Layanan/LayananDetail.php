<?php

namespace App\Livewire\Admin\Layanan;

use App\Models\Layanan;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Detail Layanan')]
class LayananDetail extends Component
{
    public $layanan;

    public function render()
    {
        return view('livewire.admin.layanan.layanan-detail');
    }

    public function mount($id)
    {
        $this->layanan = Layanan::findOrFail($id);

    }
}
