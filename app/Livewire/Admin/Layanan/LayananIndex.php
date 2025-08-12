<?php

namespace App\Livewire\Admin\Layanan;

use App\Models\Layanan;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Layanan')]
class LayananIndex extends Component
{
    public function render()
    {
        $layanans = Layanan::all();

        return view('livewire.admin.layanan.layanan-index', [
            'layanans' => $layanans
        ]);
    }
}
